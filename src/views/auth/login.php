<div class="container">
	<section class="main-section">

		<form id="main-form" method="POST" action="" novalidate="novalidate">
			
			<div id="main-form-error"><?= $__($form_error) ?></div>
			
			<div class="input-box">
				<span class="input-span"><?= $__('email') ?></span>
				<input class="main-input" type="text" name="email" value="<?= $email ?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?= $__('password') ?></span>
				<input class="main-input" type="password" name="password" />
			</div>
			
			
			<div class="main-form-note">
				<?= $__('dont_have_an_account') ?>? 
				<a href="users/create"><?= strtolower($__('register')) ?></a>.
			</div>
			
			<button type="submit" id="main-form-btn" name="log_in"><?= $__('log_in') ?></button>
			
		</form>

	</section>
</div>
