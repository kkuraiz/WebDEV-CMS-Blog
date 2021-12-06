<!-------f----------

------------------->
<?php
    session_start();
	require('connect.php');

    $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
    $slug = filter_input(INPUT_GET,'slug',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if($id === false || $_SESSION['isVisited'] === true)
    {
        header("Location: index.php");  
        exit;
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
        <?php else:?>
            <li><a href="index.php">Home</a></li>
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
                <img src= '<?= '.\uploads\\'.$chapter['image_name']?>'>
            <?php endif ?>
        </div>
    </div>
</div>
</body>
</html>