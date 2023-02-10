<!DOCTYPE HTML>
<html>
<?php

  include_once("header.php");

  if(!$_SESSION["userid"]){
    header("Location: login.php");
  }
 ?>

 <title>
   Create a Page!
 </title>

 <head>
   <h1>
     Start a community!
   </h1>
 </head>

<?php
  echo $errormessage;
 ?>

 <body>
   <form action="create_page_process.php" method="POST">
     <input type="text" id="title" name="title" value="Title"></br>
     <input type="text" id="desc" name="desc" value="Description"></br></br>
     <input type="checkbox" id="images" name="images" value="1">
     <label for="images">Allow images?</label></br></br>
     <input type="submit" value="Create community!">
   </form>
 </body>
</html>
