<?php

class Session {

	public $user_id;
	private $user_status;

	private $logged_in = false;
	private $last_login;

	const MAX_LOGIN_PERIOD = 60*60*24;

	function __construct() {
		session_start();
		$this->check_login();
	}

	private function check_login() {
		if(isset($_SESSION['user_id'])) {
			$this->user_id = $_SESSION['user_id'];
			$this->user_status = $_SESSION['user_status'];
			$this->last_login = $_SESSION['last_login'];
			$this->logged_in = true;
		} else {
			unset($this->user_id);
			unset($this->user_status);
			unset($this->last_login);
			$this->logged_in = false;
		}
	}

	public function is_logged_in() {
		// return $this->logged_in;
		return $this->logged_in && !$this->is_login_expired();
	}

	public function login($user) {
		if($user) {
			$this->user_id = $_SESSION['user_id'] = $user->id;
			$this->user_status = $_SESSION['user_status'] = $user->status;
			$this->last_login = $_SESSION['last_login'] = time();
			$this->logged_in = true;
		}
	}

	public function logout() {
		unset($_SESSION['user_id']);
		unset($_SESSION['user_status']);
		unset($this->user_id);
		unset($this->user_status);
		unset($this->last_login);
		$this->logged_in = false;
	}

	private function is_login_expired() {
		if(!isset($this->last_login)) {
			return true;
		} elseif(($this->last_login + self::MAX_LOGIN_PERIOD) < time()) {
			return true;
		} else {
			return false;
		}
	}

	public function display_session_message($msg="") {
		$output = '';
		if(isset($_SESSION['message'])) {
			$msg = $_SESSION['message'];
			$output .= "<div id=\"message\">";
			$output .= $msg;
			$output .= "</div>";
			unset($_SESSION['message']);
		}
		return $output;
	}
}