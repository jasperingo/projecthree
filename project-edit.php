<?php


include_once'res/php/util.php';


if (!signed_in()) {
	urlRedirect("login.php");
}

if (!isset($_GET['id'])) {
	urlRedirect("400.html");
}



$form_result="";
$topic_error="";
$privacy_error="";
$description_error="";



if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit_project'])) {
	
	$response = postCurl(API_URL."updateprojectprofile.php", json_encode(array(
		"topic"=> $_POST['topic'],
		"privacy"=> $_POST['privacy'],
		"description"=> $_POST['description'],
		"id"=> $_GET['id']
	)), app_headers());
	
	if (curl_errno($response[0])) {
		$_SESSION['server_error'] = 1;
		urlRedirect("project-edit.php?id=".$_GET['id']);
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		
		case 400 :
			
			if (isset($body['error']['topic_error'])) {
				$_SESSION['input_errors']['topic'] = $body['error']['topic_error'];
			}
			
			if (isset($body['error']['privacy_error'])) {
				$_SESSION['input_errors']['privacy'] = $body['error']['privacy_error'];
			}
			
			if (isset($body['error']['description_error'])) {
				$_SESSION['input_errors']['description'] = $body['error']['description_error'];
			}
			
			urlRedirect("project-edit.php?id=".$_GET['id']);
		
		case 404 :
			$_SESSION['404_error'] = 1;
			urlRedirect("project-edit.php?id=".$_GET['id']);
			
		case 500 :
			$_SESSION['server_error'] = 1;
			urlRedirect("project-edit.php?id=".$_GET['id']);
			
		default :
			$_SESSION['success'] = 1;
			urlRedirect("project-edit.php?id=".$_GET['id']);
	}
	
}



if (isset($_SESSION['server_error'])) {
	$form_result = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}

if (isset($_SESSION['404_error'])) {
	$form_result = get_form_error($strings['not_found_error']);
	unset($_SESSION['404_error']);
}

if (isset($_SESSION['input_errors'])) {
	$error = $_SESSION['input_errors'];
		
	if (isset($error['topic'])) {
		if ($error['topic'] == 1) {
			$topic_error = get_input_error($strings['topic_empty_input_error']);
		} elseif ($error['topic'] == 2) {
			$topic_error = get_input_error($strings['topic_long_input_error']);
		} elseif ($error['topic'] == 3) {
			$topic_error = get_input_error($strings['topic_short_input_error']);
		}
	}
	
	if (isset($error['privacy'])) {
		$privacy_error = get_input_error($strings['choose_a_valid_option']);
	}
	
	if (isset($error['description'])) {
		if ($error['description'] == 1) {
			$description_error = get_input_error($strings['description_empty_input_error']);
		} elseif ($error['description'] == 2) {
			$description_error = get_input_error($strings['description_long_input_error']);
		} elseif ($error['description'] == 3) {
			$description_error = get_input_error($strings['description_short_input_error']);
		}
	}
	
	unset($_SESSION['input_errors']);
}


if (isset($_SESSION['success'])) {
	$form_result = get_form_success($strings['updated']);
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



$response = getCurl(API_URL."getprojectedit.php?id=".$_GET['id'], app_headers());

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




?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Project Edit <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet" type="text/css" href="res/css/main.css">
	<link rel="stylesheet" type="text/css" href="res/css/projectpage.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>


<body>
	
	<?php $nav_active = 4; include_once'res/php/header.php'; ?>
	
	
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
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
	
</body>


</html>



