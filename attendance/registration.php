<!DOCTYPE HTML>
<?php

include 'core/init.php';

if(empty($_POST) === false){
		$required_fields = array('username', 'password', 'password_again','firstname','email');
			foreach($_POST as $key => $value){
				if(empty($value) && in_array($key, $required_fields) === true){
					$errors[] = 'Fields maked with an asterik are required';
					break 1;
				}
			}
		if(empty($errors) == true){
			if(user_exists($_POST['username']) == true){
				$errors[] = 'Sorry, the username \' '.$_POST['username'].' \' is already taken';
			}
			if(preg_match("/\\s/", $_POST['username']) == true){
				$errors[] = 'Your username must not contain any sapces';
			}
			if(strlen($_POST['username']) < 4){
				$errors[] = 'Your username must be at least 4 characters';
			}
			if(strlen($_POST['password']) < 6){
				$errors[] = 'Your password must be at least 6 characters';
			}
			if($_POST['password'] !== $_POST['password_again']){
				$errors[] = 'Your password do not match';
			}
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false){
				$errors[] = 'A valid email address is required';
			}
			if(email_exists($_POST['email']) == true){
				$errors[] = 'Sorry, the email address \''.$_POST['email'].'\' is already in use';
			}
		}if(empty($errors) == true){	
			$register_data = array(
			'username' 		=> $_POST['username'],
			'password' 		=> $_POST['password'],
			'firstname'		=> $_POST['firstname'],
			'lastname' 		=> $_POST['lastname'],
			'email' 		=> $_POST['email'],
			'email_code' 	=> md5($_POST['username'] + microtime())
			);
			register_user($register_data);
			header('Location: login.php?registered');
			exit();
		}
	}

?>
<html>
<head>
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="./css/login.css">
	<link type="image/x-icon" href="./img/registration.ico" rel="shortcut icon" />
</head>
<body>
	
	<div big="big_wraper">	
	<?php
		if(!empty($errors)){echo output_errors($errors); }	
	?>
	<form method="POST" action="">
		<span style="position: relative; top: -10px;">*</span><input type="text" name="firstname" value="<?php if(isset($_POST['firstname'])){ echo $_POST['firstname'] ; }?>" placeholder="Firstname" /> <br>
		&nbsp;<input type="text" name="lastname" value="<?php if(isset($_POST['lastname'])){ echo $_POST['lastname'] ; }?>" placeholder="Lastname"> <br >
		<span style="position: relative; top: -10px;">*</span><input type="email" name="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email'] ; }?>" placeholder="Email Address" /> <br>
		<span style="position: relative; top: -10px;">*</span><input type="text" value="<?php if(isset($_POST['username'])){ echo $_POST['username'] ; }?>" name="username" placeholder="Username" /> <br>
		<span style="position: relative; top: -10px;">*</span><input type="password" name="password" placeholder="Password"> <br >
		<span style="position: relative; top: -10px;">*</span><input type="password"  name="password_again" placeholder="Retype Password"> <br >

		<input type="submit"  id="submit" value="Submit" /> 
	</form>
	</div>
</body>
</html>