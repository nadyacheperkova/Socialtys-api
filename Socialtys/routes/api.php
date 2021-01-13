<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Register & Login User

Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')
    ->name('api/logout');

Route::post('/android_login', 'App\Http\Controllers\Auth\LoginController@authenticateAndroidApp')
    ->name('android_login');

Route::post('/login', 'App\Http\Controllers\Auth\LoginController@authenticate')
    ->name('api/login');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register')
->name('register');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')
    ->name('api/logout');

Route::get('/user/verify/{email}', 'App\Http\Controllers\Auth\RegisterController@verifyUser');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/auth_user', 'App\Http\Controllers\Auth\LoginController@getAuthenticatedUser')
    ->name('auth_user');


//Auth::routes();
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/test', 'App\Http\Controllers\CommunityController@test');

// Show Register Page & Login Page
Route::get('/login', 'App\Http\Controllers\Auth\LoginController@index')
    ->name('login')->middleware('guest');
Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@index')
    ->name('api/register')->middleware('guest');

// Register & Login User

Route::post('/login', 'App\Http\Controllers\Auth\LoginController@authenticate')
    ->name('api/login');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register')
    ->name('register');

Route::get('/user/verify/{email}', 'App\Http\Controllers\Auth\RegisterController@verifyUser');

// Get Access token
Route::get('/login_activity', 'App\Http\Controllers\UserController@getLoginActivity')
    ->name('login_activity');

//Community CRUD
Route::prefix('/communities')->group( function() {
    Route::get('', 'App\Http\Controllers\CommunityController@index')->middleware('jwt.auth');
    Route::post('', 'App\Http\Controllers\CommunityController@store');
    Route::get('/{community}', 'App\Http\Controllers\CommunityController@show');
    Route::patch('/{community}', 'App\Http\Controllers\CommunityController@update');
    Route::delete('/{community}', 'App\Http\Controllers\CommunityController@destroy');
    Route::post('/search', 'App\Http\Controllers\CommunityController@search');
    Route::get('/{community}/join/{user}', 'App\Http\Controllers\CommunityController@join');
});

//Jobs CRUD
Route::prefix('/jobs')->group( function() {
    Route::get('', 'App\Http\Controllers\JobController@index');
    Route::post('', 'App\Http\Controllers\JobController@store');
    Route::get('/{job}', 'App\Http\Controllers\JobController@show');
    Route::patch('/{job}', 'App\Http\Controllers\JobController@update');
    Route::delete('/{job}', 'App\Http\Controllers\JobController@destroy');
});

//POSTS CRUD
Route::prefix('/posts')->group( function() {
    Route::get('', 'App\Http\Controllers\PostController@index');
    Route::post('', 'App\Http\Controllers\PostController@store');
    Route::get('/{post}', 'App\Http\Controllers\PostController@show');
    Route::post('post/like', 'App\Http\Controllers\HomeController@like');
    Route::patch('/{post}', 'App\Http\Controllers\PostController@update');
    Route::delete('/{post}', 'App\Http\Controllers\PostController@destroy');
});

//COMMENTS CRUD
Route::prefix('/comments')->group( function() {
    Route::post('', 'App\Http\Controllers\CommentController@store');
    Route::get('/{comment}', 'App\Http\Controllers\CommentController@show');
    Route::patch('/{comment}', 'App\Http\Controllers\CommentController@update');
    Route::delete('/{comment}', 'App\Http\Controllers\CommentController@destroy');
});

//User CRUD
Route::prefix('/users')->group( function() {
    Route::get('', 'App\Http\Controllers\UserController@index');
    Route::get('/{user}/communities', 'App\Http\Controllers\UserController@getCommunities');
    Route::get('/{user}', 'App\Http\Controllers\UserController@show');
    Route::patch('/{user}', 'App\Http\Controllers\UserController@update');
    Route::delete('/{user}', 'App\Http\Controllers\UserController@destroy');
    Route::post('/search', 'App\Http\Controllers\UserController@search');
});


Route::get('/kiki', 'App\Http\Controllers\UserController@getUsers')
    ->name('kiki');

//Chat functionality routes
Route::post('/add-to-chat-room', 'App\Http\Controllers\UserController@findOrCreate');
Route::post('/save-conversation', 'App\Http\Controllers\UserController@saveMessage');
Route::get('/users', 'App\Http\Controllers\UserController@getUsers');
Route::post('/chats', 'App\Http\Controllers\UserController@getMessages');

Route::get('/chat_users', 'App\Http\Controllers\UserController@getUsers');
Route::get('/login_attempts', 'App\Http\Controllers\UserController@LoginAttempt');

