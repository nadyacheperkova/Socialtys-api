<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

// Show Register Page & Login Page
Route::get('/login', 'App\Http\Controllers\Auth\LoginController@index')
    ->name('login')->middleware('guest');
Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@index')
    ->name('register')->middleware('guest');

Route::get('/home', 'HomeController@index')
    ->name('home')->middleware('guest');

