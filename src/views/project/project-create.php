<?php


include_once'res/php/util.php';


if (!signed_in()) {
	urlRedirect("login.php");
}


$form_result="";
$topic_error="";
$student_error="";
$university_error="";
$department_error="";
$topic_value="";
$student_value="";
$university_value="";
$department_value="";


function formToSession () {
	
	$_SESSION['input_values'] = array(
		"topic"=> $_POST['topic'],
		"university_name"=> $_POST['university_name'],
		"department_name"=> $_POST['department_name'],
		"student_email"=> $_POST['student_email']
	);
	
	urlRedirect("project-create.php");
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['create_project'])) {
	
	$response = postCurl(API_URL."createproject.php", json_encode(array(
		"topic"=> $_POST['topic'],
		"university_name"=> $_POST['university_name'],
		"department_name"=> $_POST['department_name'],
		"student_email"=> $_POST['student_email']
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
			
			if (isset($body['error']['university_name_error'])) {
				$_SESSION['input_errors']['university'] = $body['error']['university_name_error'];
			}
			
			if (isset($body['error']['department_name_error'])) {
				$_SESSION['input_errors']['department'] = $body['error']['department_name_error'];
			}
			
			if (isset($body['error']['university_department_error'])) {
				$_SESSION['input_errors']['university_department'] = $body['error']['university_department_error'];
			}
			
			if (isset($body['error']['student_email_error'])) {
				$_SESSION['input_errors']['student'] = $body['error']['student_email_error'];
			}
			
			formToSession();
			
		case 500 :
			$_SESSION['server_error'] = 1;
			formToSession();
			
		default :
			urlRedirect("project.php?id=".$body['success']['id']);
	}
	
}



if (isset($_SESSION['server_error'])) {
	$form_result = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}


if (isset($_SESSION['input_values'])) {
	$topic_value = $_SESSION['input_values']['topic'];
	$university_value = $_SESSION['input_values']['university_name'];
	$department_value = $_SESSION['input_values']['department_name'];
	$student_value = $_SESSION['input_values']['student_email'];
	unset($_SESSION['input_values']);
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
	
	if (isset($error['university'])) {
		$university_error = get_input_error($strings['university_name_exist_input_error']);
	}
	
	if (isset($error['department'])) {
		$department_error = get_input_error($strings['department_name_exist_input_error']);
	}
	
	if (isset($error['university_department'])) {
		$department_error = get_input_error($strings['university_department_exist_input_error']);
	}
	
	if (isset($error['student'])) {
		if ($error['student'] == 1) {
			$student_error = get_input_error($strings['student_email_exist_input_error']);
		} elseif ($error['student'] == 2) {
			$student_error = get_input_error($strings['student_email_same_input_error']);
		}
	}
	
	unset($_SESSION['input_errors']);
}






?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Project Create <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet" type="text/css" href="res/css/main.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>


<body>
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section id="main-section">
		
		<form id="main-form" method="POST" action="" novalidate="novalidate">
			
			<?php echo $form_result; ?>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['topic'];?></span>
				<?=$topic_error;?>
				<input class="main-input" type="text" name="topic" value="<?=$topic_value;?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['university_name'];?></span>
				<?=$university_error;?>
				<input class="main-input" type="text" name="university_name" value="<?=$university_value;?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['department_name'];?></span>
				<?=$department_error;?>
				<input class="main-input" type="text" name="department_name" value="<?=$department_value;?>" />
			</div>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['student_email'];?></span>
				<?=$student_error;?>
				<input class="main-input" type="text" name="student_email" value="<?=$student_value;?>" />
			</div>
			
			<button type="submit" id="main-form-btn" name="create_project"><?=$strings['create'];?></button>
			
		</form>
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
	
</body>


</html>





