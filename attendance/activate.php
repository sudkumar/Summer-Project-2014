<?php

include 'core/init.php';

?>
<html>
		<head>
			<title>Registered</title>
			<link rel="stylesheet" type="text/css" href="./css/success.css">
			<link type="image/x-icon" href="./img/registration.ico" rel="shortcut icon" />
		</head>
		<body>
			<div big="big_wraper">	
				<div id="success_message">
<?php
if(isset($_GET['email'], $_GET['email_code']) == true){
	$email = trim($_GET['email']);
	$email_code = trim($_GET['email_code']);
	
	if(email_exists($email) == false){
		$errors[] = 'Ooops, something went wrong, and we couldn\'t find that email address';
	}else if(activate($email, $email_code) == false){
		$errors[] = 'We have trouble activating your account';
	}if(!empty($errors) == true){
		echo '<span style="color: red;  list-style: none;">'.output_errors($errors).'</span>';
		echo '<a href="index.php" style="font: bold 20px Comic Sans MS, cursive; " >Click here for login page. </a>';
	}
	else{
		header('Location: login.php?activated');
	?>	
				</div>
			</div>
		</body>
		</html>
	<?php
	} 
}else{
		header('Location: index.php');
		exit();
}
?>
