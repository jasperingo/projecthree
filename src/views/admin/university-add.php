<?php


include_once'../res/php/util.php';





function formToSession () {
	
	$_SESSION['input_values'] = array(
		"name"=> $_POST['name'],
		"acronym"=> $_POST['acronym'],
		"address"=> $_POST['address'],
		"description"=> $_POST['description'],
	);
	
	urlRedirect("university-add.php");
}

function error500 () {
	$_SESSION['server_error'] = 1;
}



$name_value="";
$acronym_value="";
$address_value="";
$description_value="";

$name_error="";
$acronym_error="";
$address_error="";
$description_error="";

$form_result="";


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['remove'])) {
	array_splice($_SESSION['departments'], (int)$_POST['index'], 1);
	if (empty($_SESSION['departments'])) {
		unset($_SESSION['departments']);
	}
	urlRedirect("university-add.php");
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])) {
	
	if (!isset($_SESSION['departments'])) {
		$_SESSION['input_errors']['departments'] = 1;
		formToSession();
	}
	
	$response = postCurl(API_URL."adduniversity.php", json_encode(array(
		"name"=> $_POST['name'],
		"acronym"=> $_POST['acronym'],
		"address"=> $_POST['address'],
		"description"=> $_POST['description'],
		"departments"=> $_SESSION['departments'],
		"id"=> $_POST['id'],
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
		
		case 401 :
			$_SESSION['auth_error'] = 1;
			formToSession();
			
		case 400 :
			
			if (isset($body['error']['name_error'])) {
				$_SESSION['input_errors']['name'] = $body['error']['name_error'];
			}
			
			if (isset($body['error']['acronym_error'])) {
				$_SESSION['input_errors']['acronym'] = $body['error']['acronym_error'];
			}
			
			if (isset($body['error']['address_error'])) {
				$_SESSION['input_errors']['address'] = $body['error']['address_error'];
			}
			
			if (isset($body['error']['description_error'])) {
				$_SESSION['input_errors']['description'] = $body['error']['description_error'];
			}
			
			if (isset($body['error']['departments_error'])) {
				$_SESSION['input_errors']['departments'] = $body['error']['departments_error'];
			}
			
			formToSession();
			
		case 500 :
			error500();
			formToSession();
			
		default :
			unset($_SESSION['departments']);
			$_SESSION['success'] = 1;
			urlRedirect("university-add.php");
	}
	
}


if (isset($_SESSION['input_values'])) {
	$name_value = $_SESSION['input_values']['name'];
	$acronym_value = $_SESSION['input_values']['acronym'];
	$address_value = $_SESSION['input_values']['address'];
	$description_value = $_SESSION['input_values']['description'];
	unset($_SESSION['input_values']);
}

if (isset($_SESSION['auth_error'])) {
	$form_result = get_form_error("ID or password incorrect");
	unset($_SESSION['auth_error']);
}

if (isset($_SESSION['server_error'])) {
	$form_result = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}

if (isset($_SESSION['success'])) {
	$form_result = get_form_success("Added");
	unset($_SESSION['success']);
}

if (isset($_SESSION['input_errors'])) {
	$error = $_SESSION['input_errors'];
	
	if (isset($error['name'])) {
		if ($error['name'] == 1) {
			$name_error = get_input_error("Enter university name");
		} elseif ($error['name'] == 2) {
			$name_error = get_input_error("University exists");
		}
	}
	
	if (isset($error['acronym'])) {
		$acronym_error = get_input_error("Enter university acronym");
	}
		
	if (isset($error['description'])) {
		$description_error = get_input_error("Enter university description");
	}
		
	if (isset($error['address'])) {
		$address_error = get_input_error("Enter university address");
	}
	
	if (isset($error['departments'])) {
		$form_result = get_form_error("You have to add departments");
	}
	
	unset($_SESSION['input_errors']);
}




$header = "Add University";



?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>University Add | Admin Panel</title>
	
	<link rel="stylesheet"  type="text/css" href="../res/css/main.css">
	<link rel="stylesheet"  type="text/css" href="../res/css/admin.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../res/icons/favicon.png" type="image/png">
	
</head>

<body>
	
	<?php include_once'../res/php/admin-header.php'; ?>
	
	
	<section class="main-section">
		
		<nav id="one">
			<a href="index.php" >Add Department</a>
		</nav>
		
		
		<?php include_once'../res/php/admin-login.php'; ?>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['name'];?></span>
				<?php echo $name_error; ?>
				<input class="main-input" type="text" name="name" value="<?=$name_value;?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['acronym'];?></span>
				<?php echo $acronym_error; ?>
				<input class="main-input" type="text" name="acronym" value="<?=$acronym_value;?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['address'];?></span>
				<?php echo $address_error; ?>
				<input class="main-input" type="text" name="address" value="<?=$address_value;?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['description']; ?></span>
				<?php echo $description_error; ?>
				<textarea class="main-textarea" name="description"><?=$description_value;?></textarea>
			</div>
			
			
			
			<button type="submit" id="main-form-btn" name="add"><?=$strings['add'];?></button>
			
		</form>
			
	</section>
	
	
	<?php if (isset($_SESSION['departments']) || !empty($_SESSION['departments'])) : ?>
	
	<?php foreach ($_SESSION['departments'] as $i=> $dept) : ?>
	
	<?php include'../res/php/admin-department.php'; ?>
	
	<?php endforeach; ?>
	
	<?php endif; ?>
	

</body>

</html>






