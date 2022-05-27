<!DOCTYPE html>
<html>
	<head>
		<base href="/" />
		
		<meta charset="UTF-8" />
		
		<title><?= $__($title) ?> <?= $__('website_title_note') ?></title>
		
		<link rel="stylesheet" type="text/css" href="res/css/main.css" />
		<link rel="stylesheet" type="text/css" href="res/css/menu.css" />
		<link rel="stylesheet" type="text/css" href="res/css/index.css" />
		<link rel="stylesheet" type="text/css" href="res/css/project.css" />
		<link rel="stylesheet"  type="text/css" href="res/css/userpage.css">
		<link rel="stylesheet" type="text/css" href="res/css/university.css" />
		
		<meta name="viewport"  content="width=device-width, initial-scale=1.0" />
		
		<link rel="shortcut icon" href="res/images/favicon.png" type="image/png" />
		
	</head>

	<body>
		
		<?= $this->fetch('./components/header.php') ?>
		
		<main><?= $content ?></main>
		
		<?= $this->fetch('./components/footer.php') ?>
		
	</body>

</html>
