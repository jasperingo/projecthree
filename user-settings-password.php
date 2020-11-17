<?php


include_once'res/php/util.php';


if (!signed_in()) {
	header("Location: login.php");
	exit;
}


$form_result="";
$password1_error="";
$password2_error="";
$password3_error="";


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update_password'])) {
	
	if ($_POST['new_password'] != $_POST['confirm_new_password']) {
		$_SESSION['new_password_error'] = 4;
		header("Location: user-settings-password.php");
		exit;
	}
	
	$response = postCurl(API_URL."updateuserpassword.php", json_encode(array(
		"password"=> $_POST['password'],
		"new_password"=> $_POST['new_password'],
	)), app_headers());
	
	if (curl_errno($response[0])) {
		$_SESSION['server_error'] = 1;
		header("Location: user-settings-password.php");
		exit;
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		
		case 400 :
			
			if (isset($body['error']['password_error'])) {
				$_SESSION['password_error'] = $body['error']['password_error'];
			}
			
			if (isset($body['error']['new_password_error'])) {
				$_SESSION['new_password_error'] = $body['error']['new_password_error'];
			}
			
			header("Location: user-settings-password.php");
			exit;
			
		case 500 :
			$_SESSION['server_error'] = 1;
			header("Location: user-settings-password.php");
			exit;
			
		default :
			$_SESSION['success'] = 1;
			header("Location: user-settings-password.php");
			exit;
	}
}




if (isset($_SESSION['server_error'])) {
	$form_result = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}

if (isset($_SESSION['password_error'])) {
	$password1_error = get_input_error($strings['password_incorrect_input_error']);
	unset($_SESSION['password_error']);
}


if (isset($_SESSION['new_password_error'])) {
	if ($_SESSION['new_password_error'] == 1) {
		$password2_error = get_input_error($strings['password_empty_input_error']);
	} elseif ($_SESSION['new_password_error'] == 2) {
		$password2_error = get_input_error($strings['password_long_input_error']);
	} elseif ($_SESSION['new_password_error'] == 3) {
		$password2_error = get_input_error($strings['password_short_input_error']);
	} elseif ($_SESSION['new_password_error'] == 4) {
		$password3_error = get_input_error($strings['password_match_input_error']);
	}
	
	unset($_SESSION['new_password_error']);
}



if (isset($_SESSION['success'])) {
	$form_result = get_form_success($strings['updated']);
	unset($_SESSION['success']);
}




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
		<?php $nav_active = 3; include_once'res/php/usersettingsnav.php'; ?>
	</section>
	
	
	<section id="main-section">
		
		<form id="main-form" method="POST" action="" novalidate="novalidate">
			
			<?php echo $form_result; ?>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['password']; ?></span>
				<?php echo $password1_error; ?>
				<input class="main-input" type="password" name="password" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['new_password']; ?></span>
				<?php echo $password2_error; ?>
				<input class="main-input" type="password" name="new_password" />
				<div class="input-span-2"><?php echo $strings['password_recommendation_note']; ?>.</div>
			</div>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['confirm_new_password']; ?></span>
				<?php echo $password3_error; ?>
				<input class="main-input" type="password" name="confirm_new_password" />
			</div>
			
			<button type="submit" id="main-form-btn" name="update_password"><?php echo $strings['save']; ?></button>
			
		</form>
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
</body>


</html>






