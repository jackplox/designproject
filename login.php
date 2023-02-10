<!DOCTYPE HTML>
<html>
  <?php
    include_once("header.php");

  ?>
  <head>
    <h1>Log-In</h1>

    <div name="errors">
      <?php
        if($errormessage)
          echo $errormessage;
       ?>
    </div>

  </head>
  <body>
    <form action="login_process.php" method="POST">
      Username:</br>
      <input type="text" name="user" value="<?php echo htmlspecialchars($_POST["user"], ENT_QUOTES);?>"/></br></br>
      Password:</br>
      <input type="password" name="pw" value="<?php echo htmlspecialchars($_POST["pw"], ENT_QUOTES);?>"/></br></br>

      </br><input type="submit" value="Log in">

    <a href="register.php">Create an Account</a>

  </body>

</html>
