<?php
require_once("./signup.html");

require_once("./validInput.php");


function register(): bool
{
  if (!ValidFields()) {
    return false;
  }

  require_once('database.php');

  insertUser($_POST['username'], $_POST['password']);

  header('Refresh: 2;URL=./index.php');
  echo "<p>Account created </p>";
  echo "<p>You will now be redirected...</p>";
  return true;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  register();
}
