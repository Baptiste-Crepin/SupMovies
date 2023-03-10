<!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
  function onSubmit() {
    document.getElementById("form").submit();
  }
</script>


<?php
function createForm($fileName, $optionalInputs = [])
{
  session_start();
  if (!isset($_SESSION['counter'])) {
    // If not, set it to zero
    $_SESSION['counter'] = 0;
  }
  include("./credentials.php");
  $CapitalizeFileName = ucfirst($fileName);
  $output = <<<HTML
  <form action=" {$fileName}.php" id='form' method="POST">
  <h2> {$CapitalizeFileName} </h2>
  <div class="input">
    <label for="username">Username :</label>
    <input name="username" required>
  </div>
  <div class="input">
    <label for="password">Password :</label>
    <input name="password" type="password" required>
  </div>
  HTML;

  foreach ($optionalInputs as $option) {
    $output .= <<<HTML
    <div class="input">
      <label for="{$option}"> {$option} :</label>
      <input name="{$option}">
    </div>
    HTML;
  }

  $output .= <<<HTML
  <button class="g-recaptcha" 
        data-sitekey="{$capchaAPIKey}" 
        data-callback='onSubmit' 
        data-action='submit'>{$CapitalizeFileName}</button>
  </form>
  HTML;
  return $output;
}

function verifyCaptcha()
{
  include('./credentials.php');
  $recaptcha_secret = $capchaAPISecretKey;
  $recaptcha_response = $_POST['g-recaptcha-response'];
  $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';

  $recaptcha_data = array(
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response,
    'remoteip' => $_SERVER['REMOTE_ADDR']
  );

  $recaptcha_options = array(
    'http' => array(
      'method' => 'POST',
      'content' => http_build_query($recaptcha_data),
      'header' => 'Content-Type: application/x-www-form-urlencoded'
    )
  );

  $recaptcha_context = stream_context_create($recaptcha_options);
  $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
  $recaptcha_result = json_decode($recaptcha_result, true);

  return $recaptcha_result['success'];
}
