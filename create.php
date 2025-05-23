<!-------f----------
    Take input to create a post
------------------->
<?php
  session_start();    
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Champion Story</title>
  <link rel="stylesheet" href="style.css" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        <h1><a href="admin_index.php">Champion Story - New Post</a></h1>
      </div> 
      <ul id="menu">
        <li><a href="admin_index.php" >Home</a></li>
      </ul> 
      <div id="all_blogs">
        <form action="process_post.php" method="post" enctype='multipart/form-data'>
          <fieldset>
            <legend>New Chapter</legend>
            <p>
              <label for="title">Chapter Title</label>
              <br>
              <input name="chapterTitle" id="title" />
            </p>          
            <p>
              <label for="champions">Champions appeared</label>
              <br>
              <input name="champions" id="champions" />
            </p>
          <p>
            <label for="title">Slug</label>
            <br>
            <input name="slug" id="title"/>
          </p>             
            <p>
              <label for="description">Description</label>
              <textarea name="description" id="description"></textarea>
            </p>
            <p>
              <label for="file">Image:</label>
              <input type="file" name="image" id="file">
            </p>
            <p>
              <input type="hidden" name="direction" value="chapter"/>
              <input type="submit" name="command" value="Create" />
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