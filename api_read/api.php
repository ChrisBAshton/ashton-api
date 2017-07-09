<?php

// public facing API

include 'api_keys.php';

class Chris {

    private $chris;
    private $type;

    function __construct($key, $type = 'json') {
        $this->checkAuthorised($key);
        $this->type = $type;
        $this->fetchJSON();
    }

    public function get($attributeOrCategory) {
        $categories = array(
            "details" => array(
                "name"                => $this->name(),
                "location"            => $this->location(),
                "description"         => $this->description(),
                "availability"        => $this->availability(),
                "resume"              => $this->resume(),
                "blogTitle"           => $this->blogTitle(),
                "blogExcerpt"         => $this->blogExcerpt(),
                "blogUrl"             => $this->blogUrl(),
                "picture"             => $this->picture()
            ),
            "social" => array(
                "tweet"               => $this->tweet(),
                "twitter"             => $this->twitter(),
                "linkedin"            => $this->linkedin(),
                "github"              => $this->github(),
                "instagram"           => $this->instagram(),
                "instagramPost"       => $this->instagramPost(),
            ),
            "miscellaneous" => array(
                "codingDays"          => $this->codingDays(),
                "daysUntilGraduation" => $this->daysUntilGraduation(),
                "apiLastUpdated"      => $this->apiLastUpdated()
            )
        );

        $requestedData = $this->getRequestedData($categories, $attributeOrCategory);

        return $this->package($requestedData);
    }

    private function getRequestedData($categories, $attributeOrCategory) {
        foreach($categories as $categoryName => $categoryAttributes) {
            if ($attributeOrCategory == $categoryName) {
                return $categoryAttributes;
            } else {
                foreach($categoryAttributes as $attributeName => $attributeValue) {
                    if ($attributeOrCategory == $attributeName) {
                        return array($attributeName => $attributeValue);
                    }
                }
            }
        }
        throw new Exception ('"'.$attributeOrCategory.'" is not a valid request!');
    }

    private function package($attributes) {

        $packaged = false;

        if ($this->type == 'json') {
            $packaged = $this->jsonify($attributes);
        }
        elseif ($this->type == 'xml') {
            $packaged = $this->xmlify($attributes);
        }
        elseif ($this->type == 'csv') {
            $packaged = $this->csvify($attributes);
        }

        if (!$packaged) {
            throw new Exception ('"'.$this->type.'" is not a valid data type!');
        }

        return $packaged;
    }

    private function json_esc($output, $esc_html = true) {
        $output = trim(preg_replace('/\s+/', ' ', $output));
        $output = str_replace('"', '\"', $output);
        return $output;
    }

    private function jsonify($attributes) {
        $json = "{";

        $processed = 0;
        foreach ($attributes as $attributeKey => $attributeVal) {
            $processed++;
            if ($processed > 1) {
                $json = $json . ",";
            }
            $json = $json . '"' . $attributeKey . '": "' . $this->json_esc($attributeVal) . '"';
        }

        $json = $json . "}";

        return $json;
    }

    private function csvify($attributes) {
        $packaged = "";
        if (count($attributes) == 1) {
            // gets first (well, only!) element in array. Can't call array[0] as it's associative
            $packaged = reset($attributes);
        } else {
            $processed = 0;
            foreach ($attributes as $attribute) {
                if (++$processed > 1) {
                    $packaged = $packaged . ", ";
                }
                $packaged = $packaged . $attribute;
            }
        }

        return $packaged;
    }

    private function xmlify($attributes) {

        header('Content-type: application/xml');

        $xml = '<?xml version="1.0"?><chris>';

        foreach ($attributes as $attributeKey => $attributeVal) {
            $xml = $xml . "<" . $attributeKey . ">";
            $xml = $xml . $attributeVal;
            $xml = $xml . "</" . $attributeKey . ">";
        }

        $xml = $xml . '</chris>';

        return $xml;
    }

    private function checkAuthorised($key) {
        $authorised = new ApiKeys();
        if (!$authorised->check($key)) {
            throw new Exception ("Not authorised");
        }
    }

    private function fetchJSON() {
        $dataJsonFile = __DIR__ . '/../data/chris.json';
        if (!file_exists($dataJsonFile)) {
            die('No such file: ' . $dataJsonFile);
        } else {
            chmod($dataJsonFile, 0777); // allow data directory to be read
            $string = file_get_contents($dataJsonFile);
            chmod($dataJsonFile, 0700); // lock down data directory again
            $this->chris = json_decode($string, true);
        }
    }

    /* DETAILS */

    public function name() {
        return $this->chris['details']['name'];
    }

    public function location() {
        return $this->chris['details']['location'];
    }

    public function description() {
        return $this->chris['details']['description'];
    }

    public function availability() {
        return $this->chris['details']['availability'];
    }

    public function resume() {
        return $this->chris['details']['resume'];
    }

    public function blogTitle() {
        return $this->chris['details']['blogTitle'];
    }

    public function blogExcerpt() {
        return $this->chris['details']['blogExcerpt'];
    }

    public function blogUrl() {
        return $this->chris['details']['blogUrl'];
    }

    public function picture() {
        return $this->chris['details']['picture'];
    }

    /* SOCIAL */

    public function tweet() {
        return $this->chris['social']['tweet'];
    }

    public function twitter() {
        return $this->chris['social']['twitter'];
    }

    public function linkedin() {
        return $this->chris['social']['linkedin'];
    }

    public function github() {
        return $this->chris['social']['github'];
    }

    public function instagram() {
        return $this->chris['social']['instagram'];
    }

    public function instagramPost() {
        return $this->chris['social']['instagramPost'];
    }

    /* MISCELLANEOUS */

    public function codingDays() {
        return $this->chris['miscellaneous']['codingDays'];
    }

    public function daysUntilGraduation() {
        return $this->chris['miscellaneous']['daysUntilGraduation'];
    }

    public function apiLastUpdated() {
        return $this->chris['miscellaneous']['apiLastUpdated'];
    }
}
