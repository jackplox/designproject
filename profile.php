<!DOCTYPE HTML>
<html>

<?php
  include("header.php");

  if(!$_SESSION["userid"]){
    header("Location: login.php");
  }
?>

<title>
<?php
  $res = mysqli_query($connection, "select * from users where id = " . $_GET["id"]);

  $row = mysqli_fetch_assoc($res);

  echo $row["name"] . "'s profile";
?>
</title>

<head>
  <h1><?php echo $row["user"]; ?></h1>
</head>

<body>
  <a href="profile.php?id=<?php echo $_GET["id"]?>">General</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <a href="profile.php?id=<?php echo $_GET["id"]; ?>&content=0">Threads</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <a href="profile.php?id=<?php echo $_GET["id"];?>&content=1">Images</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <a href="profile.php?id=<?php echo $_GET["id"];?>&content=2">Communities</a>


  <h2>
    <?php
    if(isset($_GET["content"])){
      switch($_GET["content"]){
        case 0:
          echo "Threads";
          break;
        case 1:
          echo "Images";
          break;
        case 2:
          echo "Communities";
          break;
      }
    }
    else{
      echo "General";
    }
    ?>
  </h2>
  <?php
    if(!isset($_GET["content"])){
      echo "
      <form action=\"textpost_process.php\" method=\"POST\">
        <input type=\"text\" id=\"textpost\" name=\"textpost\" value=\"What's on your mind?\">
        <input type=\"submit\" value=\"Post\">
      </form>

      </br>

      <form action=\"upload.php\">
        <input type=\"submit\" value=\"Post an image\">
      </form>

      </br>
      ";
    }
  ?>


  <?php
    if(isset($_GET["content"])){
      switch($_GET["content"]){
        case 0:
          $res = mysqli_query($connection, "select * from " . $row["user"] . "_posts where image_address = \"null\"");
          break;
        case 1:
          $res = mysqli_query($connection, "select * from " . $row["user"] . "_posts where NOT image_address = \"null\"");
          break;
        case 2:
          $jsonDir = "./users/" . $_GET["id"] . "/pages.json";
          $data = file_get_contents($jsonDir);
          $jsonArr = json_decode($data, true);

          foreach($jsonArr as $jsonObj){
            echo "<a href=page.php?id=" . $jsonObj["id"] . ">" . $jsonObj["title"] . "</a></br></br>";
          }

      }
      if($_GET["content"] != 2){
        while($row = mysqli_fetch_array($res)){
          $resultset[] = $row;
        }

        foreach($resultset as $result){
          if($result["image_address"] != "null"){
              echo "<a href=post.php?type=0&id=" . $_GET["id"] . "&pid=" . $result["id"] . "><img src=\"" . $result["image_address"]. "\"width=100></br>" . $result["text"] . "</a>" . "</br>" . $result["date"] . "</br></br>";
          }
          else{
              echo "<a href=post.php?type=0&id=" . $_GET["id"] . "&pid=" . $result["id"] . ">" . $result["text"] . "</a>" . "</br>" . $result["date"] . "</br></br>";
          }

        }
      }
    }
    else{

    }



   ?>
</body>

</html>
