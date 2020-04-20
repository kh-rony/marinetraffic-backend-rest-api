<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// All routes are prefixed with '/api' by default

Route::middleware('auth:api')->get('/user', function(Request $request)
{
    return $request->user();
});
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function()
{
    Route::get('user-details', 'API\UserController@userDetails');
});


// vessel API
// throttle:10,60 means 10 requests per 60 minutes for every user
Route::group(['middleware' => ['auth:api', 'throttle:10,60']], function()
{
    Route::post('vessels', 'API\VesselController@createVessels');

    Route::get('vessels/json', 'API\VesselController@getVesselsJSON');
    Route::get('vessels/xml', 'API\VesselController@getVesselsXML');
    Route::get('vessels/csv', 'API\VesselController@getVesselsCSV');

    Route::get('vessels/json/{id}', 'API\VesselController@getSingleVesselJSON');
    Route::get('vessels/xml/{id}', 'API\VesselController@getSingleVesselXML');
    Route::get('vessels/csv/{id}', 'API\VesselController@getSingleVesselCSV');
});
