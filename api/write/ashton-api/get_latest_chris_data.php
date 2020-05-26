<?php

// this should run every 10 mins to create a json file with the info, as
// we don't want to have to query linkedin and twitter every time we load the site.

require_once(__DIR__ . '/../twitter/twitter.php');
require_once(__DIR__ . '/../../read/api_keys.php');

date_default_timezone_set('Europe/London');

class LatestChrisData {

    public $social  = array();
        // latest tweet
        // urls for:
            // twitter
            // linkedin
            // github

    public $details = array();
        // name
        // location
        // availability
        // resume
        // latest blog post
        // picture

    public $miscellaneous = array();
        // codingDays
        // daysUntilGraduation

    function __construct() {
        $this->keys = new ApiKeys();
        $this->getSocial();
        $this->getDetails();
        $this->getMiscellaneous();
    }

    private function getSocial() {
        $twitterKeys = $this->keys->getTwitterKeys();
        $twitter = new Twitter($twitterKeys['consumer_key'], $twitterKeys['consumer_secret'], $twitterKeys['oauth_access_token'], $twitterKeys['oauth_access_token_secret']);
        $this->social['tweet']    = $twitter->tweet;
        $this->social['twitter']  = "https://twitter.com/ChrisBAshton";
        $this->social['linkedin'] = "https://www.linkedin.com/in/chrisbashton";
        $this->social['github']   = "https://github.com/ChrisBAshton";
        $this->social['instagram']= "https://instagram.com/ChrisBAshton";
        $this->social['instagramPost']= $this->getInstagramLink();
    }

    private function getInstagramLink() {
        // access token generated using client-side (implicit) auth: https://www.instagram.com/developer/authentication/
        $authenticatedUrl = 'https://api.instagram.com/v1/users/552326513/media/recent/?access_token=' . $this->keys->getInstagramToken();
        $contents = $this->get_data($authenticatedUrl);
        $feed = json_decode($contents);
        return $feed->data[0]->link;
    }

    private function getDetails() {
        $this->details['name']         = "Chris Ashton";
        $this->details['location']     = $this->getBlogPostContent("http://ashton.codes/current-location/");
        $this->details['description']  = $this->getBlogPostContent("http://ashton.codes/current-description/");
        $this->details['availability'] = $this->getBlogPostContent("http://ashton.codes/current-status/");

        $this->details['resume']       = $this->getResume();
        $this->getBlogDetails();
        $this->details['picture']      = "https://s.gravatar.com/avatar/f0b6f16140ccdbbed8225b4ccb1ece8e?s=300";
    }

    private function getResume() {
        return "Experienced Developer working for the Government Digital Service. Previous: BBC News. I am a highly efficient, organised and creative individual, founder of my own digital agency and tenor in the BBC Symphony Chorus.";
        // @TODO - this url 403s
        // $url = "https://ashton.codes/wp-json/wp/v2/users/1";
        // $contents = $this->get_data($url);
        // $feed = json_decode($contents);
        // return $feed->description;
    }

    private function getBlogPostContent($url) {
        $html = $this->get_data($url);
        $contentBeginning = '<div id="post-content" class="entry-content">';
        $contentBeginning = strpos($html, $contentBeginning) + strlen($contentBeginning);
        $contentEnd = strpos($html, '</div>', $contentBeginning);
        $content = substr($html, $contentBeginning, $contentEnd - $contentBeginning);
        $content = trim(strip_tags($content, '<a>'));
        return $content;
    }

    private function getBlogDetails() {
        $url = "http://ashton.codes/api/get_posts/";
        $contents = $this->get_data($url);
        $feed = json_decode($contents);
        $feed = $feed->posts;

        /*
         * Function to turn a mysql datetime (YYYY-MM-DD HH:MM:SS) into a unix timestamp
         *
         * Taken from http://www.webdeveloper.com/forum/showthread.php?62042-convert-mysql-DATETIME-to-timestamp&p=348107#post348107
         * @param str The string to be formatted
         */
        function convert_datetime($str) {
            list($date, $time) = explode(' ', $str);
            list($year, $month, $day) = explode('-', $date);
            list($hour, $minute, $second) = explode(':', $time);

            $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
            return $timestamp;
        }

        foreach($feed as $post) {
            if (!isset($latest) || convert_datetime($post->date) > convert_datetime($latest->date)) {
                $latest = $post;
            }
        }

        $this->details['blogTitle'] = $latest->title;
        $this->details['blogExcerpt'] = $latest->excerpt;
        $this->details['blogUrl'] = $latest->url;
    }

    private function get_data($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    private function getMiscellaneous() {
        $this->miscellaneous['codingDays']          = $this->getCodingDays();
        $this->miscellaneous['daysUntilGraduation'] = $this->getDaysUntilGraduation();
        $this->miscellaneous['apiLastUpdated']      = time();
    }

    private function getCodingDays() {
        $startedCoding = strtotime("01/01/2009");
        $today = time();
        $secondsPassed = $today - $startedCoding;
        $daysPassed = $secondsPassed / 60 / 60 / 24;
        return round($daysPassed, 0);
    }

    private function getDaysUntilGraduation() {
        $graduate = strtotime("07/14/2015"); // stupid American date system
        $today = time();
        $secondsToWait = $graduate - $today;
        $daysToWait = $secondsToWait / 60 / 60 / 24;
        return round($daysToWait, 0);
    }

    public function toArray() {
        return array(
            'details'       => $this->details,
            'social'        => $this->social,
            'miscellaneous' => $this->miscellaneous
        );
    }

    public function __toString() {
        return json_encode($this->toArray());
    }
}
