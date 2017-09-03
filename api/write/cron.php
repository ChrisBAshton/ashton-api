<?php
require_once('ashton-api/get_latest_chris_data.php');
require_once(__DIR__ . '/../read/api_keys.php');

try {
    $keys = new ApiKeys();
    $dataFile = $keys->pathToPrivateDirectory() . '/chris.json';
    $data = new LatestChrisData();
    chmod($dataFile, 0777); // allow data directory to be read
    file_put_contents($dataFile, $data);
    chmod($dataFile, 0700); // lock down data directory again
} catch(Exception $e) {
    echo $e->getMessage();
}
