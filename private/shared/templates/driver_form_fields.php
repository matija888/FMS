<label for="first_name">Ime</label>
<input type="text" name="driver[first_name]" id="first_name" value="<?php echo h($driver->first_name) ; ?>"><br>

<label for="last_name">Prezime</label>
<input type="text" name="driver[last_name]" id="last_name" value="<?php echo h($driver->last_name); ?>" required><br>

<label for="phone">Telefon</label>
<input type="tel" name="driver[phone]" id="phone" value="<?php echo h($driver->phone); ?>" required><br>

<label for="email">Email</label>
<input type="email" name="driver[email]" id="email" value="<?php echo h($driver->email); ?>" multiple required><br>

<label for="address_name">Adresa</label>
<input type="text" name="driver[address_name]" id="address_name" value="<?php echo h($driver->address_name); ?>" multiple required><br>

<label for="city_id">Grad</label>
<select name="driver[city_id]" id="city_id" required>
	<?php foreach (Driver::get_city_names() as $city) {
		echo "<option value=\"{$city['city_id']}\"";
		if($driver->city_id == $city['city_id']) {
			echo " selected";
		}
		echo ">";
		echo h($city['city_name']);
		echo "</option>";
	} ?>
	
</select><br>

<label for="position_id">Pozicija</label>
<select name="driver[position_id]" id="position_id">
	<?php foreach (Driver::get_position_names() as $position) {
		echo "<option value=\"{$position['position_id']}\"";
		if($driver->position_id == $position['position_id']) {
			echo " selected";
		}
		echo ">";
		echo h($position['position_name']);
		echo "</option>";
	} ?>
	
</select><br>

<label for="vehicle_id">Vozilo koje zadužuje</label>
<select name="driver[vehicle_id]" id="vehicle_id">
	<?php
		$vehicles = Vehicle::get_available_vehicles($driver->vehicle_id);
		if(!empty($vehicles)) {
			foreach ($vehicles as $vehicle) {
				echo "<option value=\"{$vehicle->id}\">";
				echo h($vehicle->reg_plate);
				echo "</option>";
			}
			echo "<option value=\"0\">";
			echo "neraspoređen";
			echo "</option>";
		} else {
			echo "<option value=\"0\">";
			echo "neraspoređen";
			echo "</option>";
			$message[] ="Trenutno ne postoje raspoloživa vozila. Vozač će biti raspoloživ.";
		}
	?>
</select><br>