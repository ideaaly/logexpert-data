<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryAttributeController;
use App\Http\Controllers\InventoryUserController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\CancellationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::group(['middleware' => 'auth'], function () {

    Route::resource('inventories', InventoryController::class);
    Route::get('/test', [InventoryController::class, 'test'])->name('inventory.test');

    // Route::controller(InventoryController::class)->group(
    //     function () {
    //         Route::get('/inventories/test', 'test')->name('inventory.test');
    //         Route::get('/inventories', 'index')->name('list.inventories');
    //         Route::get('/inventories/create', 'create')->name('create.inventory');
    //         Route::get('/inventories/{inventory}', 'show')->name('show.inventory');
    //         Route::get('/inventories/{inventory}/edit', 'edit')->name('edit.inventory');
    //         Route::post('/inventories', 'store')->name('store.inventory');
    //         Route::put('/inventories/{inventory}', 'update')->name('update.inventory');
    //         Route::delete('/inventories/{inventory}', 'destroy')->name('destroy.inventory');
    //     }
    // );

    Route::controller(CancellationController::class)->group(
        function () {
            Route::get('/cancellations', 'index')->name('list.cancellations');
        }
    );

    Route::controller(InventoryController::class)->group(
        function () {
            // List
            Route::get('/list/drafts/', 'listDrafts')->name('list.draft.inventories');
            Route::get('/list/ordered/', 'listOrdered')->name('list.ordered.inventories');
            Route::get('/list/confirmed/', 'listConfirmed')->name('list.confirmed.inventories');
            Route::get('/list/assigned/', 'listAssigned')->name('list.assigned.inventories');
            Route::get('/list/todo/', 'listTodo')->name('list.todo.inventories');
            Route::get('/list/finished/', 'listFinished')->name('list.finished.inventories');
            Route::get('/list/cancelled/', 'listCancelled')->name('list.cancelled.inventories');
            Route::get('/list/archived/', 'listArchived')->name('list.archived.inventories');
            


            Route::get('/inventories/todo/{inventory}', 'showTodo')->name('show.todo.single');


            // Confirm
            Route::get('/confirm/{id}/', 'confirmInventory')->name('confirm.inventory');
            Route::post('/update_inventory/confirm/', 'updateInventorytoConfirm')->name('update.inventory.confirm');

            // Cancel
            Route::get('/cancel/{id}/', 'cancelInventory')->name('cancel.inventory');
            Route::post('/update_inventory/cancel/', 'updateInventorytoCancelled')->name('update.inventory.cancelled');

            // Archive
            Route::get('/archive/{id}/', 'archiveInventory')->name('archive.inventory');
            Route::post('/update_inventory/archive/', 'updateInventorytoArchived')->name('update.inventory.archived');

            // All to Finished
            Route::get('/update_inventory/finished/', 'updateToFinished')->name('update.inventory.finished');
        }
    );

    Route::resource('appointments', AppointmentController::class);

    Route::controller(OrderController::class)->group(
        function () {
            Route::get('/orders', 'index')->name('list.orders');
            Route::get('/orders_month/{month}','orderByMonths')->name('list.month.orders');
            Route::get('/orders/chart','showChart')->name('chart.orders');
        }
    );
    Route::controller(AppointmentController::class)->group(
        function () {
            Route::get('/create/{id}/appointment/', 'createInventoryAppointment')->name('create.inventappt');
            Route::get('/edit/{id}/appointment/', 'editInventoryAppointment')->name('edit.inventappt');
            Route::post('/update_appt', 'updateInventoryAppointment')->name('update.inventappt');
        }
    );

    Route::controller(InventoryAttributeController::class)->group(function () {

        /* Edit Property */
        Route::get('/edit/{id}/inventory/', 'editInventory')->name('edit.inventory');
        Route::post('/update_inventory/inventory/', 'updateInventory')->name('update.inventory');

        /* Edit Property */
        Route::get('/edit/{id}/property/', 'editProperty')->name('edit.property');
        Route::post('/update_property/inventory/', 'updateProperty')->name('update.property');

        /* Edit Tenant */
        Route::get('/edit/{id}/tenant/', 'editTenant')->name('edit.tenant');
        Route::post('/update_tenant/inventory/', 'updateTenant')->name('update.tenant');

        /* Edit Informations */
        Route::get('/edit/{id}/informations/', 'editInformations')->name('edit.informations');
        Route::post('/update_inventory/informations/', 'updateInformations')->name('update.informations');
        Route::post('/update_inventory/informations-draft/', 'updateInformationsDraft')->name('update.informations.draft');
        Route::post('/update_inventory/informations-after/', 'updateAfterConfirmed')->name('update.informations.after');
    });

    Route::controller(InventoryUserController::class)->group(function () {
        /* Edit Informations */
        Route::get('/assign', 'index')->name('assign.list');
        Route::get('/assign/{id}/user/', 'assignUserReferent')->name('assign.userref');
        Route::post('/update_inventory/userref/', 'updateUserReferent')->name('update.userref');
    });

    /* Experts */
    Route::controller(ExpertController::class)->group(
        function () {
            Route::get('/expert/assigned', 'listAssigned')->name('list.expert.assigned');
            Route::get('/expert/todo', 'listTodo')->name('list.expert.todo');
            Route::get('/expert/finished', 'listFinished')->name('list.expert.finished');
        }
    );


    Route::resource('users', UserController::class);

    Route::controller(UserController::class)->group(function () {
        Route::get('users/{user}/edit/informations', 'editInformations')->name('users.edit.informations');
        Route::post('createUser/', 'creatUser')->name('users.create.informations');
        Route::post('updateUser/', 'updateInformations')->name('users.update.informations');
    });

    Route::controller(DasboardController::class)->group(function () {
        Route::get('/dashboard/manager', 'displayManager')->name('dashboard.manager');
        Route::get('/dashboard/expert', 'displayExpert')->name('dashboard.expert');
    });

    Route::controller(PropertyTypeController::class)->group(function () {
        Route::get('/property_types', 'index')->name('list.property_types');
        Route::post('/property_types/store/', 'store')->name('store.property_type');
        Route::delete('/property_types/{id}', 'destroy')->name('destroy.property_type');
        Route::get('/property_types/{id}/edit', 'edit')->name('edit.property_type');
        Route::post('/property_types/{id}', 'update')->name('update.property_type');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports', 'index')->name('index.reports');
    });
});
