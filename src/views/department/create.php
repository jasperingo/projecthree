<div class="container">
	
	<section id="main-section">

		<div id="departments-heading">
			<h2><?= $__('Add_Department') ?></h2>
		</div>

		<form id="main-form" method="POST" action="" novalidate="novalidate">
			
			<div id="main-form-error"><?= $form_error ?></div>
			
			<div class="input-box">
				<span class="input-span"><?= $__('name') ?></span>
				<input class="main-input" type="text" name="name" value="<?= $name ?>" />
				<div class="input-error"><?= $__($name_error) ?></div>
			</div>

			<div class="input-box">
				<span class="input-span"><?= $__('acronym') ?></span>
				<input class="main-input" type="text" name="acronym" value="<?= $acronym ?>" />
				<div class="input-error"><?= $__($acronym_error) ?></div>
			</div>
			
			<button type="submit" id="main-form-btn" name="register"><?= $__('Add_Department') ?></button>
			
		</form>
	</section>
	
</div>
