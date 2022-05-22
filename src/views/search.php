<?php


include_once'res/php/util.php';



if (isset($_GET['q'])) {
	
	if ($_GET['q'] == "") {
		urlRedirect("search.php");
	}
	
	$page = getPageStart("page", PAGE_LIMIT);
	
	$response = getCurl(API_URL."getprojectssearch.php?q=".$_GET['q']."&page_start=".$page."&page_limit=".PAGE_LIMIT, app_headers());
	
	if (curl_errno($response[0])) {
		urlRedirect("500.html");
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		case 400 :
			urlRedirect("400.html");
		case 500 :
			urlRedirect("500.html");
	}
	
	$projects = $body['success']['projects'];
	
	$projects_count = $body['success']['projects_count'];
	
}


?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Search <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet"  type="text/css" href="res/css/main.css">
	<link rel="stylesheet" type="text/css" href="res/css/project.css">
	<link rel="stylesheet" type="text/css" href="res/css/searchpage.css?7">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>


<body>
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section id="main-section">
		
		<form id="search-page-form" method="GET" action="search.php">
			<input type="text" id="search-page-input" name="q" value="<?=isset($_GET['q'])?$_GET['q']:"";?>"  /><button type="submit" id="search-page-btn">
				<?=$icons['search'];?>
			</button>
		</form>
		
		<?php if (!isset($_GET['q'])) : ?>
		
		<?=get_no_data_box($strings['search_project3']); ?>
		
		<?php else : ?>
		
		<div id="result-count"><?=$projects_count." ".$strings['results_found'];?></div>
		
		<?php foreach ($projects AS $pj) : ?>
		<?php include'res/php/project.php'; ?>
		<?php endforeach; ?>
		
		<?php if (empty($projects)) : ?>
		<?=get_no_data_box($strings['no_result_found']); ?>
		<?php endif; ?>
		
		<?php echo getPagesBox("page", ceil($projects_count/PAGE_LIMIT), "search.php?q=".$_GET['q']."&page=", null, "", array(
			"next"=> $icons['next'],
			"previous"=> $icons['previous'],
		)); ?>
		
		<?php endif; ?>
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
</body>


</html>






