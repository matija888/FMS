<?php
	require_once('../../private/initialize.php');
	require_login();
	if(!$session->is_logged_in() || !isset($_GET['id'])) { redirect_to(url_for('login')); }

	$id = h($_GET['id']);
	$user = User::find_by_id($id);
	
	if($user === false) {
		redirect_to(url_for('admins'));
	}

	if(is_post_request()){

		$args = h_args($_POST['user']);

		$user->change_attributes($args);
		$result = $user->update();

		$file = current($_FILES);
		if(!empty($file)) {
			try {
				$file = new UploadFile(PUBLIC_PATH . '/images/admins/');
			} catch (Exception $e) {
				$errors[] = $e->getMessage();
			}

			$res = $file->upload($user->id);
		}

		if($result === true) {
			$_SESSION['message'] = 'Podaci korisnika '. $user->username .' su uspesno izmenjeni';
			redirect_to(url_for('admins/' . h(u($id))));
		} else {
			// display the rest of the page with displaying errors

		}

	}
?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<a class="back" href="<?php echo url_for('admins'); ?>">&laquo; Povratak na stranicu prikaza svih korisnika</a>
	</div>
	<article>
		<h1>Izmeni podatke postojeceg korisnika</h1>
		<p id="ajax-error"></p>
		<?php echo display_errors($user->errors); ?>
		<form action="<?php echo url_for('edit-admins/' . h(u($user->id))); ?>" method="post" enctype="multipart/form-data">
			<?php include(SHARED_PATH . '/templates/user_form_fields.php'); ?>		
			<input type="submit" value="Izmeni korisnika" class="btn">	
		</form>
	</article>
</div><!-- kraj main-a -->
<script src="<?php echo url_for('js/validate_username.js'); ?>"></script>
<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	