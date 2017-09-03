<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// these variables are globally accessible from within index.php/docs.php/get.php
$method    = getUrlParam('method');
$category  = getUrlParam('category');
$attribute = getUrlParam('attribute');
$type      = getUrlParam('type');
$key       = getUrlParam('key');

if($method === 'docs') {
    require 'docs.php';
}
elseif($method === 'get') {
    require 'get.php';
}
else {
    echo "Invalid request.";
}

function getUrlParam($param) {
    if (isset($_GET[$param])) {
        return $_GET[$param];
    }
    return false;
}
