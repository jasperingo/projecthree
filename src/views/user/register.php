<?php


include_once'res/php/util.php';


if (signed_in()) {
	header("Location: user.php?id=".user_id());
	exit;
}


function formToSession () {
	
	$_SESSION['input_values'] = array(
		"title"=> $_POST['title'],
		"first_name"=> $_POST['first_name'],
		"last_name"=> $_POST['last_name'],
		"email"=> $_POST['email']
	);
	
	header("Location: register.php");
	exit;
}

function error500 () {
	$_SESSION['server_error'] = 1;
}



$title_value="";
$first_name_value="";
$last_name_value="";
$email_value="";

$title_error="";
$first_name_error="";
$last_name_error="";
$email_error="";
$password1_error="";
$password2_error="";
$form_error="";


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {
	
	if ($_POST['password'] != $_POST['confirm_password']) {
		$_SESSION['input_errors']['password'] = 4;
		formToSession();
	}
	
	$_POST['title'] = $_POST['title']==$strings['choose_one']?"":$_POST['title'];
	
	$response = postCurl(API_URL."signup.php", json_encode(array(
		"title"=> $_POST['title'],
		"first_name"=> $_POST['first_name'],
		"last_name"=> $_POST['last_name'],
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
			
			if (isset($body['error']['title_error'])) {
				$_SESSION['input_errors']['title'] = $body['error']['title_error'];
			}
			
			if (isset($body['error']['first_name_error'])) {
				$_SESSION['input_errors']['first_name'] = $body['error']['first_name_error'];
			}
			
			if (isset($body['error']['last_name_error'])) {
				$_SESSION['input_errors']['last_name'] = $body['error']['last_name_error'];
			}
			
			if (isset($body['error']['email_error'])) {
				$_SESSION['input_errors']['email'] = $body['error']['email_error'];
			}
			
			if (isset($body['error']['password_error'])) {
				$_SESSION['input_errors']['password'] = $body['error']['password_error'];
			}
			
			formToSession();
			
		case 500 :
			error500();
			formToSession();
			
		default :
			
			if (empty($body['success']['token'])) {
				header("Location: login.php");
				exit;
			}
			
			make_cookie($body['success']['id'], $body['success']['token']);
			
			header("Location: user.php?id=".$body['success']['id']);
			exit;
	}
	
}


if (isset($_SESSION['input_values'])) {
	$title_value = $_SESSION['input_values']['title'];
	$first_name_value = $_SESSION['input_values']['first_name'];
	$last_name_value = $_SESSION['input_values']['last_name'];
	$email_value = $_SESSION['input_values']['email'];
	unset($_SESSION['input_values']);
}

if (isset($_SESSION['server_error'])) {
	$form_error = get_form_error($strings['server_error']);
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
	
	if (isset($error['email'])) {
		if ($error['email'] == 1) {
			$email_error = get_input_error($strings['email_empty_input_error']);
		} elseif ($error['email'] == 2) {
			$email_error = get_input_error($strings['email_invalid_input_error']);
		} elseif ($error['email'] == 3) {
			$email_error = get_input_error($strings['email_taken_input_error']);
		}
	}
	
	if (isset($error['password'])) {
		if ($error['password'] == 1) {
			$password1_error = get_input_error($strings['password_empty_input_error']);
		} elseif ($error['password'] == 2) {
			$password1_error = get_input_error($strings['password_long_input_error']);
		} elseif ($error['password'] == 3) {
			$password1_error = get_input_error($strings['password_short_input_error']);
		} elseif ($error['password'] == 4) {
			$password2_error = get_input_error($strings['password_match_input_error']);
		}
	}
	
	unset($_SESSION['input_errors']);
}



?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Register <?=$strings['website_title_note'];?></title>
	
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
				<span class="input-span"><?php echo $strings['title']; ?></span>
				<?php echo $title_error; ?>
				<select class="main-select" name="title">
					<option><?php echo $strings['choose_one']; ?></option>
					<?php foreach ($strings['title_arr'] AS $title) : ?>
					<option <?=$title==$title_value?"selected":"";?>><?php echo $title; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['first_name']; ?></span>
				<?php echo $first_name_error; ?>
				<input class="main-input" type="text" name="first_name" value="<?php echo $first_name_value; ?>" />
			</div>
	
			<div class="input-box">
				<span class="input-span"><?php echo $strings['last_name']; ?></span>
				<?php echo $last_name_error; ?>
				<input class="main-input" type="text" name="last_name" value="<?php echo $last_name_value; ?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['email']; ?></span>
				<?php echo $email_error; ?>
				<input class="main-input" type="email" name="email" value="<?php echo $email_value; ?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['password']; ?></span>
				<?php echo $password1_error; ?>
				<input class="main-input" type="password" name="password" />
				<div class="input-span-2"><?php echo $strings['password_recommendation_note']; ?>.</div>
			</div>
			
			<div class="input-box">
				<span class="input-span"><?php echo $strings['confirm_password']; ?></span>
				<?php echo $password2_error; ?>
				<input class="main-input" type="password" name="confirm_password" />
			</div>
			
			<div class="main-form-note">
				<?php echo $strings['already_have_an_account']; ?>? 
				<a href="login.php"><?php echo strtolower($strings['log_in']); ?></a>.
			</div>
			
			<div class="main-form-note">
				<?php echo $strings['by_registering_you_agree_to_our']; ?> 
				<a href="terms.html"><?php echo strtolower($strings['terms_and_policy']); ?></a>.
			</div>
			
			<button type="submit" id="main-form-btn" name="register"><?php echo $strings['register']; ?></button>
			
		</form>
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	

</body>

</html>



