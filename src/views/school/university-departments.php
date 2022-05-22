<?php


include_once'res/php/util.php';


if (!isset($_GET['id'])) {
	urlRedirect("400.html");
}


$response = getCurl(API_URL."getuniversity.php?id=".$_GET['id'], app_headers());

if (curl_errno($response[0])) {
	urlRedirect("500.html");
}
	
$code = httpCodeCurl($response[0]);

$body = json_decode($response[1], true);

curl_close($response[0]);

switch ($code) {
	
	case 404 :
		urlRedirect("404.html");
		
	case 500 :
		urlRedirect("500.html");
}


$data = $body['success']['university'];



$page = getPageStart("page", PAGE_LIMIT);

$response = getCurl(API_URL."getuniversitydepartments.php?id=".$_GET['id']."&page_start=".$page."&page_limit=".PAGE_LIMIT, app_headers());

if (curl_errno($response[0])) {
	urlRedirect("500.html");
}

$code = httpCodeCurl($response[0]);
	
$body = json_decode($response[1], true);
	
curl_close($response[0]);

switch ($code) {
	
	case 404 :
		urlRedirect("404.html");
		
	case 500 :
		urlRedirect("500.html");
}


$departments = $body['success']['university_departments'];

$departments_count = $body['success']['university_departments_count'];



?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
	
	<title>University <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet"  type="text/css" href="res/css/main.css">
	<link rel="stylesheet" type="text/css" href="res/css/university.css">
	<link rel="stylesheet" type="text/css" href="res/css/universitypage.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>


<body>
	
	<?php include_once'res/php/header.php'; ?>
	
	<section id="sub-section">
		
		<?=$icons['university'];?>
		
		<div id="university-page-name"><?=$data['name'];?></div>
		
		<div id="university-page-acronym"><?=$data['acronym'];?></div>
		
		<div id="university-page-description"><?=lineBreakString($data['description']);?></div>
		
		<div id="university-page-address"><?=$data['address'];?></div>
		
	</section>
	
	
	<section id="main-section">
		
		<?php 
		$p_active = "";
		$d_active = "active";
		include_once'res/php/universitynav.php'; 
		?>
		
		<?php foreach ($departments AS $dept) : ?>
		<div class="university-box">
			<?= $icons['department']; ?><a>
				<div class="university-box-name"><?=$dept['name'];?></div>
				<div class="university-box-acronym"><?=$dept['acronym'];?></div>
			</a>
		</div>
		<?php endforeach; ?>
		
		<?php if (empty($departments)) : ?>
		<?= get_no_data_box($strings['no_department']); ?>
		<?php endif; ?>
		
		<?php echo getPagesBox("page", ceil($departments_count/PAGE_LIMIT), "university-departments.php?id=".$_GET['id']."&page=", null, "#entity-nav", array(
			"next"=> $icons['next'],
			"previous"=> $icons['previous'],
		)); ?>
		
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
</body>


</html>



