<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GanttChartController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'staff', 'check.permission'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(ProjectController::class)->group(function () {
        Route::get('projects', 'index')->name('projects');
        Route::get('project/create', 'create')->name('project.create');
        Route::post('project/store', 'store')->name('project.store');
        Route::get('project/delete/{code}', 'delete')->name('project.delete');
        Route::get('project/edit/{code}', 'edit')->name('project.edit');
        Route::post('project/update/{code}', 'update')->name('project.update');
        Route::get('project/{code}/{tab?}', 'show')->name('project.details');
        Route::post('project/multi-delete', 'multiDelete')->name('project.multi-delete');

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
        Route::get('users', 'index')->name('users');
        Route::get('user/create', 'create')->name('user.create');
        Route::post('user/store', 'store')->name('user.store');
        Route::get('user/delete/{id}', 'delete')->name('user.delete');
        Route::get('user/edit/{id}', 'edit')->name('user.edit');
        Route::post('user/update/{id}', 'update')->name('user.update');

    });

    Route::controller(MeetingController::class)->group(function () {
        Route::get('meetings', 'index')->name('meetings');
        Route::get('meeting/create', 'create')->name('meeting.create');
        Route::post('meeting/store', 'store')->name('meeting.store');
        Route::get('meeting/delete/{id}', 'delete')->name('meeting.delete');
        Route::get('meeting/edit/{id}', 'edit')->name('meeting.edit');
        Route::post('meeting/update/{id}', 'update')->name('meeting.update');
        Route::post('meeting/multi-delete', 'multiDelete')->name('meeting.multi-delete');
        Route::get('meeting/join/{id}', 'join')->name('meeting.join');

    });

    // manage roles
    Route::controller(RoleController::class)->group(function () {
        Route::get('roles', 'index')->name('roles');
        Route::get('roles/create', 'create')->name('roles.create');
        Route::post('roles/store', 'store')->name('roles.store');

        Route::middleware(['check:roles,id'])->group(function () {
            Route::get('roles/edit/{id}', 'edit')->name('roles.edit');
            Route::get('roles/delete/{id}', 'delete')->name('roles.delete');
            Route::post('roles/update/{id}', 'update')->name('roles.update');
        });
    });

    Route::controller(PermissionController::class)->group(function () {
        Route::get('permissions', 'index')->name('permissions');
        Route::get('permission/create', 'create')->name('permission.create');
        Route::post('permission/store', 'store')->name('permission.store');
        Route::get('permission/delete/{id}', 'delete')->name('permission.delete');
        Route::get('permission/edit/{id}', 'edit')->name('permission.edit');
        Route::post('permission/update/{id}', 'update')->name('permission.update');
        Route::post('permission/multi-delete', 'multiDelete')->name('permission.multi-delete');

    });

    // assign permission
    Route::controller(RolePermissionController::class)->group(function () {
        Route::post('assign/permissions/store/{role_id}/{permission_id}', 'store')->name('store.permissions');
    });

});
