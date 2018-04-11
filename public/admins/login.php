<?php require_once('../../private/initialize.php'); ?>
<?php
	if(is_not_faked_request()) {
			
	if(is_post_request()) {

		if(is_valid_csrf_token()) {

			if(is_recent_csrf_token()) {

				$username = trim($_POST['username']);
				$password = trim($_POST['password']);

				if(empty($username)) {
					$errors[] = "Morate uneti korisničko ime da biste se ulogovali.";
				} 

				if (empty($password)) {
					$errors[] = "Morate uneti lozinku da biste se ulogovali.";
				}

				if(empty($errors)) {
					// try to find user with username/pass combination
					// $user = User::authenticate($username, $password);
					$user = User::find_by_username($username);
					if($user != false && $user->verify_password($password)) {
						$session->login($user);
						redirect_to(url_for('admins'));
					} else {
						$errors[] = "Greška pri logovanju. Molimo Vas da unesete ispravno korisničko ime i lozinku.";
					}
				}

			} else {
				$errors[] = "Greška pri logovanju";
				// token is not recent
				// $errors[] = "Token is not recent";
				// var_dump($_SESSION);
				// var_dump($_POST);
			}
		} else {
			$errors[] = "Greška pri logovanju";
			// $errors[] = "Token is not valid<br>";
			// var_dump($_SESSION);
			// var_dump($_POST);
			// token is not valid
		}
		
	} else {
		// var_dump($_SESSION);
		// var_dump($_POST);
		$username = '';
		$password = '';
		$message[] = "Molimo Vas da se ulogujete koristeći svoje korisničko ime i lozinku.";
	}
} else {
	// it is faked request (there is no $_SERVER['HTTP_REFERER'] defined)
	// var_dump(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST));
	// var_dump($_SERVER['HTTP_REFERER']);
	// var_dump($_SERVER['HTTP_HOST']);
}

	// var_dump($_SERVER);
?>


<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
<?php
	echo display_errors($errors);
	echo display_message($message);
?>
	<p>FMS (Fleet Management System) je aplikacija namenjena za upravljanje voznim parkom. Molimo Vas da se ulogujete sa svojim korisničkim imenom i lozinkom.</p>
</div><!-- kraj main-a -->

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>