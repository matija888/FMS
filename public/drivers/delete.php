<?php
	require_once('../../private/initialize.php');
	require_login();

	$id = h($_GET['id']);
	$driver = Driver::find_by_id($id);

	if($driver === false) {
		redirect_to(url_for('drivers'));
	}

	if(is_post_request()) {

		$result = $driver->delete();

		if($result === true) {
			$_SESSION['message'] = 'Vozač '. h($driver->full_name()) .' je uspesno izbrisan iz baze.';
			redirect_to(url_for('drivers'));
		} else {
			// display the rest of the page with displaying errors
		}

	}
?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<a class="back" href="<?php echo url_for('drivers'); ?>">&laquo; Povratak na stranicu prikaza svih vozača</a>
	</div>
	<article>
		<h1>Brisanje vozača iz baze</h1>
		<p class="attention">Da li ste sigurni da zelite da obrisete vozača iz baze? <br>
		Izbrisani podaci bice nepovratno izbrisani.</p>
		<?php echo display_errors($driver->errors); ?>
		<div id="tabela">
			<table>
				<tr>
					<td>Ime i prezime:</td>
					<td><?php echo h($driver->full_name()); ?></td>
				</tr>
				<tr>
					<td>Pozicija:</td>
					<td><?php echo h($driver->position_name); ?></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><?php echo h($driver->email); ?></td>
				</tr>
			</table>
		</div>
		<form action="<?php echo url_for('delete-drivers/' . h(u($driver->id)) ); ?>" method="post">	
			<input type="submit" value="Izbrisi korisnika" class="btn">	
		</form>
	</article>
</div><!-- kraj main-a -->

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	