<div class="container">
	
	<section id="main-section">

		<div id="departments-heading">
			<h2><?= $__('Edit_Department') ?></h2>
		</div>

		<form id="main-form" method="POST" action="" novalidate="novalidate">
			
			<div id="main-form-error"><?= $__($form_error) ?></div>

			<div id="main-form-success"><?= $__($form_success) ?></div>
			
			<div class="input-box">
				<span class="input-span"><?= $__('name') ?></span>
				<input class="main-input" type="text" name="name" value="<?= $data->name ?>" />
				<div class="input-error"><?= $__($name_error) ?></div>
			</div>

			<div class="input-box">
				<span class="input-span"><?= $__('acronym') ?></span>
				<input class="main-input" type="text" name="acronym" value="<?= $data->acronym ?>" />
				<div class="input-error"><?= $__($acronym_error) ?></div>
			</div>
			
			<button type="submit" id="main-form-btn" name="register"><?= $__('Add_Department') ?></button>
			
		</form>
	</section>
	
</div>
