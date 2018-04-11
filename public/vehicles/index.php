<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php

// set current_page, per_page and get from database total user count
$current_page = isset($_GET['page']) ? h($_GET['page']) : 1;
$total_page = Vehicle::count_all();
$per_page = 11;
$pagination = new Pagination($current_page, $per_page, $total_page);

$sql = "SELECT * FROM vehicles ";
$sql .= "LEFT JOIN vehicles_make ";
$sql .= "ON vehicles.make_id = vehicles_make.make_id ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$vehicles = Vehicle::find_by_sql($sql);

?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<a class="btn" href="<?php echo url_for('insert-vehicles'); ?>">Dodaj novo vozilo</a>
	</div>
	<?php
		if($pagination->total_pages() != 1) {
			$url = url_for('vehicles');
			echo $pagination->page_links($url);
		}
		if($vehicles) {
		?>
		<article>
			<table class="vehicles">
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
		<?php
		foreach ($vehicles as $vehicle) {
			include(SHARED_PATH . '/templates/vehicles_table.php');
		} ?>
			</table>	
		</article>
		<?php
		}
	?>
</div><!-- kraj main-a -->

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	