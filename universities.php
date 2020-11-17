<?php


include_once'res/php/util.php';


$page = getPageStart("page", PAGE_LIMIT);

$response = getCurl(API_URL."getuniversities.php?page_start=".$page."&page_limit=".PAGE_LIMIT);

if (curl_errno($response[0])) {
	urlRedirect("500.html");
}
	
$code = httpCodeCurl($response[0]);

if ($code == 500) {
	urlRedirect("500.html");
}

$body = json_decode($response[1], true);

curl_close($response[0]);


$unies = $body['success']['universities'];

$unies_count = $body['success']['universities_count'];



?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
	
	<title>Universities <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet"  type="text/css" href="res/css/main.css">
	<link rel="stylesheet" type="text/css" href="res/css/university.css">
	<link rel="stylesheet" type="text/css" href="res/css/universitiespage.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>


<body>
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section id="main-section">
		
		<div id="universities-head"><?=$strings['universities_on_project3'];?></div>
		
		
		<?php foreach ($unies AS $uni) : ?>
		<?php include'res/php/university.php'; ?>
		<?php endforeach; ?>
		
		<?php if (empty($unies)) : ?>
		<?= get_no_data_box($strings['no_university']); ?>
		<?php endif; ?>
		
		<?php echo getPagesBox("page", ceil($unies_count/PAGE_LIMIT), "universities.php?page=", null, "", array(
			"next"=> $icons['next'],
			"previous"=> $icons['previous'],
		)); ?>
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
</body>


</html>




