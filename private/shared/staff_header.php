<!doctype html>
<html>
<head>
    <title>FMS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="<?php echo url_for('stylesheets/style.css'); ?>" type="text/css">

	<!-- Add jQuery -->  
	<script type="text/javascript" src="<?php echo url_for('js/jquery-3.3.1.min.js'); ?>"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<div id="company_logo">
				<img src="<?php echo url_for('images/logo.png') ?>" alt="logo">
			</div>
			<?php if($session->is_logged_in()) { ?>
			<div id="nav">
				<ul>
					<li><a href="<?php echo url_for('vehicles'); ?>">Vozila</a></li>
					<li><a href="<?php echo url_for('drivers'); ?>">vozači</a></li>
					<li><a href="<?php echo url_for('admins'); ?>">Administratori</a></li>
				</ul>
			</div>
			<?php } ?>
			
			<div id="app_logo">
			<img src="<?php echo url_for('images/fms.png') ?>" alt="Fleet Management System">
			</div>
		</div><!-- kraj header-a -->

		<div id="sidebar">
		<?php
			if($session->is_logged_in()) {
			
				if(isset($_GET['drivers-widget'])) {
					include_once(SHARED_PATH . '/nav_widgets/drivers_widget.php');
				} elseif(isset($_GET['vehicles-widget'])) {
					include_once(SHARED_PATH . '/nav_widgets/vehicles_widget.php');
				} else {
					include_once(SHARED_PATH . '/nav_widgets/admins_widget.php');
				}
			
			} else {
				include_once(SHARED_PATH . '/nav_widgets/login.php');
			}
		?>
		</div><!-- kraj sidebar-a -->