<?php


include_once'res/php/util.php';



$response = getCurl(API_URL."getrandomprojects.php?page_start=0&page_limit=4");

if (curl_errno($response[0])) {
	urlRedirect("500.html");
}

$code = httpCodeCurl($response[0]);

if ($code == 500) {
	urlRedirect("500.html");
}

$body = json_decode($response[1], true);
	
curl_close($response[0]);

$projects = $body['success']['projects'];



$response = getCurl(API_URL."getuniversities.php?page_start=0&page_limit=4");

if (curl_errno($response[0])) {
	urlRedirect("500.html");
}
	
$code = httpCodeCurl($response[0]);

if ($code == 500) {
	urlRedirect("500.html");
}

$body = json_decode($response[1], true);

curl_close($response[0]);


$unies = $body['success']['universities'];



?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Project3 <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet" type="text/css" href="res/css/main.css">
	<link rel="stylesheet" type="text/css" href="res/css/index.css">
	<link rel="stylesheet" type="text/css" href="res/css/project.css">
	<link rel="stylesheet" type="text/css" href="res/css/university.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>

<body>
	
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section class="main-section">
		
		<div id="index-welcome">
		
			<div id="index-welcome-note">School projects at it's best</div>
	
			<div id="index-welcome-small-note">
				Manage school projects efficiently with Project3. 
				Join us today and make your project the best.
			</div>
	
			<a id="index-welcome-link" href="register.php" ><?php echo $strings['join_us']; ?></a>
	
		</div>

		
		<div id="index-features">
			
			<div class="index-feature">
				<?php echo $icons['project_index']; ?>
				<div>Easily create, manage and share projects</div>
			</div>
			
			<div class="index-feature">
				<?php echo $icons['messages_index']; ?>
				<div>Communicate with projects' supervisors and students</div>
			</div>
			
			<div class="index-feature">
				<?php echo $icons['documents_index']; ?>
				<div>Send, preview and approve project documents</div>
			</div>
			
			<div class="index-feature">
				<?php echo $icons['web_index']; ?>
				<div>Browse through a wide library of projects</div>
			</div>
			
		</div>
		
		
		<?php if (!empty($projects)) : ?>
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
		<?php endif; ?>
		
		
		<div id="index-abouts">
			
			<div class="index-about">
				<div class="index-about-head">About us</div>
				<div class="index-about-body">We are here to provide students and supervisors with the necessary tools for carrying out school projects.</div>
			</div>
			
			<div class="index-about">
				<div class="index-about-head">Our mission</div>
				<div class="index-about-body">To make school projects durable, accessable and efficient.</div>
			</div>
			
			<a href="register.php" id="index-abouts-link"><?=$strings['register'];?></a>
			
		</div>
		
		
	</section>

	<?php include_once'res/php/footer.php'; ?>
	
	
</body>

</html>





