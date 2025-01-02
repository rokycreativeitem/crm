<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstallController;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
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
// Route::get('server-side-datatable', [ProjectController::class, 'server_side_table'])->name('server.side.datatable');

//Installation routes
Route::controller(InstallController::class)->group(function () {
    Route::get('/install', 'index')->name('install');
    Route::get('install/step0', 'step0')->name('step0');
    Route::get('install/step1', 'step1')->name('step1');
    Route::get('install/step2', 'step2')->name('step2');
    Route::any('install/step3', 'step3')->name('step3');
    Route::get('install/step4', 'step4')->name('step4');
    Route::get('install/step4/{confirm_import}', 'confirmImport')->name('step4.confirm_import');
    Route::get('install/step5', 'step5')->name('step5');
    Route::get('install/install', 'confirmInstall')->name('confirm_install');
    Route::post('install/validate', 'validatePurchaseCode')->name('install.validate');
    Route::any('install/finalizing_setup', 'finalizingSetup')->name('finalizing_setup');
    Route::get('install/success', 'success')->name('success');
});
//Installation routes

require __DIR__ . '/auth.php';
require __DIR__ . '/payment.php';
require __DIR__ . '/admin.php';
