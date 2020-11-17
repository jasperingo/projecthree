<?php


include_once'res/php/util.php';


function error500 () {
	$_SESSION['server_error'] = 1;
	urlRedirect("recover-password.php");
}

$email_error="";
$code_error="";
$password_error="";
$password1_error="";
$form_result="";
$email_value="";


if (isset($_GET['r'])) {
	session_unset();
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['request'])) {
	
	$response = postCurl(API_URL."requestpasswordrecovery.php", json_encode(array("email"=> $_POST['email'])), app_headers());
	
	if (curl_errno($response[0])) {
		$_SESSION['email_value'] = $_POST['email'];
		error500();
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		
		case 400 :
			
			if (isset($body['error']['email_error'])) {
				$_SESSION['email_error'] = $body['error']['email_error'];
			}
			
			$_SESSION['email_value'] = $_POST['email'];
			
			urlRedirect("recover-password.php");
			
		case 500 :
			$_SESSION['email_value'] = $_POST['email'];
			error500();
			
		default :
			
			$_SESSION['recover_email'] = $_POST['email'];
			$_SESSION['recover_code'] = $body['success']['code'];
			
			urlRedirect("recover-password.php");
			
	}
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['recover'])) {
	
	if ($_POST['password'] != $_POST['confirm_password']) {
		$_SESSION['password_error'] = 4;
		urlRedirect("recover-password.php");
	}
	
	$response = postCurl(API_URL."recoverpassword.php", json_encode(array(
		"email"=> $_SESSION['recover_email'],
		"code"=> $_POST['code'],
		"password"=> $_POST['password']
	)), app_headers());
	
	if (curl_errno($response[0])) {
		error500();
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		
		case 400 :
			
			if (isset($body['error']['code_error'])) {
				$_SESSION['code_error'] = $body['error']['code_error'];
			}
			
			if (isset($body['error']['password_error'])) {
				$_SESSION['password_error'] = $body['error']['password_error'];
			}
			
			urlRedirect("recover-password.php");
			
		case 500 :
			error500();
			
		default :
			
			session_unset();
			$_SESSION['success'] = 1;
			
			urlRedirect("recover-password.php");
			
	}
}



if (isset($_SESSION['server_error'])) {
	$form_result = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}


if (isset($_SESSION['email_value'])) {
	$email_value = $_SESSION['email_value'];
	unset($_SESSION['email_value']);
}

if (isset($_SESSION['email_error'])) {
	$email_error = get_input_error($strings['email_not_exist_input_error']);
	unset($_SESSION['email_error']);
}


if (isset($_SESSION['password_error'])) {
	if ($_SESSION['password_error'] == 1) {
		$password_error = get_input_error($strings['password_empty_input_error']);
	} elseif ($_SESSION['password_error'] == 2) {
		$password_error = get_input_error($strings['password_long_input_error']);
	} elseif ($_SESSION['password_error'] == 3) {
		$password_error = get_input_error($strings['password_short_input_error']);
	} elseif ($_SESSION['password_error'] == 4) {
		$password1_error = get_input_error($strings['password_match_input_error']);
	}
	
	unset($_SESSION['password_error']);
}

if (isset($_SESSION['code_error'])) {
	if ($_SESSION['code_error'] == 1) {
		$code_error = get_input_error($strings['recover_password_code_invalid_input_error']);
	} elseif ($_SESSION['code_error'] == 2) {
		$code_error = get_input_error($strings['recover_password_code_expired_input_error']);
	}
	
	unset($_SESSION['code_error']);
}

if (isset($_SESSION['success'])) {
	$form_result = get_form_success($strings['recover_password_success']);
	unset($_SESSION['success']);
}



?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Recover Password <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet"  type="text/css" href="res/css/main.css?h">
	<link rel="stylesheet"  type="text/css" href="res/css/register.css?d">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>

<body>
	
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section class="main-section">

		<form id="main-form" method="POST" action="" novalidate="novalidate">
			
			<?php echo $form_result; ?>
			
			<?php if (isset($_SESSION['recover_email'])) : ?>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['recover_password_code_note']; ?></span>
				<?php echo $code_error; ?>
				<input class="main-input" type="text" name="code" value="<?=$_SESSION['recover_code'];?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['password']; ?></span>
				<?php echo $password_error; ?>
				<input class="main-input" type="password" name="password" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['confirm_password']; ?></span>
				<?php echo $password1_error; ?>
				<input class="main-input" type="password" name="confirm_password" />
			</div>
			
			<div class="main-form-note">
				<a href="<?="recover-password.php?r=1";?>"><?php echo $strings['go_back']; ?></a>
			</div>
			
			<button type="submit" id="main-form-btn" name="recover"><?php echo $strings['send']; ?></button>
			
			<?php else : ?>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['request_recover_password_note']; ?></span>
				<?php echo $email_error; ?>
				<input class="main-input" type="text" name="email" value="<?=$email_value;?>" />
			</div>

			<button type="submit" id="main-form-btn" name="request"><?php echo $strings['send']; ?></button>
			
			<?php endif; ?>
			
		</form>
		
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
	
</body>

</html>


