<div class="container">
	
	<section id="sub-section">
		
		<div id="project-page-topic">
			<?= $icons['project']; ?><h1><?=$data['topic'];?></h1>
		</div>
		
		<?php include_once'res/php/projectnav.php'; ?>
		
	</section>
	
	<section id="main-section">
		
		<form id="main-form" method="POST" action="" novalidate="novalidate">
			
			<?php echo $form_result; ?>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['topic'];?></span>
				<?=$topic_error;?>
				<input class="main-input" type="text" name="topic" value="<?=$data['topic'];?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['privacy'];?></span>
				<?=$privacy_error;?>
				<select class="main-select" name="privacy">
					<?php foreach ($strings['privacy_arr'] AS $i=> $pri) : ?>
					<option value="<?=$i;?>" <?=$i==$data['privacy']?"selected":"";?>><?=$pri;?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['description'];?></span>
				<?=$description_error;?>
				<textarea class="main-textarea" name="description"><?=$data['description'];?></textarea>
			</div>
			
			<button type="submit" id="main-form-btn" name="edit_project"><?=$strings['save'];?></button>
			
		</form>
		
	</section>

</div>
