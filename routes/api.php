<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\Item\ItemController;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth/'], function (Router $router) {

    $router->post('login', [AuthController::class, 'login'])
        ->name('login');

    $router->post('signup', [AuthController::class, 'signup'])
        ->name('signup');

    $router->middleware('jwt.authenticate')
        ->post('refresh', [AuthController::class, 'refresh'])
        ->name('refresh');

    $router->middleware('auth:api')
        ->get('myself', [AuthController::class, 'mySelf'])
        ->name('myself');
});

Route::middleware('jwt.auth')->group(callback: function (Router $router) {
    $router->post('auth/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::group(['prefix' => 'inventory/'], function (Router $router) {
        $router->get('index', [InventoryController::class, 'index'])->name('inventory.index');
        $router->get('all-inventories', [InventoryController::class, 'allInventories'])->name('item.allInventories');
        $router->post('store', [InventoryController::class, 'store'])->name('inventory.store');
        $router->get('show/{inventory}', [InventoryController::class, 'show'])->name('inventory.show');
        $router->put('update/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
        $router->delete('delete/{inventory}', [InventoryController::class, 'delete'])->name('inventory.delete');
    });

    Route::group(['prefix' => 'item/'], function (Router $router) {
        $router->get('index', [ItemController::class, 'index'])->name('item.index');
        $router->post('store', [ItemController::class, 'store'])->name('item.store');
        $router->get('show/{item}', [ItemController::class, 'show'])->name('item.show');
        $router->put('update/{item}', [ItemController::class, 'update'])->name('item.update');
        $router->delete('delete/{item}', [ItemController::class, 'delete'])->name('item.delete');
    });

});
