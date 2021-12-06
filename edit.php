<!-------f----------

------------------->
<?php
  session_start();
	require('connect.php');

  $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
  if($id === false || !isset($id) || $_SESSION['isVisitedEdit'] === true)
  {
    header("Location: admin_index.php");  
    exit;
  }
  else
  {
    $_SESSION['isVisitedEdit'] = true;
  }

	$query = "SELECT * FROM chapter WHERE chapter_ID = $id";
	$statement = $db->prepare($query);
	$statement->execute();
  $hextech = $statement->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Chapter</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="https://cdn.tiny.cloud/1/46we5e2tkb3cq5226hm8j4x57xm27s2lrwe0q9w1dktk08lw/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
      tinymce.init(
      {
        selector: 'textarea'
      });
    </script>
</head>
<body>
  <div id="wrapper">
  <?php if($_SESSION['isLogin'] === true): ?>
    <div id="header">
      <h1><a href="index.php">Champion Story - Edit</a></h1>
    </div> 
    <ul id="menu">
      <li><a href="admin_index.php" >Home</a></li>
    </ul> 
    <div id="all_blogs">
      <form action="process_post.php" method="post" enctype='multipart/form-data'>
        <fieldset>
          <legend>Edit Chapter</legend>
          <p>
            <label for="title">Chapter Name</label>
            <input name="chapterTitle" id="title" value="<?=$hextech['chapter_name']?>" />
          </p>
          <p>
            <label for="title">Champion Appeared</label>
            <input name="champions" id="title" value="<?=$hextech['champion_name']?>" />
          </p>
          <p>
            <label for="title">Slug</label>
            <input name="slug" id="title" value="<?=$hextech['slug']?>" />
          </p>          
          <p>
            <label for="content">Description</label>
            <textarea name="description" id="content">
<?=$hextech['description']?>
            </textarea>
          </p>
          <p>
            <label for="file">Image:</label>
            <?php if($hextech['image_name'] != ''): ?>
              <img src= '<?= '.\uploads\\'.$hextech['image_name']?>'>
              <br>
              <input type="submit" name="command" value="DeleteImage" onclick="return confirm('Are you sure you wish to delete this image?')" />               
            <?php endif ?>           
            <input type="file" name="image" id="file">
          </p>
          <p>
            <input type="hidden" name="id" value="<?=$id?>" />
            <input type="hidden" name="direction" value="chapter"/>
            <input type="submit" name="command" value="Update" />
            <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />           
          </p>
        </fieldset>
      </form>
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