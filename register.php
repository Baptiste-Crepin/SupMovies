<?php

require_once("./registerPage.php");
session_start();

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

  $_SESSION['username'] = $_POST['username'];

  header('Refresh: 2;URL=./index.php');
  echo "<p>Account created </p>";
  echo "<p>You will now be redirected...</p>";
  return true;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  register();
}
