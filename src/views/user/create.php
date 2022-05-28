<div class="container">
	
	<form id="main-form" method="POST" action="" novalidate="novalidate">
		
		<div id="main-form-error"><?= $form_error ?></div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('first_name') ?></span>
			<input class="main-input" type="text" name="first_name" value="<?= $first_name ?>" />
			<div class="input-error"><?= $__($first_name_error) ?></div>
		</div>

		<div class="input-box">
			<span class="input-span"><?= $__('last_name') ?></span>
			<input class="main-input" type="text" name="last_name" value="<?= $last_name ?>" />
			<div class="input-error"><?= $__($last_name_error) ?></div>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('email') ?></span>
			<input class="main-input" type="email" name="email" value="<?= $email ?>" />
			<div class="input-error"><?= $__($email_error) ?></div>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('password') ?></span>
			<input class="main-input" type="password" name="password" />
			<div class="input-error"><?= $__($password_error) ?></div>
			<div class="input-span-2"><?= $__('password_recommendation_note') ?>.</div>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('confirm_password') ?></span>
			<input class="main-input" type="password" name="password_confirmation" />
		</div>
		
		<div class="main-form-note">
			<?= $__('already_have_an_account') ?>? 
			<a href="auth/login"><?= strtolower($__('log_in')) ?></a>.
		</div>
		
		<div class="main-form-note">
			<?= $__('by_registering_you_agree_to_our') ?> 
			<a href="terms"><?= strtolower($__('terms_and_policy')) ?></a>.
		</div>
		
		<button type="submit" id="main-form-btn" name="register"><?= $__('register') ?></button>
		
	</form>
	
</div>
