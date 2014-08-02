<?php

include './core/init.php';

logged_in_redirect();

if(isset($_GET['registered']) and empty($_GET['registered']))
{	include 'includes/success_dialog_head.php';
	?>
	<script type="text/javascript"> success_msg = "You have been registered successfully.<br>An email have been sent to your email address. Use that to activate your account.";</script>
	<?php
	include 'includes/success_dialog_foot.php';	
}
if(isset($_GET['reseted']) and empty($_GET['reseted']))
{	include 'includes/success_dialog_head.php';
	?>
	<script type="text/javascript"> success_msg = "Your new password has been mailed to your email address.<br>Use that to login.";</script>
	<?php
	include 'includes/success_dialog_foot.php';	
}
if(isset($_GET['activateaccount']) and empty($_GET['activateaccount']))
{	include 'includes/success_dialog_head.php';
	?>
	<script type="text/javascript"> success_msg = "An email have been sent to your email address. Use that to activate your account";</script>
	<?php
	include 'includes/success_dialog_foot.php';	
}
if(isset($_GET['activated']) and empty($_GET['activated']))
{	include 'includes/success_dialog_head.php';
	?>
	<script type="text/javascript"> success_msg = "Your account has been successfully activated. <br>You are free to logIn";</script>
	<?php
	include 'includes/success_dialog_foot.php';	
}
if(empty($_POST) === false){
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(empty($username) === true || empty($password) == true){
		$errors[] = 'You need to enter a username and password';
	}else if(user_exists($username) == false){
		$errors[] = 'We can\'t find the username. Have you registered ?';
	}else if(user_active($username) == false){
		$errors[] = 'You haven\'t activated your account !';
	}else{
		$login = login($username, $password);
		if($login == false){
			$errors[] = 'That password  is incorrect';
		}else{
			//set the sessions
			$_SESSION['user_id'] = $login;	
				
			//redirect user to home
			header('Location: .');
			exit();
		}
	}	

	//print_r($errors);
	
}
?>

<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="./css/login.css">
	<link type="image/x-icon" href="./img/login.ico" rel="shortcut icon" />
</head>
<body>
	<div big="big_wraper">	
	
	<form method="POST" action="login.php">
		<span style="position: relative; top: -10px;">*</span><input type="text" id="username" name="username" placeholder="Username" /> <br>
		<span style="position: relative; top: -10px;">*</span><input type="password" id="password" name="password" placeholder="Password"> <br >
		<input type="submit"  id="submit" value="LogIn" /> <br>
		<a href="reset.php"  style="float: left;display: block; margin-bottom:10px;">Forgot password ? </a> <a style="float: right;display: block; margin-bottom:10px;" href="activateaccount.php">Activate Account ?</a> <br>
		<a href="registration.php" style="clear:both; display: block;">Sign Up</a>
	</form>
	<?php
		if(!empty($errors)){
			echo output_errors($errors);
		}
	?>
	</div>
</body>
</html>
