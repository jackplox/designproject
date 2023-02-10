<?php
  include("header.php");

  if(!$_SESSION["userid"]){
    header("Location: login.php");
  }

  $jsonDir = "./users/" . $_SESSION["userid"] . "/pages.json";

  $data = file_get_contents($jsonDir);

  $jsonArr = json_decode($data, true);

  $i = 0;

  foreach($jsonArr as $jsonObj){

    if($jsonObj['id'] == $_GET['id']){
      unset($jsonArr[$i]);
      $jsonArr = array_values($jsonArr);
      break;
    }
    $i++;
  }

  $json = json_encode($jsonArr);

  file_put_contents($jsonDir, $json);
  header("Location: page.php?id=" . $_GET["id"]);
?>
