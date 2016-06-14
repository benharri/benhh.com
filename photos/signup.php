<?php
$v_page_title = "Sign Up";
require "inc/header.php";
?>



<form method="post" action="action.php?do=register">
<fieldset>
  <legend>Fill out your information.</legend>

  <label for="username">Username</label>
  <input type="text" name="username" id="username" required>

  <label for="password">Password</label>
  <input type="password" name="password" id="password" required>

  <label for="password-reenter">Re-enter your password</label>
  <input type="password" name="password-reenter" id="password-reenter" required>
  <br><br>
  <input type="submit" value="Register">

</fieldset>
</form>


<?php
require "inc/footer.php";
