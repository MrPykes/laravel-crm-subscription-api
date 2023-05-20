<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\UnsubscribeController;
use App\Http\Controllers\GetResponseController;
use App\Http\Controllers\AweberController;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::prefix('subscriber')->group(function () {
    Route::get('/get-details/{id}', [SubscriberController::class, 'get_data_by_subscriber_id']);
    Route::get('/manage-list', [SubscriberController::class, 'manage_list'])->name('manage-list');

    Route::get('/add-new', [SubscriberController::class, 'add_new'])->name('add-new');
    Route::post('/store', [SubscriberController::class, 'store'])->name('store');
    Route::post('/update', [SubscriberController::class, 'update'])->name('update');
    Route::get('/edit/{id}', [SubscriberController::class, 'edit'])->name('edit');
    Route::any('/delete/{id}', [SubscriberController::class, 'delete'])->name('delete');
});



Route::prefix('aweber')->group(function () {
    Route::get('/login', [AweberController::class, 'login']);
    Route::get('/callback', [AweberController::class, 'callback']);
    Route::get('/accounts', [AweberController::class, 'getAweberAccounts']);
    Route::get('/list', [AweberController::class, 'getAweberList']);
    Route::get('/contacts', [AweberController::class, 'getAweberContacts']);
});

Route::prefix('getresponse')->group(function () {
    Route::get('/contacts', [GetResponseController::class, 'getContacts']);
    Route::get('/contacts/{id}', [GetResponseController::class, 'getContact']);
    Route::any('/contacts/{id}/delete', [GetResponseController::class, 'deleteContact']);
});


Route::get('/unsubscribe', [UnsubscribeController::class, 'index']);
Route::post('/unsubscribe', [UnsubscribeController::class, 'unsubscribe'])->name('unsubscribe');
