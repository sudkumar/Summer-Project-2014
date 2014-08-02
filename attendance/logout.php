<?php
session_start();

if(isset($_SESSION['user_id'])){
	unset($_SESSION['user_id']);
}
if(isset($_SESSION['query_submited'])){
	unset($_SESSION['query_submited']);
}
if(isset($_SESSION['post'])){
	unset($_SESSION['post']);
}
if(isset($_SESSION['email_data'])){
	unset($_SESSION['email_data']);
}
if(isset($_SESSION['file_path'])){
	unlink($_SESSION['file_path']);
	unset($_SESSION['file_path']);
}

session_destroy();

header('Location: login.php');
?>
