<!DOCTYPE HTML>

<?php
  include("header.php");

  if(!$_SESSION["userid"]){
    header("Location: home.php");
  }
 ?>

<html>
  <?php
    $res = mysqli_query($connection, "select * from pages where id = " . $_GET["id"]);
    $row = mysqli_fetch_assoc($res);

    if(!$row){
      echo "Oops, this page doesnt exist. You can <a href=\"create_page.php\">create this page!</a>";
      die();
    }

    $jsonDir = "./users/" . $_SESSION["userid"] . "/pages.json";
   ?>
  <title>
    <?php echo $row["title"]; ?>
  </title>

  <head>
    <h1>
      <?php echo $row["title"]; ?>
    </h1>
    <h3>
      <?php echo $row["description"];?>
    </h3>
  </head>
  <body>


      <a href="page.php?id=<?php echo $_GET["id"]?>">General</a>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <a href="page.php?id=<?php echo $_GET["id"]; ?>&content=0">Threads</a>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <a href="page.php?id=<?php echo $_GET["id"];?>&content=1">Images</a>

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
          }
        }
        else{
          echo "General";
        }
        ?>
      </h2>

    <?php
      $pagesData = file_get_contents($jsonDir);
      $pages = json_decode($pagesData, true);

      $isFollowing = 0;

      foreach($pages as $page){
       if($page['id'] === $row["id"]){
         $isFollowing = 1;
       }
      }

      if($isFollowing == 1){
        echo "<a href=\"unfollow_page.php?id=" . $row["id"] . "&title=" . $row["title"] . "\">UnFollow</a>";
      }
      else{
        echo "<a href=\"follow_page.php?id=" . $row["id"] . "&title=" . $row["title"] . "\">Follow</a>";
      }
    ?>

    </br></br>

    <a href="page_post.php?id=<?php echo $_GET["id"]; ?>">Post to this page</a>

    <?php
      if(isset($_GET["content"])){
        switch($_GET["content"]){
          case 0:
            $sqlQuery = "select * from " . strtolower($row["title"]) . "_page where image_address = \"null\"";
            break;
          case 1:
            $sqlQuery = "select * from " . $row["title"] . "_page where NOT image_address = \"null\"";
            break;
          }

          $res = mysqli_query($connection, $sqlQuery);

          while($row = mysqli_fetch_array($res)){
            $resultset[] = $row;
          }

          echo "</br></br>";

          foreach($resultset as $result){
            if($result["image_address"] != "null"){
                echo "<a href=post.php?type=1&id=" . $_GET["id"] . "&pid=" . $result["id"] . "><img src=\"" . $result["image_address"]. "\"width=100></br>" . $result["text"] . "</a>" . "</br>" . $result["date"] . "</br></br>";
            }
            else{
                echo "<a href=post.php?type=1&id=" . $_GET["id"] . "&pid=" . $result["id"] . ">" . $result["text"] . "</a>" . "</br>" . $result["date"] . "</br></br>";
            }

        }
      }
     ?>



  </body>
</html>
