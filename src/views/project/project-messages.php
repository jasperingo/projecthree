<?php


include_once'res/php/util.php';


if (!signed_in()) {
	urlRedirect("login.php");
}

if (!isset($_GET['id'])) {
	urlRedirect("400.html");
}


$form_result="";


function pageRedirect () {
	$pg = isset($_GET['page']) ? "&page=".$_GET['page'] : "";
	urlRedirect("project-messages.php?id=".$_GET['id'].$pg);
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['content'])) {
	
	$response = postCurl(API_URL."sendmessage.php", json_encode(array(
		"content"=> $_POST['content'], 
		"project_id"=> $_GET['id']
	)), auth_header());
	
	if (curl_errno($response[0])) {
		$_SESSION['server_error'] = 1;
		pageRedirect();
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		case 400 :
			if (isset($body['error']['content_error'])) {
				$_SESSION['content_error'] = 1;
			}
			pageRedirect();
		case 500 :
			$_SESSION['server_error'] = 1;
			pageRedirect();
		default :
			$_SESSION['success'] = 1;
			urlRedirect("project-messages.php?id=".$_GET['id']);
	}
}


if (isset($_SESSION['server_error'])) {
	$form_result = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}

if (isset($_SESSION['content_error'])) {
	$form_result = get_form_error($strings['message_empty_input_error']);
	unset($_SESSION['content_error']);
}

if (isset($_SESSION['success'])) {
	$form_result = get_form_success($strings['sent']);
	unset($_SESSION['success']);
}


postCurl(API_URL."updatemessageseen.php", json_encode(array("project_id"=> $_GET['id'])), auth_header());
	

$response = getCurl(API_URL."getprojectparticipants.php?id=".$_GET['id'], app_headers());

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


$participants = [
	"student_id"=> $body['success']['student_id'], 
	"supervisor_id"=> $body['success']['supervisor_id']
];



$page = getPageStart("page", PAGE_LIMIT);

$response = getCurl(API_URL."getprojectmessages.php?id=".$_GET['id']."&page_start=".$page."&page_limit=".PAGE_LIMIT, app_headers());

$code = httpCodeCurl($response[0]);
	
$body = json_decode($response[1], true);
	
curl_close($response[0]);


switch ($code) {
	case 403 :
		 urlRedirect("403.html");
	case 404 :
		 urlRedirect("404.html");
	case 500 :
		urlRedirect("500.html");
}

$topic = $body['success']['project_topic'];

$messages = $body['success']['project_messages'];

$messages_count = $body['success']['project_messages_count'];




?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Project Messages <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet" type="text/css" href="res/css/main.css">
	<link rel="stylesheet" type="text/css" href="res/css/projectpage.css">
	<link rel="stylesheet" type="text/css" href="res/css/projectmessagespage.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>


<body>
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section id="sub-section">
		
		<div id="project-page-topic">
			<?= $icons['project']; ?><h1><?=$topic;?></h1>
		</div>
		
		<?php $nav_active = 3; include_once'res/php/projectnav.php'; ?>
		
	</section>
	
	<section id="main-section">
		
		<form id="main-form" method="POST" action="">
			
			<?php echo $form_result; ?>
			
			<textarea id="message-content-input" name="content" placeholder="<?=$strings['enter_your_message'];?>"></textarea><button type="submit" id="message-send-btn">
				<?=$strings['send'];?>
			</button>
			
		</form>
		
		
		<div id="messages-box">
			
			<?php foreach ($messages as $m) : ?>
			<div class="message-box <?=$m['sender_id']==user_id()?"right":"left";?>">
				
				<?php if ($m['sender_id']!=user_id()) : ?>
				<img src="api/photos/<?=$m['sender_photo_name'];?>" class="message-user-img" />
				<?php endif; ?>
				
				<div class="message-box-body">
					<div class="message-user-name"><?=$m['sender_name'];?></div>
					
					<div class="message-content"><?=$m['automated']?$strings['automated_msg_arr'][$m['automated']-1]:$m['content'];?></div>
					
					<div class="message-date-read">
						<span class="message-date">
							<?=makeDate($m['date']);?>
						</span><span class="message-read">
							<?=$m['seen']?$strings['read']:$strings['unread'];?>
						</span>
					</div>
				</div>
				
				<?php if ($m['sender_id']==user_id()) : ?>
				<img src="api/photos/<?=$m['sender_photo_name'];?>" class="message-user-img" />
				<?php endif; ?>
				
			</div>
			<?php endforeach; ?>
			
			<?php if (empty($messages)) : ?>
			<?=get_no_data_box($strings['no_message']); ?>
			<?php endif; ?>
			
		</div>
		
		<?php echo getPagesBox("page", ceil($messages_count/PAGE_LIMIT), "project-messages.php?id=".$_GET['id']."&page=", null, "#entity-nav", array(
			"next"=> $icons['next'],
			"previous"=> $icons['previous'],
		)); ?>
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
	
</body>


</html>


