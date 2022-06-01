
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






