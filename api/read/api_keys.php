<?php

class ApiKeys {

    private $path_to_private_dir;

    public function __construct() {
        $config = yaml_parse(file_get_contents(__DIR__ . '/../../config/paths.yml'));
        $this->path_to_private_dir = __DIR__ . $config['path_to_private_dir'];
    }

    public function check($key) {
        $authorised = false;
        foreach ($this->getAshtonApiKeys() as $email => $authorised_key) {
            if ($key == $authorised_key) {
                $authorised = true;
            }
        }
        return $authorised;
    }

    public function pathToPrivateDirectory() {
        return $this->path_to_private_dir;
    }

    public function getMyPersonalAshtonApiKey() {
        return $this->getAshtonApiKeys()['chris.ashton@webdapper.com'];
    }

    public function getAshtonApiKeys() {
        return yaml_parse(file_get_contents($this->path_to_private_dir . '/ashton-api.yml'));
    }

    public function getLinkedInKeys() {
        return yaml_parse(file_get_contents($this->path_to_private_dir . '/linkedin.yml'));
    }

    public function getTwitterKeys() {
        return yaml_parse(file_get_contents($this->path_to_private_dir . '/twitter.yml'));
    }

    public function getInstagramToken() {
        $instagram = yaml_parse(file_get_contents($this->path_to_private_dir . '/instagram.yml'));
        return $instagram['access-token'];
    }
}
