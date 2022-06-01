
	<section id="sub-section">
		
		<div id="project-page-topic">
			<?= $icons['project']; ?><h1><?=$data['topic'];?></h1>
		</div>
		
		<?php $nav_active = 0; include_once'res/php/projectnav.php'; ?>
		
	</section>
	
	<section id="main-section">
		
		<?php if ($data['document_id'] > 0) : ?>
		<a href="download-document.php?id=<?=$data['document_id'];?>" id="project-page-download"><?=$strings['download_document'];?></a>
		<?php else : ?>
		<div id="project-page-download-blur"><?=$strings['no_document'];?></div>
		<?php endif; ?>
		
		<a href="university-departments.php?id=<?=$data['university_id'];?>" id="project-page-school">
			<?=$icons['department'];?>
			<span><?=$data['department_name'];?></span>
			<span id="project-page-school-in"><?=$strings['in'];?></span>
			<?= $icons['university']; ?>
			<span><?=$data['university_name'];?></span>
		</a>
		
		<div id="project-page-privacy-date">
			<span>
				<?=$icons['privacy'];?>
				<span><?=$strings['privacy_arr'][$data['privacy']];?></span>
			</span>
			<span>
				<?=$icons['date'];?>
				<span><?=makeDate($data['creation_date']);?></span>
			</span>
		</div>
		
		<div id="project-page-participants">
			
			<div class="project-page-participant">
				<div class="project-page-participant-head">
					<img class="project-page-participant-img" src="api/photos/<?=$data['supervisor_photo_name'];?>" />
				</div><a href="user.php?id=<?=$data['supervisor_id'];?>" class="project-page-participant-body">
					<div class="project-page-participant-name"><?=$data['supervisor_name'];?></div>
					<div class="project-page-participant-role"><?=$strings['supervisor'];?></div>
				</a>
			</div>
			
			<div class="project-page-participant">
				<div class="project-page-participant-head">
					<img class="project-page-participant-img" src="api/photos/<?=$data['student_photo_name'];?>" />
				</div><a href="user.php?id=<?=$data['student_id'];?>" class="project-page-participant-body">
					<div class="project-page-participant-name"><?=$data['student_name'];?></div>
					<div class="project-page-participant-role"><?=$strings['student'];?></div>
				</a>
			</div>
			
		</div>
		
		
		<div id="project-page-privacy-description">
			<?php if (!empty($data['description'])) : ?>
			<?=lineBreakString($data['description']);?>
			<?php else : ?>
			<div><?=$strings['no_description'];?></div>
			<?php endif; ?>
		</div>
		
		
		<div id="project-page-rating">
			<?php for ($i=1;$i<6;$i++) {
				if ($data['rating'] < $i && $data['rating'] <= ($i-1)) {
					echo $icons['blank_star']; 
				} elseif ($data['rating'] < $i && $data['rating'] > ($i-1)) {
					echo $icons['half_star']; 
				} else {
					echo $icons['star'];
				}
			}?>
			<div><?=$data['rating']." ".$strings['reviews'];?></div>
		</div>
		
		
	</section>

