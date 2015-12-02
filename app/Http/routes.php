<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['auth', 'sidebar']], function(){
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/admin/', ['as' => 'admin', 'uses' => 'HomeController@admin']);
    Route::get('/admin/clients', ['as' => 'admin.clients', 'uses' => 'AdminController@clients']);
    Route::get('/admin/projects', ['as' => 'admin.projects', 'uses' => 'AdminController@projects']);
    Route::get('/admin/users', ['as' => 'admin.users', 'uses' => 'AdminController@users']);
    Route::get('/admin/roles', ['as' => 'admin.roles', 'uses' => 'AdminController@roles']);

    Route::get('/subscribe/{project}', ['as' => 'subscribe.project', 'uses' => 'SubscriptionController@subscribe']);
    Route::get('/unsubscribe/{project}', ['as' => 'unsubscribe.project', 'uses' => 'SubscriptionController@unsubscribe']);
    Route::get('/subscriptions/', ['as' => 'subscriptions.index', 'uses' => 'SubscriptionController@index']);

    // Controllers
    Route::resource('user', 'UserController');
    Route::resource('client', 'ClientController');
    Route::get('client/{client}/archive/', ['as' => 'client.archive', 'uses' => 'ClientController@archive']);
    Route::get('client/{client}/republish/', ['as' => 'client.publish', 'uses' => 'ClientController@publish']);
    Route::resource('project', 'ProjectController');
    Route::get('project/{project}/archive/', ['as' => 'project.archive', 'uses' => 'ProjectController@archive']);
    Route::get('project/{project}/republish/', ['as' => 'project.publish', 'uses' => 'ProjectController@publish']);
    Route::resource('copydeck', 'CopydeckController');
    Route::get('project/{project}/copydeck/create', ['as' => 'copydeck.create', 'uses' => 'CopydeckController@create']);
    Route::post('project/{project}/copydeck/create', ['as' => 'copydeck.store', 'uses' => 'CopydeckController@store']);
    Route::resource('file', 'FileController');
    Route::get('project/{project}/copydeck/{copydeck}/version/create', ['as' => 'file.create', 'uses' => 'FileController@create']);
    Route::post('project/{project}/copydeck/{copydeck}/version/create', ['as' => 'file.store', 'uses' => 'FileController@store']);
    Route::get('file/{file}/status/{status}', ['as' => 'file.status', 'uses' => 'FileController@changeStatus']);
    Route::resource('notification', 'NotificationController');
    Route::resource('role', 'RoleController');
});

// Authentication routes
Route::get('auth/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes
Route::get('auth/register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('auth/register', 'Auth\AuthController@postRegister');