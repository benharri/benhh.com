<?php

$v_page_title = "Log In";
require "inc/header.php";

?>

<form action="login_check.php" method="post">
  <fieldset>
  <legend>Login</legend>
    <label for="username">Username: </label>
    <input name="username" id="username" type="text" required />
    <label for="password">Password: </label>
    <input name="password" id="password" type="password" required /><br><br>
    <input type="submit" value="Log In" /><br><br>
  <a href="signup.php">Sign up for an account</a>
  </fieldset>
</form>


<?php
// echo '<pre>'; print_r(get_defined_vars()); echo '</pre>';
require "inc/footer.php";