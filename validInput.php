<?php

function isValidPass(string $str): bool
{
  if (strlen($str) < 8) {
    echo "<p>Your password must be at least 8 characters long</p>";
    return false;
  }

  if (!preg_match('/\d/', $str)) {
    echo "<p>Your password must contain numbers 0-9</p>";
    return false;
  }

  if (!preg_match('/[A-Z]/', $str)) {
    echo "<p>Your password must contain uppercase letters A-Z</p>";
    return false;
  }

  if (!preg_match('/[a-z]/', $str)) {
    echo "<p>Your password must contain lowercase letters a-z</p>";
    return false;
  }

  return true;
}

function validInput(string $input): bool
{
  if (!isset($input) || empty($input)) {
    echo "<p>You must answer all the inputs correctly</p>";
    return false;
  }

  return True;
}

function ValidFields(): bool
{
  if (!validInput($_POST['username']) || !validInput($_POST['password'])) {
    return false;
    echo "<p>not valid</p>";
  }
  if (!isValidPass($_POST['password'])) {
    return false;
  }

  return true;
}
