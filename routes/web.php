<?php

use App\Http\Controllers\FaqController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('pages.home');
})->name('home');

// User login, signup
Route::controller(UserController::class)->group(function () {
    Route::post('/login', 'login')->name('user.login');
    Route::post('/register', 'register')->name('user.register');
});

// Faq index, paginate
Route::controller(FaqController::class)->group(function () {
    Route::get('/faqs', 'index')->name('faqs.index');
    Route::get('/faqs/paginate', 'paginate')->name('faqs.paginate');
});