<?php
	require_once('../../private/initialize.php');
	require_login();
	include_once(SHARED_PATH . '/staff_header.php');

if(is_post_request()) {

	$args = h_args($_POST['driver']);

	$driver = new Driver($args);
	$result = $driver->insert();
	// var_dump($result);

	if($result === true) {
		$new_id = $driver->id;
		$_SESSION['message'] = 'Vozac '. h($driver->full_name()) .'je uspesno registrovan u bazi.';
		redirect_to(url_for('drivers/' . h(u($new_id)) ));
	} else {
		// display the rest of the page with displaying errors
	}

} else {
	$driver = new Driver();
}

?>
<div id="main">
	<div class="action">
		<a class="back" href="<?php echo url_for('drivers'); ?>">&laquo; Povratak na stranicu prikaza svih vozača</a>
	</div>
	<article>
		<h1>Dodaj novog vozaca</h1>
		<?php echo display_errors($driver->errors); ?>
		<form action="<?php echo url_for('insert-drivers'); ?>" method="post">
			<?php include(SHARED_PATH . '/templates/driver_form_fields.php'); ?>
			<input type="submit" value="Registruj korisnika" class="btn">
		</form>
		<?php echo display_message($message); ?>
	</article>
</div><!-- kraj main-a -->

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	