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
		
		<?php //foreach ($projects AS $pj) : ?>
		<?php //include'res/php/project.php'; ?>
		<?php //endforeach; ?>
		
		<?php //if (empty($projects)) : ?>
		<?//= get_no_data_box($strings['no_project']); ?>
		<?php// endif; ?>
		
		<?php /*echo getPagesBox("page", ceil($projects_count/PAGE_LIMIT), "user.php?id=".$_GET['id']."&page=", null, "#user-projects-head", array(
			"next"=> $icons['next'],
			"previous"=> $icons['previous'],
		));*/ ?>
		
	</section>
</div>