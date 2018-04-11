<?php
	require_once('../../private/initialize.php');
	require_login();

	$id = h($_GET['id']);
	
	$driver = Driver::find_by_id($id);
	if($driver === false) {
		redirect_to(url_for('drivers'));
	}

	if(is_post_request()){

		$args = h_args($_POST['driver']);

		// var_dump($args);
		// exit();

		$driver->change_attributes($args);
		
		$result = $driver->update();

		if($result === true) {
			$_SESSION['message'] = 'Podaci korisnika '. h($driver->full_name()) .' su uspesno izmenjeni';
			redirect_to(url_for('drivers/' . h(u($id)) ));
		} else {
			// display the rest of the page with displaying errors
			$errors = $driver->errors;
		}

	}
?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<a class="back" href="<?php echo url_for('drivers'); ?>">&laquo; Povratak na stranicu prikaza svih vozača</a>
	</div>
	<article>
		<h1>Izmeni podatke postojeceg vozača</h1>
		<form action="<?php echo url_for('edit-drivers/' . h(u($driver->id)) ); ?>" method="post">
			<?php include(SHARED_PATH . '/templates/driver_form_fields.php'); ?>		
			<input type="submit" value="Izmeni korisnika" class="btn">	
		</form>
		<?php echo display_errors($errors); ?>
	</article>
</div><!-- kraj main-a -->

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	