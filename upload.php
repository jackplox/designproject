<!DOCTYPE HTML>
<html>
<?php
  include_once("header.php");
  
  if(!$_SESSION["userid"]){
    header("Location: login.php");
  }
 ?>
 <head>
   <title>
     Upload an image
   </title>
   <h1>
     Create an image post
   </h1>
 </head>

 <body>
   <form action="upload_process.php" method="POST" enctype="multipart/form-data">
     <input type="file" name="uploadImage" id="uploadImage">
     <input type="text" name="caption" id="caption" value="Enter a caption...">
     <input type="submit" value="Post Image" name="submit">
   </form>
 </body>

</html>
