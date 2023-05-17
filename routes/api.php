<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\GetResponseController;
use App\Http\Controllers\AweberController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('subscriber')->group(function () {
    Route::get('/get-details/{id}', [SubscriberController::class, 'get_data_by_subscriber_id']);

    Route::get('/contacts', [GetResponseController::class, 'getContacts']);
    Route::get('/contacts/{id}', [GetResponseController::class, 'getContact']);
    Route::get('/contacts/{id}/subscribe', [GetResponseController::class, 'subscribeContact']);
    Route::any('/contacts/{id}/unsubscribe', [GetResponseController::class, 'unsubscribeContact']);
    Route::any('/contacts/{id}/delete', [GetResponseController::class, 'deleteContact']);
});

// Route::any('aweber/token', [AweberController::class, 'getAweberToken']);
// Route::get('aweber/authorize', [AweberController::class, 'redirectToAweberAuthorization']);


Route::get('/aweber/authorize', [AweberController::class, 'redirectToAweberAuthorization']);
Route::get('/aweber/token', [AweberController::class, 'getAweberToken']);
Route::get('/aweber/account-id', [AweberController::class, 'getAweberAccountId']);
