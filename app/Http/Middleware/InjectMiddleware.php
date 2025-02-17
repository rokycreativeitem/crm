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
        if (!session()->isStarted()) {
            session()->start();
        }
        // Proceed to handle the request and get the response
        $response = $next($request);

        $currentRouteName = Route::currentRouteName();

        $company_components = Addon_hook::whereHas('addon', function ($query) {
            $query->where('status', 1);
        })
            ->where(function ($query) use ($currentRouteName) {
                // Check if the route is exactly the current route name, or if it starts with 'addon.'
                $query->where('app_route', $currentRouteName)
                    ->orWhere('app_route', 'addon.any')
                    ->orWhere(function ($query) use ($currentRouteName) {
                        $query->where('app_route', 'like', 'addon');
                    });
            })
            ->with('addon')
            ->get();

        // $company_components = Addon_hook::whereHas('addon', function ($query) {
        //     $query->where('status', 1);
        // })
        // ->where('app_route', '')
        // ->with('addon')
        // ->get();


        // Skip DOM manipulation if no components are available
        if ($company_components->isEmpty() || $response->headers->get('Content-Type') !== 'text/html; charset=UTF-8') {
            return $response;
        }

        // Modify the response content (HTML)
        $content = $response->getContent();

        libxml_use_internal_errors(true);

        if (empty($content)) {
            // Provide a default fallback content if $content is empty
            $content = '<!DOCTYPE html><html><body></body></html>';
        }

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;

        // Suppress warnings during parsing but ensure $content is not empty
        if (!empty($content)) {
            @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        } else {
            // Handle cases where $content is unexpectedly empty
            throw new \Exception("Content is empty and cannot be processed by DOMDocument.");
        }


        // libxml_use_internal_errors(true);
        // $dom = new \DOMDocument('1.0', 'UTF-8');
        // $dom->preserveWhiteSpace = false;
        // @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $errors = [];

        foreach ($company_components as $component) {
            $componentDom = $component->dom ? json_decode($component->dom, true) : [];

            // Validate component DOM structure
            if (!$componentDom) {
                $errors[] = "Component DOM not found for addon: {$component->addon->title}";
                continue;
            }

            // Validate addon route
            $route = Route::getRoutes()->getByName($component->addon_route);
            if (!$route) {
                $errors[] = "Addon route '{$component->addon_route}' not found.";
                continue;
            }

            // Find parent element in DOM
            $parentElement = $dom->getElementById($componentDom['parent']);
            if (!$parentElement) {
                $errors[] = "Parent element '{$componentDom['parent']}' not found in DOM.";
                continue;
            }

            // Render and insert the component
            $renderedComponent = App::call($route->getAction('uses'));
            if (!trim($renderedComponent)) {
                continue;
            }

            // print_r($renderedComponent);
            // die;
            $fragment = $dom->createDocumentFragment();
            $fragment->appendXML($renderedComponent);

            // Append or insert based on position
            if ($fragment->hasChildNodes()) {
                if ($componentDom['position'] === 'inside') {
                    $parentElement->appendChild($fragment);
                } else {
                    $parentElement->parentNode->insertBefore($fragment, $parentElement->nextSibling);
                }
            }
            // if ($componentDom['position'] === 'inside') {
            //     $parentElement->appendChild($fragment);
            // } else {
            //     $parentElement->parentNode->insertBefore($fragment, $parentElement->nextSibling);
            // }
        }

        $modifiedContent = $dom->saveHTML();

        // Update response content only if modifications were made
        if ($modifiedContent !== $content) {
            $response->setContent($modifiedContent);
        }

        // Store errors in session for display
        if (!empty($errors)) {
            Session::flash('component_errors', $errors);
        }

        libxml_clear_errors();

        return $response;
    }
}
