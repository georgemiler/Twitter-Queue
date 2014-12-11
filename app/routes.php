<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::post('/tweet',  array('before' => 'validateTweets', 'uses' => 'TweetController@add'));

Route::get('/', function() {
  return "Welcome to the Twitter Queue app!";
});
