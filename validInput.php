<?php

function isValidPass(string $str): bool
{
  $failedCases = [];

  if (strlen($str) < 8) {
    $failedCases[] = "be at least 8 characters long";
  }

  if (!preg_match('/\d/', $str)) {
    $failedCases[] = "contain numbers 0-9";
  }

  if (!preg_match('/[A-Z]/', $str)) {
    $failedCases[] = "contain uppercase letters A-Z";
  }

  if (!preg_match('/[a-z]/', $str)) {
    $failedCases[] = "contain lowercase letters a-z";
  }

  if (!empty($failedCases)) {
    echo "<div class='error'>
          <h3>Your password must</h3>";
    foreach ($failedCases as $case) {
      echo "<p>$case</p>";
    }
    echo "</div>";
    return false;
  }

  return true;
}


function validInput(string $input): bool
{
  if (!isset($input) || empty($input)) {
    echo "<p class='error'>You must answer all the inputs correctly</p>";
    return false;
  }

  return True;
}

function ValidFields(): bool
{
  if (!validInput($_POST['username']) || !validInput($_POST['password'])) {
    echo "<p class='error'>not valid</p>";
    return false;
  }
  if (!isValidPass($_POST['password'])) {
    return false;
  }

  return true;
}
