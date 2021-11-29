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


Auth::routes();


Route::resource('/entregas', 'EntregasController');

Route::resource('/usuarios', 'UserController');

Route::resource('/usuarioPedido', 'UserPedidoController');

Route::resource('/enviarEmail', 'EmailController');

Route::get('/', 'HomeController@index')->name('home');

Route::get('storage-link', function(){
	Artisan::call('storage:link');
});