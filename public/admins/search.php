<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php

if(is_post_request()) {
	$first_name = isset($_POST['first_name']) ? h($_POST['first_name']) : '';
	// var_dump($first_name);
	$users = User::find_by_first_name($first_name);
	// var_dump($user);
} else {
	$users = false;
	$first_name = '';
}
?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<form action="<?php echo url_for('search-admins'); ?>" method="post">
			<input type="text" name="first_name" id="first_name" onkeyup="ajaxSearch()">
			<input type="submit" class="btn" value="Search">
		</form>
		<span>Ukucajte ime da biste pronašli administratora</span>
		<p id="ajax-error"></p>
	</div>
	<?php
		echo "<article>";
		if($users) {
			foreach ($users as $user) {
				include(SHARED_PATH . '/templates/user_element.php');
			}
		} elseif(!empty($first_name)) {
			$message[] = "User with first_name = '" . h($first_name) . "' doesn't exist!";
		}
		echo "</article>";

		echo display_message($message);
	?>
<script src="<?php echo url_for('js/user_search.js'); ?>"></script>
</div><!-- kraj main-a -->

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	