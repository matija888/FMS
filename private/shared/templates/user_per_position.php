<a href="<?php echo url_for('admins/' . $user->id); ?>">
	<div class="small-element">
		<img src="<?php echo url_for("images/admins/{$user->id}.jpg"); ?>" alt="">
		<span><?php echo h($user->full_name()); ?></span>
		<span><?php echo h($user->phone); ?></span>
	</div>
</a>