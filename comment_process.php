<?php
  include("header.php");
  switch($_GET["type"]){
    case 0:
      $jsonDir = "./users/" . $_SESSION["userid"] . "/" . $_GET["pid"] . "_comments.json";
      break;
    case 1:
      $jsonDir = "./pages/" . $_GET["id"] . "/" . $_GET["pid"] . "_comments.json";
      break;
  }

  if($tempJson = file_get_contents($jsonDir)){
    $arr = json_decode($tempJson, true);
  }

  $arr[] = ["comment" => $_POST["comment"], "userid" => $_SESSION["userid"], "parent" => $_GET["parent"], "id" => time()];
  $json = json_encode($arr);

  file_put_contents($jsonDir, $json);

  switch($_GET["type"]){
    case 0:
      header("Location: profile.php?id=" . $_GET["id"]);
      break;
    case 1:
      header("Location: post.php?type=1&id=" . $_GET["id"] . "&pid=" . $_GET["pid"]);
      break;
  }


 ?>
