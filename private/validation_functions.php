<?php

	function is_blank($value) {
		return !isset($value) || trim($value) === '';
	}

	function has_presence($value) {
		return !is_blank($value);
	}

	function has_length_greater_than($value, $min) {
		$length = strlen($value);
		return $length > $min;
	}

	function has_length_less_than($value, $max) {
		$length = strlen($value);
		return $length < $max;
	}

	function has_length_exactly($value, $exact) {
		//$exact = (int) $exact;
		$length = strlen($value);
		return $length == $exact;
	}

	// for example has_length('abcd', [ 'min'=>3 , 'max'=>8 ])
	function has_length($value, $option) {
		if(isset($option['min']) && !has_length_greater_than($value, $option['min'] - 1)) {
			return false;
		} elseif( isset($option['max']) && !has_length_less_than($value, $option['max'] + 1)) {
			return false;
		} elseif(isset($option['exact']) && !has_length_exactly($value, $option['exact'])) {
			return false;
		} else {
			return true;
		}
	}

	function has_inclusion_of($value, $set) {
		return in_array($value, $set);
	}

	function has_exclusion_of($value, $set) {
		return !in_array($value, $set);
	}

	function has_string($value, $required_string) {
		return strpos($required_string, $value) !== false;
	}

	function has_valid_email_format($value) {
		$email_regex = "/[a-zA-z0-9.-]+\@[a-zA-z0-9.-]+.[a-zA-Z]+/"	;
		return preg_match($email_regex, $value) === 1;
	}

	function has_unique_page_name($page_name, $current_id) {
		$page_set = find_all_pages();

		while ($page = mysqli_fetch_assoc($page_set)) {
			if($page['menu_name'] === $page_name && $current_id === 0) {
				//var_dump($page['menu_name']);
				return false;
			}
		}

		return true;
	}

	function has_unique_username($username, $current_id=0) {
		$user = User::find_by_username($username);

		if($user === false || $user->id == $current_id) {
			// username is unique
			return true;
		} else {
			// username is not unique
			return false;
		}

	}
?>