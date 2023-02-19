  <?php
  function createForm($fileName)
  {
    echo '<form action="' . $fileName . '.php" method="POST">';
    echo '<h2>' . ucfirst($fileName) . '</h2>';
  ?>
    <div class="input">
      <label for="username">Username :</label>
      <input name="username" required>
    </div>
    <div class="input">
      <label for="password">Password :</label>
      <input name="password" type="password" required>
    </div>
  <?php
    echo '<button type="submit">' . ucfirst($fileName) . '</button>';
  }
