<div class="container">
	<section id="main-section">
		
		<form id="search-page-form" method="GET" action="">
			<input 
				name="q" 
				type="text"
				value="<?= $_GET['q'] ?? '' ?>"
				placeholder="<?= $__('search_project3') ?>" 
			/>
			<button type="submit">
				<?= $icons['search'] ?>
			</button>
		</form>
		
		<?php if (!isset($_GET['q'])) : ?>
		
			<div class="no-data-box"><?= $__('search_project3') ?></div>
		
		<?php else : ?>
		
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
				<div class="no-data-box"><?= $__('no_result_found') ?></div>
			<?php endif ?>
		
		<?php endif; ?>
		
	</section>
</div>
