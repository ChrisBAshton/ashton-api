<?php

// this should run every 10 mins to create a json file with the info, as
// we don't want to have to query linkedin and twitter every time we load the site.

require_once('twitter/twitter.php');
require_once('linkedin/linkedin.php');

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
        $this->getSocial();
        $this->getDetails();
        $this->getMiscellaneous();
    }

    private function getSocial() {
        $twitter = new Twitter();
        $this->social['tweet']    = $twitter->tweet;
        $this->social['twitter']  = "http://twitter.com/ChrisBAshton";
        $this->social['linkedin'] = "https://www.linkedin.com/in/chrisbashton";
        $this->social['github']   = "http://github.com/ChrisBAshton";
    }

    private function getDetails() {
        $this->details['name']         = "Chris Ashton";
        $this->details['location']     = "Aberystwyth";
        $this->details['description']  = "Web developer | Pragmatic Programmer | Entrepreneur";
        $this->details['availability'] = "Rather busy, but happy to consider freelance development work.";

        $this->details['resume']       = $this->getResume();
        $this->getBlogDetails();
        $this->details['picture']      = "https://s.gravatar.com/avatar/f0b6f16140ccdbbed8225b4ccb1ece8e?s=300";
    }

    private function getResume() {

        $pattern = "/<summary>([\s\S]*)<\/summary>/msU";

        $linkedin = new LinkedIn();

        preg_match($pattern, $linkedin->summary, $matches);
        $resume = $matches[1];

        $resume = nl2br($resume);
        
        return $resume;
    }

    private function getBlogDetails() {
        $url = "http://ashton.codes/blog/category/updates/";
        $html = $this->get_data($url);

        $blogBeginning = "<!-- latest_blog_begin--title -->";
        $blogEnd       = "<!-- latest_blog_end--title -->";
        $descriptionBeginsAt = strpos($html, $blogBeginning) + strlen($blogBeginning);
        $descriptionEndsAt = strpos($html, $blogEnd);
        $length = $descriptionEndsAt - $descriptionBeginsAt;
        $this->details['blogTitle'] = trim(substr($html, $descriptionBeginsAt, $length));

        $blogBeginning = "<!-- latest_blog_begin--excerpt -->";
        $blogEnd       = "<!-- latest_blog_end--excerpt -->";
        $descriptionBeginsAt = strpos($html, $blogBeginning) + strlen($blogBeginning);
        $descriptionEndsAt = strpos($html, $blogEnd);
        $length = $descriptionEndsAt - $descriptionBeginsAt;
        $this->details['blogExcerpt'] = trim(substr($html, $descriptionBeginsAt, $length));

        $blogBeginning = "<!-- latest_blog_begin--url -->";
        $blogEnd       = "<!-- latest_blog_end--url -->";
        $descriptionBeginsAt = strpos($html, $blogBeginning) + strlen($blogBeginning);
        $descriptionEndsAt = strpos($html, $blogEnd);
        $length = $descriptionEndsAt - $descriptionBeginsAt;
        $this->details['blogUrl'] = trim(substr($html, $descriptionBeginsAt, $length));
    }

    /* gets the data from a URL */
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
    }

    private function getCodingDays() {
        $startedCoding = strtotime("01/01/2009");
        $today = time();
        $secondsPassed = $today - $startedCoding;
        $daysPassed = $secondsPassed / 60 / 60 / 24;
        return round($daysPassed, 0);
    }

    private function getDaysUntilGraduation() {
        $graduate = strtotime("07/15/2015"); // stupid American date system
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
