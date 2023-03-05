<?php
function createForm($fileName)
{
  $CapitalizeFileName = ucfirst($fileName);
  return <<<HTML
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
  <button type="submit"> {$CapitalizeFileName} </button>
  </form>
  HTML;
}
