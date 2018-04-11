<?php
	require_once('../../private/initialize.php');
	require_login();
	if(!isset($_GET['id'])) { redirect_to(url_for('drivers')); }
	$id = h($_GET['id']);
	$driver = Driver::find_by_id($id);
?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<a class="back" href="<?php echo url_for('drivers'); ?>">&laquo; Povratak na stranicu prikaza svih korisnika</a>
	</div>
	<?php echo display_session_message(); ?>
	<table class="user">
		<tr>
			<th>First name</th>
			<td><?php echo h($driver->first_name); ?></td>
		</tr>
		<tr>
			<th>Last name</th>
			<td><?php echo h($driver->last_name); ?></td>
		</tr>
		<tr>
			<th>Phone</th>
			<td><?php echo h($driver->phone); ?></td>
		</tr>
		<tr>
			<th>Email</th>
			<td><?php echo h($driver->email); ?></td>
		</tr>
		<tr>
			<th>Address</th>
			<td><?php echo h($driver->address_name); ?></td>
		</tr>
		<tr>
			<th>City</th>
			<td><?php echo h($driver->city_name); ?></td>
		</tr>
		<tr>
			<th>Country</th>
			<td><?php echo h($driver->country_name); ?></td>
		</tr>
		<tr>
			<th>Position</th>
			<td><?php echo h($driver->position_name); ?></td>
		</tr>
	</table>
</div>

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>