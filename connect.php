<!-------f----------

------------------->
<?php
	define('DB_DSN', 'mysql:host=localhost;dbname=hextech;charset=utf8');
	define('DB_USER', 'admin');
	define('DB_PASS', '#Admin01');
	
	try
	{
		$db = new PDO(DB_DSN, DB_USER, DB_PASS);
	}
	catch (PDOException $e)
	{
		print "Error: " . $e->getMessage();
		die();
	}
?>