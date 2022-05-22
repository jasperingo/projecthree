<!DOCTYPE html>
<html>
	<head>
		
		<meta charset="UTF-8" />
		
		<title>Project3 <?= $__('website_title_note') ?></title>
		
		<link rel="stylesheet" type="text/css" href="res/css/main.css" />
		<link rel="stylesheet" type="text/css" href="res/css/index.css" />
		<link rel="stylesheet" type="text/css" href="res/css/project.css" />
		<link rel="stylesheet" type="text/css" href="res/css/university.css" />
		
		<meta name="viewport"  content="width=device-width, initial-scale=1.0" />
		
		<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png" />
		
	</head>

	<body>
		
		<?= $this->fetch('./components/header.php') ?>
		
		<section class="main-section">
			
			<div id="index-welcome">
			
				<div id="index-welcome-note">School projects at it's best</div>
		
				<div id="index-welcome-small-note">
					Manage school projects efficiently with Project3. 
					Join us today and make your project the best.
				</div>
		
				<a id="index-welcome-link" href="user/create" ><?= $__('join_us'); ?></a>
		
			</div>

			
			<div id="index-features">
				
				<div class="index-feature">
					<?= $icons['project_index'] ?>
					<div>Easily create, manage and share projects</div>
				</div>
				
				<div class="index-feature">
					<?= $icons['messages_index'] ?>
					<div>Communicate with projects' supervisors and students</div>
				</div>
				
				<div class="index-feature">
					<?= $icons['documents_index'] ?>
					<div>Send, preview and approve project documents</div>
				</div>
				
				<div class="index-feature">
					<?= $icons['web_index'] ?>
					<div>Browse through a wide library of projects</div>
				</div>
				
			</div>
			
			
			<?php /* if (!empty($projects)) : ?>
			<div id="index-projects">
				
				<div id="index-projects-head"><?=$strings['top_projects'];?></div>
				
				<?php foreach ($projects AS $pj) : ?>
				<?php include'res/php/project.php'; ?>
				<?php endforeach; ?>
				
			</div>
			<?php endif; ?>
			
			
			<?php if (!empty($unies)) : ?>
			<div id="index-universities">
				
				<div id="index-universities-head"><?=$strings['universities_on_project3'];?></div>
				
				<?php foreach ($unies AS $uni) : ?>
				<?php include'res/php/university.php'; ?>
				<?php endforeach; ?>
				
				<a href="universities.php" id="index-universities-link"><?=$strings['view_all'];?></a>
				
			</div>
			<?php endif;*/ ?>
			
			
			<div id="index-abouts">
				
				<div class="index-about">
					<div class="index-about-head">About us</div>
					<div class="index-about-body">We are here to provide students and supervisors with the necessary tools for carrying out school projects.</div>
				</div>
				
				<div class="index-about">
					<div class="index-about-head">Our mission</div>
					<div class="index-about-body">To make school projects durable, accessable and efficient.</div>
				</div>
				
				<a href="user/create" id="index-abouts-link"><?= $__('register') ?></a>
				
			</div>
			
			
		</section>
		
		<?= $this->fetch('./components/footer.php') ?>
		
	</body>

</html>
