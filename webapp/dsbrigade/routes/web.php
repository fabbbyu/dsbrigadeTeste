<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoticiaController;

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


Route::get('/', [NoticiaController::class, 'index']);
Route::get('/list', [NoticiaController::class, 'list']);



// Route::name('noticias.')->prefix('noticias')->group(function () {
//     Route::get('/', 'NoticiaController@index')->name('index');  
//     Route::get('/list', 'NoticiaController@list')->name('list');
// });