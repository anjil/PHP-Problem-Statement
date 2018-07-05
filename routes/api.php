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

Route::get('/users', 'UserController@UserList');

Route::post('/user/create', 'UserController@store');

//Route::group(['prefix' => 'api'], function () {
    //API V1
    Route::group(['prefix' => 'v1'], function () {

        Route::group(['middleware' => 'api'], function () {

            Route::get('teams', 'Api\TeamsController@list')->name('api.teams');

            Route::post('teams/add', 'Api\TeamsController@store')->name('api.teams.add');

            Route::get('teams/{teamId}/players', 'Api\TeamsController@getPlayerByTeamId')->name('api.teams.players');

        });
    });
//});