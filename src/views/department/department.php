<div class="container">

	<section id="sub-section">
		
		<div id="profile-page-img"><?= $icons['department'] ?></div>

		<div id="profile-page-name"><?= "{$data->name} ({$data->acronym})" ?></div>

		<?php if ($user !== null) : ?>
		<a id="profile-edit-link" href="/departments/<?= $data->id ?>/edit"><?= $__('Edit_department') ?></a>
		<?php endif ?>
		
	</section>
	
	<section id="main-section">

		<div id="profile-projects-head">
			<?= $icons['project'] ?>
			<div><?= $__('projects') ?></div>
		</div>
		
	</section>

</div>
