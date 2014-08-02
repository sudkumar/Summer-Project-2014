<!DOCTYPE HTML>
<?php
include './core/init.php';

if(isset($_SESSION['user_id'])){
	header('Location: welcome.php');
}

?>
<html>
<head>
	<title>Reset password</title>
	<link rel="stylesheet" type="text/css" href="./css/login.css">
	<link type="image/x-icon" href="./img/reset.ico" rel="shortcut icon" />
</head>

<?php
	if(isset($_POST['email'])){
				if(empty($_POST['email'])){
					$errors[] = 'Field marked with an asterik is required';
				}
			if(empty($errors) == true){
				if(email_exists($_POST['email']) == false){
					$errors[] = 'No user have registered with this email !';
				}else if(empty($errors) === true){
						recover("password", $_POST['email']);
						header('Location: login.php?reseted');
						exit();	
					}
			}			
	}
?>
<body>
	
	<div big="big_wraper">	
	
	<form method="POST" action="">
		<span style="position: relative; top: -10px;">*</span><input type="email" id="email" name="email" placeholder="Email Address"> <br >
		<input type="submit"  id="submit" value="Submit" /> <br>
	</form>
	<?php
		if(!empty($errors)){
			echo output_errors($errors);
		}
	?>
	</div>
</body>
</html>