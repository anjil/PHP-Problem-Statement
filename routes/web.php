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

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* Team routes starts */
Route::group(
    array(
        'prefix' => 'admins/teams',
        'middleware' => ['auth']
    ),
    function() {
        Route::get('/',[
            'uses' => 'TeamsController@list',
            'as' => 'team.list',
        ]);
        
        Route::get('/add',[
            'uses' => 'TeamsController@create',
            'as' => 'team.create',
        ]);
        Route::post('/save',[
            'uses' => 'TeamsController@store',
            'as' => 'team.store',
        ]);

        Route::get('/edit/{id}',[
            'uses' => 'TeamsController@edit',
            'as' => 'team.edit',
        ]);
        Route::post('/update/{id}',[
            'uses' => 'TeamsController@update',
            'as' => 'team.update',
        ]);

        Route::post('/delete/{id}',[
            'uses' => 'TeamsController@delete',
            'as' => 'team.delete',
        ]);
    }
);
/* Team routes ends */

/* Player routes starts */
Route::group(
    array(
        'prefix' => 'admins/players',
        'middleware' => ['auth']
    ),
    function() {
        Route::get('/',[
            'uses' => 'PlayersController@list',
            'as' => 'player.list',
        ]);
        
        Route::get('/add',[
            'uses' => 'PlayersController@create',
            'as' => 'player.create',
        ]);
        Route::post('/save',[
            'uses' => 'PlayersController@store',
            'as' => 'player.store',
        ]);

        Route::get('/edit/{id}',[
            'uses' => 'PlayersController@edit',
            'as' => 'player.edit',
        ]);
        Route::post('/update/{id}',[
            'uses' => 'PlayersController@update',
            'as' => 'player.update',
        ]);

        Route::post('/delete/{id}',[
            'uses' => 'PlayersController@delete',
            'as' => 'player.delete',
        ]);
    }
);
/* Player routes ends */

Route::Group(
    array(
        'middleware' => ['web']
    ),
    function(){

        Route::get('/',[
            'uses' => 'TeamsController@listTeams',
        ]);

        Route::get('/teams/{teamId}/players',[
            'uses' => 'TeamsController@teamPlayers',
            'as' => 'teams.players'
        ]);
    }
);

