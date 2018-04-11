<?php
	require_once('../../private/initialize.php');
	require_login();

	$id = h($_GET['id']);
	$vehicle = Vehicle::find_by_id($id);
	
	if($vehicle === false) {
		redirect_to(url_for('vehicles/index.php'));
	}

	if(is_post_request()){

		$result = $vehicle->delete();
		// var_dump($result);
		if($result === true) {
			$_SESSION['message'] = 'Korisnik '. h($vehicle->reg_plate) .' je uspesno izbrisan iz baze.';
			redirect_to(url_for('vehicles/index.php'));
		} else {
			// display the rest of the page with displaying errors

		}

	}
?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<a class="back" href="<?php echo url_for('vehicles'); ?>">&laquo; Povratak na stranicu prikaza svih vozila</a>
	</div>
	<article>
		<h1>Brisanje vozila iz baze</h1>
		<p class="attention">Da li ste sigurni da zelite da obrisete vozilo iz baze? <br>
		Izbrisani podaci bice nepovratno izbrisani.</p>
		<?php echo display_errors($vehicle->errors); ?>
		<div id="tabela">
			<table>
				<tr>
					<td>Registration plate:</td>
					<td><?php echo h($vehicle->reg_plate); ?></td>
				</tr>
				<tr>
					<td>Make:</td>
					<td><?php echo h($vehicle->make_name); ?></td>
				</tr>
				<tr>
					<td>Model/Engine:</td>
					<td><?php echo h($vehicle->model) . " / " . h($vehicle->engine); ?></td>
				</tr>
			</table>
		</div>
		<form action="<?php echo url_for('vehicles/delete.php?id=' . $vehicle->id); ?>" method="post">	
			<input type="submit" value="Izbrisi korisnika" class="btn">	
		</form>
	</article>
</div><!-- kraj main-a -->

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	