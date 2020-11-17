<?php


include_once'res/php/util.php';


if (!isset($_GET['id'])) {
	urlRedirect("400.html");
}


$form_result="";


function pageRedirect () {
	$pg = isset($_GET['page']) ? "&page=".$_GET['page'] : "";
	urlRedirect("project-reviews.php?id=".$_GET['id'].$pg);
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['star'])) {
	
	$response = postCurl(API_URL."sendreview.php", json_encode(array(
		"content"=> $_POST['content'], 
		"star"=> $_POST['star'],
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
			if (isset($body['error']['content_error']) || isset($body['error']['star_error'])) {
				$_SESSION['input_error'] = 1;
			}
			pageRedirect();
		case 500 :
			$_SESSION['server_error'] = 1;
			pageRedirect();
		default :
			$_SESSION['success'] = 1;
			pageRedirect();
	}
}


if (isset($_SESSION['server_error'])) {
	$form_result = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}

if (isset($_SESSION['input_error'])) {
	$form_result = get_form_error($strings['review_input_error']);
	unset($_SESSION['input_error']);
}

if (isset($_SESSION['success'])) {
	$form_result = get_form_success($strings['sent']);
	unset($_SESSION['success']);
}


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

$response = getCurl(API_URL."getprojectreviews.php?id=".$_GET['id']."&page_start=".$page."&page_limit=".PAGE_LIMIT, app_headers());

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

$reviews = $body['success']['project_reviews'];

$reviews_count = $body['success']['project_reviews_count'];




?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Project Reviews <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet" type="text/css" href="res/css/main.css">
	<link rel="stylesheet" type="text/css" href="res/css/projectpage.css">
	<link rel="stylesheet" type="text/css" href="res/css/projectreviewspage.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>


<body>
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section id="sub-section">
		
		<div id="project-page-topic">
			<?= $icons['project']; ?><h1><?=$topic;?></h1>
		</div>
		
		<?php $nav_active = 1; include_once'res/php/projectnav.php'; ?>
		
	</section>
	
	<section id="main-section">
		
		<?php if (signed_in() && user_id() != $participants['student_id'] && user_id() != $participants['supervisor_id']) : ?>
		<form id="main-form" method="POST" action="">
			
			<?php echo $form_result; ?>
			
			<span id="review-input-label" class="input-span"><?=$strings['review_this_project'];?></span>
			
			<select id="review-star-input" name="star">
				<option value="0"><?=$strings['star'];?></option>
				<?php for ($i=1;$i<6;$i++) : ?>
				<option value="<?=$i;?>"><?=$i." ".$strings['star'];?></option>
				<?php endfor; ?>
			</select><textarea id="review-content-input" name="content"></textarea>
			
			<button type="submit" id="review-send-btn"><?=$strings['send'];?></button>
			
		</form>
		<?php endif; ?>
		
		
		<div id="reviews-box">
			
			<?php foreach ($reviews as $v) : ?>
			<div class="review-box">
				<a href="user.php?id=<?=$v['sender_id'];?>" class="review-user">
					<img src="api/photos/<?=$v['sender_photo_name'];?>" class="review-user-img" />
					<div class="review-user-name"><?=$v['sender_name'];?></div>
				</a>
				<div class="review-content"><?=lineBreakString($v['content']);?></div>
				<div class="review-star-date">
					<div class="review-star">
						<?php for ($i=1;$i<6;$i++) {
							if ($v['star'] < $i && $v['star'] <= ($i-1)) {
								echo $icons['blank_star']; 
							} elseif ($v['star'] < $i && $v['star'] > ($i-1)) {
								echo $icons['half_star']; 
							} else {
								echo $icons['star'];
							}
						}?>
					</div><div class="review-date">
						<?=makeDate($v['date']);?>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
			
			<?php if (empty($reviews)) : ?>
			<?=get_no_data_box($strings['no_review']); ?>
			<?php endif; ?>
			
		</div>
		
		<?php echo getPagesBox("page", ceil($reviews_count/PAGE_LIMIT), "project-reviews.php?id=".$_GET['id']."&page=", null, "#entity-nav", array(
			"next"=> $icons['next'],
			"previous"=> $icons['previous'],
		)); ?>
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
	
</body>


</html>


