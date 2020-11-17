<?php


include_once'res/php/util.php';


if (!signed_in()) {
	header("Location: login.php");
	exit;
}


$form_result="";
$email_error="";


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update_email'])) {
	
	$response = postCurl(API_URL."updateuseremail.php", json_encode(array("email"=> $_POST['email'])), app_headers());
	
	if (curl_errno($response[0])) {
		$_SESSION['server_error'] = 1;
		header("Location: user-settings-email.php");
		exit;
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		
		case 400 :
			
			if (isset($body['error']['email_error'])) {
				$_SESSION['email_error'] = $body['error']['email_error'];
			}
			
			header("Location: user-settings-email.php");
			exit;
			
		case 500 :
			$_SESSION['server_error'] = 1;
			header("Location: user-settings-email.php");
			exit;
			
		default :
			$_SESSION['success'] = 1;
			header("Location: user-settings-email.php");
			exit;
	}
}




if (isset($_SESSION['server_error'])) {
	$form_result = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}

if (isset($_SESSION['email_error'])) {
	if ($_SESSION['email_error'] == 1) {
		$email_error = get_input_error($strings['email_empty_input_error']);
	} elseif ($_SESSION['email_error'] == 2) {
		$email_error = get_input_error($strings['email_invalid_input_error']);
	} elseif ($_SESSION['email_error'] == 3) {
		$email_error = get_input_error($strings['email_taken_input_error']);
	}
	unset($_SESSION['email_error']);
}


if (isset($_SESSION['success'])) {
	$form_result = get_form_success($strings['updated']);
	unset($_SESSION['success']);
}





$response = getCurl(API_URL."getuseremail.php", app_headers());

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


$data = $body['success']['user_email'];



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
		<?php $nav_active = 2; include_once'res/php/usersettingsnav.php'; ?>
	</section>
	
	
	<section id="main-section">
		
		<form id="main-form" method="POST" action="" novalidate="novalidate">
			
			<?php echo $form_result; ?>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['email']; ?></span>
				<?php echo $email_error; ?>
				<input class="main-input" type="text" name="email" value="<?php echo $data; ?>" />
			</div>
			
			<button type="submit" id="main-form-btn" name="update_email"><?php echo $strings['save']; ?></button>
			
		</form>
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
</body>


</html>









