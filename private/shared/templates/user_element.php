<div class="element">
		<img src="<?php echo url_for("images/admins/" . h($user->id) . ".jpg"); ?>" alt="">	
		
	<?php if($admin->status == 2) { ?>
		<?php if($admin->id != $user->id) { ?>
		<a href="<?php echo url_for('delete-admins/' . h(u($user->id))); ?>">
			<img id="delete" src="<?php echo url_for('images/delete.png'); ?>" alt="">
		</a>
		<?php } ?>
		<a href="<?php echo url_for('edit-admins/' . h(u($user->id))); ?>">
			<img id="edit" src="<?php echo url_for('images/edit.png'); ?>" alt="">
		</a>
	<?php } ?>
		<a href="<?php echo url_for('admins/' . h(u($user->id))); ?>">
			<img id="user_info" src="<?php echo url_for('images/info.png'); ?>" alt="">
		</a>
	
	<div id="tabela">
		<table class="user">
			<tr>
				<th>Korisnicko ime:</th>
				<td><?php echo h($user->username); ?></td>
			</tr>
			<tr>
				<th>Ime i prezime:</th>
				<td><?php echo h($user->full_name()); ?></td>
			</tr>
			<tr>
				<th>Pozicija:</th>
				<td><?php echo h($user->position_name); ?></td>
			</tr>
			<tr>
				<th>Status:</th>
				<td><?php echo (h($user->status) == "1") ? "Admin": "Superadmin"; ?></td>
			</tr>
		</table>
	</div>
</div>
	