<?php
	require_once('../../private/initialize.php');
	require_login();
	include_once(SHARED_PATH . '/staff_header.php');

if(is_post_request()){

	$args = h_args($_POST['vehicle']);
	
	$vehicle = new Vehicle($args);
	
	$result = $vehicle->insert();

	if($result === true) {
		$new_id = $vehicle->id;
		$_SESSION['message'] = 'Vozilo '. h($vehicle->reg_plate) .' je uspesno registrovano u bazi.';
		redirect_to(url_for('vehicles/' . h(u($new_id)) ));
	} else {
		// display the rest of the page with displaying errors
	}

} else {
	$vehicle = new Vehicle();
}

?>
<div id="main">
	<div class="action">
		<a class="back" href="<?php echo url_for('vehicles'); ?>">&laquo; Povratak na stranicu prikaza svih vozila</a>
	</div>
	<article>
		<h1>Dodaj novo vozilo</h1>
		<?php echo display_errors($vehicle->errors); ?>
		<form action="<?php echo url_for('insert-vehicles'); ?>" method="post">
			<?php include(SHARED_PATH . '/templates/vehicles_form_fields.php'); ?>
			<input type="submit" value="Dodaj vozilo" class="btn">
		</form>
	</article>
</div><!-- kraj main-a -->

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	