<?php

use App\Addons\Support\Controllers\FaqController;
use App\Addons\Support\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Tickets routes are here
// Route::middleware(['web', 'inject'])->prefix('admin')->controller(TicketController::class)->group(function () {
//     Route::get('addon/menu', 'menu_item')->name('addon.menu');

//     Route::get('addon/ticket', 'index')->name('addon.ticket');
//     Route::get('addon/ticket/create', 'create')->name('addon.ticket.create');
//     Route::post('addon/ticket/store', 'store')->name('addon.ticket.store');
//     Route::get('addon/ticket/edit/{id}', 'edit')->name('addon.ticket.edit');
//     Route::post('addon/ticket/update/{id}', 'update')->name('addon.ticket.update');
//     Route::get('addon/ticket/delete/{id}', 'delete')->name('addon.ticket.delete');
// });

// =====================

// Route::middleware(['auth', 'web', 'inject'])->controller(TicketController::class)->group(function () {
//     Route::get('addon/menu', 'menu_item')->name('addon.menu');

//     Route::get('addon/ticket', 'index')->name('admin.addon.ticket');
//     Route::get('addon/ticket/create', 'create')->name('admin.addon.ticket.create');
//     Route::post('addon/ticket/store', 'store')->name('admin.addon.ticket.store');
//     Route::get('addon/ticket/edit/{id}', 'edit')->name('admin.addon.ticket.edit');
//     Route::post('addon/ticket/update/{id}', 'update')->name('admin.addon.ticket.update');
//     Route::get('addon/ticket/delete/{id}', 'delete')->name('admin.addon.ticket.delete');

//     // Route::get('addon/faq', 'index')->name('admin.addon.faq');
//     Route::get('addon/feedback', 'index')->name('admin.addon.feedback');
//     Route::get('addon/report', 'index')->name('admin.addon.report');
//     Route::get('addon/macro', 'index')->name('admin.addon.macro');
//     Route::get('addon/custom_fields', 'index')->name('admin.addon.custom_fields');
//     Route::get('addon/ticket_categories', 'index')->name('admin.addon.ticket_categories');
//     Route::get('addon/ticket_priorities', 'index')->name('admin.addon.ticket_priorities');
//     Route::get('addon/ticket_status', 'index')->name('admin.addon.ticket_status');
//     Route::get('addon/ticket_settings', 'index')->name('admin.addon.ticket_settings');
//     Route::get('addon/automation_rules', 'index')->name('admin.addon.automation_rules');
//     Route::get('addon/chatbot_settings', 'index')->name('admin.addon.chatbot_settings');
// });

// Route::middleware(['auth', 'web', 'inject'])->controller(FaqController::class)->group(function () {
//     Route::get('addon/faq', 'index')->name('admin.addon.faq');
//     Route::get('addon/faq/create', 'create')->name('admin.addon.faq.create');
//     Route::post('addon/faq/store', 'store')->name('admin.addon.faq.store');
//     Route::get('addon/faq/delete/{id}', 'delete')->name('admin.addon.faq.delete');
//     Route::get('addon/faq/edit/{id}', 'edit')->name('admin.addon.faq.edit');
// });

Route::middleware(['auth', 'web', 'inject'])->prefix('admin')->name('admin.')->group(function () {
    Route::controller(TicketController::class)->group(function () {
        Route::get('addon/menu', 'menu_item')->name('addon.menu');

        // TICKET ROUTES
        Route::get('addon/ticket', 'index')->name('addon.ticket');
        Route::get('addon/ticket/create', 'create')->name('addon.ticket.create');
        Route::post('addon/ticket/store', 'store')->name('addon.ticket.store');
        Route::get('addon/ticket/edit/{id}', 'edit')->name('addon.ticket.edit');
        Route::post('addon/ticket/update/{id}', 'update')->name('addon.ticket.update');
        Route::get('addon/ticket/delete/{id}', 'delete')->name('addon.ticket.delete');
        // Route::get('addon/ticket/details', 'show')->name('addon.ticket.details');
        Route::post('addon/support/multi-delete', 'multiDelete')->name('addon.support.multi-delete');

        // TICKET MESSAGE ROUTES
        Route::get('addon/ticket/message/{ticket_thread_code?}', 'ticket_message')->name('addon.ticket.message');
        Route::post('addon/ticket/message/store', 'ticket_message_store')->name('addon.ticket.message.store');

        // TICKET CATEGORY ROUTES
        Route::get('addon/ticket/category', 'ticket_category')->name('addon.ticket.category');
        Route::get('addon/ticket/category/create', 'ticket_category_create')->name('addon.ticket.category.create');
        Route::post('addon/ticket/category/store', 'ticket_category_store')->name('addon.ticket.category.store');
        Route::get('addon/ticket/category/edit/{id}', 'ticket_category_edit')->name('addon.ticket.category.edit');
        Route::post('addon/ticket/category/update/{id}', 'ticket_category_update')->name('addon.ticket.category.update');
        Route::get('addon/ticket/category/delete/{id}', 'ticket_category_delete')->name('addon.ticket.category.delete');

        // TICKET PRIORITY ROUTES
        Route::get('addon/ticket/priority', 'ticket_priority')->name('addon.ticket.priority');
        Route::get('addon/ticket/priority/create', 'ticket_priority_create')->name('addon.ticket.priority.create');
        Route::post('addon/ticket/priority/store', 'ticket_priority_store')->name('addon.ticket.priority.store');
        Route::get('addon/ticket/priority/edit/{id}', 'ticket_priority_edit')->name('addon.ticket.priority.edit');
        Route::post('addon/ticket/priority/update/{id}', 'ticket_priority_update')->name('addon.ticket.priority.update');
        Route::get('addon/ticket/priority/delete/{id}', 'ticket_priority_delete')->name('addon.ticket.priority.delete');

        // Route::get('addon/faq', 'index')->name('addon.faq');
        Route::get('addon/feedback', 'index')->name('addon.feedback');
        Route::get('addon/report', 'index')->name('addon.report');
        Route::get('addon/macro', 'index')->name('addon.macro');
        Route::get('addon/custom_fields', 'index')->name('addon.custom_fields');
        // Route::get('addon/ticket_categories', 'index')->name('addon.ticket_categories');
        Route::get('addon/ticket_priorities', 'index')->name('addon.ticket_priorities');
        Route::get('addon/ticket_status', 'index')->name('addon.ticket_status');
        Route::get('addon/ticket_settings', 'index')->name('addon.ticket_settings');
        Route::get('addon/automation_rules', 'index')->name('addon.automation_rules');
        Route::get('addon/chatbot_settings', 'index')->name('addon.chatbot_settings');
    });

    Route::controller(FaqController::class)->group(function () {
        Route::get('addon/faq', 'index')->name('addon.faq');
        Route::get('addon/faq/create', 'create')->name('addon.faq.create');
        Route::post('addon/faq/store', 'store')->name('addon.faq.store');
        Route::get('addon/faq/edit/{id}', 'edit')->name('addon.faq.edit');
        Route::post('addon/faq/update/{id}', 'update')->name('addon.faq.update');
        Route::get('addon/faq/delete/{id}', 'delete')->name('addon.faq.delete');
    });
});
Route::middleware(['auth', 'web', 'inject'])->prefix('client')->name('client.')->group(function () {
    Route::controller(TicketController::class)->group(function () {
        Route::get('addon/menu', 'menu_item')->name('addon.menu');

        // TICKET ROUTES
        Route::get('addon/ticket', 'index')->name('addon.ticket');
        Route::get('addon/ticket/create', 'create')->name('addon.ticket.create');
        Route::post('addon/ticket/store', 'store')->name('addon.ticket.store');
        Route::get('addon/ticket/edit/{id}', 'edit')->name('addon.ticket.edit');
        Route::post('addon/ticket/update/{id}', 'update')->name('addon.ticket.update');
        Route::get('addon/ticket/delete/{id}', 'delete')->name('addon.ticket.delete');
        // Route::get('addon/ticket/details', 'show')->name('addon.ticket.details');
        Route::post('addon/support/multi-delete', 'multiDelete')->name('addon.support.multi-delete');

        // TICKET MESSAGE ROUTES
        Route::get('addon/ticket/message/{ticket_thread_code?}', 'ticket_message')->name('addon.ticket.message');
        Route::post('addon/ticket/message/store', 'ticket_message_store')->name('addon.ticket.message.store');

        // TICKET CATEGORY ROUTES
        Route::get('addon/ticket/category', 'ticket_category')->name('addon.ticket.category');
        Route::get('addon/ticket/category/create', 'ticket_category_create')->name('addon.ticket.category.create');
        Route::post('addon/ticket/category/store', 'ticket_category_store')->name('addon.ticket.category.store');
        Route::get('addon/ticket/category/edit/{id}', 'ticket_category_edit')->name('addon.ticket.category.edit');
        Route::post('addon/ticket/category/update/{id}', 'ticket_category_update')->name('addon.ticket.category.update');
        Route::get('addon/ticket/category/delete/{id}', 'ticket_category_delete')->name('addon.ticket.category.delete');

        // TICKET PRIORITY ROUTES
        Route::get('addon/ticket/priority', 'ticket_priority')->name('addon.ticket.priority');
        Route::get('addon/ticket/priority/create', 'ticket_priority_create')->name('addon.ticket.priority.create');
        Route::post('addon/ticket/priority/store', 'ticket_priority_store')->name('addon.ticket.priority.store');
        Route::get('addon/ticket/priority/edit/{id}', 'ticket_priority_edit')->name('addon.ticket.priority.edit');
        Route::post('addon/ticket/priority/update/{id}', 'ticket_priority_update')->name('addon.ticket.priority.update');
        Route::get('addon/ticket/priority/delete/{id}', 'ticket_priority_delete')->name('addon.ticket.priority.delete');

        Route::get('addon/faq', 'index')->name('addon.faq');
        Route::get('addon/feedback', 'index')->name('addon.feedback');
        Route::get('addon/report', 'index')->name('addon.report');
        Route::get('addon/macro', 'index')->name('addon.macro');
        Route::get('addon/custom_fields', 'index')->name('addon.custom_fields');
        Route::get('addon/ticket_status', 'index')->name('addon.ticket_status');
        Route::get('addon/ticket_settings', 'index')->name('addon.ticket_settings');
        Route::get('addon/automation_rules', 'index')->name('addon.automation_rules');
        Route::get('addon/chatbot_settings', 'index')->name('addon.chatbot_settings');
    });

    Route::controller(FaqController::class)->group(function () {
        Route::get('addon/faq', 'index')->name('addon.faq');
        Route::get('addon/faq/create', 'create')->name('addon.faq.create');
        Route::post('addon/faq/store', 'store')->name('addon.faq.store');
        Route::get('addon/faq/edit/{id}', 'edit')->name('addon.faq.edit');
        Route::post('addon/faq/update/{id}', 'update')->name('addon.faq.update');
        Route::get('addon/faq/delete/{id}', 'delete')->name('addon.faq.delete');
    });
});
