<?php
	$end = date('d-m-Y', strtotime('+1 year', strtotime( h($vehicle->reg_date)) ));
	$current_date = date('d-m-Y');
?>
<tr
	<?php if(strtotime($current_date) > strtotime($end)) { echo " style=\"background-color: red; color:white;\""; } ?>
	<?php if(strtotime($current_date) < strtotime($end)
			&& strtotime('+5 days', strtotime($current_date)) > strtotime($end) )
		 { echo " style=\"background-color: #f09898; \""; } ?>
>
	<td><?php echo $end; ?></td>
	<td><?php echo date('d-m-Y', strtotime(h($vehicle->reg_date)) ); ?></td>
	<td><?php echo h($vehicle->id); ?></td>
	<td><?php echo h($vehicle->reg_plate); ?></td>
	<td><?php echo h($vehicle->make_name); ?></td>
	<td><?php echo h($vehicle->model); ?></td>
	<td><?php echo h($vehicle->engine); ?></td>
	<td><?php echo h($vehicle->fuel_type); ?></td>
	<td><?php echo h($vehicle->prod_year); ?></td>
	<td>
		<a href="<?php echo url_for('vehicles/show.php?vehicle_widget&id=' . h(u($vehicle->id)) ); ?>">
			<img src="<?php echo url_for('images/info.png'); ?>" alt="">
		</a>
	</td>
	<td>
		<a href="<?php echo url_for('vehicles/edit.php??vehicle_widget&id=' . h(u($vehicle->id)) ); ?>">
			<img src="<?php echo url_for('images/edit.png'); ?>" alt="">
		</a>
	</td>
	<td>
		<a href="<?php echo url_for('vehicles/delete.php??vehicle_widget&id=' . h(u($vehicle->id)) ); ?>">
			<img src="<?php echo url_for('images/delete.png'); ?>" alt="">
		</a>
	</td>
</tr>