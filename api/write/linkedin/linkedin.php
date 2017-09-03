<?php

class LinkedIn {

    public $summary;

    function __construct($consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret) {
        try {
            // Fill the keys and secrets you retrieved after registering your app
            $oauth = new OAuth($consumer_key, $consumer_secret);
            $oauth->setToken($oauth_access_token, $oauth_access_token_secret);

            $params = array();
            $headers = array();
            $method = OAUTH_HTTP_METHOD_GET;

            // Specify LinkedIn API endpoint to retrieve your own profile
            $url = "https://api.linkedin.com/v1/people/id=kRM9jq0bTn:(summary)";

            // By default, the LinkedIn API responses are in XML format. If you prefer JSON, simply specify the format in your call
            // $url = "https://api.linkedin.com/v1/people/~?format=json";

            // Make call to LinkedIn to retrieve your own profile
            $oauth->fetch($url, $params, $method, $headers);

            $this->summary = $oauth->getLastResponse();

        } catch (Exception $e) {
            $this->summary = "Could not get About. Error: " . $e->getMessage();
        }
    }
}
