<?php

if ($_GET['url']) {
    $url = $_GET['url'];
    if ($url === 'http://api.ashton.codes/card/github') {
        echo file_get_contents(__DIR__ . '/cards/github.php');
    }
    if ($url === 'http://api.ashton.codes/card/instagram') {
        $instagramPost = file_get_contents('http://api.ashton.codes/get/social/instagramPost/?key=4923&format=json');
        // @TODO - need Twig...
        echo file_get_contents(__DIR__ . '/cards/instagram.php');
    }
    else {
        echo "Card not found";
    }
}
else {
    echo "Please provide a URL parameter, e.g. http://api.ashton.codes/card/github";
}
