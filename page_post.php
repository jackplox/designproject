<!DOCTYPE HTML>
<html>
<?php
  include_once("header.php");


  if(!$_SESSION["userid"]){
    header("Location: login.php");
  }
 ?>
<head>
  <h3>
    Share with
    <?php
      $res = mysqli_query($connection, "select * from pages where id = " . $_GET["id"]);
      $row = mysqli_fetch_assoc($res);

      echo $row["title"];
    ?>
  </h3>
</head>
<body>
  <h4>
    Post text
  </h4>
  <form action="page_post_process.php?type=1&id=<?php echo $_GET["id"]; ?>" method="POST">
    <input type="text" id="textpost" name="textpost" value="What's on your mind?">
    <input type="submit" value="Post">
  </form>
<h4>
  Post an image
</h4>
  <form action="page_post_process.php?type=2&id=<?php echo $_GET["id"]; ?>" method="POST" enctype="multipart/form-data">
    <input type="file" name="uploadImage" id="uploadImage">
    <input type="text" name="caption" id="caption" value="Enter a caption...">
    <input type="submit" value="Post Image" name="submit">
  </form>
</body>
</html>
