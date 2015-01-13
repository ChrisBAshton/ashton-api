<?php
$developmentMode = false; // change to true when you want to test locally
require_once('get_latest_chris_data.php');

try {
    $data = new LatestChrisData();
    if ($developmentMode) {
        var_dump($data);
    }
    else {
        $dataFile = __DIR__ . '/../data/chris.json';
        chmod($dataFile, 0777); // allow data directory to be read
        file_put_contents($dataFile, $data);
        chmod($dataFile, 0700); // lock down data directory again
    }
} catch(Exception $e) {
    echo $e->getMessage();
}