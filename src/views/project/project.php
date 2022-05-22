<?php


include_once'res/php/util.php';


if (!isset($_GET['id'])) {
	urlRedirect("400.html");
}


$response = getCurl(API_URL."getproject.php?id=".$_GET['id'], app_headers());

if (curl_errno($response[0])) {
	urlRedirect("500.html");
}

$code = httpCodeCurl($response[0]);

$body = json_decode($response[1], true);

curl_close($response[0]);


switch ($code) {
	case 404 :
		urlRedirect("404.html");
	case 403 :
		urlRedirect("403.html");
	case 500 :
		urlRedirect("500.html");
}


$data = $body['success']['project'];


$participants = ["student_id"=> $data['student_id'], "supervisor_id"=> $data['supervisor_id']];


?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Project <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet" type="text/css" href="res/css/main.css">
	<link rel="stylesheet" type="text/css" href="res/css/projectpage.css?c">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>


<body>
	
	<?php include_once'res/php/header.php'; ?>
	
	
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
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
	
</body>


</html>


