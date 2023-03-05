<?php

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

function getUsername(): string|null
{
  session_start();
  if (!isset($_SESSION['username']) or empty($_SESSION['username'])) {
    return null;
  }
  return $_SESSION['username'];
}

function displayAccount(): string
{

  $user = getUsername();
  if (!$user) {
    return <<<HTML
    <div id="account">
    <a href="./login.php"><button>Log in</button></a>
    </div>
    HTML;
  }

  if (fileExists()) {
    $Img = "https://baptiste-crepin.fr/SupMovies/UserPics/ {$_SESSION['username']}";
  } else {
    $Img = "https://baptiste-crepin.fr/SupMovies/UserPics/default/1";
  }


  return <<<HTML
  <div id="account">
    <p> {$_SESSION['username']} </p>
    <img class="profilePic" draggable="false" src="{$Img}" >
    
    <div class="buttons">
      <a href="./cart.php"><img class="icons orange" draggable="false" src="./assets/icons/cart-shopping-solid.svg"></a>
      <input type="checkbox" id="profilePic" name="menu" class="dropdown">
      <label for="profilePic">
        <img class="icons white" id="bars" draggable="false" src="./assets/icons/bars-solid.svg">
        <img class="icons white" id="cross" src="./assets/icons/xmark-solid.svg">
      </label>
    
      <ul class="dropdown">
        <li class="dropdown-content"><a href="./upload.php">Settings</a></li>
        <li class="dropdown-content"><a href="./cart.php">Cart</a></li>
        <li class="dropdown-content"><a href="./logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
  HTML;
}
