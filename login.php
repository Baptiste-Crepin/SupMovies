<?php

require_once('./loginTemplate.php');
require_once('createForm.php');
echo createForm('login');
echo footer('register', 'Create your SupMovies account');

function login(): void
{
  require_once("./validInput.php");
  if (!ValidFields()) return;

  require_once('./database.php');
  if (!userPassword($_POST['username'], $_POST['password'])) return;

  session_start();
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
  login();
}
