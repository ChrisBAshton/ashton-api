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
    if ($url === 'https://api.ashton.codes/card/github') {
        $template = $twig->load('github.html');
        echo $template->render();
    }
    else if ($url === 'https://api.ashton.codes/card/instagram') {
        $template = $twig->load('instagram.html');
        $instagramPostUrl = json_decode(file_get_contents('https://api.ashton.codes/get/social/instagramPost/?key=' . $key . '&format=json'))->instagramPost;
        if ($instagramPostUrl) {
            echo $template->render(array(
                'instagramPost' => $instagramPostUrl . 'embed'
            ));
        }
        else {
            echo "Error fetching Instagram feed.";
        }
    }
    else {
        echo "Card not found";
    }
}
else {
    echo "Please provide a URL parameter, e.g. https://api.ashton.codes/card/github";
}
