<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php

if(is_post_request()) {
	$reg_plate = isset($_POST['reg_plate']) ? h($_POST['reg_plate']) : '';
	// var_dump($reg_plate);
	$vehicle = Vehicle::find_by_reg_plate($reg_plate);
	// var_dump($vehicle);
} else {
	$vehicle = false;
	$reg_plate = '';
}
?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<form action="<?php echo url_for('vehicles/search.php?vehicle_widget'); ?>" method="post">
			<input type="text" name="reg_plate" id="reg_plate" onkeyup="ajaxSearch()">
			<input type="submit" class="btn" value="Search">
		</form>
		<span>Ukucajte registracionu oznaku da biste pronašli vozilo</span>
	</div>
	<article>
		<table class="vehicles">
			<thead>
				<tr>
					<th>ID</th>
					<th>Registraciona oznaka</th>
					<th>Marka</th>
					<th>Model</th>
					<th>Motor</th>
					<th>Tip goriva</th>
					<th>Datum poslednje registracije</th>
					<th>Godina proizvodnje</th>
					<th>View</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if($vehicle) {
					include(SHARED_PATH . '/templates/vehicles_table.php');
				} elseif(!empty($reg_plate)) {
					$message[] = "vehicle with reg_plate = '" . h($reg_plate) . "' doesn't exist!";
				}
				echo display_message($message);
			?>
			</tbody>
		</table>
	</article>
</div><!-- kraj main-a -->
<script src="<?php echo url_for('js/vehicle_search.js'); ?>"></script>
<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	