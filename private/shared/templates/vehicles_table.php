<tr>
	<td><?php echo h($vehicle->id); ?></td>
	<td><?php echo h($vehicle->reg_plate); ?></td>
	<td><?php echo h($vehicle->make_name); ?></td>
	<td><?php echo h($vehicle->model); ?></td>
	<td><?php echo h($vehicle->engine); ?></td>
	<td><?php echo h($vehicle->fuel_type); ?></td>
	<td><?php echo date('d-m-Y', strtotime(h($vehicle->reg_date)) ); ?></td>
	<td><?php echo h($vehicle->prod_year); ?></td>
	<td>
		<a href="<?php echo url_for('vehicles/' . h(u($vehicle->id)) ); ?>">
			<img src="<?php echo url_for('images/info.png'); ?>" alt="">
		</a>
	</td>
	<td>
		<a href="<?php echo url_for('edit-vehicles/' . h(u($vehicle->id)) ); ?>">
			<img src="<?php echo url_for('images/edit.png'); ?>" alt="">
		</a>
	</td>
	<td>
		<a href="<?php echo url_for('delete-vehicles/' . h(u($vehicle->id)) ); ?>">
			<img src="<?php echo url_for('images/delete.png'); ?>" alt="">
		</a>
	</td>
</tr>
