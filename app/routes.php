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


/****************************************************
 * ADMIN ROUTES
 ***************************************************/
Route::group(["before"=>"admin"], function () {
    Route::post("/result/create", array(
        "as" => "result/create",
        "uses" => "ResultController@create"
    ));

    Route::any('/admin', array(
        'as' => 'admin',
        'uses' => 'AdminController@index'
    ));

    Route::any('events/{id}/activate', array(
        'before' => 'admin',
        'uses' => 'EventController@activate'
    ));

    Route::any('/cards/reslug', array(
        'uses' => 'CardController@reslugCards'
    ));

    Route::any('/decks/reslug', array(
        'uses' => 'DeckController@reslugDecks'
    ));

});
Route::when('*/create', 'admin');



/*********************************************************
 * User registration, password reset and other junk
 */
Route::any("/request", [
    "as" => "user/request",
    "uses" => "UserController@request"
]);

Route::any("/reset/{token}", [
    "as" => "user/reset",
    "uses" => "UserController@reset"
]);

Route::any('/login', array(
    'as' => 'user/login',
    'uses' => 'UserController@login'
));

Route::any('/register', array(
    'as' => 'user/register',
    'uses' => 'UserController@register'
));

Route::any('/register/newUser', array(
    'as' => 'user/newUser',
    'uses' => 'UserController@newUser'
));


/* General stuff */
Route::resource('events', 'EventController');
Route::resource('decks', 'DeckController');
Route::resource('cards', 'CardController');
