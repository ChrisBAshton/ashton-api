<?php
$paths = yaml_parse(file_get_contents(__DIR__ . '/../../config/paths.yml'));
$path_to_data_file = __DIR__ . $paths['path_to_private_dir'];
require_once('ashton-api/get_latest_chris_data.php');

try {
    $data = new LatestChrisData();
    $dataFile = $path_to_data_file . '/chris.json';
    chmod($dataFile, 0777); // allow data directory to be read
    file_put_contents($dataFile, $data);
    chmod($dataFile, 0700); // lock down data directory again
} catch(Exception $e) {
    echo $e->getMessage();
}
