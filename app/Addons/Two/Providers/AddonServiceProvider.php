<?php

namespace App\Addons\Two\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // load addon view path
        View::addNamespace('event', app_path('Addons/Event/views'));

        // load addon routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    public function register()
    {
        // Other service registration logic, if any
    }
}