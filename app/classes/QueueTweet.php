<?php

class QueueTweet {

  public function tweet($job, $data)
  {

    $settings = array(
      'oauth_access_token' => $_ENV['OAUTH_ACCESS_TOKEN'],
      'oauth_access_token_secret' => $_ENV['OAUTH_ACCESS_TOKEN_SECRET'],
      'consumer_key' => $_ENV['CONSUMER_KEY'],
      'consumer_secret' => $_ENV['CONSUMER_SECRET'],
    );

    $url = 'https://api.twitter.com/1.1/statuses/update.json';
    $requestMethod = 'POST';

    $postFields = array(
      'status' => $data['message'],
    );

    $twitter = new TwitterAPIExchange($settings);

    echo $data['message'] . '\n';
    echo 'Response: \n';
    echo $twitter->setPostfields($postFields)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

    $job->delete();
  }

}
