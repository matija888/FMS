<?php
	require_once('../../private/initialize.php');
	require_login();

	$id = h($_GET['id']);
	$user = User::find_by_id($id);
	if($user === false) {
		redirect_to(url_for('admins'));
	}

	if(is_post_request()){

		$result = $user->delete();
		if($result === true) {
			unlink(PUBLIC_PATH . "/images/admins/" . h($user->id) . ".png");
			$_SESSION['message'] = 'Korisnik '. h($user->username) .' je uspesno izbrisan iz baze.';
			redirect_to(url_for('admins'));
		} else {
			// display the rest of the page with displaying errors

		}

	}
?>
<?php include_once(SHARED_PATH . '/staff_header.php'); ?>
<div id="main">
	<div class="action">
		<a class="back" href="<?php echo url_for('admins'); ?>">&laquo; Povratak na stranicu prikaza svih korisnika</a>
	</div>
	<article>
		<h1>Brisanje korisnika iz baze</h1>
		<p class="attention">Da li ste sigurni da zelite da obrisete korisnika iz baze? <br>
		Izbrisani podaci bice nepovratno izbrisani.</p>
		<?php echo display_errors($user->errors); ?>
		<div id="tabela">
				<table>
					<tr>
						<td>Korisnicko ime:</td>
						<td><?php echo h($user->username); ?></td>
					</tr>
					<tr>
						<td>Ime i prezime:</td>
						<td><?php echo h($user->full_name()); ?></td>
					</tr>
					<tr>
						<td>Pozicija:</td>
						<td><?php echo h($user->position_id); ?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?php echo h($user->email); ?></td>
					</tr>
					<tr>
						<td>Status:</td>
						<td>
						<?php echo h($user->status) . " / "?>
						<?php echo ( h($user->status) == "1" ) ? "Admin": "Superadmin" ?>
						</td>
					</tr>
				</table>
			</div>
		<form action="<?php echo url_for('delete-admins/' . $user->id); ?>" method="post">	
			<input type="submit" value="Izbrisi korisnika" class="btn">	
		</form>
	</article>
</div><!-- kraj main-a -->

<?php include_once(SHARED_PATH . '/staff_footer.php'); ?>
        
	