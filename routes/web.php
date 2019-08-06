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

// Auth::routes();

// Route::resource('dashboard', 'DashboardController');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->middleware(['auth'])->name('dashboard');

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/users', 'User\UserController@index')->name('users');
});

Route::group(['middleware' => ['auth']], function () {

    Route::resource('/stakeholders', 'Stakeholders\StakeholdersController');
    Route::get('/stakeholders-list', 'Stakeholders\StakeholdersController@showAll')->name('stakeholders-list');
    Route::post('/stakeholders-add', 'Stakeholders\StakeholdersController@store')->name('stakeholders-add');
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/job-list', 'JobController@index')->name('job-list');
    Route::get('/job-list/{stage?}', 'JobController@getJobsByStage');
    Route::get('/job-list/{status?}', 'JobController@getJobsByStatus');
    Route::get('/job-list/{stage?}/{status?}', 'JobController@getJobsByStageAndStatus');
    Route::get('/job-stage-card', 'JobController@jobStageCard')->name('job-stage-card');
    Route::get('jobs', function () {

        if (view()->exists('pages/job/jobListFull')) {

            return view('pages/job/jobListFull');
        }
    })->name('jobs');

});

// Route::get('/job-list', 'JobController@index')->middleware(['auth'])->name('job-list');
// Route::get('/job-list/{stage?}', 'JobController@getJobsByStage')->middleware(['auth']);
// Route::get('/job-list/{status?}', 'JobController@getJobsByStatus')->middleware(['auth']);
// Route::get('/job-list/{stage?}/{status?}', 'JobController@getJobsByStageAndStatus')->middleware(['auth']);

Route::get('jobs', function () {

    if (view()->exists('pages/job/jobListFull')) {

        return view('pages/job/jobListFull');

    }

})->middleware(['auth'])->name('jobs');
