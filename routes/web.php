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
Auth::routes();

Route::get('/', 'ScansController@index');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/scans/daily', 'ScansController@dailyIndex');
Route::get('/scans/event/{id}', 'ScansController@eventIndex');

Route::post('/scans/daily', 'ScansController@inputdailyscan');
Route::post('/scans/event/{id}', 'ScansController@inputeventscan');

Route::group(['middleware' => ['auth']], function() {
	
	////
	//// GET
	////
	
	// Settings
	Route::get('/settings', 'AdminController@settings');

	// Reports
	Route::get('/admin/reports', 'AdminController@reports');

	Route::post('/admin/reports/membersday_export', 'AdminController@membersday_export');
	Route::post('/admin/reports/daysmember_export', 'AdminController@daysmember_export');
	Route::post('/admin/reports/membersevent_export', 'AdminController@membersevent_export');
	Route::post('/admin/reports/eventsmember_export', 'AdminController@eventsmember_export');
	// Events
	Route::get('/admin/events', 'AdminController@events');
	Route::get('/admin/events/view/{id}', 'AdminController@view_event');
	Route::get('/admin/events/edit/{id}', 'AdminController@edit_event');
	Route::get('/admin/events/new', 'AdminController@new_event');
	// Members
	Route::get('/admin/members', 'AdminController@members');
	Route::get('/admin/members/view/{id}', 'AdminController@view_member');
	Route::get('/admin/members/edit/{id}', 'AdminController@edit_member');
	Route::get('/admin/members/new', 'AdminController@new_event');
	Route::get('/admin/members/export_not_printed', 'AdminController@export_not_printed');
	Route::get('/admin/members/export_all', 'AdminController@export_all');

	////
	//// POST
	////
	
	// Settings
	Route::put('/update_settings', 'AdminController@update_settings');
	
	// Reports
	Route::post('/admin/reports/membersday', 'AdminController@membersday');
	Route::post('/admin/reports/daysmember', 'AdminController@daysmember');
	Route::post('/admin/reports/membersevent', 'AdminController@membersevent');
	Route::post('/admin/reports/eventsmember', 'AdminController@eventsmember');
	//Events
	Route::post('/admin/events/delete/{id}', 'AdminController@delete_event');
	Route::post('/admin/events/edit/{id}', 'AdminController@update_event');
	Route::post('/admin/events/new', 'AdminController@create_event');
	//Members
	Route::post('/admin/members/delete/{id}', 'AdminController@delete_member');
	Route::post('/admin/members/edit/{id}', 'AdminController@update_member');
	Route::post('/admin/members/new', 'AdminController@create_member');
	Route::post('/admin/members/import_list', 'AdminController@import_list');

});
	// API Calls
	Route::get('members', 'AdminController@members_api');
	Route::get('events', 'AdminController@events_api');