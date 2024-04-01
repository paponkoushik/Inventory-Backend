<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Exam\ExamController;
use App\Http\Controllers\User\UserAnswerController;
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

    $router->middleware('jwt.authenticate')
        ->post('refresh', [AuthController::class, 'refresh'])
        ->name('refresh');

    $router->middleware('auth:api')
        ->get('myself', [AuthController::class, 'mySelf'])
        ->name('myself');
});

Route::middleware('jwt.auth')->group(function (Router $router) {
    $router->post('logout', [AuthController::class, 'logout'])
        ->name('logout');

});
