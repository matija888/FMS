<?php
	$admin = User::find_by_id($session->user_id);
?>
<div class="widget">
	<h2><?php echo ($admin->status === '2') ? 'Superadmin' : 'Admin'; ?></h2>
	<div class="inner">
		<table>
			<tr>
				<td><b>Ime i prezime:</b></td>
				<td><?php echo h($admin->full_name()); ?></td>
			</tr>
			<tr>
				<td><b>Korisničko ime:</b></td>
				<td><?php echo h($admin->username); ?></td>
			</tr>
		</table>
		<div>
			<div class="btn" onclick="location.href='<?php echo url_for('admins'); ?>'">Upravljanje administratorima</div>
			<div class="btn" onclick="location.href='<?php echo url_for('search-admins'); ?>'">Pretraga administratora</div>
			<div class="btn" onclick="location.href='<?php echo url_for('display-by-position'); ?>'">Prikaz administratora po pozicijama</div>
			<div class="btn" onclick="location.href='<?php echo url_for('logout'); ?>';">Logout</div>
		</div>
	</div>
</div>