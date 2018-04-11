<?php
require_once('../../private/initialize.php');
require_login();

$sql = "SELECT * FROM vehicles ";
$sql .= "LEFT JOIN vehicles_make ";
$sql .= "ON vehicles.make_id = vehicles_make.make_id ";
$sql .= "ORDER BY reg_date ";

$vehicles = Vehicle::find_by_sql($sql);
$vehicles = json_encode($vehicles);
// header("Content-Type: application/json");
echo $vehicles;