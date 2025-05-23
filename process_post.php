<!-------f----------
	Process every command
------------------->
<?php
	session_start();

	$fromEdit = false;

	$commandValue = $_POST['command'];//hidden value, value can't be edit
	$direction = $_POST['direction'];//hidden value, value can't be edit

	$id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
	if($id === false)
	{
		header("Location: index.php");  
		exit;
	}

	$chapterTitle = filter_input(INPUT_POST, 'chapterTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$champions = filter_input(INPUT_POST, 'champions', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$slug_raw = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$description = $_POST['description'];//not sanitize due to TINY
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$cpassword = filter_input(INPUT_POST, 'cpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$filter_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	$email = filter_var($filter_email, FILTER_VALIDATE_EMAIL);


	$error = false;
	$errorMessage="Error";

//Image Upload
	require('.\lib\ImageResize.php');
	require('.\lib\ImageResizeException.php');

	use \Gumlet\ImageResize;

	//Image Upload
	function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') 
	{
	   $current_folder = dirname(__FILE__);       
	   $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
	   
	   return join(DIRECTORY_SEPARATOR, $path_segments);
	}  

	function file_is_an_image($temporary_path, $new_path) 
	{
	    $allowed_mime_types      = ['image/jpeg', 'image/png'];
	    $allowed_file_extensions = ['jpg', 'jpeg', 'png'];
	    
	    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
	    $actual_mime_type        = getimagesize($temporary_path)['mime'];
	    
	    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
	    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
	    
	    return $file_extension_is_valid && $mime_type_is_valid;
	} 

	$image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
	$upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0); 

	if ($image_upload_detected) 
	{ 
	    $image_filename        = $_FILES['image']['name'];
	    $temporary_image_path  = $_FILES['image']['tmp_name'];
	    $new_image_path        = file_upload_path($image_filename);
	    if (file_is_an_image($temporary_image_path, $new_image_path)) 
	    {
	        move_uploaded_file($temporary_image_path, $new_image_path);

	        $image = new ImageResize($new_image_path);
	        $image->resizeToWidth(400);
	        $image->save('uploads\\'.$image_filename);
	    }
	}
	elseif($upload_error_detected && $_FILES['image']['error'] != 4)
	{
		$image_filename = '';
		$error = true;
	}

	//Command
	if($direction === 'chapter')
	{
		if(empty(trim($chapterTitle)) || empty(trim($champions)) || empty(trim($description)))
		{
			$error = true;
		}
		else
		{
			require('connect.php');
			$slug = str_replace(' ', '-', $slug_raw);
			if($commandValue === "Create")
			{
				$query = "INSERT INTO chapter(chapter_name, champion_name, slug, description, image_name) values ('$chapterTitle', '$champions', '$slug','$description', '$image_filename')";
				$statement = $db->prepare($query);
				$statement->execute();
			}
			elseif($commandValue === "Update")
			{
				$query = "SELECT * FROM chapter WHERE chapter_ID = $id";
				$statement = $db->prepare($query);
				$statement->execute();
				$test_data = $statement->fetch();

				if($image_filename != $test_data['image_name'] && $image_filename != '')
				{
					$query = "UPDATE chapter SET chapter_name = '$chapterTitle', champion_name = '$champions', slug = '$slug', description = '$description', image_name = '$image_filename' WHERE chapter_ID = $id";
					$statement = $db->prepare($query);
					$statement->execute();					
				}	
				else
				{
					$query = "UPDATE chapter SET chapter_name = '$chapterTitle', champion_name = '$champions', slug = '$slug', description = '$description' WHERE chapter_ID = $id";
					$statement = $db->prepare($query);
					$statement->execute();					
				}
			}
			elseif($commandValue === "Delete") 
			{
				$query = "DELETE FROM chapter WHERE chapter_ID = $id";
				$statement = $db->prepare($query);
				$statement->execute();		
			}
			elseif($commandValue === "DeleteImage") 
			{
				$query = "UPDATE chapter SET image_name = '' WHERE chapter_ID = $id";
				$statement = $db->prepare($query);
				$statement->execute();
				$fromEdit = true;
				$_SESSION['isVisitedEdit'] = false;
			}		
		}
	}
	else
	{
		if(empty(trim($username)) || empty(trim($password)) || empty(trim($fname)) || empty(trim($lname))
		|| empty(trim($email)))
		{
			$error = true;
		}
		else
		{
			require('connect.php');
			if($commandValue === "Update User")
			{
				$query = "UPDATE admin_user SET username = '$username', password = '$password', FName = '$fname', LName = '$lname', user_email =  '$email' WHERE user_id = $id";
				$statement = $db->prepare($query);
				$statement->execute();
			}
			elseif($commandValue === "Delete User")
			{
				if($id === 1)
				{
					$error = true;
				}
				else
				{
					$query = "DELETE FROM admin_user WHERE user_id = $id";
					$statement = $db->prepare($query);
					$statement->execute();	
				}
			}
			elseif($commandValue === "Register")
			{
				if($cpassword === $password)
				{
					$hash_password = password_hash($password, PASSWORD_BCRYPT);
					$query = "INSERT INTO admin_user(username, password, FName, LName, user_email) values ('$username', '$hash_password', '$fname', '$lname', '$email')";
					$statement = $db->prepare($query);
					$statement->execute();
				}
				else
				{
					$_SESSION['isPasswordValid'] = false;
					header("Location: edit_users.php");	
					exit;
				}
			}
		}
	}	
 	
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Blog</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
	<?php if($error === true): ?>
	<h1><?=$errorMessage?></h1>
	<?php elseif($direction === 'chapter'): ?>
	<?php
		if($fromEdit === true)
		{
			header("Location: edit.php?id=$id");
			exit;	
		} 
		else
		{
			header("Location: admin_index.php");	
			exit;	
		}	
	?>
	<?php elseif($direction === 'admin'): ?>
	<?php 	
		header("Location: admin_users.php");	
		exit;
		endif;
	?>
</body>
</html>