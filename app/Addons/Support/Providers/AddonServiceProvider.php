<?php

namespace App\Addons\Support\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // load addon view path
        View::addNamespace('support', app_path('Addons/Support/views'));

        // load addon routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/support.php');
    }

    public function register()
    {
        // Other service registration logic, if any
    }
}
