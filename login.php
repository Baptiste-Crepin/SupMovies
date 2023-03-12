<?php

require_once('./loginTemplate.php');
require_once('createForm.php');
echo createForm('login');
echo footer('register', 'Create your SupMovies account');

function login(): void
{
  require_once("./validInput.php");
  if (!ValidFields()) return;
  if (!verifyCaptcha()) return;

  $_SESSION['counter']++;
  require_once('./database.php');
  if (!userPassword($_POST['username'], $_POST['password'])) return;

  $_SESSION['counter'] = 0;
  $_SESSION['username'] = $_POST['username'];

  header('Refresh: 1;URL=./index.php');
  echo <<<HTML
  <div class='success'>
  <h3>Welcome {$_SESSION['username']}</h3>
  <p>You will now be redirected...</p>
  </div>
  HTML;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $maxAttempts = 5;
  // anti brute force
  // echo $_SESSION['counter'];
  if ($_SESSION['counter'] > $maxAttempts) {
    die("<p class='error'>Too many login attempts. Please try again later.</p>");
  }
  if ($maxAttempts - $_SESSION['counter'] <= 3) {
    echo "<p class='countdown'>" . $maxAttempts - $_SESSION['counter'] . " more attempts</p>";
  }

  login();
}
