<?php
require 'vendor/autoload.php';

header("Access-Control-Allow-Origin: *");

$app = new Slim\App;
$app->get('/update-index', '\FolderIndexController:updateIndex');
$app->get('/', '\FolderIndexController:returnJSON');
$app->run();
