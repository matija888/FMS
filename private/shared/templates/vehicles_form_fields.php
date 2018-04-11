<table>
	<tr>
		<td><label for="reg_plate">Registraciona oznaka</label></td>
		<td><input type="text" name="vehicle[reg_plate]" id="reg_plate" value="<?php echo h($vehicle->reg_plate) ; ?>"></td>
	</tr>
	<tr>
		<td><label for="make_id">Marka</label></td>
		<td>
			<select name="vehicle[make_id]" id="make_id">
				<?php foreach(Vehicle::get_make_names() as $make) {
					echo "<option value=\"{$make['make_id']}\" name=\"vehicle[make_id]\"";
					if($make['make_id'] == $vehicle->make_id) {
						echo " selected";
					}
					echo ">" . h($make['make_name']);
					echo "</option>";
				} ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="model">Model</label></td>
		<td><input type="text" name="vehicle[model]" id="model" value="<?php echo h($vehicle->model); ?>" required></td>
	</tr>
	<tr>
		<td><label for="engine">Tip motora</label></td>
		<td><input type="text" name="vehicle[engine]" id="engine" value="<?php echo h($vehicle->engine); ?>" multiple required></td>
	</tr>
	<tr>
		<td><label for="fuel_type">Tip goriva</label></td>
		<td>
			<?php $fuel_types = Vehicle::FUEL_TYPE; ?>
			<select name="vehicle[fuel_type]" id="">
				<?php for($i=1; $i<=count($fuel_types); $i++) {
					echo "<option value=\"{$fuel_types[$i]}\" name=\"vehicle[fuel_type]\"";
					if($fuel_types[$i] == $vehicle->fuel_type) {
						echo " selected";
					} 
					echo ">". h($fuel_types[$i]);
					echo "</option>";
				} ?>
				
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="kilometrage">Kilometraža</label></td>
		<td><input type="text" name="vehicle[kilometrage]" id="kilometrage" value="<?php echo h($vehicle->kilometrage); ?>" multiple required></td>
	</tr>
	<tr>
		<td><label for="reg_date">Datum poslednje registracije</label></td>
		<td><input type="date" name="vehicle[reg_date]" id="reg_date" value="<?php echo h($vehicle->reg_date); ?>" multiple required></td>
	</tr>
	<tr>
		<td><label for="prod_year">Godina proizvodnje</label></td>
		<td><input type="year" name="vehicle[prod_year]" id="prod_year" value="<?php echo h($vehicle->prod_year); ?>" multiple required></td>
	</tr>
</table>

























