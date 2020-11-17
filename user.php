<?php


include_once'res/php/util.php';


if (!isset($_GET['id'])) {
	urlRedirect("400.html");
}


$response = getCurl(API_URL."getuser.php?id=".$_GET['id'], app_headers());

if (curl_errno($response[0])) {
	header("Location: 500.html");
	exit;
}

$code = httpCodeCurl($response[0]);

$body = json_decode($response[1], true);

curl_close($response[0]);


switch ($code) {
	
	case 404 :
		header("Location: 404.html");
		exit;
		
	case 500 :
		header("Location: 500.html");
		exit;
}


$data = $body['success']['user'];



$page = getPageStart("page", PAGE_LIMIT);

$response = getCurl(API_URL."getuserprojects.php?id=".$_GET['id']."&page_start=".$page."&page_limit=".PAGE_LIMIT, app_headers());

$code = httpCodeCurl($response[0]);
	
$body = json_decode($response[1], true);
	
curl_close($response[0]);


switch ($code) {
	
	case 404 :
		header("Location: 404.html");
		exit;
		
	case 500 :
		header("Location: 500.html");
		exit;
}


$projects = $body['success']['user_projects'];

$projects_count = $body['success']['user_projects_count'];




?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="UTF-8">
	
	<title>User <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet"  type="text/css" href="res/css/main.css">
	<link rel="stylesheet"  type="text/css" href="res/css/project.css">
	<link rel="stylesheet"  type="text/css" href="res/css/userpage.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>

<body>
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section id="sub-section">
		
		<img id="user-page-img" src="api/photos/<?=$data['photo_name']; ?>" />
		
		<div id="user-page-name"><?=$data['title']." ".$data['first_name']." ".$data['last_name']; ?></div>
		
		<div id="user-page-bio"><?=lineBreakString($data['bio']);?></div>
		
	</section>
	
	<section id="main-section">
		
		<div id="user-projects-head"><?=$strings['projects'];?></div>
		
		<?php foreach ($projects AS $pj) : ?>
		<?php include'res/php/project.php'; ?>
		<?php endforeach; ?>
		
		<?php if (empty($projects)) : ?>
		<?= get_no_data_box($strings['no_project']); ?>
		<?php endif; ?>
		
		<?php echo getPagesBox("page", ceil($projects_count/PAGE_LIMIT), "user.php?id=".$_GET['id']."&page=", null, "#user-projects-head", array(
			"next"=> $icons['next'],
			"previous"=> $icons['previous'],
		)); ?>
		
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
	
</body>


</html>