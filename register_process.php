<!DOCTYPE HTML>
<html>
  <head>
    <?php
      include("header.php");
      
      $errormessage = "";

      if(strcmp($_POST["pw"], $_POST["pw2"]) != 0){
        $errormessage .= "Your passwords do not match </br>";
      }

      if(strlen($_POST["user"]) < 3){
        $errormessage .= "Your username must contain more than 3 characters</br>";
      }

      if(strcmp($_POST["name"], "") == 0){
        $errormessage .= "You cannot leave your name blank </br>";
      }

      $user = mysqli_real_escape_string($connection, $_POST["user"]);
      $pw = md5($_POST["pw"]);
      $email = mysqli_real_escape_string($connection, $_POST["email"]);
      $name = mysqli_real_escape_string($connection, $_POST["name"]);

      $res = mysqli_query($connection, "select * from users where user =\"" . $user . "\" or email =\"" . $email . "\"");
      $row = mysqli_fetch_assoc($res);



      if(strcmp($row["user"], $_POST["user"]) == 0){
        $errormessage .= "This username is already in use. </br>";
      }
      if(strcmp($row["email"], $_POST["email"]) == 0){
        $errormessage .= "This email is already in use. </br>";
      }


      if(strcmp($errormessage, "") == 0){

        mysqli_query($connection, "insert into users (user, password, email, name) values ('$user', '$pw','$email','$name')");
        $postTableQuery = "create table " . $user . "_posts(id int NOT NULL PRIMARY KEY AUTO_INCREMENT, text varchar(255), image_address varchar(255), date varchar(255))";
        mysqli_query($connection, $postTableQuery);

        $res = mysqli_query($connection, "select * from users where user = \"" . $user . "\"");
        $row = mysqli_fetch_assoc($res);

        $target_dir = "./users/" . $row["id"];

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

        echo "User successfully created!";

        include("login.php");
      }
      else{
        include("register.php");
      }
    ?>
  </head>
  <body>
  </body>
</html>
