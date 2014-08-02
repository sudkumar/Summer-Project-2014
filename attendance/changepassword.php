<html>
<?php
	include './core/init.php';
	if(logged_in() === false){ 
		header('Location: login.php');
	}
?>
<head>
	<title>Change Password</title>
	<link rel="stylesheet" type="text/css" href="./css/login.css">
	<link type="image/x-icon" href="./img/reset.ico" rel="shortcut icon" />
</head>
<?php
	if(isset($_GET['force']) and empty($_POST['force']) and password_recover($session_user_id) == true){
		$force = array();
		$force[] = 'You need to change your passowrd before procceding further ';
	}
	if(empty($_POST) === false){
			$required_fields = array('current_password', 'password', 'password_again');
			foreach($_POST as $key => $value){
				if(empty($value) && in_array($key, $required_fields) === true){
					$errors[] = 'Fields maked with an asterik are required';
					break 1;
				}
			}
			if(empty($errors) == true){
				if(md5($_POST['current_password']) !== $user_data['password']){
					$errors[] = "Wrong current password";
				}if(trim($_POST['password']) !== trim($_POST['password_again'])){
					$errors[] = "New password don't match!";
				}if(strlen($_POST['password']) < 6){
					$errors[] = "Password must be atleast 6 characters";
				}else if(empty($errors) === true){
					change_password($session_user_id, $_POST['password']);
					header('Location: index.php?passwordchanged');
					exit();
				}
			}	
	}
?>
<body>
	
	<div big="big_wraper">

		<form action="" method="POST">
			<?php
				if(!empty($force)){
					echo output_errors($force);
				}	
			?>
			<span style="position: relative; top: -10px;">*</span><input type="password" name="current_password" placeholder="Current Password"><br>
			<span style="position: relative; top: -10px;">*</span><input type="password" name="password" placeholder="New Password" /> <br>
			<span style="position: relative; top: -10px;">*</span><input type="password" name="password_again" placeholder="Retype Password" /> <br>
			<input type="submit"  id="submit" value="Submit" />
		</form>
		<?php
			if(!empty($errors)){
				echo output_errors($errors);
			}	
		?>
	</div>
</body>
</html>