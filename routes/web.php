<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\CondominiosController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	Route::get('map', function () {return view('pages.maps');})->name('map');
	Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	Route::get('table-list', function () {return view('pages.tablesargon');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::get('condominios', [CondominiosController::class,'index'])->name('condominios');
	Route::get('api/condominios/lista', [CondominiosController::class,'getCondiminios'])->name('condominios-list');
	Route::post('api/condominios/guardar', [CondominiosController::class,'store'])->name('condominios-save');
	Route::post('api/condominios/eliminar/{condominio}', [CondominiosController::class,'destroy'])->name('condominios-delete');
	Route::get('api/clientes/lista', [ClientesController::class,'index'])->name('clientes-list');
});

