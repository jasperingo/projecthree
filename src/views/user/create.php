<?php $titles = $__('title_arr'); ?>

<section class="main-section">
	
	<form id="main-form" method="POST" action="" novalidate="novalidate">
		
		<?= $form_error; ?>
		
		<div class="input-box">
			<span class="input-span"><?= $__('title') ?></span>
			<?//= $title_error ?>
			<select class="main-select" name="title" value="<?= $title ?>">
				<option><?= $__('choose_one') ?></option>
				<?php foreach ($titles as $item) : ?>
				<option><?= $item; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('first_name') ?></span>
			<?//= $first_name_error ?>
			<input class="main-input" type="text" name="first_name" value="<?= $first_name; ?>" />
		</div>

		<div class="input-box">
			<span class="input-span"><?= $__('last_name') ?></span>
			<?//= $last_name_error; ?>
			<input class="main-input" type="text" name="last_name" value="<?= $last_name; ?>" />
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('email') ?></span>
			<?//= $email_error; ?>
			<input class="main-input" type="email" name="email" value="<?= $email; ?>" />
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('password') ?></span>
			<?//= $password1_error; ?>
			<input class="main-input" type="password" name="password" />
			<div class="input-span-2"><?= $__('password_recommendation_note') ?>.</div>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('confirm_password') ?></span>
			<?//= $password2_error; ?>
			<input class="main-input" type="password" name="confirm_password" />
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
	
</section>
