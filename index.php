<?php
require 'vendor/autoload.php';

$app = new \Slim\App;

$app->get('/{folder_id}', function ($request, $response, $args) {
  // Get feed
  $feed = new GoogleFeed();

  // Write folder with ID
  $response
    ->getBody()
    ->write(
      json_encode(
        $feed->getFolder($args['folder_id']),
        true
      )
    );

  return $response;
});

$app->run();


//root folder id:0Byo7P47EvrO9ZU1BdHpMUFVNN00
