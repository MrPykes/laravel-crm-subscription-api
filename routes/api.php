<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



// Route::any('aweber/token', [AweberController::class, 'getAweberToken']);
// Route::get('aweber/authorize', [AweberController::class, 'redirectToAweberAuthorization']);


Route::get('/aweber/get-awebercode', [AweberController::class, 'get_awebercode']);
Route::get('/aweber/authorize', [AweberController::class, 'redirectToAweberAuthorization']);
Route::get('/aweber/token', [AweberController::class, 'getAweberToken']);
Route::any('/aweber/account-id', [AweberController::class, 'getAweberAccountId']);
Route::any('/aweber/subscribers', [AweberController::class, 'getAweberSubscribers']);
Route::any('/aweber/find', [AweberController::class, 'findAweberSubscriber']);
Route::get('/aweber/delete', [AweberController::class, 'deleteAweberSubscriber']);
