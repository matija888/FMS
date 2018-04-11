<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php

// set current_page, per_page and get from database total user count
$current_page = isset($_GET['page']) ? h($_GET['page']) : 1;
$total_page = User::count_all();
$per_page = 6;
$pagination = new Pagination($current_page, $per_page, $total_page);

$sql = "SELECT * FROM users ";
$sql .= "LEFT JOIN positions ON users.position_id = positions.position_id ";
$sql .= "ORDER BY users.position_id ASC ";
$sql .= " LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$users = User::find_by_sql($sql);


// var_dump($_SERVER);
?>

<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<?php if($admin->status == 2) { ?>
	<div class="action">
		<a class="btn" href="<?php echo url_for('insert-admins'); ?>">Dodaj novog administratora</a>
	</div>
	<?php } ?>
	<?php
		if($pagination->total_pages() != 1) {
			$url = url_for('admins');
			echo $pagination->page_links($url);
		}
		
		if($users) {
			echo "<article>";
			foreach ($users as $user) {
				include(SHARED_PATH . '/templates/user_element.php');
			}
			echo "</article>";
		}
	?>
</div><!-- kraj main-a -->
<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>