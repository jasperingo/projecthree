<?php


include_once'res/php/util.php';


if (!signed_in()) {
	header("Location: login.php");
	exit;
}


$form_result="";
$title_error="";
$first_name_error="";
$last_name_error="";
$bio_error="";



if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update_profile'])) {
	
	$_POST['title'] = $_POST['title']==$strings['choose_one']?"":$_POST['title'];
	
	$response = postCurl(API_URL."updateuserprofile.php", json_encode(array(
		"title"=> $_POST['title'],
		"first_name"=> $_POST['first_name'],
		"last_name"=> $_POST['last_name'],
		"bio"=> $_POST['bio']
	)), app_headers());
	
	if (curl_errno($response[0])) {
		$_SESSION['server_error'] = 1;
		header("Location: user-settings-profile.php");
		exit;
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		
		case 400 :
			
			if (isset($body['error']['title_error'])) {
				$_SESSION['input_errors']['title'] = $body['error']['title_error'];
			}
			
			if (isset($body['error']['first_name_error'])) {
				$_SESSION['input_errors']['first_name'] = $body['error']['first_name_error'];
			}
			
			if (isset($body['error']['last_name_error'])) {
				$_SESSION['input_errors']['last_name'] = $body['error']['last_name_error'];
			}
			
			if (isset($body['error']['bio_error'])) {
				$_SESSION['input_errors']['bio'] = $body['error']['bio_error'];
			}
			
			header("Location: user-settings-profile.php");
			exit;
			
		case 500 :
			$_SESSION['server_error'] = 1;
			header("Location: user-settings-profile.php");
			exit;
			
		default :
			$_SESSION['success'] = 1;
			header("Location: user-settings-profile.php");
			exit;
	}
}




if (isset($_SESSION['server_error'])) {
	$form_result = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}

if (isset($_SESSION['input_errors'])) {
	$error = $_SESSION['input_errors'];
		
	if (isset($error['title'])) {
		$title_error = get_input_error($strings['choose_a_valid_option']);
	}
		
	if (isset($error['first_name'])) {
		$first_name_error = get_input_error($strings['first_name_empty_input_error']);
	}
		
	if (isset($error['last_name'])) {
		$last_name_error = get_input_error($strings['last_name_empty_input_error']);
	}
	
	if (isset($error['bio'])) {
		if ($error['bio'] == 2) {
			$bio_error = get_input_error($strings['bio_long_input_error']);
		} elseif ($error['bio'] == 3) {
			$bio_error = get_input_error($strings['bio_short_input_error']);
		}
	}
	
	unset($_SESSION['input_errors']);
}


if (isset($_SESSION['success'])) {
	$form_result = get_form_success($strings['updated']);
	unset($_SESSION['success']);
}





$response = getCurl(API_URL."getuser.php?id=".user_id(), app_headers());

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



?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="UTF-8">
	
	<title>User Settings <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet"  type="text/css" href="res/css/main.css">
	<link rel="stylesheet"  type="text/css" href="res/css/usersettingspage.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>

<body>
	
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section id="sub-section">
		<?php $nav_active = 0; include_once'res/php/usersettingsnav.php'; ?>
	</section>
	
	
	<section id="main-section">
		
		<form id="main-form" method="POST" action="" novalidate="novalidate">
	
			<?php echo $form_result; ?>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['title']; ?></span>
				<?php echo $title_error; ?>
				<select class="main-select" name="title">
					<option><?php echo $strings['choose_one']; ?></option>
					<?php foreach ($strings['title_arr'] AS $title) : ?>
					<option <?=$title==$data['title']?"selected":"";?>><?=$title; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['first_name']; ?></span>
				<?php echo $first_name_error; ?>
				<input class="main-input" type="text" name="first_name" value="<?php echo $data['first_name']; ?>" />
			</div>
	
			<div class="input-box">
				<span class="input-span"><?php echo $strings['last_name']; ?></span>
				<?php echo $last_name_error; ?>
				<input class="main-input" type="text" name="last_name" value="<?php echo $data['last_name']; ?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['bio']; ?></span>
				<?php echo $bio_error; ?>
				<textarea class="main-textarea" name="bio"><?php echo $data['bio']; ?></textarea>
			</div>
			
			<button type="submit" id="main-form-btn" name="update_profile"><?php echo $strings['save']; ?></button>
	
		</form>
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
</body>


</html>

