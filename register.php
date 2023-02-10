<!DOCTYPE HTML>
<html>
<?php
  include_once("header.php");

  if($_SESSION["userid"]){
    header("Location: profile.php?id=" . $_SESSION["userid"]);
  }
 ?>

  <head>
    <h1>Create an Account</h1>

    <div id="errors">
      <?php
        echo $errormessage;
      ?>
    </div>
  </head>
  <body>
    <form action="register_process.php" method="POST">
      Username:</br>
      <input type="text" name="user" value="<?php echo htmlspecialchars($_POST["user"], ENT_QUOTES);?>"/></br></br>
      Email:</br>
      <input type="email" name="email" value="<?php echo htmlspecialchars($_POST["email"], ENT_QUOTES);?>"/></br></br>
      Password:</br>
      <input type="password" name="pw" value="<?php echo htmlspecialchars($_POST["pw"], ENT_QUOTES);?>"/></br></br>
      Re-Enter Password:</br>
      <input type="password" name="pw2"/></br></br>
      What would you like to be called?</br>
      <input type="text" name="name" value="<?php echo htmlspecialchars($_POST["name"], ENT_QUOTES);?>"/></br></br>

      </br><input type="submit" value="Create account"/>
    </form>
  </body>
</html>
