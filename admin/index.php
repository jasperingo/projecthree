<?php


include_once'../res/php/util.php';



function pageRedirect () {
	urlRedirect("index.php");
}



$name_value="";
$acronym_value="";

$name_error="";
$acronym_error="";
$form_result="";


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])) {
	
	if (empty($_POST['name']) || empty($_POST['acronym'])) {
		$_SESSION['input_errors'] = 1;
		$_SESSION['input_values'] = [
			"name"=> $_POST['name'],
			"acronym"=> $_POST['acronym'],
		];
		pageRedirect();
	}
	
	
	$_SESSION['departments'][] = [
		"name"=> $_POST['name'],
		"acronym"=> $_POST['acronym'],
	];
	$_SESSION['success'] = 1;
	pageRedirect();
	
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['remove'])) {
	array_splice($_SESSION['departments'], (int)$_POST['index'], 1);
	if (empty($_SESSION['departments'])) {
		unset($_SESSION['departments']);
	}
	pageRedirect();
}


if (isset($_SESSION['input_values'])) {
	$name_value = $_SESSION['input_values']['name'];
	$acronym_value = $_SESSION['input_values']['acronym'];
	unset($_SESSION['input_values']);
}

if (isset($_SESSION['input_errors'])) {
	$form_result = get_form_error("Fill input properly");
	unset($_SESSION['input_errors']);
}

if (isset($_SESSION['success'])) {
	$form_result = get_form_success("Added");
	unset($_SESSION['success']);
}



$header = "Admin Panel";


?>

<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	
	<title>Project3 Admin Panel</title>
	
	<link rel="stylesheet"  type="text/css" href="../res/css/main.css">
	<link rel="stylesheet"  type="text/css" href="../res/css/admin.css">
	
	<meta name="viewport"  content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../res/icons/favicon.png" type="image/png">
	
</head>

<body>
	
	<?php include_once'../res/php/admin-header.php'; ?>
	
	
	<section class="main-section">
		
		<nav id="three">
			<a href="university-add.php">
				Add with university
			</a><a href="university-department-add.php">
				Add to university
			</a><a href="university-department-remove.php">
				Remove from university
			</a>
		</nav>
		
		
		<form id="main-form" method="POST" action="" novalidate="novalidate">
			
			<?php echo $form_result; ?>
			
			<div class="input-box">
				<span class="input-span"><?=$strings['department_name'];?></span>
				<?=$name_error;?>
				<input class="main-input" type="text" name="name" value="<?=$name_value;?>" />
			</div>
		
			<div class="input-box">
				<span class="input-span"><?=$strings['department_acronym'];?></span>
				<?=$acronym_error;?>
				<input class="main-input" type="text" name="acronym" value="<?=$acronym_value;?>" />
			</div>
		
			<button type="submit" id="main-form-btn" name="add"><?=$strings['add'];?></button>
		
		</form>
		
		
		
		<?php if (isset($_SESSION['departments']) || !empty($_SESSION['departments'])) : ?>
		
		<?php foreach ($_SESSION['departments'] as $i=> $dept) : ?>
		
		<?php include'../res/php/admin-department.php'; ?>
		
		<?php endforeach; ?>
		
		<?php endif; ?>
		
	
	</section>
	
	
	
</body>

</html>




