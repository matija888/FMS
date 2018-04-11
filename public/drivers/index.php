<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php

// set current_page, per_page and get from database total user count
$current_page = isset($_GET['page']) ? h($_GET['page']) : 1;
$total_page = Driver::count_all();
$per_page = 13;
$pagination = new Pagination($current_page, $per_page, $total_page);

$sql = "SELECT *, drivers.id AS id FROM drivers ";
$sql .= "LEFT JOIN positions ON positions.position_id = drivers.position_id ";
$sql .= "LEFT JOIN drivers_vehicles ON drivers_vehicles.driver_id = drivers.id ";
$sql .= "LEFT JOIN vehicles ON drivers_vehicles.vehicle_id = vehicles.id ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
// echo $sql;
$drivers = Driver::find_by_sql($sql);
// var_dump($drivers);
?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<a class="btn" href="<?php echo url_for('insert-drivers'); ?>">Dodaj novog vozaca</a>
	</div>
	<?php
		if($pagination->total_pages() != 1) {
			$url = url_for('drivers');
			echo $pagination->page_links($url);
		}
		if($drivers) {
			?>
			<article>
				<table class="user">
					<tr>
						<th>ID</th>
						<th>Ime i prezime</th>
						<th>Pozicija</th>
						<th>Registraciona oznaka</th>
						<th>View</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
					<?php
					foreach ($drivers as $driver) {
						include(SHARED_PATH . '/templates/drivers_table.php');
					}
					?>
				</table>	
			</article>
			<?php
		}
		
	?>
</div><!-- kraj main-a -->

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	