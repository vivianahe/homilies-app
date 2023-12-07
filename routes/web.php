<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrayerController;
use App\Http\Controllers\HomiliesController;

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

Auth::routes(['register' => false]);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::view('/inicio', 'pag')->name('inicio');
Route::view('/homilyAll', 'pag')->name('homilyAll');
Route::view('/homilyDetail/{id}', 'pag')->name('homilyDetail');
Route::view('/donateView', 'pag')->name('donateView');
Route::view('/contact', 'pag')->name('contact');

Route::resource('/homilies', HomiliesController::class);
Route::get('/homilies_desc', [HomiliesController::class, 'getDescHomily']);
Route::post('/contact', [HomiliesController::class, 'postFrmContact']);
Route::apiResource("prayers", PrayerController::class);

Route::group(['middleware' => 'auth'], function () {
    Route::view('/home', 'home')->name('home');
    Route::view('/homilyAddView', 'home')->name('homilyAddView');
    Route::view('/homilyAllAdm', 'home')->name('homilyAllAdm');
    Route::view('/detailHomily/{id}', 'home')->name('detailHomily');
    Route::view('/editHomily/{id}', 'home')->name('editHomily');
    Route::view('/prayerView', 'home')->name('prayerView');
    Route::view('/userView', 'home')->name('userView');
    Route::apiResource("users", UserController::class);
    Route::apiResource("getHomilies", HomiliesController::class);
    Route::post('/addHomilies', [HomiliesController::class, 'store']);
    Route::get('/getHomeliasId/{id}', [HomiliesController::class, 'getHomeliasId']);
    Route::post('/updateHomilia', [HomiliesController::class, 'updateHomilia']);
});
