<div class="container">

	<section id="sub-section">
		
		<div id="profile-page-img"><?= $icons['project']; ?></div>
		
		<div id="profile-page-name"><?= $data->topic ?></div>

		<div id="profile-page-description"><?= $data->description ?></div>

		<?php if ($canEdit) : ?>
		<a id="profile-edit-link" href="/projects/<?= $data->id ?>/update"><?= $__('Edit_project') ?></a>
		<?php endif ?>

		<a id="download-link" href="<?= $documentUrl ?>" download>
			<?= $icons['download']; ?>
			<span><?= $__('download_document') ?></span>
		</a>

	</section>
	
	<section id="main-section">

		<div>
			<h4 class="heading-4 ">Department</h4>
			<div class="main-item">
				<a href="/departments/<?= $data->department->id ?>">
					<?= $icons['department'] ?>
					<div>
						<div class="main-item-head"><?= $data->department->name ?></div>
						<div><?= $data->department->acronym ?></div>
					</div>
				</a>
			</div>
		</div>

		<div>
			<h4 class="heading-4 ">Collaborators</h4>
			<ul class="main-list-no-margin">
				<?php foreach ($data->collaborators as $collaborator) : ?>
				<li class="main-item">
					<a href="/users/<?= $collaborator->user->id ?>">
						<?= $icons['user'] ?>
						<div>
							<div class="main-item-head"><?= $collaborator->user->getFullName() ?></div>
						</div>
					</a>
				</li>
				<?php endforeach ?>
			</ul>
		</div>

	</section>

</div>
