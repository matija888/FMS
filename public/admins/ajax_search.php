<?php
require_once('../../private/initialize.php');
require_login();

$username = isset($_POST['username']) ? h($_POST['username']) : '';

$first_name = isset($_POST['first_name']) ? h($_POST['first_name']) : '';

if(has_presence($username)) {
	$result = has_unique_username($username) ? true : false;
	echo json_encode($result);
}

if($first_name) {
	$user = User::find_by_first_name($first_name);

	$result['admin_id'] = $_SESSION['user_id'];
	$result['admin_status'] = $_SESSION['user_status'];

	$result['user'] = ($user !== false) ? $user : 'false';
	// header("Content-Type: application/json");
	echo json_encode($result);
}