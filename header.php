<!DOCTYPE HTML>
<html>
<?php

    class DatabaseInstance{
      private static $instance = null;
      private static $connection = null;

      function __construct(){
        self::$connection = mysqli_connect("localhost","root","root","designproject");
      }

      public static function getInstance(){
        if(self::$instance == null){
          self::$instance = new DatabaseInstance();
        }

        return self::$instance;
      }

      public function getConnection(){
        return self::$connection;
      }
    }


  session_start();
  $db = new DatabaseInstance();
  $dbInstance = $db->getInstance();
  $connection = $dbInstance->getConnection();

  if($_SESSION["userid"]){
    echo "<a href=\"logout.php\">Log Out</a>";
  }
  echo "  ";
  echo "<a href=\"home.php\">Home</a>";
 ?>




</html>
