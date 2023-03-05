<?php

require_once('./header.php');

function validType(string $fileType): bool
{
  $validTypes = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
  if (!in_array($fileType, $validTypes)) {
    echo "Please select a JPG / JPEG / PNG or gif file";
    return false;
  }
  return true;
}

function ftpLogin(string $ftpServer, string $ftpUsername, string $ftpPassword): bool | object
{
  try {
    $ftpConnection = ftp_connect($ftpServer);
  } catch (\Exception $e) {
    die($e->getMessage());
    return false;
  }

  ftp_login($ftpConnection, $ftpUsername, $ftpPassword);
  return $ftpConnection;
}


function addImg(): bool
{
  if (!isset($_FILES['file'])) {
    return false;
  }

  require_once('credentials.php');
  //TODO: set account name as file name
  $fileName = $_SESSION['username'];
  $fileTmp = $_FILES['file']['tmp_name'];
  $fileType = $_FILES['file']['type'];

  if (!validType($fileType)) {
    return false;
  }

  $ftpConnection = ftpLogin($ftpServer, $ftpUsername, $ftpPassword);
  if (!$ftpConnection) {
    echo "Error connecting to the ftp server";
    return false;
  }

  if (!ftp_put($ftpConnection, $ftpDir . $fileName, $fileTmp)) {
    echo "Error whilst uploading file";
    return false;
  }

  ftp_close($ftpConnection);

  $redirectURL = 'https://baptiste-crepin.fr/SupMovies/UserPics/' . $fileName;
  echo '<H2>File uploaded successfully</H2>';
  echo '<a href="' . $redirectURL . '"><img draggable="false" src="https://baptiste-crepin.fr/SupMovies/UserPics/' . $fileName . '"></a>';


  header('Refresh: 5;URL=./index.php');
  echo "<p>Account created </p>";
  echo "<p>You will now be redirected...</p>";
  return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  addImg();
}


require_once('./upload.html');
