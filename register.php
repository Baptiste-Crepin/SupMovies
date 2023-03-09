<?php

require_once('./loginTemplate.php');
require_once('createForm.php');
echo createForm('register');
echo footer('login', 'You already have an account ? Log in!');

function register(): void
{
  require_once("./validInput.php");
  if (!ValidFields()) return;

  require_once('database.php');
  if (!insertUser($_POST['username'], $_POST['password'])) return;

  session_start();
  $_SESSION['username'] = $_POST['username'];

  header('Refresh: 2;URL=./index.php');
  echo <<<HTML
  <div class='success'>
  <h3>Welcome {$_SESSION['username']}, your account has been created</h3>
  <p>You will now be redirected...</p>
  </div>
  HTML;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  register();
}
