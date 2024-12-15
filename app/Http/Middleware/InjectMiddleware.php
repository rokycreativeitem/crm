<?php

namespace App\Http\Middleware;

use App\Models\Addon;
use App\Models\Addon_hook;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class InjectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Proceed to handle the request and get the response
        $response = $next($request);

        $currentRouteName = Route::currentRouteName();

        $company_components = Addon_hook::whereHas('addon', function ($query) {
            $query->where('status', 1);
        })
            ->where('app_route', $currentRouteName)
            ->with('addon')->get();

        // Modify the response content (HTML)
        if ($response->headers->get('Content-Type') === 'text/html; charset=UTF-8') {
            $content = $response->getContent();

            $dom = new \DOMDocument();
            @$dom->loadHTML($content);

            $err = [];
            foreach ($company_components as $component) {
                $component_dom = $component->dom ? json_decode($component->dom, true) : [];

                // check component dom
                if (! $component_dom) {
                    $err[] = "Component not found : {$component->addon->title}";
                    continue;
                }

                // check component routes
                $route = Route::getRoutes()->getByName($component->addon_route);
                if (! $route) {
                    $err[] = "Requested addon failed to load : {$component->addon_route}.";
                    continue;
                }

                // check parent hook
                $section = $dom->getElementById($component_dom['parent']);
                if (! $section) {
                    $err[] = "Component parent hook not found.";
                    continue;
                }

                // render and push the component
                $rendered_component = App::call($route->getAction('uses'));

                // Check if rendered component is not empty
                if (empty(trim($rendered_component))) {
                    continue;
                }

                $fragment = $dom->createDocumentFragment();
                $fragment->appendXML($rendered_component);

                $component_dom['position'] == 'inside'
                ? $section->appendChild($fragment)
                : $section->parentNode->insertBefore($fragment, $section->nextSibling);
            }

            $modifiedContent = $dom->saveHTML();

            // Set the modified content back to the response
            $response->setContent($modifiedContent);

            if (count($err) > 0) {
                Session::flash('component_error', $err);
            }
        }    


        return $response;
    }
    
}
