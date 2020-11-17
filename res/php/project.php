


<div class="project-box">
	<?= $icons['project']; ?><a href="project.php?id=<?=$pj['id'];?>" >
		<div class="project-box-topic"><?=$pj['topic'];?></div>
		<div class="project-box-school">
			<span class="project-box-university"><?=$pj['university_name'];?></span> - 
			<span class="project-box-department"><?=$pj['department_name'];?></span>
		</div>
		<div class="project-box-participants">
			<span class="project-box-participant">
				<img class="project-box-participant-img" src="api/photos/<?=$pj['supervisor_photo_name'];?>" />
				<span class="project-box-participant-name"><?=$pj['supervisor_name'];?></span>
			</span>
			<span class="project-box-participants-and">&</span>
			<span class="project-box-participant">
				<img class="project-box-participant-img" src="api/photos/<?=$pj['student_photo_name'];?>" />
				<span class="project-box-participant-name"><?=$pj['student_name'];?></span>
			</span>
		</div>
		<div class="project-box-rating">
			<?php 
				
				for ($i=1;$i<6;$i++) {
					if ($pj['rating'] < $i && $pj['rating'] <= ($i-1)) {
						echo $icons['blank_star']; 
					} elseif ($pj['rating'] < $i && $pj['rating'] > ($i-1)) {
						echo $icons['half_star']; 
					} else {
						echo $icons['star'];
					}
				}
				
			?>
		</div>
	</a>
</div>
			

