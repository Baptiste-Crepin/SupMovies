<?php

require_once('./loginTemplate.php');
require_once('createForm.php');
$optionalInputs = ['email'];
echo createForm('register', $optionalInputs);
echo footer('login', 'You already have an account ? Log in!');

function register(): void
{
  require_once("./validInput.php");
  if (!ValidFields()) return;
  if (!verifyCaptcha()) return;

  require_once('database.php');
  if (!insertUser($_POST['username'], $_POST['password'])) return;

  #optional inputs
  updateEmail($_POST['username'], $_POST['email']);

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
