<div class="container">
		
	<form id="main-form" method="POST" action="" novalidate="novalidate">

		<h2><?= $__('Profile_update') ?></h2>

		<div id="main-form-error"><?= $__($profile_form_error) ?></div>

		<div id="main-form-success"><?= $__($profile_form_success) ?></div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('first_name') ?></span>
			<input class="main-input" type="text" name="first_name" value="<?= $data->firstName ?>" />
			<div class="input-error"><?= $__($first_name_error) ?></div>
		</div>

		<div class="input-box">
			<span class="input-span"><?= $__('last_name') ?></span>
			<input class="main-input" type="text" name="last_name" value="<?= $data->lastName ?>" />
			<div class="input-error"><?= $__($last_name_error) ?></div>
		</div>

		<div class="input-box">
			<span class="input-span"><?= $__('email') ?></span>
			<input class="main-input" type="text" name="email" value="<?= $data->email ?>" />
			<div class="input-error"><?= $__($email_error) ?></div>
		</div>
		
		<button type="submit" id="main-form-btn" name="update_profile"><?= $__('save') ?></button>

	</form>

	<form id="main-form" method="POST" action="/users/<?= ((object) $user)->id ?>/password/update" novalidate="novalidate">
		
		<h2><?= $__('Password_update') ?></h2>

		<div id="main-form-error"><?= $__($password_form_error) ?></div>

		<div id="main-form-success"><?= $__($password_form_success) ?></div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('password') ?></span>
			<input class="main-input" type="password" name="password" />
			<div class="input-error"><?= $__($password_error) ?></div>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('new_password') ?></span>
			<input class="main-input" type="password" name="new_password" />
			<div class="input-error"><?= $__($new_password_error) ?></div>
			<div class="input-span-2"><?= $__('password_recommendation_note') ?>.</div>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('confirm_new_password') ?></span>
			<input class="main-input" type="password" name="new_password_confirmation" />
		</div>
		
		<button type="submit" id="main-form-btn" name="update_password"><?= $__('save') ?></button>
		
	</form>

</div>
