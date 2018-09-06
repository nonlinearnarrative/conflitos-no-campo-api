<?php
require 'vendor/autoload.php';

$app = new \Slim\App;
$gf = new GoogleFeed();

$app->get('/', function ($request, $response, $args) {
  forEach($gf->getFolder('0Byo7P47EvrO9ZU1BdHpMUFVNN00') as $file) {
    print_r($file);
  }
});

$app->run();
