<!DOCTYPE html>
<html>
  <head>

    <base href="/" />

    <meta charset="UTF-8" />
    
    <title><?= $code ?> error | School Project Management System</title>
    
    <link rel="stylesheet" type="text/css" href="res/css/main.css" />
    <link rel="stylesheet" type="text/css" href="res/css/error.css" />
    
    <meta name="viewport"  content="width=device-width, initial-scale=1.0" />
    
    <link rel="shortcut icon" href="res/icons/favicon.png" type="image/png" />
    
  </head>

  <body>
    
    <?= $this->fetch('./components/sm-header.php', ['text' => "$code error"]) ?>
    
    <main>
      <div id="main-section">
        <section>
          <?= $message ?> 
        </section>
      </div>
    </main>
    
    <?= $this->fetch('./components/footer.php') ?>
    
  </body>

</html>
