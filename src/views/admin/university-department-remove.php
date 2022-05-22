<?php


include_once'../res/php/util.php';


function formToSession () {
	$_SESSION['name_value'] = $_POST['name'];
	urlRedirect("university-department-remove.php");
}

function error500 () {
	$_SESSION['server_error'] = 1;
}



$name_value="";

$name_error="";

$form_result="";


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['remove'])) {
	array_splice($_SESSION['departments'], (int)$_POST['index'], 1);
	if (empty($_SESSION['departments'])) {
		unset($_SESSION['departments']);
	}
	urlRedirect("university-department-remove.php");
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['uni_remove'])) {
	
	if (!isset($_SESSION['departments'])) {
		$_SESSION['departments_error'] = 1;
		formToSession();
	}
	
	$departments_arr = array();
	
	foreach ($_SESSION['departments'] as $dept) {
		$departments_arr[] = $dept['name'];
	}
	
	$response = postCurl(API_URL."removedepartment.php", json_encode(array(
		"name"=> $_POST['name'],
		"departments"=> $departments_arr,
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
			
			if (isset($body['error']['departments_error'])) {
				$_SESSION['departments_error'] = $body['error']['departments_error'];
			}
			
			formToSession();
			
		case 404 :
			$_SESSION['name_error'] = 1;
			formToSession();
			
		case 500 :
			error500();
			formToSession();
			
		default :
			unset($_SESSION['departments']);
			$_SESSION['success'] = 1;
			urlRedirect("university-department-remove.php");
	}
	
}


if (isset($_SESSION['name_value'])) {
	$name_value = $_SESSION['name_value'];
	unset($_SESSION['name_value']);
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
	$form_result = get_form_success("Removed");
	unset($_SESSION['success']);
}

if (isset($_SESSION['name_error'])) {
	$name_error = get_input_error("University don't exist");
	unset($_SESSION['name_error']);
}

if (isset($_SESSION['departments_error'])) {
	$form_result = get_form_error("You have to add departments");
	unset($_SESSION['departments_error']);
}


$header = "Remove Departments from University";



?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>University Departments Remove | Admin Panel</title>
	
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
				<span class="input-span"><?=$strings['university_name'];?></span>
				<?php echo $name_error; ?>
				<input class="main-input" type="text" name="name" value="<?=$name_value;?>" />
			</div>

			<button type="submit" id="main-form-btn" name="uni_remove"><?=$strings['remove'];?></button>
			
		</form>
			
	</section>
	
	
	<?php if (isset($_SESSION['departments']) || !empty($_SESSION['departments'])) : ?>
	
	<?php foreach ($_SESSION['departments'] as $i=> $dept) : ?>
	
	<?php include'../res/php/admin-department.php'; ?>
	
	<?php endforeach; ?>
	
	<?php endif; ?>
	

</body>

</html>







