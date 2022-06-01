<div class="container">
	
	<form id="main-form" method="POST" action="" novalidate="novalidate" enctype="multipart/formdata">
		
		<div class="heading-2">
			<h2><?= $__('create_project') ?></h2>
		</div>

		<div id="main-form-error"><?= $__($form_error) ?></div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('topic') ?></span>
			<input class="main-input" type="text" name="topic" value="<?= $topic ?>" />
			<div class="input-error"><?= $__($topic_error) ?></div>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('department') ?></span>
			<select class="main-select" name="department_id" value="<?= $department_id ?>" >
				<option value=""><?= $__('choose_one') ?></option>
				<?php foreach ($departments as $department) : ?>
					<option value="<?= $department->id ?>"><?= "{$department->name} ({$department->acronym})" ?></option>
				<?php endforeach ?>
			</select>
			<div class="input-error"><?= $__($department_id_error) ?></div>
		</div>

		<div class="input-box">
			<span class="input-span"><?= $__('description') ?></span>
			<textarea class="main-textarea" type="text" name="description" value="<?= $description ?>"></textarea>
			<div class="input-error"><?= $__($description_error) ?></div>
		</div>
		
		<button type="submit" id="main-form-btn" name="create_project"><?= $__('create') ?></button>
		
	</form>

</div>
