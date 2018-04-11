<?php
	require_once('../../private/initialize.php');
	require_login();
	include_once(SHARED_PATH . '/staff_header.php');

if(is_post_request()) {

	$args = h_args($_POST['user']);
	// var_dump($args);
	$user = new User($args);

	// UPLOADING USER PHOTO
	try {
		$file = new UploadFile(PUBLIC_PATH . '/images/admins/');
	} catch (Exception $e) {
		$errors[] = $e->getMessage();
	}

	$mysqli_result = $db->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'fleet' AND TABLE_NAME = 'users'");
	$autoincrement = $db->fetch_assoc($mysqli_result);
	$new_photo_id = $autoincrement['AUTO_INCREMENT'];

	$file->upload($new_photo_id);

	if(!empty($file->errors)) {
		$errors = $file->errors;
	} else {
		$result = $user->insert();

		if($result === true) {
			
			$new_id = $user->id;
			
			$_SESSION['message'] = 'Korisnik '. h($user->username) .' je uspesno registrovan';
			redirect_to(url_for('admins/' . h(u($new_id)) ));

		} else {	
			// display the rest of the page with displaying errors
			$errors = $user->errors;
		}
	}

} else {
	$user = new User();
	// var_dump($user);
}

?>
<div id="main">
	<div class="action">
		<a class="back" href="<?php echo url_for('admins'); ?>">&laquo; Povratak na stranicu prikaza svih korisnika</a>
	</div>
	<article>
		<h1>Kreiranje novog aministratora</h1>
		
		<p id="ajax-error"></p>
		<?php echo display_errors($errors); ?>
		<form action="<?php echo url_for('insert-admins'); ?>" method="post" enctype="multipart/form-data">

			<?php include(SHARED_PATH . '/templates/user_form_fields.php'); ?>	

			<label for="filename">Image</label>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo UploadFile::MAX_FILE_SIZE; ?>">
			<input type="file" name="filename" id="filename" accept="image/*" required><br>
			<span>Slika koju upload-ujete mora biti do 3KB</span><br>
			<input type="submit" value="Registruj korisnika" class="btn">
		</form>

	</article>
</div><!-- kraj main-a -->
<script src="<?php echo url_for('js/validate_username.js'); ?>"></script>
<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	