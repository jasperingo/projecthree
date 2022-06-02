<div class="container">
	<section id="main-section">
	
		<div class="heading-2">
			<h2><?= $__('Departments') ?></h2>
			
			<?php if ($user !== null) : ?>
			<a href="/departments/create">Add</a>
			<?php endif ?>
		</div>

		<ul class="main-list">

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

	</section>
</div>
