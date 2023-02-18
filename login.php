<?php
require_once("./login.html");
require_once("./validInput.php");


function login(): bool
{
  if (!ValidFields()) {
    return false;
  }

  require_once('./database.php');

  if (!userPassword($_POST['username'], $_POST['password'])) {
    return false;
  }
  userPassword($_POST['username'], $_POST['password']);

  header('Refresh: 2;URL=./index.php');
  echo "<p>logged in</p>";
  echo "<p>You will now be redirected...</p>";
  return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  login();
}
