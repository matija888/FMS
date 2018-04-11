<?php
require_once('../../private/initialize.php');
require_login();

$drivers = Driver::find_all();

$drivers = json_encode($drivers);
// header("Content-Type: application/json");
echo $drivers;