<div class="container">
	
	<form id="main-form" method="POST" action="" novalidate="novalidate">
		
		<?= $form_error; ?>
		
		<div class="input-box">
			<span class="input-span"><?= $__('first_name') ?></span>
			<input class="main-input" type="text" name="first_name" value="<?= $first_name; ?>" />
			<?//= $first_name_error ?>
		</div>

		<div class="input-box">
			<span class="input-span"><?= $__('last_name') ?></span>
			<input class="main-input" type="text" name="last_name" value="<?= $last_name; ?>" />
			<?//= $last_name_error; ?>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('email') ?></span>
			<input class="main-input" type="email" name="email" value="<?= $email; ?>" />
			<?//= $email_error; ?>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('password') ?></span>
			<input class="main-input" type="password" name="password" />
			<?//= $password1_error; ?>
			<div class="input-span-2"><?= $__('password_recommendation_note') ?>.</div>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('confirm_password') ?></span>
			<input class="main-input" type="password" name="confirm_password" />
			<?//= $password2_error; ?>
		</div>
		
		<div class="main-form-note">
			<?= $__('already_have_an_account') ?>? 
			<a href="auth/login"><?= strtolower($__('log_in')) ?></a>.
		</div>
		
		<div class="main-form-note">
			<?= $__('by_registering_you_agree_to_our') ?> 
			<a href="about/terms"><?= strtolower($__('terms_and_policy')) ?></a>.
		</div>
		
		<button type="submit" id="main-form-btn" name="register"><?= $__('register') ?></button>
		
	</form>
	
</div>
