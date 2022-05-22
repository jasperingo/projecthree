<?php


include_once'res/php/util.php';


if (!signed_in()) {
	header("Location: login.php");
	exit;
}


$form_result="";


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update_photo'])) {
	
	if (empty($_FILES['photo']['name'])) {
		$_SESSION['photo_error'] = 1;
		header("Location: user-settings-photo.php");
		exit;
	}
	
	$p = new CurlFile($_FILES['photo']['tmp_name'], 'image/*', $_FILES['photo']['name']);
	
	$response = postCurl(API_URL."updateuserphoto.php", array("photo"=> $p), auth_header());
	
	if (curl_errno($response[0])) {
		$_SESSION['server_error'] = 1;
		header("Location: user-settings-photo.php");
		exit;
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		
		case 400 :
			
			if (isset($body['error']['photo_error'])) {
				$_SESSION['photo_error'] = $body['error']['photo_error'];
			}
			
			header("Location: user-settings-photo.php");
			exit;
			
		case 500 :
			$_SESSION['server_error'] = 1;
			header("Location: user-settings-photo.php");
			exit;
			
		default :
			$_SESSION['success'] = 1;
			header("Location: user-settings-photo.php");
			exit;
	}
}




if (isset($_SESSION['server_error'])) {
	$form_result = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}

if (isset($_SESSION['photo_error'])) {
	$form_result = get_form_error($strings['photo_error']);
	unset($_SESSION['photo_error']);
}

if (isset($_SESSION['success'])) {
	$form_result = get_form_success($strings['updated']);
	unset($_SESSION['success']);
}



$response = getCurl(API_URL."getuserphotoname.php", app_headers());

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


$data = $body['success']['user_photo_name'];



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
		<?php $nav_active = 1; include_once'res/php/usersettingsnav.php'; ?>
	</section>
	
	
	<section id="main-section">
		
		<form id="main-form" method="POST" action="" enctype="multipart/form-data">
			
			<?php echo $form_result; ?>
			
			<img id="user-settings-img" src="api/photos/<?=$data;?>" />
			
			<input id="photo-input" type="file" accept="image/*" name="photo" />
			
			<button type="submit" id="main-form-btn" name="update_photo"><?php echo $strings['save']; ?></button>
			
		</form>
		
		<span id="js-text" class="hide"><?=$strings['photo_error'];?></span>
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
	<script type="text/javascript">
		
		var photoInput = _id("photo-input");
		photoInput.addEventListener("change", checkPhoto);
		
		var photoImg = _id("user-settings-img");
		
		function checkPhoto () {
			removeError();
			validatePhoto(this.files[0], showPhoto, errorPhoto);
		}
		
		function removeError () {
			if (photoImg.previousElementSibling) {
				photoImg.parentElement.removeChild(photoImg.previousElementSibling);
			}
		}
		
		function showPhoto () {
			photoImg.src = this.result;
		}
		
		function errorPhoto () {
			var box = _ce("div");
			box.className = "form-error-box";
			box.innerHTML = _id("js-text").innerHTML;
			photoImg.parentElement.insertBefore(box, photoImg);
		}
		
		
	</script>
	
	
</body>

</html>

