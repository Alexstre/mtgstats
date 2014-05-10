<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

use App\Event;

Route::any('/', [
    "as" => "events/index",
    "uses" => "EventController@index"
]);

Route::group(["before"=>"auth"], function () {

    Route::any('/profile', [
        "as" => "user/profile",
        "uses" => "UserController@profile"
    ]);

    Route::any("/logout", [
        "as" => "user/logout",
        "uses" => "UserController@logout"
    ]);

});

Route::any("/request", [
    "as" => "user/request",
    "uses" => "UserController@request"
]);

Route::any("/reset/{token}", [
    "as" => "user/reset",
    "uses" => "UserController@reset"
]);

Route::when('*/create', 'auth');

Route::when('*/activate', array('auth', 'admin'));

Route::any('/admin', array(
    'before'=>'admin',
    'as' => 'admin',
    'uses' => 'AdminController@index'
));

Route::any('events/{id}/activate', array(
    'before' => 'admin',
    'uses' => 'EventController@activate'
));

Route::resource('events', 'EventController');
Route::resource('decks', 'DeckController');
Route::resource('cards', 'CardController');