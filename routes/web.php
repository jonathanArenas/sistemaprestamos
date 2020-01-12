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

Route::get('/', 'Auth\LoginController@showLoginForm');

Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('show/desglose/individual/{cliente}/{monto}/{fecha?}', 'PrestamoController@desgloseIndividual');
Route::get('pruebas/{parametro?}', 'PrestamoController@getLatestKeyForPrestamoGrupal');
Route::group(['prefix' => 'dashboard'], function(){
    
    //Route::get();
    Route::post('seccion', 'SeccionController@store')->name('seccion');
    Route::post('clientesgrupos', 'ClienteController@clientesGrupo')->name('clientesgrupos');
    Route::post('clienteShow', 'ClienteController@showAjax')->name('clienteShow');
	//Route::resource('user', 'UserController');
	Route::resource('roles', 'RoleController');
	Route::resource('permiso', 'PermisoController');
	Route::resource('usuario', 'Auth\RegisterController');
	Route::resource('prestamo/diario', 'PrestamoDiarioController');
	Route::resource('prestamo/grupal', 'PrestamoGrupalController');
	Route::resource('prestamo/mensual', 'PrestamoMensualController');
	Route::resource('desglose/pago/dia', 'DesglosePagoController');
	Route::resource('cliente', 'ClienteController');
	Route::resource('grupo', 'GrupoController');
	Route::resource('cobradores', 'CobradorController');
	Route::resource('user', 'UserController');

});