<!DOCTYPE HTML>
<html>
  <?php
    include_once("header.php");
   ?>
<head>
  <?php
    switch($_GET["type"]){
      case 0:
        $sqlQuery = "select * from users where id = " . $_GET["id"];
        break;

      case 1:
        $sqlQuery = "select * from pages where id = " . $_GET["id"];
        break;
    }

    $res = mysqli_query($connection, $sqlQuery);
    $row = mysqli_fetch_assoc($res);

    switch($_GET["type"]){
      case 0:
        $titleLink = "<a href=profile.php?id=" . $_GET["id"] . ">" . $row["user"] . "</a>";
        break;
      case 1:
        $titleLink = "<a href=page.php?id=" . $_GET["id"] . ">" . $row["title"] . "</a>";
        break;
    }
   ?>

   <h2>
     <?php
      echo $titleLink;
     ?>
   </h2>
</head>
<body>
  <?php
    switch($_GET["type"]){
      case 0:
        $sqlQuery = "select * from " . $row["user"] . "_posts where id = " . $_GET["pid"];
        break;
      case 1:
        $sqlQuery = "select * from " . strtolower($row["title"]) . "_page where id = " . $_GET["pid"];
        break;
    }

    $res = mysqli_query($connection, $sqlQuery);
    $row = mysqli_fetch_assoc($res);

    if($row["image_address"] != "null"){
      echo "<img src=\"" . $row["image_address"] . "\"alt=\"" . $row["text"] . "\" width=500>";
    }
    echo "</br></br>" . $row["text"];
   ?>

   <form action="comment_process.php?type=<?php echo $_GET["type"]; ?>&id=<?php echo $_GET["id"]; ?>&pid=<?php echo $_GET["pid"];?>&parent=null" method="POST">
     <input type="text" id="comment" name="comment" value="Thoughts?">
     <input type="submit" id="submit" value="Comment">
   </form>

   </br></br>

   <?php
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

     foreach($arr as $jsonObj){
       $sqlQuery = "select * from users where id =" . $jsonObj["userid"];
       $res = mysqli_query($connection, $sqlQuery);
       $row = mysqli_fetch_assoc($res);
       echo $jsonObj["comment"] . "</br>" . "<a href=profile.php?id=" . $jsonObj["userid"] . ">" . $row["user"] . "</a></br></br>";
     }
   }


   ?>
</body>

</html>
