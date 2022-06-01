<div class="container">
	<section id="main-section">
	
		<div id="departments-heading">
			<h2><?= $__('Departments') ?></h2>
			
			<?php if ($user !== null) : ?>
			<a href="/departments/create">Add</a>
			<?php endif ?>
		</div>

		<ul id="departments-list">
			<li class="department-item">
				<a href="/departments/1">
					<?= $icons['department'] ?>
					<div>
						<div class="department-item-head">Information Technology</div>
						<div>IFT</div>
					</div>
				</a>
			</li>
		</ul>

	</section>
</div>
