<?php

  include("header.php");


  if(!$_SESSION["userid"]){
    header("Location: login.php");
  }

  $errormessage = "";

  $pageTitle = mysqli_real_escape_string($connection, $_POST["title"]);

  $res = mysqli_query($connection, "select * from pages where title = \"" . $pageTitle . "\"");
  $row = mysqli_fetch_assoc($res);

  if($row){
    $errormessage .= "A page with this title already exists. Please choose a different title.</br>";
    include("create_page.php");
    die();
  }


  if(strlen($row["title"]) > 20){
    $errormessage .= "Page title cannot be more than 20 characters";
    include("create_page.php");
    die();
  }

  $createPageQ = "CREATE TABLE " . $pageTitle . "_page (id int NOT NULL PRIMARY KEY AUTO_INCREMENT, text varchar(255), image_address varchar(255), date varchar(255))";
  $res = mysqli_query($connection, $createPageQ);

  $description = mysqli_real_escape_string($connection, $_POST["desc"]);

  if(!$_POST["images"]){
    $insertPageQ = "insert into pages (title, description) values (\"" . $pageTitle .  "\", \"" . $description . "\")";
  }
  else{
    $insertPageQ = "insert into pages (title, description, allow_images) values (\"" . $pageTitle .  "\", \"" . $description . "\", \"" . $_POST["images"] . "\")";
  }


  $res = mysqli_query($connection, $insertPageQ);

  $res = mysqli_query($connection, "select * from pages where title = \"" . $pageTitle . "\"");
  $row = mysqli_fetch_assoc($res);


  if(!$row){
    echo "something went wrong.";
  }


  $target_dir = "./pages/" . $row["id"];

  if(!is_dir($target_dir)){
    if(mkdir($target_dir, 0777)){
      //echo "Success";
    }
    else{
      $errormessage .= "Failure to create path to pages. If you're seeing this, something went terribly wrong.";
      include("create_page.php");
      die();
    }
  }

  $jsonDir = "./users/" . $_SESSION["userid"] . "/pages.json";

  if($tempJson = file_get_contents($jsonDir)){
    $arr = json_decode($tempJson, true);
  }

  $arr[] = ["title" => $row["title"], "id" => $row["id"], "admin" => "1"];
  $json = json_encode($arr);

  file_put_contents($jsonDir, $json);

  header("Location: page.php?id=" . $row["id"]);

 ?>
