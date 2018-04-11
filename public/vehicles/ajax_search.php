<?php
require_once('../../private/initialize.php');
require_login();

$reg_plate = isset($_POST['reg_plate']) ? h($_POST['reg_plate']) : '';
// $reg_plate = "BG 7";
if($reg_plate) {
	$vehicle = Vehicle::find_by_reg_plate($reg_plate);
	$vehicle = ($vehicle !== false) ? $vehicle : 'false';
	echo json_encode($vehicle);
}