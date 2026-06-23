<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');

    Route::prefix('master-items')
        ->controller(App\Http\Controllers\MasterItemsController::class)
        ->group(function () {

            Route::get('/', 'index');
            Route::get('/search', 'search');

            Route::get('/form/{method}/{id?}', 'formView');
            Route::post('/form/{method}/{id?}', 'formSubmit');

            Route::get('/view/{kode}', 'singleView');
            Route::get('/export-excel', 'exportExcel');
            Route::get('/delete/{id}', 'delete');

            Route::get('/update-random-data', 'updateRandomData');
        });

    Route::prefix('kategoris')
        ->controller(App\Http\Controllers\KategoriController::class)
        ->group(function () {

            Route::get('/', 'index'); 
            Route::get('/search', 'search');
            Route::get('/print/{kode}', 'exportPdf');

            Route::get('/form/{method}/{id?}', 'formView');
            Route::post('/form/{method}/{id?}', 'formSubmit');

            Route::get('/view/{id}', 'singleView');
            Route::get('/delete/{id}', 'delete');
        });
});
