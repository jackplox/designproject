<!DOCTYPE HTML>
<html>
  <?php
    include("header.php");

    function sortByDate($a, $b){
      return $a["date"] < $b["date"];
    }
  ?>
  <head>
    <h1>Home</h1>
    <?php
      if(!$_SESSION["userid"]){
        echo "<a href=\"login.php\">Log-in</a>";
      }
      else{
        echo "<a href=\"profile.php?id=" . $_SESSION["userid"] . "\">Profile</a></br></br>";
        echo "<a href=\"create_page.php\">Start a community page!</a>";

        echo "<h3> Communities you follow </h3>";

        $jsonDir = "./users/" . $_SESSION["userid"] . "/pages.json";

        if($jsonData = file_get_contents($jsonDir)){
            $arr = json_decode($jsonData, true);

            foreach($arr as $page){
              $sqlQuery = "select * from " . strtolower($page["title"]) . "_page";
              $res = mysqli_query($connection, $sqlQuery);

              while($row = mysqli_fetch_assoc($res)){
                  $arrPosts[] = $row + ["pid" => $page["id"]];
              }
            }

            usort($arrPosts, "sortByDate");

            foreach($arrPosts as $post){
              $sqlQuery = "select * from pages where id=" . $post["pid"];
              $res = mysqli_query($connection, $sqlQuery);

              $row = mysqli_fetch_assoc($res);


              if($post["image_address"] != "null"){
                echo "<a href=post.php?type=1&id=" . $post["pid"] . "&pid=" . $post["id"] . "><img src=\"" . $post["image_address"] . "\"width=100></br>" . $post["text"] . "</a>" . "</br>" . $post["date"] . "</br><a href=page.php?id=" . $post["pid"] . ">" . $row["title"] . "</a></br></br>";
              }
              else {
                echo "<a href=post.php?type=1&id=" . $post["pid"] . "&pid=" . $post["id"] . ">" . $post["text"] . "</a>" . "</br>" . $post["date"] . "</br><a href=page.php?id=" . $post["pid"] . ">" . $row["title"] . "</a></br></br>";
              }
            }
        }


      }
    ?>

  </head>

  <body>

  </body>
</html>
