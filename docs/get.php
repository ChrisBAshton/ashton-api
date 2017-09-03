<?php
require_once(__DIR__ . '/../api/read/api.php');

call_api($type, $key, $category, $attribute);

function call_api($type, $key, $category, $attribute) {
    try {
        if (!$type) {
            $type = 'json';
        }

        $chris = new Chris($key, $type);

        // request attribute if specified, otherwise pull in the whole category
        $requestData = $attribute ? $attribute : $category;

        echo $chris->get($requestData);

    } catch (Exception $e) {
        error($e->getMessage());
    }
}

function error($error) {
    echo '{
        "error": "' . $error . '"
    }';
}
