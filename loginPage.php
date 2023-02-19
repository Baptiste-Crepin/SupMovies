<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Baptiste Crepin, Martin Pierrache">
  <title>Login</title>
  <link href="./assets/styles/main.css" media="all" rel="stylesheet" type="text/css">
</head>

<body>
  <?php
  require_once('createForm.php');
  createForm('login')
  ?>

  <a href="./index.php">Go back</a>
</body>

</html>