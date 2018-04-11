<label for="first_name">Ime</label>

<input type="text" name="user[first_name]" id="first_name" value="<?php echo h($user->first_name) ; ?>"><br>

<label for="last_name">Prezime</label>
<input type="text" name="user[last_name]" id="last_name" value="<?php echo h($user->last_name); ?>" required><br>

<label for="username">Korisničko ime</label>
<input type="text" name="user[username]" id="username" value="<?php echo h($user->username); ?>" onkeyup="ajaxSearch()"><br>

<label for="password">Lozinka</label>
<input type="password" name="user[password]" id="password" value="<?php echo h($user->password); ?>" ><br>

<label for="confirm_password">Potvrda lozinke</label>
<input type="password" name="user[confirm_password]" id="confirm_password" value="<?php echo h($user->confirm_password); ?>" ><br>

<label for="phone">Telefon</label>
<input type="tel" name="user[phone]" id="phone" value="<?php echo h($user->phone); ?>" required><br>

<label for="email">Email</label>
<input type="email" name="user[email]" id="email" value="<?php echo h($user->email); ?>" multiple required><br>

<label for="address_name">Adresa</label>
<input type="text" name="user[address_name]" id="address_name" value="<?php echo h($user->address_name); ?>" multiple required><br>

<label for="city_id">Grad</label>
<select name="user[city_id]" id="city_id" required>
	<?php foreach (User::get_city_names() as $city) {
		echo "<option value=\"{$city['city_id']}\"";
		if($user->city_id == $city['city_id']) {
			echo " selected";
		}
		echo ">";
		echo h($city['city_name']);
		echo "</option>";
	} ?>
	
</select><br>

<label for="position_id">Pozicija</label>
<select name="user[position_id]" id="position_id">
	<?php foreach (User::get_position_names() as $position) {
		echo "<option value=\"{$position['position_id']}\"";
		if($user->position_id == $position['position_id']) {
			echo " selected";
		}
		echo ">";
		echo h($position['position_name']);
		echo "</option>";
	} ?>
	
</select><br>

<fieldset>
	<legend>Dodeli privilegiju korisniku</legend>
	<label for="admin">Admin
		<input type="radio" name="user[status]" value="1" id="admin" <?php if($user->status == 1) { echo " checked"; } ?>>
	</label>
	
	<label for="superadmin">Superadmin
		<input type="radio" name="user[status]" value="2" id="superadmin" <?php if($user->status == 2) { echo " checked"; } ?>>
	</label>
	
</fieldset>