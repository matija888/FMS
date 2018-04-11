<?php
	require_once('../../private/initialize.php');
	require_login();

	$id = h($_GET['id']);
	
	$vehicle = Vehicle::find_by_id($id);
	if($vehicle === false) {
		redirect_to(url_for('vehicles/index.php'));
	}

	if(is_post_request()){

		$args = h_args($_POST['vehicle']);
		$vehicle->change_attributes($args);

		$result = $vehicle->update();

		if($result === true) {
			$_SESSION['message'] = 'Podaci vozila '. h($vehicle->reg_plate) .' su uspesno izmenjeni';
			redirect_to(url_for('vehicles/show.php?vehicle_widget&id=' . h(u($id)) ));
		} else {
			// display the rest of the page with displaying errors

		}

	}
?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<a class="back" href="<?php echo url_for('vehicles'); ?>">&laquo; Povratak na stranicu prikaza svih vozila</a>
	</div>
	<article>
		<h1>Izmeni podatke postojeceg vozila</h1>
		<?php echo display_errors($vehicle->errors); ?>
		<form action="<?php echo url_for('vehicles/edit.php?vehicle_widget&id=' . h(u($vehicle->id)) ); ?>" method="post">
			<?php include(SHARED_PATH . '/templates/vehicles_form_fields.php'); ?>		
			<input type="submit" value="Izmeni vozilo" class="btn">	
		</form>
	</article>
</div><!-- kraj main-a -->

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	