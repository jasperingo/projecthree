<!DOCTYPE html>
<html>
  <head>
    
    <meta charset="UTF-8" />
    
    <title><?= $__($title) ?> | School Project Management System</title>
    
    <link rel="stylesheet" type="text/css" href="res/css/main.css" />
    <link rel="stylesheet" type="text/css" href="res/css/about.css" />
    
    <meta name="viewport"  content="width=device-width, initial-scale=1.0" />
    
    <link rel="shortcut icon" href="res/icons/favicon.png" type="image/png" />
    
  </head>

  <body>

    <?= $this->fetch('./components/sm-header.php', ['text' => $__('app_name')]) ?>
    
    <main id="main-section"><?= $content ?></main>
    
    <?= $this->fetch('./components/footer.php') ?>

  </body>

</html>
