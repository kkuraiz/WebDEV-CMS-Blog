<!-------f----------

------------------->
<?php
  session_start();
  require('connect.php'); 
  $_SESSION['isLogin'] = false;

  $errorMsg = "";
  if(isset($_POST['command']))
  {
    if(!empty($_POST['username']) && !empty($_POST['password']))
    {     
      $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      //get username
      $query = "SELECT username FROM admin_user";
      $statement = $db->prepare($query);
      $statement->execute();

      while($adminuser = $statement->fetchAll(PDO::FETCH_COLUMN, 0))
      {
        $username_array = $adminuser;
      }

      //get password
      $query = "SELECT password FROM admin_user";
      $statement = $db->prepare($query);
      $statement->execute();

      while($adminuser = $statement->fetchAll(PDO::FETCH_COLUMN, 0))
      {
        $password_array = $adminuser;
      }

      //session
      if (in_array($username, $username_array)) 
      {
        $key = array_search($username, $username_array);
        if(password_verify($password, $password_array[$key]))
        {
          $_SESSION['isLogin'] = true;
          header("Location: admin_index.php");
        }
        else
        {
          $errorMsg = "Password is incorrect";
        }
      }
      else
      {
        $errorMsg = "Username is incorrect";
      }
    }
    else
    {
      $errorMsg = "Please enter a password or username"; 
    }
  }
  
?>
<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <title>Champion Story</title>
      <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body>
    <div id="wrapper">
      <form method="post">
        <fieldset>
          <p>
            <label for="username">Username</label>
            <input name="username" id="username"/>
          </p>
          <p>
            <label for="password">Password</label>
            <input type="password" name="password" id="password"/>              
          </p>
          <p>
            <input type="submit" name="command" value="Login" /> 
            <a href="index.php"><input type="button" name="return" value="Return"></a>
          </p>
          <p><?= $errorMsg ?></p>
        </fieldset>
      </form>
    </div>
  </body>
</html>
