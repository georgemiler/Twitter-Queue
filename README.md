# Twitter Queue
Queue API for Twitter

Use the API to send in bulk requests with tweet messages and delay times for each tweet. The Twitter Queue system will posts each tweets to your Twitter feed after the given delay.

# Setup
* Go to 'https://apps.twitter.com/' and create an app for the Twitter account that the API should use.
* Go to the 'Keys and Access tokens' tab of your app and generate the Access Token.
* Go to the 'Permissions' tab and grant the app read and write access to the Twitter account.
* Create the files '.env.php' and '.env.local.php' in the project root and add the Twitter oath token info, E.g:

```
<?php

return array(
  'OAUTH_ACCESS_TOKEN' => "YOUR_SECRET_DATA_HERE",
  'OAUTH_ACCESS_TOKEN_SECRET' => "YOUR_SECRET_DATA_HERE",
  'CONSUMER_KEY' => "YOUR_SECRET_DATA_HERE",
  'CONSUMER_SECRET' => "YOUR_SECRET_DATA_HERE",
  );
```

* Make sure [beanstalkd](http://kr.github.io/beanstalkd/) is installed
* Install dependencies with Composer: `composer install`
* Start beanstalkd: `sudo /etc/init.d/beanstalkd start`
* Start the queue task listener: `php artisan queue:listen`

# How to use

* Send post data to the tweet route, e.g: "http://twitter-queue.app/tweet"
* Example data:

```
{
  "tweets":
  [
    {"message": "Message 0, a twitter message with 0 min delay", "delay": 0},
    {"message": "Message 1, a twitter message with 10 min delay", "delay": 10},
    {"message": "Message 2, a twitter message with 20 min delay", "delay": 20},
    {"message": "Message 3, a twitter message with 30 min delay", "delay": 30}
  ]
}
```

* Watch how the tweets are posted to your Twitter feed after the set delays.
