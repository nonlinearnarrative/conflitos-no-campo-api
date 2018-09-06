<?php
require 'vendor/autoload.php';

$app = new Slim\App;
$app->get('/update-index', '\FolderIndexController:updateIndex');
$app->get('/', '\FolderIndexController:returnJSON');
$app->run();

//root folder id:0Byo7P47EvrO9ZU1BdHpMUFVNN00
