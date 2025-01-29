<?php

use App\Http\Controllers\AddonController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GanttChartController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'staff', 'check.permission'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'staff_dashboard'])->name('dashboard');

    Route::controller(ProjectController::class)->group(function () {
        Route::get('{layout?}/projects', 'index')->name('projects');
        Route::get('project/create', 'create')->name('project.create');
        Route::post('project/store', 'store')->name('project.store');
        Route::get('project/delete/{code}', 'delete')->name('project.delete');
        Route::get('project/edit/{code}', 'edit')->name('project.edit');
        Route::post('project/update/{code}', 'update')->name('project.update');
        Route::get('project/{code}/{tab?}', 'show')->name('project.details');
        Route::post('project/multi-delete', 'multiDelete')->name('project.multi-delete');

        Route::get('categories', 'categories')->name('project.categories');
        Route::get('project-category/create', 'category_create')->name('project.category.create');
        Route::post('project-category/store/{id?}', 'category_store')->name('project.category.store');
        Route::get('project-category/delete/{id}', 'category_delete')->name('project.category.delete');
        Route::get('project-category/edit/{id}', 'category_edit')->name('project.category.edit');
        // Route::post('project-category/update/{id}', 'category_update')->name('project.category.update');
    });

    Route::controller(MilestoneController::class)->group(function () {
        Route::get('milestones', 'index')->name('milestones');
        Route::get('milestone/create', 'create')->name('milestone.create');
        Route::post('milestone/store', 'store')->name('milestone.store');
        Route::get('milestone/delete/{code}', 'delete')->name('milestone.delete');
        Route::get('milestone/edit/{code}', 'edit')->name('milestone.edit');
        Route::post('milestone/update/{id}', 'update')->name('milestone.update');
        Route::post('milestone/multi-delete', 'multiDelete')->name('milestone.multi-delete');
        Route::get('milestone/tasks/{id}', 'show')->name('milestone.tasks');

    });

    Route::controller(TaskController::class)->group(function () {
        Route::get('tasks', 'index')->name('tasks');
        Route::get('task/create', 'create')->name('task.create');
        Route::post('task/store', 'store')->name('task.store');
        Route::get('task/delete/{id}', 'delete')->name('task.delete');
        Route::get('task/edit/{id}', 'edit')->name('task.edit');
        Route::post('task/update/{id}', 'update')->name('task.update');
        Route::post('task/multi-delete', 'multiDelete')->name('task.multi-delete');

        Route::get('tasks-datatable', 'index')->name('tasks.datatable');

    });

    Route::controller(GanttChartController::class)->group(function () {
        Route::get('gantt_chart', 'index')->name('gantt_chart');
    });

    Route::controller(FileController::class)->group(function () {
        Route::get('files', 'index')->name('files');
        Route::get('file/create', 'create')->name('file.create');
        Route::post('file/store', 'store')->name('file.store');
        Route::get('file/delete/{id}', 'delete')->name('file.delete');
        Route::get('file/edit/{id}', 'edit')->name('file.edit');
        Route::post('file/update/{id}', 'update')->name('file.update');
        Route::post('file/multi-delete', 'multiDelete')->name('file.multi-delete');
        Route::get('file/download/{id}', 'download')->name('file.download');

    });

    Route::controller(UserController::class)->group(function () {
        Route::get('users/{type}', 'index')->name('users');
        Route::get('user/create', 'create')->name('user.create');
        Route::post('user/store', 'store')->name('user.store');
        Route::get('user/delete/{id}', 'delete')->name('user.delete');
        Route::get('user/edit/{id}', 'edit')->name('user.edit');
        Route::post('user/update/{id}', 'update')->name('user.update');
        Route::post('user/multi-delete', 'multiDelete')->name('user.multi-delete');

        Route::get('manage_profile', 'manage_profile')->name('manage.profile');
        Route::post('manage_profile/update', 'manage_profile_update')->name('manage.profile.update');

    });

    Route::controller(MeetingController::class)->group(function () {
        Route::get('meetings', 'index')->name('meetings');
        Route::get('meeting/create', 'create')->name('meeting.create');
        Route::post('meeting-store', 'store')->name('meeting-store');
        Route::get('meeting/delete/{id}', 'delete')->name('meeting.delete');
        Route::get('meeting/edit/{id}', 'edit')->name('meeting.edit');
        Route::post('meeting/update/{id}', 'update')->name('meeting.update');
        Route::post('meeting/multi-delete', 'multiDelete')->name('meeting.multi-delete');
        Route::get('meeting/join/{id}', 'join')->name('meeting.join');

    });

    Route::controller(InvoiceController::class)->group(function () {
        Route::get('invoice', 'index')->name('invoice');
        Route::get('invoice/create', 'create')->name('invoice.create');
        Route::post('invoice/store', 'store')->name('invoice.store');
        Route::get('invoice/delete/{id}', 'delete')->name('invoice.delete');
        Route::get('invoice/edit/{id}', 'edit')->name('invoice.edit');
        Route::post('invoice/update/{id}', 'update')->name('invoice.update');
        Route::post('invoice/multi-delete', 'multiDelete')->name('invoice.multi-delete');
        Route::get('invoice/payout/{id}', 'payout')->name('invoice.payout');
        Route::get('invoice/view/{id}', 'view')->name('invoice.view');
    });

    Route::controller(TimesheetController::class)->group(function () {
        Route::get('timesheets', 'index')->name('timesheets');
        Route::get('timesheet/create', 'create')->name('timesheet.create');
        Route::post('timesheet/store', 'store')->name('timesheet.store');
        Route::get('timesheet/delete/{id}', 'delete')->name('timesheet.delete');
        Route::get('timesheet/edit/{id}', 'edit')->name('timesheet.edit');
        Route::post('timesheet/update/{id}', 'update')->name('timesheet.update');
        Route::post('timesheet/multi-delete', 'multiDelete')->name('timesheet.multi-delete');
    });

    // manage roles
    Route::controller(RoleController::class)->group(function () {
        Route::get('roles', 'index')->name('roles');
        Route::get('role/permission', 'permission')->name('role.permission');

    });

    // assign permission
    Route::controller(RolePermissionController::class)->group(function () {
        Route::post('permissions/store', 'store')->name('store.permissions');
    });

    Route::controller(EventController::class)->group(function () {
        Route::get('events', 'index')->name('events');
        Route::get('event/create', 'create')->name('event.create');
        Route::post('event/store', 'store')->name('event.store');
        Route::get('event/delete/{id}', 'delete')->name('event.delete');
        Route::get('event/edit/', 'edit')->name('event.edit');
        Route::post('event/update/{id}', 'update')->name('event.update');

    });

    Route::controller(MessageController::class)->group(function () {
        Route::post('message/store', 'store')->name('message.store');
        Route::post('message/thread/store', 'thread_store')->name('message.thread.store');
        Route::get('message/{message_thread?}', 'message')->name('message');
        Route::get('message/start/new', 'message_new')->name('message.message_new');
        Route::get('message/message_left_side_bar', 'message_left_side_bar')->name('message.message_left_side_bar');
    });

    Route::controller(ReportController::class)->group(function () {

        Route::get('project_report', 'project_report')->name('project_report');
        Route::get('client_report', 'client_report')->name('client_report');

    });
    Route::controller(AddonController::class)->group(function () {
        Route::get('update/center', 'index')->name('update.center');
        Route::get('addon/add', 'add')->name('addon.add');
        Route::post('addon/store', 'store')->name('addon.store');
    });

    Route::controller(SettingsController::class)->group(function () {
        Route::get('system_settings', 'system_settings')->name('system_settings');
        Route::post('system_settings/update', 'system_settings_update')->name('system_settings.update');

        Route::get('payment_settings', 'payment_settings')->name('payment_settings');
        Route::post('payment_settings/update', 'payment_settings_update')->name('payment_settings.update');

        Route::get('notification_settings', 'notification_settings')->name('notification_settings');
        Route::any('notification_settings/store/{param1}/{id?}', 'notification_settings_store')->name('notification_settings.store');

        Route::get('manage_language', 'manage_language')->name('manage_language');
        Route::post('language/store', 'language_store')->name('language.store');
        Route::post('language/direction/update', 'language_direction_update')->name('language.direction.update');
        Route::post('language/import', 'language_import')->name('language.import');
        Route::get('language/delete/{id}', 'language_delete')->name('language.delete');

        Route::get('language/phrase/edit/{lan_id}', 'edit_phrase')->name('language.phrase.edit');
        Route::post('language/phrase/update/{phrase_id?}', 'update_phrase')->name('language.phrase.update');
        Route::get('language/phrase/import/{lan_id}', 'phrase_import')->name('language.phrase.import');

        Route::get('about', 'about')->name('about');
        Route::any('save_valid_purchase_code/{action_type?}', 'save_valid_purchase_code')->name('save_valid_purchase_code');

    });

    Route::get('select-language/{language}', [LanguageController::class, 'select_lng'])->name('select.language');

});
