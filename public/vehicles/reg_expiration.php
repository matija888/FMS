<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php

// set current_page, per_page and get from database total user count
$current_page = isset($_GET['page']) ? h($_GET['page']) : 1;

$total_page = Vehicle::count_all();

$per_page = 7;
$pagination = new Pagination($current_page, $per_page, $total_page);

$sql = "SELECT * FROM vehicles ";
$sql .= "LEFT JOIN vehicles_make ";
$sql .= "ON vehicles.make_id = vehicles_make.make_id ";
$sql .= "ORDER BY reg_date ASC ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()} ";
// var_dump($sql);
$vehicles = Vehicle::find_by_sql($sql);
// var_dump($vehicles);
$period = isset($_GET['period']) ? h($_GET['period']) : false;
if($period) {
	$vehicles = Vehicle::find_vehicles_by_reg_period($period);
}

?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<?php
		$url = url_for('vehicles/reg_expiration.php?vehicle_widget&');
		
		if($pagination->total_pages() != 1) {
			echo $pagination->page_links($url);
		}
		if($vehicles) {
			?>
			<h1>Istek registracija</h1>
			<p>Današnji datum: <?php echo date('d-m-Y'); ?></p>
			<p>Istek registracija u narednih:</p>
			<div>
				<input type="radio" name="period" value="days_5" id="days_5"><span>5 dana</span>
				<input type="radio" name="period" value="days_10" id="days_10"><span>10 dana</span>
				<input type="radio" name="period" value="days_30" id="days_30"><span>30 dana</span>
				<input type="radio" name="period" value="display_all" id="display_all"><span>Prikaz svih vozila</span>
			</div><br>
			<article>
				<table class="vehicles">
					<thead>
						<th>Expiration of registration</th>
						<th>Registration date</th>
						<th>ID</th>
						<th>Registration plate</th>
						<th>Make</th>
						<th>Model</th>
						<th>Engine</th>
						<th>Fuel type</th>
						<th>Production year</th>
						<th>View</th>
						<th>Edit</th>
						<th>Delete</th>
					</thead>
					<tbody>	
						
					<?php
						foreach ($vehicles as $vehicle) {
							include(SHARED_PATH . '/templates/vehicles_table_reg.php');
					} ?>
					</tbody>
				</table>	
			</article>
			<?php
		}
	?>
</div><!-- kraj main-a -->
<script src="<?php echo url_for('js/vehicle_registration.js'); ?>"></script>
<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	