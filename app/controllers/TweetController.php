<?php

class TweetController extends BaseController {

  /*
  Raw request format:
  {
  "tweets":
    [
      {"message": "message 0, delay 0 min", "delay": 0},
      {"message": "message 1, delay 1 min", "delay": 1},
      {"message": "message 2, delay 2 min", "delay": 2},
      {"message": "message 3, delay 0 min", "delay": 0}
    ]
  }
  */
  public function add() {
    $request = Request::instance();
    $content = json_decode($request->getContent());

    $tweets = $content->tweets;

    foreach($tweets as $tweet) {
      $date = Carbon::now()->addMinutes($tweet->delay);
      Queue::later($date, 'QueueTweet@tweet', array('message' => $tweet->message));
      $tweet->date = $date;
    }

    return Response::json(array('status' => 'OK', 'tweets' => $tweets));
  }
}
