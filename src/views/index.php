<div class="container">
	
	<section id="index-welcome">
	
		<div id="index-welcome-note">School Projects at your finger tips</div>

		<div id="index-welcome-small-note">
			Upload and download school project documents from different department and students worldwide.
		</div>

		<a id="index-welcome-link" href="users/create" ><?= $__('join_us'); ?></a>

	</section>

	<section>

		<h4 class="heading-4 "><?= $__('Recent_projects') ?></h4>

		<ul class="main-list-no-margin">
			<?php foreach ($projects as $project) : ?>
				<li class="main-item">
					<a href="/projects/<?= $project->id ?>">
						<?= $icons['user'] ?>
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

	<section>

		<h4 class="heading-4 "><?= $__('Departments') ?></h4>

		<ul class="main-list-no-margin">
			<?php foreach ($departments as $department) : ?>
				<li class="main-item">
					<a href="/departments/<?= $department->id ?>">
						<?= $icons['department'] ?>
						<div>
							<div class="main-item-head"><?= $department->name ?></div>
							<div><?= $department->acronym ?></div>
						</div>
					</a>
				</li>
			<?php endforeach ?>
		</ul>
		
		<?php if (empty($departments)) : ?>
			<div class="no-data-box"><?= $__('no_department') ?></div>
		<?php endif ?>

	</section>
	
</div>
