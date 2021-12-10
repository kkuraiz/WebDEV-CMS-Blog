<!-------f----------

------------------->
<?php
    session_start();
	require('connect.php');
    $_SESSION['isVisitedEdit'] = false;

    $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
    $slug = filter_input(INPUT_GET,'slug',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if($id === false || $_SESSION['isVisited'] === true)
    {
        if($_SESSION['isLogin'] === false)
        {
            header("Location: index.php");  
            exit;
        }
        else
        {
            header("Location: admin_index.php");  
            exit;
        }
    }
    else
    {
        $_SESSION['isVisited'] = true;
    }

	$query = "SELECT * FROM chapter WHERE chapter_ID = $id";
	$statement = $db->prepare($query);
	$statement->execute();
    $chapter = $statement->fetch();

    $dateTime = strtotime($chapter['release_date']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$chapter['chapter_name']?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>    
</head>
<body>
<div id="wrapper">
    <div id="header">
        <h1>Chapter - <?=$chapter['chapter_name']?></h1>
    </div>
    <ul id="menu">
        <?php if($_SESSION['isLogin'] === true): ?>
            <li><a href="admin_index.php">Home</a></li>
            <li><a href="edit.php?id=<?=$id?>">Edit</a></li>
            <p></p>
            <form action="admin_index.php" id="search_bar" method="post">
                <input type="text" name="search" placeholder="Search..">
                <button type="submit">Submit</button>
            </form> 
        <?php else:?>
            <li><a href="index.php">Home</a></li>
            <p></p>
            <form action="index.php" id="search_bar" method="post">
                <input type="text" name="search" placeholder="Search..">
                <button type="submit">Submit</button>
            </form> 
        <?php endif ?>               
    </ul>
    <div id="all_blogs">
        <div class="blog_post">
          <h2>
              <?=$chapter['chapter_name']?>
          </h2>
          <small>
              Release date: <?=date("M d, Y", $dateTime)?>
          </small>
        </div>
        <div class='blog_content'>
            <?=$chapter['description']?>

            <?php if($chapter['image_name'] != ''): ?>
                <img src= '<?= '.\uploads\\'.$chapter['image_name']?>' id='image'>
            <?php endif ?>
        </div>
    </div>
</div>
</body>
</html>