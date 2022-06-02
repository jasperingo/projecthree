<div class="container">
	<section id="sub-section">
		
		<div id="profile-page-img"><?= $icons['user'] ?></div>

		<div id="profile-page-name"><?= "{$data->firstName} {$data->lastName}" ?></div>
		
	</section>

	<section id="main-section">
		
		<div id="profile-projects-head">
			<?= $icons['project'] ?>
			<div><?= $__('projects') ?></div>
		</div>
		
		<ul class="main-list-no-margin">
			<?php foreach ($collaborations as $collaboration) : ?>
			<li class="main-item">
				<a href="/projects/<?= $collaboration->project->id ?>">
					<?= $icons['project'] ?>
					<div>
						<div class="main-item-head"><?= $collaboration->project->topic ?></div>
					</div>
				</a>
			</li>
			<?php endforeach ?>
		</ul>

	</section>
</div>
