<?php
	require_once('../../private/initialize.php');
	require_login();
	if(!isset($_GET['id'])) { redirect_to(url_for('vehicles/index.php')); }
	$id = h($_GET['id']);
	$vehicle = Vehicle::find_by_id($id);

?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<a class="back" href="<?php echo url_for('vehicles'); ?>">&laquo; Povratak na stranicu prikaza svih vozila</a>
	</div>
	<?php echo display_session_message(); ?>
	<table class="user">
		<tr>
			<th>Registraciona oznaka</th>
			<td><?php echo h($vehicle->reg_plate); ?></td>
		</tr>
		<tr>
			<th>Marka</th>
			<td><?php echo h($vehicle->make_name); ?></td>
		</tr>
		<tr>
			<th>Model</th>
			<td><?php echo h($vehicle->model); ?></td>
		</tr>
		<tr>
			<th>Tip motora</th>
			<td><?php echo h($vehicle->engine); ?></td>
		</tr>
		<tr>
			<th>Tip goriva</th>
			<td><?php echo h($vehicle->fuel_type); ?></td>
		</tr>
		<tr>
			<th>Kilometraža</th>
			<td><?php echo h($vehicle->kilometrage); ?></td>
		</tr>
		<tr>
			<th>Datum poslednje registracije</th>
			<td><?php echo h($vehicle->reg_date); ?></td>
		</tr>
		<tr>
			<th>Godina proizvodnje</th>
			<td><?php echo h($vehicle->prod_year); ?></td>
		</tr>
	</table>
</div>

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>