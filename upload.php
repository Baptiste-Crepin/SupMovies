<!DOCTYPE html>
<link href="./assets/styles/main.css" media="all" rel="stylesheet" type="text/css">
<link href="./assets/styles/upload.css" media="all" rel="stylesheet" type="text/css">

<?php

require_once('./header.php');

function validType(string $fileType): bool
{
  $validTypes = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
  if (!in_array($fileType, $validTypes)) {
    echo "Please select a JPG / JPEG / PNG or GIF file";
    return false;
  }
  return true;
}

function ftpLogin(string $ftpServer, string $ftpUsername, string $ftpPassword)
{
  try {
    $ftpConnection = ftp_connect($ftpServer, timeout: 1000);
    if ($ftpConnection === false) {
      throw new Exception('Failed to connect to FTP server');
    }

    $loginSuccess = ftp_login($ftpConnection, $ftpUsername, $ftpPassword);
    if ($loginSuccess === false) {
      throw new Exception('Failed to authenticate user on FTP server');
    }

    return $ftpConnection;
  } catch (Exception $e) {
    die($e->getMessage());
  }
}

function addImg(): void
{
  if (!isset($_FILES['file']) || $_FILES['file']['size'] == 0) {
    throw new Exception("Please select a file");
  }

  require_once('credentials.php');

  $fileName = $_SESSION['username'];
  $fileTmp = $_FILES['file']['tmp_name'];
  $fileType = $_FILES['file']['type'];

  if (!validType($fileType)) {
    throw new Exception();
  }

  $ftpConnection = ftpLogin($ftpServer, $ftpUsername, $ftpPassword);

  if (!$ftpConnection) {
    throw new Exception("Error connecting to the ftp server");
  }

  if (!ftp_put($ftpConnection, $ftpDir . $fileName, $fileTmp)) {
    throw new Exception("Error whilst uploading file");
  }

  ftp_close($ftpConnection);

  echo <<<HTML
    <H2>File uploaded successfully</H2>
    <p>You will now be redirected...</p>
  HTML;
}

function inputEmail()
{
  require_once('database.php');
  if (!isset($_POST['email']) || $_POST['email'] == '') {
    throw new Exception("Please enter an email");
  }
  updateEmail($_SESSION['username'], $_POST['email']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $maxErrors = 2;
  $errorLogs = [];
  try {
    addImg();
  } catch (Exception $e) {
    $errorLogs[] = $e->getMessage();
  }
  try {
    inputEmail();
  } catch (Exception $e) {
    $errorLogs[] = $e->getMessage();
  }
  if (count($errorLogs) == $maxErrors) {
    foreach ($errorLogs as $error) {
      echo "<p class='error'>" . $error . "</p>";
    }
  } else {
    header('Refresh: 1;URL=./index.php');
  }
}
?>

<body>
  <main>
    <h2>Upload a profile picture</h2>
    <img class="currentProfilePic" src="<?php echo getProfilePic() ?>?v=<?php echo time() ?>">

    <form action="upload.php" method="POST" enctype="multipart/form-data">
      <div>
        <label for="file" id="file-label">Select a file:</label>
        <input type="file" name="file" id="file" onchange="previewFile()">
      </div>
      <div>
        <label for="email" id="email-label">Change your email</label>
        <input type="email" name="email" id="email">
      </div>
      <input type="submit" name="submit" value="Upload">
      <div id="loading" style="display: none;">Uploading...</div>
    </form>
  </main>
</body>

</html>


<script>
  function previewFile() {
    const PROFILE_PIC_PREVIEW = document.getElementsByClassName('currentProfilePic')[0];
    const FILE_INPUT = document.getElementById('file');
    const FILE = FILE_INPUT.files[0];
    const READER = new FileReader();

    READER.onloadend = function() {
      PROFILE_PIC_PREVIEW.src = READER.result;
    }

    if (FILE) {
      READER.readAsDataURL(FILE);
    } else {
      PROFILE_PIC_PREVIEW.src = "<?php echo getProfilePic() ?>";
    }
  }
</script>