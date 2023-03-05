<?php

require_once('./loginTemplate.php');
require_once('createForm.php');
echo createForm('register');
echo footer('login', 'You already have an account ? Log in!');

function register(): bool
{
  require_once("./validInput.php");
  if (!ValidFields()) {
    return false;
  }

  require_once('database.php');
  if (!insertUser($_POST['username'], $_POST['password'])) {
    return false;
  }

  session_start();
  $_SESSION['username'] = $_POST['username'];

  header('Refresh: 2;URL=./index.php');
  echo "<p>Welcome {$_SESSION['username']}, your account has been created</p>";
  echo "<p>You will now be redirected...</p>";
  return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  register();
}
