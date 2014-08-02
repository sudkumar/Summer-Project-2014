<!DOCTYPE HTML>
<?php
include './core/init.php';

logged_in_redirect();

?>
<html>
<head>
	<title>Account Activation</title>
	<link rel="stylesheet" type="text/css" href="./css/login.css">
	<link type="image/x-icon" href="./img/activate.ico" rel="shortcut icon" />
</head>

<?php
	if(empty($_POST) === false){
				if(empty($_POST['email'])){
					$errors[] = 'Field marked with an asterik is required';
				}
			if(empty($errors) == true){
				if(email_exists($_POST['email']) == false){
					$errors[] = 'No user have registered with this email!!!';
				}else if(empty($errors) === true){
						if(email_active($_POST['email']) == false){
							activate_account($_POST['email']);
							header('Location: login.php?activateaccount');
						}else{
							$errors[] = "Your account has already been activated!!";
						}	
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