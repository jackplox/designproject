<?php
  include("header.php");

  if(!$_SESSION["userid"]){
    header("Location: login.php");
  }
  
  $jsonDir = "./users/" . $_SESSION["userid"] . "/pages.json";

  if($tempJson = file_get_contents($jsonDir)){
    $arr = json_decode($tempJson, true);
  }

  $arr[] = ["title" => $_GET["title"], "id" => $_GET["id"], "admin" => "0"];
  $json = json_encode($arr);

  file_put_contents($jsonDir, $json);

  header("Location: page.php?id=" . $_GET["id"]);
 ?>
