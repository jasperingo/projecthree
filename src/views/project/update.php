<div class="container">
	
	<form id="main-form" method="POST" action="" novalidate="novalidate" enctype="multipart/form-data">
		
		<div class="heading-2">
			<h2><?= $__('create_project') ?></h2>
		</div>

		<div id="main-form-error"><?= $__($form_error) ?></div>

		<div id="main-form-success"><?= $__($form_success) ?></div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('topic') ?></span>
			<input class="main-input" type="text" name="topic" value="<?= $data->topic ?>" />
			<div class="input-error"><?= $__($topic_error) ?></div>
		</div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('department') ?></span>
			<select class="main-select" name="department_id">
				<option value=""><?= $__('choose_one') ?></option>
				<?php foreach ($departments as $department) : ?>
				<option 
					value="<?= $department->id ?>"
					<?= intval($data->department->id) === $department->id ? 'selected' : ''?>
				>
					<?= "{$department->name} ({$department->acronym})" ?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="input-error"><?= $__($department_id_error) ?></div>
		</div>

		<div class="input-box">
			<span class="input-span"><?= $__('description') ?></span>
			<textarea class="main-textarea" name="description"><?= $data->description ?></textarea>
			<div class="input-error"><?= $__($description_error) ?></div>
		</div>

		<div class="input-box">
			<span class="input-span"><?= $__('Document') ?></span>
			<input class="main-input" type="file" name="document" accept="application/pdf" />
			<div class="input-error"><?= $__($document_error) ?></div>
		</div>
		
		<button type="submit" id="main-form-btn" name="create_project"><?= $__('Update') ?></button>
		
	</form>

	<form id="main-form" method="POST" action="/projects/<?= $data->id ?>/collaborator/create" novalidate="novalidate">
			
		<h2><?= $__('Add_collaborator') ?></h2>

		<div id="main-form-error"><?= $__($collaborator_form_error) ?></div>

		<div id="main-form-success"><?= $__($collaborator_form_success) ?></div>
		
		<div class="input-box">
			<span class="input-span"><?= $__('email') ?></span>
			<input class="main-input" type="text" name="collaborator_email" value="<?= $collaborator_email ?>" />
			<div class="input-error"><?= $__($collaborator_email_error) ?></div>
		</div>
		
		<button type="submit" id="main-form-btn" name="update_password"><?= $__('add') ?></button>
			
	</form>

</div>
