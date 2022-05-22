<?php


include_once'res/php/util.php';


if (signed_in()) {
	header("Location: user.php?id=".user_id());
	exit;
}


function formToSession () {
	$_SESSION['email_value'] = $_POST['email'];
	header("Location: login.php");
	exit;
}

function error500 () {
	$_SESSION['server_error'] = 1;
}

$email_value="";

$email_error="";
$password_error="";
$form_error="";



if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['log_in'])) {
	
	$response = postCurl(API_URL."signin.php", json_encode(array(
		"email"=> $_POST['email'],
		"password"=> $_POST['password']
	)), app_headers());
	
	if (curl_errno($response[0])) {
		error500();
		formToSession();
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		
		case 400 :
			
			if (isset($body['error']['email_error'])) {
				$_SESSION['email_error'] = $body['error']['email_error'];
			}
			
			if (isset($body['error']['password_error'])) {
				$_SESSION['password_error'] = $body['error']['password_error'];
			}
			
			formToSession();
			
		case 500 :
			error500();
			formToSession();
			
		default :
			
			make_cookie($body['success']['id'], $body['success']['token']);
			
			header("Location: user.php?id=".$body['success']['id']);
			exit;
			
	}
}


if (isset($_SESSION['email_value'])) {
	$email_value = $_SESSION['email_value'];
	unset($_SESSION['email_value']);
}

if (isset($_SESSION['server_error'])) {
	$form_error = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}

if (isset($_SESSION['email_error'])) {
	$email_error = get_input_error($strings['email_not_exist_input_error']);
	unset($_SESSION['email_error']);
}

if (isset($_SESSION['password_error'])) {
	$password_error = get_input_error($strings['password_incorrect_input_error']);
	unset($_SESSION['password_error']);
}




?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Log in <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet"  type="text/css" href="res/css/main.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>

<body>
	
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section class="main-section">

		<form id="main-form" method="POST" action="" novalidate="novalidate">
			
			<?php echo $form_error; ?>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['email']; ?></span>
				<?php echo $email_error; ?>
				<input class="main-input" type="text" name="email" value="<?php echo $email_value; ?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['password']; ?></span>
				<?php echo $password_error; ?>
				<input class="main-input" type="password" name="password" />
			</div>
			
			
			<div class="main-form-note">
				<?php echo $strings['dont_have_an_account']; ?>? 
				<a href="register.php"><?php echo strtolower($strings['register']); ?></a>.
			</div>
			
			<div class="main-form-note">
				<a href="recover-password.php"><?php echo $strings['forgot_password']; ?>?</a>
			</div>
			
			<button type="submit" id="main-form-btn" name="log_in"><?php echo $strings['log_in']; ?></button>
			
			
		</form>
		
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
	
</body>

</html>


