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
	return view('welcome');
});

Route::get('/api', function () {
	return view('drive.index');
})->name('Gdrive');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('login.google');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

// Rutas para acceder al contenido
Route::middleware('auth')->group(function(){

	//Route::get('/api', 'GoogleDriveController@getFolders')->name('Gapi');
	Route::get('/api/{id}', 'GoogleDriveController@ListFolders')->name('Gapi');
	Route::get('/api/delete/{id}', 'GoogleDriveController@delteFile')->name('Delete');
	Route::post('/api/{id}', 'GoogleDriveController@uploadFiles')->name('upload');
	//Route::post('/api/upload', 'GoogleDriveController@uploadFiles');



	//Roles
	Route::post('roles/store', 'RoleController@store')->name('roles.store')
    ->middleware('can:permission:roles.create');

    Route::get('roles', 'RoleController@index')->name('roles.index')
    ->middleware('can:permission:roles.index');

    Route::get('roles/create', 'RoleController@create')->name('roles.create')
    ->middleware('can:permission:roles.create');

    Route::put('roles/{role}', 'RoleController@update')->name('roles.update')
    ->middleware('can:permission:roles.edit');

    Route::get('roles/{role}', 'RoleController@show')->name('roles.show')
    ->middleware('can:permission:roles.show');

    Route::delete('roles/{role}', 'RoleController@destroy')->name('roles.destroy')
    ->middleware('can:permission:roles.destroy');

    Route::get('roles/{role}/edit', 'RoleController@edit')->name('roles.edit')
    ->middleware('can:permission:roles.edit');


	// ADMIN
	Route::get('admin', 'AdminController@index')->name('admin.index')
	->middleware('can:permission:admin.index');
	
	// Technical Admin
	Route::get('technicalAdmin', 'TechnicalAdminController@index')->name('technicalAdmin.index')
	->middleware('can:permission:technicalAdmin.index');

	// Project Manager
	Route::get('projectManager', 'ProjectManagerController@index')->name('projectManager.index')
	->middleware('can:permission:projectManager.index');

	// team Admin
	Route::get('teamManager', 'TeamManagerController@index')->name('teamManager.index')
	->middleware('can:permission:teamManager.index');

	// Designer
	Route::get('designer', 'DesignerController@index')->name('designer.index')
	->middleware('can:permission:designer.index');

	// client
	Route::get('client', 'ClientController@index')->name('client.index')
	->middleware('can:permission:client.index');

	// Prospective clients
	Route::get('prospectiveClients', 'ProspectiveClientsController@index')->name('prospectiveClients.index')
	->middleware('can:permission:prospectiveClients.index');


});
