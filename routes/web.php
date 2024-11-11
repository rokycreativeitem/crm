<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login')->middleware('redirect');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('/settings/profile', [AdminController::class, 'profile_settings'] )->name('admin.settings.profile');
    // Route::get('/settings/profile_list/{id?}', [AdminController::class, 'profile_list'] )->name('admin.settings.profile.list');
    // Route::post('/settings/profile_project_permission_update', [AdminController::class, 'profile_project_permission_update'] )->name('admin.settings.profile.project.permission.update');
    // Route::get('/settings/profile_delete', [AdminController::class, 'profile_delete'] )->name('admin.settings.profile.delete');
    // Route::get('/settings/profile_create_form', [AdminController::class, 'profile_create_form'] )->name('admin.settings.profile.create.form');
    // Route::get('/settings/project_modules_list/{id}', [AdminController::class, 'settings_project_modules_list'] )->name('admin.settings.product.modules.list');

});

Route::middleware('check.permission')->group(function () {
    Route::get('check-access', function () {
        return '<h1>Welcome</h1>';
    })->name('check.access');
});

require __DIR__ . '/auth.php';
