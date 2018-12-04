<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('authenticate', 'Auth\MobileAuthController@create_token');

Route::group(['middleware' => ['jwt.auth']], function() {
	Route::get('unauthenticate', 'Auth\MobileAuthController@black_list_token');

	// Exports
	Route::post('admin/reports/membersday_export', 'AdminController@membersday_export');
	Route::post('admin/reports/daysmember_export', 'AdminController@daysmember_export');
	Route::post('admin/reports/membersevent_export', 'AdminController@membersevent_export');
	Route::post('admin/reports/eventsmember_export', 'AdminController@eventsmember_export');

	// Scans
	Route::post('/mobile_scans/daily', 'ScansController@mobiledailyscan');
	Route::post('/mobile_scans/event/{id}', 'ScansController@mobileeventscane');

	// Event/Member List
	Route::get('members', 'AdminController@mobile_members_api');
	Route::get('events', 'AdminController@mobile_events_api');
	Route::get('get_event/{event_id}', 'AdminController@mobile_get_event');

	// Reports
	
	Route::post('/admin/reports/mobile-daysmember', 'AdminController@mobile_daysmember')->name('mobile-daysmember');
	Route::post('/admin/reports/mobile-membersday', 'AdminController@mobile_membersday')->name('mobile-membersday');
	Route::post('/admin/reports/mobile-eventsmember', 'AdminController@mobile_eventsmember')->name('mobile-eventsmember');
	Route::post('/admin/reports/mobile-membersevent', 'AdminController@mobile_membersevent')->name('mobile-membersevent');
	
	//Web Switch
	Route::get('/admin/is_disabled', 'ScansController@is_disabled');
	Route::put('/admin/disable', 'ScansController@disable_site');
});
