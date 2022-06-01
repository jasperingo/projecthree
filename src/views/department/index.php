<div class="container">
	<section id="main-section">
	
		<div id="departments-heading">
			<h2><?= $__('Departments') ?></h2>
			
			<?php if ($user !== null) : ?>
			<a href="/departments/create">Add</a>
			<?php endif ?>
		</div>

		<ul id="departments-list">

			<?php foreach ($departments as $department) : ?>

			<li class="department-item">
				<a href="/departments/<?= $department->id ?>">
					<?= $icons['department'] ?>
					<div>
						<div class="department-item-head"><?= $department->name ?></div>
						<div><?= $department->acronym ?></div>
					</div>
				</a>
			</li>

			<?php endforeach ?>
			
		</ul>

	</section>
</div>
