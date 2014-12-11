<?php

Route::filter('validateTweets', function()
{
	$request = Request::instance();
	$content = json_decode($request->getContent());

	if(!isset($content->tweets) || !is_array($content->tweets))
	{
		return Response::json(array('status' => 'Failed', 'error' => 'No Tweets found!', 'data' => $content));
	}

	$tweets = $content->tweets;

	// Validate input parameters
	foreach($tweets as $tweet) {
		if(!isset($tweet->delay) || !is_int($tweet->delay) ||
		!isset($tweet->message)) {
			return Response::json(array('status' => 'Failed', 'error' => 'Invalid Tweet found!', 'data' => $tweet));
		}

		// Take into account that URL:s are shortened by twitter
		$messageLength = strlen($tweet->message);
		$shortenedUrlLength = 30; // TODO: A more accurate number can be requested through the twitter API
		$urlRegex = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		if(preg_match($urlRegex, $tweet->message, $url)) {
			$urlLength = strlen($url[0]);
			$messageLength = $messageLength - $urlLength + $shortenedUrlLength;
		}

		if ($messageLength > 140) {
				return Response::json(array('status' => 'Failed', 'error' => 'Tweet exceeds 140 char limit!', 'data' => $tweet));
		}
	}
});

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});


/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
