<!-------f----------

------------------->
<?php
	session_start();
	require('connect.php');
	$_SESSION['isVisited'] = false;	
	$_SESSION['isVisitedEdit'] = false;

	if(isset($_POST['search']))
	{
		$search_input = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	else
	{
		$search_input = '';
	}

	if(isset($_GET['sort']))
	{
		if($_GET['sort'] === 'release')
		{
			$query = "SELECT * FROM chapter WHERE chapter_name LIKE '%$search_input%' ORDER BY release_date";
			$statement = $db->prepare($query);
			$statement->execute();
		}
		elseif($_GET['sort'] === 'champion')
		{
			$query = "SELECT * FROM chapter WHERE chapter_name LIKE '%$search_input%' ORDER BY champion_name";
			$statement = $db->prepare($query);
			$statement->execute();
		}
		else
		{
			$query = "SELECT * FROM chapter WHERE chapter_name LIKE '%$search_input%' ORDER BY chapter_name";
			$statement = $db->prepare($query);
			$statement->execute();
		}
		$_SESSION['sort'] = $_GET['sort'];
	}
	else
	{
		$_GET['sort'] = 'title';
		$_SESSION['sort'] = $_GET['sort'];

		$query = "SELECT * FROM chapter WHERE chapter_name LIKE '%$search_input%' ORDER BY chapter_name";
		$statement = $db->prepare($query);
		$statement->execute();
	}
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
</head>
<body>
    <div id="wrapper">
    	<?php if($_SESSION['isLogin'] === true): ?> 
	        <div id="header">
	            <h1><a href="admin_index.php">Champion Story</a></h1>
	        </div>
			<ul id="menu">
			    <li><a href="create.php" >New Chapter</a></li>
			    <li><a href="admin_users.php">Users</a></li>
			    <li><a href="authenticate.php">Logout</a></li>
			</ul>
			<ul id="sorting">
				<li>Sort by:</li>
				<li id="sorting_inner"><a href="admin_index.php?sort=title" 
					<?php if($_GET['sort'] === 'title'):?> style="color:red" <?php endif ?>>Title</a></li>
				<li id="sorting_inner"><a href="admin_index.php?sort=release"
					<?php if($_GET['sort'] === 'release'):?> style="color:red" <?php endif ?>>Release Date</a></li>
				<li id="sorting_inner"><a href="admin_index.php?sort=champion"
					<?php if($_GET['sort'] === 'champion'):?> style="color:red" <?php endif ?>>Champions</a></li>
			</ul>
			<form id="search_bar" method="post">
				<input type="text" name='search' placeholder="Search..">
				<button type="submit">Submit</button>
			</form>
			<div id="all_blogs">
				<?php if($statement->rowCount() !== 0): ?>
					<?php while ($hextech = $statement->fetch()): ?>
						<div class='blog_post'>
							<h2><a href="show.php?id=<?=$hextech['chapter_ID']?>&slug=<?=$hextech['slug']?>"><?= $hextech['chapter_name']?></a></h2>
							<small>
								<a href="edit.php?id=<?=$hextech['chapter_ID']?>">Edit</a>
							</small>
						</div>
						<div class='blog_content'>			
							<?php $dateTime = strtotime($hextech['release_date']); ?>						
							<p>Release date: <?=date("M d, Y", $dateTime)?></p>	
						</div>
						<br>			
					<?php endwhile ?>
					<?php else: ?>
						<h1>There is no chapter currently</h1>
					<?php endif ?>
			</div>
	        <div id="footer">
	            Copywrong 2021 - No Rights Reserved
	        </div>
	    <?php else: ?>
	    	<p>You're not login</p>
	    <?php endif ?>
    </div>
</body>
</html>