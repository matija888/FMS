<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php

// set current_page, per_page and get from database total user count
$current_page = isset($_GET['page']) ? h($_GET['page']) : 1;

$sql = "SELECT * FROM users ";
$sql .= "LEFT JOIN positions ON users.position_id = positions.position_id ";
$sql .= "ORDER BY users.position_id ASC ";
$users = User::find_by_sql($sql);
?>

<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<?php if($admin->status == 2) { ?>
		<div class="action">
			<a class="btn" href="<?php echo url_for('insert-admins'); ?>">Dodaj novog administratora</a>
		</div>
	<?php } ?>

	<div class="superadmin">
		<h3>Superadmins</h3>
		<?php foreach ($users as $user) {
			if($user->position_id == 1) {
				include(SHARED_PATH . '/templates/user_per_position.php');
			}
		} ?>
	</div>
	
	<div class="specialist">
		<h3>Fleet Reporting Specialists</h3>
		<?php foreach ($users as $user) {
			if($user->position_id == 2) {
				include(SHARED_PATH . '/templates/user_per_position.php');
			}
		} ?>
	</div>
	
	<div class="administrator">
		<h3>Fleet Administrators</h3>
		<?php foreach ($users as $user) {
			if($user->position_id == 3) {
				include(SHARED_PATH . '/templates/user_per_position.php');
			}
		} ?>
	</div>
	
</div><!-- kraj main-a -->
<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>