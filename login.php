<?php

require_once('./loginTemplate.php');
require_once('createForm.php');
echo createForm('login');
echo footer('register', 'Create your SupMovies account');

function login(): bool
{
  require_once("./validInput.php");
  if (!ValidFields()) {
    return false;
  }

  require_once('./database.php');
  if (!userPassword($_POST['username'], $_POST['password'])) {
    return false;
  }

  session_start();
  $_SESSION['username'] = $_POST['username'];

  header('Refresh: 1;URL=./index.php');
  echo "<p>Welcome {$_SESSION['username']}</p>";
  echo "<p>You will now be redirected...</p>";
  return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  login();
}
