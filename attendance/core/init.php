<?php

session_start();
error_reporting(0);

require "database/connect.php";
require "functions/user.php";
require "functions/general.php";

$current_file = explode('/',$_SERVER['SCRIPT_NAME']);

$current_file = end($current_file);

if(logged_in() === true){
	$session_user_id = $_SESSION['user_id'];
	$user_data = user_data($session_user_id, 'user_id', 'username', 'password', 'firstname', 'lastname','email', 'password_recover');
	if(user_active($user_data['username']) === false){
		unset($_SESSION['user_id']);
		header('Location: login.php');
		exit();
	}
	if($current_file !== 'changepassword.php' && $user_data['password_recover'] == 1){
		header('Location: changepassword.php?force ');
	}
}

$errors = array();

?>