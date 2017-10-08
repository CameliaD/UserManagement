<?php

require_once "lib/globals.php";
require_once "lib/config.php";

// If the user is not logged in is redirected to the login page, in order to have access to the current page.
function redirectToLogIn()
{
	if(!isset($_SESSION['user']))
	{
		header("location: login.php");
	}
	else if($_SESSION['user'] != 'logged_in')
	{
		header("location: login.php");
	}	
}

// The function is used to log out the user.
function logOut()
{
	$_SESSION['user'] = 'logged_out';
	unset($_SESSION['userid']);
	
	session_destroy();
}

// The function is used for connecting to MySql Database.
function connectToDbServer()
{
	global $MySQLi, $DB_SERVER_NAME,$DB_USER_NAME,$DB_PASSWORD,$DB_NAME;
	$MySQLi = new mysqli($DB_SERVER_NAME,$DB_USER_NAME,$DB_PASSWORD,$DB_NAME);
	if (mysqli_connect_errno()) {
		echo "Database connexion error";
		exit();
	}
}

// The function is used to log in the user.
function logIn()
{
	global $MySQLi;
	$username = "";
	$password = "";
	$query = "";
	if( isset($_POST['username']) && isset($_POST['password']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		connectToDbServer();
		$query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
		if ($result = $MySQLi->query($query)) {
			if ($row = $result->fetch_row()) {
				$_SESSION['user'] = 'logged_in';
				$_SESSION['userid'] = $row[0];
				header("location: view_account.php");
			}
			$result->close();
		}
		$MySQLi->close();
	}
}

// The function is used to create a new account.
function signUp()
{
	global $MySQLi;
	$username = "";
	$password = "";
	$email = "";
	$phone = "";
	$firstname = "";
	$lastname = "";
	$description = "";
	$avatarpath = "images/avatars/standard.jpg";
	$userid = "";
	
	if( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['firstname']) && isset($_POST['lastname']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		connectToDbServer();
		$query = "INSERT INTO users_database.user (username, email, phone, `first name`, `last name`, password) VALUES ('$username', '$email', '$phone', '$firstname', '$lastname', '$password')";
		$MySQLi->query($query);
		
		/* get the userid of the new created account */
		$queryid = "SELECT id, username FROM user WHERE username = '$username'";
		if ($result = $MySQLi->query($queryid)) {
			if ($row = $result->fetch_row()) {
				$userid = $row[0];
			}
			$result->close();
		}
		
		/* upload image */
		if(isset($_FILES['image'])){
		  $errors= array();
		  $file_name = $_FILES['image']['name'];
		  $file_size =$_FILES['image']['size'];
		  $file_tmp =$_FILES['image']['tmp_name'];
		  $file_type=$_FILES['image']['type'];
		  if(empty($errors)==true){
			 move_uploaded_file($file_tmp,"images/avatars/".$file_name);
			 if($file_name != '')
				$avatarpath = "images/avatars/$file_name";
		  }else{
			 print_r($errors);
		  }
	   }
	   
	   /* get description */
	   $description = $_POST['description'];
	   
	   /* insert image and description in user_optional_attributes */
	   if($avatarpath != "images/avatars/standard.jpg" || $description != "")
	   {
		    $queryinsert = "INSERT INTO user_optional_attributes (Description, Avatar, userid) VALUES ('$description', '$avatarpath', '$userid')";
			$MySQLi->query($queryinsert);
			
	   }
	   
		header("location: login.php");

		$MySQLi->close();
	}
}

// The function make possible for user to edit his account information
function edit()
{
	global $MySQLi;
	$username = '';
	$password = '';
	$email = '';
	$phone = '';
	$firstname = '';
	$lastname = '';
	$description = '';
	$avatarpath = 'images/avatars/standard.jpg';
	$userId = $_SESSION['userid'];
	connectToDbServer();
	
	/* loading current user data in form */
	$query = "SELECT * FROM user WHERE id = $userId";
	if ($result = $MySQLi->query($query)) {

		if ($row = $result->fetch_row()) {
			$username = $row[1];
			$password = $row[6];
			$email = $row[2];
			$phone = $row[3];
			$firstname = $row[4];
			$lastname = $row[5];
			$query2 = "SELECT * FROM user_optional_attributes WHERE userid = $userId";
			if ($result2 = $MySQLi->query($query2)) {

				if ($row2 = $result2->fetch_row()) {
					$description = $row2[0];
					$avatarpath = $row2[1];
				}
			}
			$result2->close();
		}
		$result->close();
	}
	
	/* saving the changes */
	if( isset($_SESSION['user']) && $_SESSION['user'] == 'logged_in' && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['firstname']) && isset($_POST['lastname']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		
		/* update user table */ 
		$query = "UPDATE `user` SET `username` = '$username', `email` = '$email', `phone` = '$phone', `first name` = '$firstname', `last name` = '$lastname', `password` = '$password' WHERE `user`.`id` = $userId";
		if ($MySQLi->query($query) === TRUE) {
			echo '<div class="alert">The changes have been saved!</div>';
		}
		
		/* upload image */ 
		if(isset($_FILES['image'])){
		  $errors= array();
		  $file_name = $_FILES['image']['name'];
		  $file_size =$_FILES['image']['size'];
		  $file_tmp =$_FILES['image']['tmp_name'];
		  $file_type=$_FILES['image']['type'];
		  if(empty($errors)==true){
			 move_uploaded_file($file_tmp,"images/avatars/".$file_name);
			 if($file_name != '')
				$avatarpath = "images/avatars/$file_name";
		  }else{
			 print_r($errors);
		  }
	   }
	   
	   /* insert/update in user_optional_attributes */ 
	   if($avatarpath != 'images/avatars/standard.jpg' || isset($_POST['description']))
	   {
		    $description = $_POST['description'];
		    $query2 = "SELECT * FROM user_optional_attributes WHERE userid = $userId";
			if ($result2 = $MySQLi->query($query2)) {

				if ($row2 = $result2->fetch_row()) {
					$queryupdate = "UPDATE `user_optional_attributes` SET `Description` = '$description', `Avatar` = '$avatarpath' WHERE `userid` = $userId";
					$MySQLi->query($queryupdate);
				}
				else {
					$queryinsert = "INSERT INTO user_optional_attributes (Description, Avatar, userid) VALUES ('$description', '$avatarpath', '$userId')";
					$MySQLi->query($queryinsert);
				}
			}
			
	   }

	}
	
	$MySQLi->close();
	
	/* loading the edit form */
	require_once "html/edit_account.html";
}

// The function shows the user's details.
function view()
{
	global $MySQLi;
	connectToDbServer();
	$description = '';
	$avatarpath = 'images/avatars/standard.jpg';
	$userId = $_SESSION['userid'];
	
	$query2 = "SELECT * FROM user_optional_attributes WHERE userid = $userId";
	if ($result2 = $MySQLi->query($query2)) {

		if ($row2 = $result2->fetch_row()) {
			$description = $row2[0];
			$avatarpath = $row2[1];
		}
	}
	$result2->close();
	echo "<div style='text-align: center;'><img src='$avatarpath' style='width:200px;height:225px;' align='middle'/></div> <br/><br/>";
	
	$query = "SELECT * FROM user WHERE id = $userId";
	
	if ($result = $MySQLi->query($query)) {

		if ($row = $result->fetch_row()) {
			echo '<tr> <th> Username <th/> <td>';
			echo $row[1];
			echo '</td> </tr> <tr> <th> Firstname <th/> <td>';
			echo $row[4];
			echo '</td> </tr> <tr> <th> Lastname <th/> <td>';
			echo $row[5];
			echo '</td> </tr> <tr> <th> Phone <th/> <td>';
			echo $row[3];
			echo '</td> </tr> <tr> <th> Email <th/> <td>';
			echo $row[2];
			echo '</td> </tr>';
		}
		$result->close();
	}
	
	$MySQLi->close();
}

// The function gives access to see all registered users.
function showUsersList()
{
	global $MySQLi;
	connectToDbServer();

	$query = "SELECT * FROM user";
	if ($result = $MySQLi->query($query)) {

		while ($row = $result->fetch_row()) {
			echo '<div class="whitebox"> 
			<div>';
			echo $row[1];
			echo '</div>';
			echo $row[2]; 
			echo '</div><br/>'; 
		}
		$result->close();
	}

	$MySQLi->close();
}

// The function delete the account.
function deactivate()
{
	global $MySQLi;
	connectToDbServer();
	$userId = $_SESSION['userid'];
	$query = "DELETE FROM `users_database`.`user` WHERE `user`.`id` = $userId";
	$MySQLi->query($query);
	echo '<h1>Your account has been deactivated successfully</h1>';
	$MySQLi->close();
	logOut();
}
?>
