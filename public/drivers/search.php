<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php

if(is_post_request()) {
	$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
	// var_dump($first_name);
	$drivers = Driver::find_by_first_name($first_name);
	// var_dump($driver);
} else {
	$drivers = false;
	$first_name = '';
}
?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<form action="<?php echo url_for('search-drivers'); ?>" method="post">
			<input type="text" name="first_name" id="first_name" onkeyup="ajaxSearch()">
			<input type="submit" class="btn" value="Search">
		</form>
		<span>Ukucajte ime da biste pronašli vozača</span>
	</div>
		<article>
			<table class="user">
				<thead>
					<tr>
						<th>ID</th>
						<th>Ime i rezime</th>
						<th>Pozicija</th>
						<th>Vozilo koje duži</th>
						<th>View</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
				<?php
					if($drivers) {
						foreach ($drivers as $driver) {
							include(SHARED_PATH . '/templates/drivers_table.php');
						}
					} elseif(!empty($first_name)) {
						$message[] = "Driver with first_name = '" . $db->db_escape($first_name) . "' doesn't exist!";
					}
				?>
				</tbody>
			</table>	
		</article>
		<?php echo display_message($message); ?>
</div><!-- kraj main-a -->
<script src="<?php echo url_for('js/driver_search.js'); ?>"></script>
<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	