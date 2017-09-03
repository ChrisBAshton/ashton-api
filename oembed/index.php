<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../api/read/api_keys.php');
Twig_Autoloader::register();

$keys = new ApiKeys();
$key = $keys->getMyPersonalAshtonApiKey();
$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($loader);

if ($_GET['url']) {
    $url = $_GET['url'];
    if ($url === 'http://api.ashton.codes/card/github') {
        echo file_get_contents(__DIR__ . '/templates/github.php');
    }
    else if ($url === 'http://api.ashton.codes/card/instagram') {
        $template = $twig->load('instagram.html');
        $instagramPostUrl = json_decode(file_get_contents('http://api.ashton.codes/get/social/instagramPost/?key=' . $key . '&format=json'))->instagramPost;
        echo $template->render(array(
            'instagramPost' => $instagramPostUrl . 'embed'
        ));
    }
    else {
        echo "Card not found";
    }
}
else {
    echo "Please provide a URL parameter, e.g. http://api.ashton.codes/card/github";
}
