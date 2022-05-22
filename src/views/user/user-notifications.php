<?php


include_once'res/php/util.php';


if (!signed_in()) {
	header("Location: login.php");
	exit;
}


$page = getPageStart("page", PAGE_LIMIT);

$response = getCurl(API_URL."getusernotifications.php?page_start=".$page."&page_limit=".PAGE_LIMIT, app_headers());

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


$notes = $body['success']['user_notifications'];

$notes_count = $body['success']['user_notifications_count'];



?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
	
	<title>User Notifications <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet"  type="text/css" href="res/css/main.css">
	<link rel="stylesheet"  type="text/css" href="res/css/usernotificationspage.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>


<body>
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section id="main-section">
		
		<?php foreach ($notes AS $n) : ?>
		<a href="project-messages.php?id=<?=$n['id'];?>" class="notification-box">
			<span><?=$strings['you_have'];?></span> 
			<strong><?=$n['count']." ". strtolower($strings['messages']);?></strong> 
			<span><?=strtolower($strings['from']);?></span> 
			<strong><?=$n['topic'];?></strong>
		</a>
		<?php endforeach; ?>
		
		<?php if (empty($notes)) : ?>
		<?= get_no_data_box($strings['no_notification']); ?>
		<?php endif; ?>
		
		<?php echo getPagesBox("page", ceil($notes_count/PAGE_LIMIT), "user-notifications.php?page=", null, "", array(
			"next"=> $icons['next'],
			"previous"=> $icons['previous'],
		)); ?>
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
</body>


</html>



