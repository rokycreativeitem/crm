<?php

use App\Addons\One\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::controller(EventController::class)->group(function () {
    Route::get('events-projects', 'index')->name('events.test');

    Route::get('check', function () {
        return '<h1>Welcome</h1>';
    })->name('check');
});
