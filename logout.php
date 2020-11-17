<?php


include_once'res/php/util.php';


if (!signed_in()) {
	header("Location: login.php");
	exit;
}


if (isset($_GET['yes'])) {
	
	$response = postCurl(API_URL."signout.php", null, app_headers());
	
	if (curl_errno($response[0])) {
		header("Location: 500.html");
		exit;
	}
	
	$code = httpCodeCurl($response[0]);
	
	curl_close($response[0]);
	
	switch ($code) {
		case 500 :
			header("Location: 500.html");
			exit;
		default :
			burn_cookie();
			header("Location: index.php");
			exit;
	}

}



?>


<!DOCTYPE html>
<html>
<head>

	<meta charset="UTF-8">
	
	<title>Log out <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet"  type="text/css" href="res/css/main.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.jpg" type="image/png">
	
	<style type="text/css">
		
		body {
			background-color:#FFC0CB;
		}
		
		#box {
			width:80%;
			text-align:center;
			margin:100px auto;
			border-radius:5px;
			background-color:#FFFFFF;
		}
		
		#top {
			padding:20px;
		}
		
		#bottom {
			padding:10px;
			
		}
		
		#bottom > a {
			width:45%;
			padding:10px;
			color:#FFFFFF;
			border-radius:5px;
			display:inline-block;
			background-color:#DC143C;
		}
		
		#bottom > a:active {
			background-color:#DCDCDC;
		}


		@media only screen and (min-width:600px) {

			#box {
				width:70%;
			}
		}


		@media only screen and (min-width:768px) {

			#box {
				width:60%;
			}
			
		}



		@media only screen and (min-width:992px) {

			#box {
				width:50%;
			}

		}


		@media only screen and (min-width:1200px) {

			
			#box {
				width:40%;
			}
		}

		
		
	</style>
	
</head>

<body>
	
	
	<div id="box">
		<div id="top"><?=$strings['logout_confirm_note'];?></div>
		<div id="bottom">
			<a href="?yes=1" ><?=$strings['yes'];?></a>
			<a href="<?=$_SERVER['HTTP_REFERER'];?>" ><?=$strings['no'];?></a>
		</div>
	</div>
	
	
</body>

</html>










