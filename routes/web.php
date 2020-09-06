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
//Route::get('show/desglose/individual/{cliente}/{monto}/{fecha?}', 'CreditoController@desgloseIndividual');
Route::get('pruebas/{parametro?}', 'PrestamoController@getLatestKeyForPrestamoGrupal');
Route::group(['prefix' => 'dashboard'], function(){
    
	//Route::get();
	Route::match(['put', 'patch'],'change/{id}', 'UserController@updatePassword')->name('changePassword');
	Route::match(['put', 'patch'],'change/passcobrador/{id}', 'CobradorController@updatePassword')->name('changePasswordCobrador');
    Route::post('seccion', 'SeccionController@store')->name('seccion');
    //Route::post('clientesgrupos', 'ClienteController@clientesGrupo')->name('clientesgrupos');
	Route::post('clienteShow', 'ClienteController@showAjax')->name('clienteShow');
	Route::post('cobradorShow', 'CobradorController@cobradorShowAjax')->name('cobradorShow');
	Route::post('userShow', 'UserController@showAjax')->name('userShow');
	Route::post('desglose', 'CreditoController@desgloseIndividual')->name('desglose');
	Route::post('showSecciones', 'ZonaController@showSecciones')->name('showSecciones');
	Route::post('shearCredito', 'CreditoController@shearCredito')->name('shearCredito');
	Route::post('savePayment', 'CobranzaController@save')->name('savePayment');
	Route::post('invoicesAjax', 'InvoicesController@invoicesAjax')->name('invoicesAjax');
	Route::post('invoiceAjax', 'InvoicesController@invoiceAjax')->name('invoiceAjax');
	Route::get('bolsa', 'BolsaController@index')->name('bolsa');

	Route::get('configuraciones', 'ConfiguracionesController@index')->name('allsettings');
	Route::get('generar/prestamo/{catalogo?}', 'CreditoController@generar')->name('generar');
	Route::get('cobranza/{id}', 'CobranzaController@getStockCredito')->name('getCobranza');
	Route::get('cliente/pdf/{id}', 'ClienteController@pdfStream')->name('streamPdfCliente');
	Route::get('credito/ficha/pdf/{id}', 'CreditoController@pdfStreamFichaPagos')->name('fichaPdfPagos');
	Route::get('credito/{num}/invoices/', 'InvoicesController@invoices')->name('invoices');
	Route::get('credito/{num}/invoice/{id}', 'InvoicesController@invoice')->name('invoice');
	Route::get('credito/{num}/invoices/pdf', 'InvoicesController@pdfInvoices')->name('pdfInvoices');
	Route::get('credito/{num}/invoice/{id}/pdf', 'InvoicesController@pdfInvoice')->name('pdfInvoice');
	Route::get('credito/export/excel', 'CreditoController@export');
	Route::get('cancelacion/{id?}', 'CancelacionesController@index')->name('cancelacion');
	Route::get('deudores', 'DeudoresController@index')->name('deudores');
	//Route::resource('user', 'UserController');
	Route::resource('roles', 'RoleController');
	Route::resource('permiso', 'PermisoController');
	//Route::resource('usuario', 'Auth\RegisterController');
	Route::resource('prestamo/diario', 'PrestamoDiarioController');
	Route::resource('prestamo/grupal', 'PrestamoGrupalController');
	Route::resource('prestamo/mensual', 'PrestamoMensualController');
	Route::resource('desglose/pago/dia', 'DesglosePagoController');
	Route::resource('cliente', 'ClienteController');
	Route::resource('grupo', 'GrupoController');
	Route::resource('cobradores', 'CobradorController');
	Route::resource('user', 'UserController');
	Route::resource('empresa', 'EmpresaController');
	Route::resource('catalogo', 'CatalogoController');
	Route::resource('zonas', 'ZonaController');
	Route::resource('credito', 'CreditoController');
	Route::resource('perfil' , 'ProfileController', ['only' => ['index', 'edit', 'show', 'update']]);
	
	

});