<?php

require_once('twitter_api_exchange.php');

date_default_timezone_set('Europe/London');

class Twitter {

    public $tweet;

    function __construct($consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret) {
        $config = array(
            'consumer_key' => $consumer_key,
            'consumer_secret' => $consumer_secret,
            'oauth_access_token' => $oauth_access_token,
            'oauth_access_token_secret' => $oauth_access_token_secret,
            'output_format' => 'json'
        );

        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $getfield = '?screen_name=ChrisBAshton&count=1';
        $requestMethod = 'GET';

        $twitter = new TwitterAPIExchange($config);
        $latestTweetJSON = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();

        $tweet = json_decode($latestTweetJSON);
        $this->tweet = $tweet[0]->id_str;
    }
}
