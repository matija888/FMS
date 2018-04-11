<?php
	function url_for($path) {
		if($path[0] != '/') {
			$path = '/' . $path;
		}
		return WWW_ROOT . $path;
	}

	function redirect_to($location) {
		header("Location: " . $location);
	}

	function is_get_request() {
		return $_SERVER['REQUEST_METHOD'] === "GET";
	}

	function is_post_request() {
		return $_SERVER['REQUEST_METHOD'] === "POST";
	}

	function h($value) {
		return htmlspecialchars($value);
	}

	function h_args($unsafe_args) {
		$args = [];
		foreach ($unsafe_args as $key => $value) {
			$args[$key] = h($value);
		}
		return $args;
	}

	function u($value) {
		return urlencode($value);
	}

	function display_errors($errors) {
		$output = "";
		if(!empty($errors)) {
			$output .= "<div class='error'><ul>";
			foreach ($errors as $error) {
				$output .= "<li>". $error ."</li>";
			}
			$output .= "</ul></div>";

			return $output;
		}
	}

	function display_message($message) {
		$output = "";
		if(!empty($message)) {
			$output .= "<div class='message'><ul>";
			foreach ($message as $msg) {
				$output .= "<li>". $msg ."</li>";
			}
			$output .= "</ul></div>";

			return $output;
		}
	}

	function clear_session_msg() {
		if(isset($_SESSION['message'])) {
			unset($_SESSION['message']);
		} 
	}

	function display_session_message() {
		$output = '';
		if(isset($_SESSION['message'])) {
			$msg = $_SESSION['message'];
			$output .= "<div id=\"message\">";
			$output .= $msg;
			$output .= "</div>";
		}
		clear_session_msg();
		return $output;
	}

	function require_login() {
		global $session;
		if(!$session->is_logged_in()) {
			redirect_to(url_for('/login'));
		}
	}
