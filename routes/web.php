<?php

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

    if (view()->exists('welcome')) {

        return view('welcome');

    }

});

// Route::group(['middleware' => []], function () {

//     Route::get('user/login', function () {

//         if (view()->exists('pages/login/login')) {

//             return view('pages/login/login');
//         }

//     });

//     Route::get('user/forgot-password', function () {

//         if (view()->exists('pages/login/forgotPassword')) {

//             return view('pages/login/forgotPassword');
//         }

//     });

//     Route::get('user/reset-password', function () {

//         if (view()->exists('pages/login/resetPassword')) {

//             return view('pages/login/resetPassword');

//         }

//     });

// });

Auth::routes([
    'verify' => false,
    'reset' => false,
    'password.request' => false
]);

Auth::routes();

// Route::resource('dashboard', 'DashboardController');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
