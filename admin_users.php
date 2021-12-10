<?php
    session_start();
    require('connect.php');

    $_SESSION['isPasswordValid'] = true;

    $query = "SELECT * FROM admin_user";
    $statement = $db->prepare($query);
    $statement->execute();
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
    <?php if($_SESSION['isLogin'] === true): ?> 
    <div id="wrapper">
        <div id="header">
            <h1><a href="admin_users.php">Admin Users</a></h1>
        </div>
        <ul id="menu">
            <li><a href="edit_users.php">Register</a></li>
            <li><a href="authenticate.php">Logout</a></li>
        </ul>
        <div id="all_blogs">
            <?php while ($hextech = $statement->fetch()): ?>
                <div class="blog_post">
                    <br>
                    <p>User: <a href="edit_users.php?id=<?=$hextech['user_id']?>"><?= $hextech['username']?></a></p>
                </div>
            <?php endwhile ?>
        </div>
        <?php else: ?>
            <p>You're not login</p>
        <?php endif ?>

        <div id="footer">
            Copywrong 2021 - No Rights Reserved
        </div>
    </div>
</body>
</html>