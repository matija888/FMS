<div class="widget">
	<h2>Log in</h2>
	<form style="width:300px;" action="<?php echo url_for('login'); ?>" method="post">
		<?php echo csrf_token_tag(); ?>
		<table>
			<tr>
				<td>Korisničko ime:</td>
				<td><input type="text" name="username" value="<?php if(isset($username)) { echo $username; } ?>"></td>
			</tr>
			<tr>
				<td>Lozinka:</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td><input class="btn" type="submit" name="submit" value="Log in"></td>
			</tr>
		</table>
	</form>
</div>