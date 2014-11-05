<?php

require_once('get_latest_chris_data.php');

try {
    $data = new LatestChrisData();
    $dataFile = __DIR__ . '/../data/chris.json';
    chmod($dataFile, 0777); // allow data directory to be read
    file_put_contents($dataFile, $data);
    chmod($dataFile, 0700); // lock down data directory again
} catch(Exception $e) {
    echo $e->getMessage();
}