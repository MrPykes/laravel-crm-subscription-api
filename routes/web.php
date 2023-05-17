<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriberController;
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
Route::get('/add-new', [SubscriberController::class, 'add_new'])->name('add-new');

Route::get('/manage-list', [SubscriberController::class, 'manage_list'])->name('manage-list');
Route::post('/store', [SubscriberController::class, 'store'])->name('store');
Route::post('/update', [SubscriberController::class, 'update'])->name('update');
Route::get('/edit/{id}', [SubscriberController::class, 'edit'])->name('edit');
Route::any('/delete/{id}', [SubscriberController::class, 'delete'])->name('delete');
