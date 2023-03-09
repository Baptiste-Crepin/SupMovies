<?php
function createForm($fileName, $optionalInputs = [])
{
  $CapitalizeFileName = ucfirst($fileName);
  $output = <<<HTML
  <form action=" {$fileName}.php" method="POST">
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
  <button type="submit"> {$CapitalizeFileName} </button>
  </form>
  HTML;
  return $output;
}
