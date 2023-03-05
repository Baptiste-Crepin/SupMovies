<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Baptiste Crepin, Martin Pierrache">
  <title>Login</title>
  <link href="./assets/styles/form.css" media="all" rel="stylesheet" type="text/css">
</head>

<body>




  <?php

  function Footer($link, $message): string
  {
    return <<<HTML
        <div class="redirect">
          <a href="./{$link}.php"><button>{$message}</button></a>
          <a href="./index.php"><button>Go back</button></a>
        </div>
      </body>
    </html>
    HTML;
  }

  ?>