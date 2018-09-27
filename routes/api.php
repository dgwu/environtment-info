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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {
    Route::post('/registeruser', 'TokenController@registerUser');
    Route::post('/getusertoken', 'TokenController@getToken');
    Route::post('/getuserdetail', 'TokenController@userDetail');

    Route::get('/latestnews', 'NewsController@latest');

    Route::get('/latestreports', 'NewsController@latestreport');
    Route::get('/issuesreported', 'NewsController@issuesReported');
    Route::post('/postreport', 'NewsController@postReport');

    Route::get('/ongoingevents', 'EventController@ongoing');
    Route::get('/upcomingevents', 'EventController@upcoming');
    Route::get('/participatedevents', 'EventController@participated');
    Route::post('/participateevent', 'EventController@participate')->middleware('auth:api');
});