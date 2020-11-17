<?php


include_once'res/php/util.php';


if (!signed_in()) {
	urlRedirect("login.php");
}

if (!isset($_GET['id'])) {
	urlRedirect("400.html");
}


$form_result="";


function pageRedirect () {
	$pg = isset($_GET['page']) ? "&page=".$_GET['page'] : "";
	urlRedirect("project-documents.php?id=".$_GET['id'].$pg);
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['document'])) {
	
	if (empty($_FILES['document']['name'])) {
		$_SESSION['document_error'] = 1;
		pageRedirect();
	}
	
	$d = new CurlFile($_FILES['document']['tmp_name'], 'application/*', $_FILES['document']['name']);
	
	$response = postCurl(API_URL."uploadprojectdocument.php", array("document"=> $d, "project_id"=> $_GET['id']), auth_header());
	
	if (curl_errno($response[0])) {
		$_SESSION['server_error'] = 1;
		pageRedirect();
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		case 400 :
			if (isset($body['error']['document_error'])) {
				$_SESSION['document_error'] = $body['error']['document_error'];
			}
			pageRedirect();
		case 500 :
			$_SESSION['server_error'] = 1;
			pageRedirect();
		default :
			$_SESSION['success'] = 1;
			pageRedirect();
	}
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['approve_document'])) {
	
	$response = postCurl(API_URL."approveprojectdocument.php", json_encode(array("project_document_id"=> $_POST['document_id'])), app_headers());
	
	if (curl_errno($response[0])) {
		urlRedirect("500.html");
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		case 403 :
			urlRedirect("403.html");
		case 404 :
			urlRedirect("404.html");
		case 500 :
			urlRedirect("500.html");
		default :
			pageRedirect();
	}
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['disapprove_document'])) {
	
	$response = postCurl(API_URL."disapproveprojectdocument.php", json_encode(array("project_document_id"=> $_POST['document_id'])), app_headers());
	
	if (curl_errno($response[0])) {
		urlRedirect("500.html");
	}
	
	$code = httpCodeCurl($response[0]);
	
	$body = json_decode($response[1], true);
	
	curl_close($response[0]);
	
	switch ($code) {
		case 403 :
			urlRedirect("403.html");
		case 404 :
			urlRedirect("404.html");
		case 500 :
			urlRedirect("500.html");
		default :
			pageRedirect();
	}
}


if (isset($_SESSION['server_error'])) {
	$form_result = get_form_error($strings['server_error']);
	unset($_SESSION['server_error']);
}

if (isset($_SESSION['document_error'])) {
	$form_result = get_form_error($strings['document_error']);
	unset($_SESSION['document_error']);
}

if (isset($_SESSION['success'])) {
	$form_result = get_form_success($strings['uploaded']);
	unset($_SESSION['success']);
}






$response = getCurl(API_URL."getprojectparticipants.php?id=".$_GET['id'], app_headers());

if (curl_errno($response[0])) {
	urlRedirect("500.html");
}

$code = httpCodeCurl($response[0]);

$body = json_decode($response[1], true);

curl_close($response[0]);


switch ($code) {
	case 404 :
		urlRedirect("404.html");
	case 403 :
		urlRedirect("403.html");
	case 500 :
		urlRedirect("500.html");
}


$participants = [
	"student_id"=> $body['success']['student_id'], 
	"supervisor_id"=> $body['success']['supervisor_id']
];



$page = getPageStart("page", PAGE_LIMIT);

$response = getCurl(API_URL."getprojectdocuments.php?id=".$_GET['id']."&page_start=".$page."&page_limit=".PAGE_LIMIT, app_headers());

$code = httpCodeCurl($response[0]);
	
$body = json_decode($response[1], true);
	
curl_close($response[0]);


switch ($code) {
	case 403 :
		 urlRedirect("403.html");
	case 404 :
		 urlRedirect("404.html");
	case 500 :
		urlRedirect("500.html");
}

$topic = $body['success']['project_topic'];

$documents = $body['success']['project_documents'];

$documents_count = $body['success']['project_documents_count'];






?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Project Documents <?=$strings['website_title_note'];?></title>
	
	<link rel="stylesheet" type="text/css" href="res/css/main.css">
	<link rel="stylesheet" type="text/css" href="res/css/projectpage.css">
	<link rel="stylesheet" type="text/css" href="res/css/projectdocumentspage.css?77">
	
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="res/icons/favicon.png" type="image/png">
	
</head>


<body>
	
	<?php include_once'res/php/header.php'; ?>
	
	
	<section id="sub-section">
		
		<div id="project-page-topic">
			<?= $icons['project']; ?><h1><?=$topic;?></h1>
		</div>
		
		<?php $nav_active = 2; include_once'res/php/projectnav.php'; ?>
		
	</section>
	
	<section id="main-section">
		
		<?php if (user_id() == $participants['student_id']) : ?>
		<form id="main-form" method="POST" action="" enctype="multipart/form-data">
			
			<?php echo $form_result; ?>
			
			<span id="document-input-label" class="input-span"><?=$strings['upload_document'];?></span>
			
			<input id="document-input" type="file" accept="application/*" name="document" /><button type="submit" id="upload-btn">
				<?=$strings['upload'];?>
			</button>
			
		</form>
		<?php endif; ?>
		
		<table id="documents-table">
			<?php foreach ($documents as $doc) : ?>
			<tr>
				<td class="document-icon"><?php
					$ext = explode(".", $doc['name']);
					switch (strtolower(end($ext))) {
						case "pdf" :
							echo $icons['pdf_document'];
							break;
						case "doc" :
						case "docx" :
							echo $icons['word_document'];
							break;
						default : 
							echo $icons['document'];
					}
					
				?></td>
				
				<td class="document-name"><?=$doc['name'];?></td>
				<td class="document-date"><?=makeDate($doc['upload_date']);?></td>
				<td class="document-actions">
					<a class="document-download-link" href="download-document.php?id=<?=$doc['id'];?>"><?=$icons['download'];?></a>
					<?php if (user_id() == $participants['supervisor_id']) : ?>
					<form method="POST" action="" class="document-form">
						<input name="document_id" value="<?=$doc['id'];?>" class="hide"  />
						<?php if ($doc['approved'] == 1) : ?>
						<button name="disapprove_document" class="disapprove"><?=$icons['disapprove'];?></button>
						<?php else : ?>
						<button name="approve_document" class="approve"><?=$icons['approve'];?></button>
						<?php endif; ?>
					</form>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
			
			<?php if (empty($documents)) : ?>
			<tr><?=get_no_data_box($strings['no_document']); ?></tr>
			<?php endif; ?>
			
		</table>
		
		<?php echo getPagesBox("page", ceil($documents_count/PAGE_LIMIT), "project-documents.php?id=".$_GET['id']."&page=", null, "#entity-nav", array(
			"next"=> $icons['next'],
			"previous"=> $icons['previous'],
		)); ?>
		
		
	</section>
	
	
	<?php include_once'res/php/footer.php'; ?>
	
	
	
</body>


</html>


