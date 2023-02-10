    <?php

      include("header.php");

      $errormessage = "";

      $user = mysqli_real_escape_string($connection, $_POST["user"]);
      $pw = md5($_POST["pw"]);

      $res = mysqli_query($connection, "select * from users where user =\"" . $user . "\" and password =\"" . $pw . "\"");
      $row = mysqli_fetch_assoc($res);
      
      if(!$row){
        $errormessage .= "Your username or password is incorrect.</br></br>
          If you do not have an account, please <a href=\"register.php\">create an account.</a></br></br>";

        include("login.php");
      }
      else{

        $_SESSION["userid"] = $row["id"];
        echo "here2";
        header("Location: home.php");
      }


    ?>
