<div class="container">

	<section id="sub-section">
		
		<div id="profile-page-img"><?= $icons['department'] ?></div>

		<div id="profile-page-name"><?= "{$data->name} ({$data->acronym})" ?></div>

		<?php if ($user !== null) : ?>
		<a id="profile-edit-link" href="/departments/<?= $data->id ?>/update"><?= $__('Edit_department') ?></a>
		<?php endif ?>
		
	</section>
	
	<section id="main-section">

		<div id="profile-projects-head">
			<?= $icons['project'] ?>
			<div><?= $__('projects') ?></div>
		</div>

		<ul class="main-list-no-margin">
			<?php foreach ($projects as $project) : ?>
				<li class="main-item">
					<a href="/projects/<?= $project->id ?>">
						<?= $icons['project'] ?>
						<div>
							<div class="main-item-head"><?= $project->topic ?></div>
						</div>
					</a>
				</li>
			<?php endforeach ?>
		</ul>

		<?php if (empty($projects)) : ?>
			<div class="no-data-box"><?= $__('no_project') ?></div>
		<?php endif ?>
		
	</section>

</div>
