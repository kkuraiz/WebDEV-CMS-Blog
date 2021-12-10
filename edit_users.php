<!-------f----------
    Edit all admin user within the database
------------------->
<?php
  session_start();
	require('connect.php');

  $isNew = false;

  $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);

  if($id === false)
  {
    header("Location: admin_index.php");  
    exit;
  }
  elseif(!isset($id))
  {
    $isNew = true;
  }
  else
  {
    $query = "SELECT * FROM admin_user WHERE user_id = $id";
    $statement = $db->prepare($query);
    $statement->execute();
    $hextech = $statement->fetch();
  }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>    
</head>
<body>
  <div id="wrapper">
  <?php if($_SESSION['isLogin'] === true): ?>      
    <div id="header">
      <h1><a href="admin_users.php">Admin Users - Edit</a></h1>
    </div> 
    <ul id="menu">
      <li><a href="admin_users.php">Home</a></li>
    </ul> 
    <div id="all_blogs">
      <form action="process_post.php" method="post">
        <?php if($isNew === false): ?>
          <fieldset>
            <legend>Edit Admin Users</legend>
            <p>
              <label for="email">Email Address</label>
              <input name="email" id="login" value="<?=$hextech['user_email']?>" />
            </p>
            <p>
              <label for="username">Username</label>
              <input name="username" id="login" value="<?=$hextech['username']?>" />
            </p>
            <p>
              <label for="password">Password</label>
              <input type="password" name="password" id="login" />
            </p>
            <p>
              <label for="fname">First Name</label>
              <input name="fname" id="login" value="<?=$hextech['FName']?>" />     
            </p>
            <p>
              <label for="lname">Last name</label>
              <input name="lname" id="login" value="<?=$hextech['LName']?>" />     
            </p>          
            <p>
              <input type="hidden" name="direction" value="admin"/>            
              <input type="hidden" name="id" value="<?=$id?>" />
              <input type="submit" name="command" value="Update User" />
              <input type="submit" name="command" value="Delete User" onclick="return confirm('Are you sure you wish to delete this user?')" />           
            </p>
          </fieldset>
        <?php else: ?>
          <fieldset>
            <legend>Register Admin Users</legend>
            <p>
              <label for="email">Email Address</label>
              <input name="email" id="login"/>
            </p>
            <p>
              <label for="username">Username</label>
              <input name="username" id="login"/>
            </p>
            <p>
              <label for="password">Password</label>
              <input type="password" name="password" id="login"/>
            </p>
            <p>
              <label for="cpassword">Confirm Password</label>
              <input type="password" name="cpassword" id="login"/>
            </p>
            <p>
              <label for="fname">First Name</label>
              <input name="fname" id="login"/>     
            </p>
            <p>
              <label for="lname">Last name</label>
              <input name="lname" id="login"/>     
            </p>          
            <p>
              <input type="hidden" name="direction" value="admin"/>
              <input type="submit" name="command" value="Register" />          
            </p>
          </fieldset>
        <?php endif ?>         
      </form>
      <?php if($_SESSION['isPasswordValid'] === false): ?>
        <p>Confirm password is not correct.</p>
      <?php 
        $_SESSION['isPasswordValid'] = true;
        endif;
      ?>
    </div>
    <div id="footer">
      Copywrong 2021 - No Rights Reserved
    </div>
  <?php else: ?>
    <p> You're not login </p>
  <?php endif ?> 
  </div> 
</body>
</html>