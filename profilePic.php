<?php
require_once('index.php');

function fileExists(): bool
{
  $file_url = 'https://baptiste-crepin.fr/SupMovies/UserPics/' . $_SESSION['username'];
  $file_headers = @get_headers($file_url);

  if ($file_headers[0] == 'HTTP/1.1 200 OK') {
    return true;
  } else {
    return false;
  }
}


function displayAccount(): void
{
  session_start();
  if (!isset($_SESSION['username'])) {
    echo '<a href="./login.php"><button>Log in</button></a>';
    echo '<a href="./register.php"><button>Register</button></a>';
    return;
  }

  if (!fileExists()) {
    $Img = '<img src="https://baptiste-crepin.fr/SupMovies/UserPics/default/1">';
    echo '<label for="item1">' . $Img . '</label>';
    return;
  }

  echo '<p>' . $_SESSION['username'] . '</p>';
  $Img = '<img src="https://baptiste-crepin.fr/SupMovies/UserPics/' . $_SESSION['username'] . '">';
  echo '<label for="item1">' . $Img . '</label>';
}

displayAccount();
