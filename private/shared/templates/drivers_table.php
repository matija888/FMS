<tr>
	<td><?php echo h($driver->id) ?></td>
	<td><?php echo h($driver->full_name()) ?></td>
	<td><?php echo h($driver->position_name); ?></td>
	<?php if($driver->reg_plate !== null) { ?>
		<td><?php echo h($driver->reg_plate); ?></td>
	<?php } else { ?>
		<td style="background-color: yellow;">neraspoređen</td>
	<?php } ?>

	<td>
		<a href="<?php echo url_for('drivers/' . h(u($driver->id)) ); ?>">
			<img src="<?php echo url_for('images/info.png'); ?>" alt="">
		</a>
	</td>
	<td>
		<a href="<?php echo url_for('edit-drivers/' . h(u($driver->id)) ); ?>">
			<img src="<?php echo url_for('images/edit.png'); ?>" alt="">
		</a>
	</td>
	<td>
		<a href="<?php echo url_for('delete-drivers/' . h(u($driver->id)) ); ?>">
			<img src="<?php echo url_for('images/delete.png'); ?>" alt="">
		</a>
	</td>
</tr>
	