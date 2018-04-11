<?php
// -------------------- PREVENT CSRF(CROSS SITE REQUEST FORGERY) ----------------------- */
function csrf_token() {
	// return bin2hex(random_bytes(32));
	return md5(uniqid(rand(), TRUE));
}

function create_csrf_token() {
	$_SESSION['csrf_token'] = csrf_token();
	$_SESSION['csrf_token_time'] = time();
	return $_SESSION['csrf_token'];
}

function destroy_csrf_token() {
	$_SESSION['csrf_token'] = null;
	$_SESSION['csrf_token_time'] = null;
	return true;
}

function csrf_token_tag() {
	$token = create_csrf_token();
	return "<input type=\"hidden\" name=\"csrf_token\" value=\"" . $token . "\">";
}

function is_valid_csrf_token() {
	if(isset($_POST['csrf_token'])) {
		return $_POST['csrf_token'] === $_SESSION['csrf_token'];
	} else {
		return false;
	}	
}

function die_on_invalid_csrf_token() {
	if(!is_valid_csrf_token()) {
		die();
	}
}

function is_recent_csrf_token() {
	if(isset($_SESSION['csrf_token_time'])) {
		return ($_SESSION['csrf_token_time'] + (60 * 60)) >= time();
	} else {
		destroy_csrf_token();
		return false;
	}
}
// -------------------- PREVENT FAKED REQUEST ----------------------- */
function is_not_faked_request() {
	if(!isset($_SERVER['HTTP_REFERER'])) {
		return false;
	} else {
		return parse_url($_SERVER['HTTP_REFERER'],  PHP_URL_HOST) == $_SERVER['HTTP_HOST'];
	}
}
?>