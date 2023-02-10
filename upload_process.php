<?php


  include("header.php");
  $res = mysqli_query($connection, "select * from users where id = " . $_SESSION["userid"]);

  $row = mysqli_fetch_assoc($res);

  $target_dir = "./users/" . $_SESSION["userid"] . "/";

  if(!is_dir($target_dir)){
    if(mkdir($target_dir, 0777)){
      //echo "Success";
    }
    else{
      $errormessage .= "Failure to create path to image posts. If you're seeing this, something went terribly wrong.";
      include("upload.php");
      die();
    }
  }

  $target_file = $target_dir . basename($_FILES["uploadImage"]["name"]);

  $uploadOk = 1;

  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  $errormessage = "";

  if(isset($_POST["submit"])){
    $check = getimagesize($_FILES["uploadImage"]["tmp_name"]);
    if($check !== false){
      $uploadOk = 1;
    }
    else{
      $uploadOk = 0;
      $errormessage .= "File selected is not an image. Please try again.</br>";
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
      $errormessage .= "Only .JPG, .PNG, .JPEG and .GIF file types are supported.</br>";
      $uploadOk = 0;
    }

    if($_FILES["uploadImage"]["size"] > 5000000){
      $errormessage .= "Sorry, we only accept images up to 5MB in size. Please try again. </br>";
      $uploadOk = 0;

    }

    if($uploadOk != 1){
      include("upload.php");
    }
    else{
      if(move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $target_file)){
          //Reminder! Escape the username!
          $caption = mysqli_real_escape_string($connection, $_POST["caption"]);
          $user = mysqli_real_escape_string($connection, $row["user"]);
          $escTarget_file = mysqli_real_escape_string($connection, $target_file);

          $postQuery = "insert into " . strtolower($user) . "_posts (text, image_address, date) values (\"". $caption . "\", \"" . $escTarget_file . "\", \"" . date("Y-m-d H:i:s") . "\")";
          mysqli_query($connection, $postQuery);

          header("Location: profile.php?id=" . $_SESSION["userid"]);
      }
      else{
        $errormessage .= "Sorry, the upload failed. Please try again. </br>";
        include("upload.php");
      }
    }
  }
 ?>
