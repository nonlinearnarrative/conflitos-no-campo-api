<?php
require 'vendor/autoload.php';
require 'google.php';

$gf = new GoogleFeed();

forEach($gf->getFolder('0Byo7P47EvrO9ZU1BdHpMUFVNN00') as $file) {
  print_r($file);
}
