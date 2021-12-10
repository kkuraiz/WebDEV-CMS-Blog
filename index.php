<!-------f----------
	Show all link for public user
------------------->
<?php
	session_start();
	require('connect.php');
	$_SESSION['isLogin'] = false;
	$_SESSION['isVisited'] = false;

	if(isset($_POST['search']))
	{
		$search_input = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	else
	{
		$search_input = '';
	}

	if(isset($_SESSION['sort']))
	{
		$sort = $_SESSION['sort'];		

		if($sort === 'release')
		{
			$query = "SELECT * FROM chapter WHERE chapter_name LIKE '%$search_input%' ORDER BY release_date";
			$statement = $db->prepare($query);
			$statement->execute();
		}
		elseif ($sort === 'champion') 
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
	}
	else
	{
		$sort = 'title';

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
        <div id="header">
            <h1><a href="index.php">Champion Story</a></h1>           
        </div>
        <ul id="menu">
		    <li><a href="authenticate.php">Login</a></li>
		</ul>
		<ul id="sorting">
			<li>Sort by:</li>
			<?php if($sort === 'release'): ?>
				<li id="sorting_inner">Release date</li>
			<?php elseif($sort === 'champion'): ?>
				<li id="sorting_inner">Champions</li>
			<?php else: ?>
				<li id="sorting_inner">Title</li>
			<?php endif ?>
		</ul>
		<form id="search_bar" method="post">
			<input type="text" name="search" placeholder="Search..">
			<button type="submit">Submit</button>
		</form>
		<div id="all_blogs">
			<?php if($statement->rowCount() !== 0): ?>
				<?php while ($hextech = $statement->fetch()): ?>
					<div class='blog_post'>
						<h2><a href="show.php?id=<?=$hextech['chapter_ID']?>&slug=<?=$hextech['slug']?>"><?=$hextech['chapter_name']?></a></h2>
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
    </div>
</body>
</html>