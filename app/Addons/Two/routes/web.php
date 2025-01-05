<?php

use App\Addons\Two\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::controller(EventController::class)->group(function () {
    Route::get('events', 'events')->name('events');
});
