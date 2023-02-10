<?php
  include("header.php");

  date_default_timezone_set("America/New_York");

  $post = mysqli_real_escape_string($connection, $_POST["textpost"]);
  $res = mysqli_query($connection, "select * from users where id = " . $_SESSION["userid"]);
  $row = mysqli_fetch_assoc($res);

  $postQuery = "insert into " . strtolower($row["user"]) . "_posts (text, image_address, date) values (\"". $post . "\", \"null\", \"" . date("Y-m-d H:i:s") . "\")";

  echo $postQuery;
  $res = mysqli_query($connection, $postQuery);

  header("Location: profile.php?id=" . $row["id"]);

 ?>
