<?php

function  is_admin($user_id){
	return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `teachers` WHERE `type` = 1 AND `user_id` = $user_id "), 0) == 1 ) ? true : false;
}

function course_registered($course_no){
	return (mysql_result(mysql_query("SELECT COUNT(`course_no`) FROM `courses` WHERE `course_no` = '$course_no' "), 0) == 1) ? true : false;
}

function print_student_data($data){
	echo '<table id="student_data" >
			<thead>
			<tr>
				<th scope="col" >Roll no</th>
				<th scope="col" >Student name</th>
				<th scope="col" >Email Id</th>
				<th scope="col" >Class conducted</th>
				<th scope="col" >Class attended</th>
				<th scope="col" >Precentage</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td colspan="6">
					<div id="scrollit">
					<table>';
			global $user_data;
			$fname = substr(md5($user_data['username'] + microtime()), 0, 8);
			$myfile = fopen("downloads/".$fname.".csv", "w") or die("Unable to open file!");
			$header= "Roll no, Student name, Email Id, Class conducted, Class Attended, Precentage";
			fwrite($myfile, $header);
			foreach($data as $count => $entry){
				echo '<tr>
						<td>'.$entry['id'].'</td>
						<td>'.$entry['student_name'].'</td>
						<td>'.$entry['email'].'</td>
						<td>'.$entry['class_conducted'].'</td>
						<td>'.$entry['class_attended'].'</td>
						<td>'.$entry['percentage'].'</td>
					</tr>'
				;
				$row = "\n".$entry['id'].', '.$entry['student_name'] .', '.$entry['email'].', '.$entry['class_conducted'].', '. $entry['class_attended'].', '.$entry['percentage'];
				fwrite($myfile, $row);
			}
				fclose($myfile);
		echo '
					</table>
					</div>
				</td>
			</tr>	
		</tboby>
		</table>';
		return "downloads/".$fname.".csv";
}
function  sendmail($email, $subject, $body){
	global $user_data;
	$student_mail = fopen('student_mail.txt', 'w');
	foreach($email as $address){
		//instructure_email($address, $subject, $body );
		$mail = "From: Instructure- ".$user_data['firstname']." ".$user_data['lastname']."\nTo: ".$address."\nSubject: ".$subject."\nMessage:\n".$body."\n\n";
		fwrite($student_mail,$mail );
	}	
	fclose($student_mail);
}
function retrieve_email($data){
	$email = array();
	foreach($data as $count => $entry){
			$email[] = $entry['email'];
						
	}
	return $email;
}

function activate($email, $email_code){
	$email = sanitize($email);
	$email_code = sanitize($email_code);
	
	if(mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `teachers` WHERE `email` = '$email' AND `email_code` = '$email_code'"),0) == 1){
		mysql_query("UPDATE `teachers` SET `active` = 1 WHERE `email` = '$email'");
		return true;
	}else{
		return false;
	}
}

function protect_page(){
	if(logged_in() === false){
		header('Location: login.php');
	}
}

function change_password($user_id, $password){
	$user_id = (int)$user_id;
	$password = md5($password);
	
	mysql_query("UPDATE `teachers` SET `password` = '$password', `password_recover` = 0 WHERE `user_id` = $user_id");
}
function recover($mode, $email){
	$mode = sanitize($mode); 
	$email = sanitize($email);
	
	$user_data = user_data(user_id_from_email($email), 'firstname','user_id', 'username');
	
	if($mode == 'username'){
		//email($email, 'You username', "Hello ". $user_data['firstname'].",\n\nYour username is: ".$user_data['username']);
	}else if($mode == 'password'){
		$generated_password  = substr(md5(rand(999, 999999)), 0, 8);
		
		// remove it after being uploaded to server..
		$myfile = fopen("pass.txt", "w") or die("Unable to open file!");
		fwrite($myfile, $generated_password);
		fclose($myfile);
		
		change_password($user_data['user_id'], $generated_password);
		update_user($user_data['user_id'], array('password_recover' => '1'));
		
		//email($register_data['email'], 'Your password recovery', "Hello". $register_data['firstname']. ",\n\nYour new password is ".$generated_password."\n\n-webmaster");
		
	}
}

function update_user($user_id, $update_data){
	$update = array();
	array_walk($update_data, 'array_sanitize');
	
	foreach($update_data as $field=>$data){
		$update[] = '`'.$field.'` = \''.$data.'\'';
	}
	mysql_query("UPDATE `teachers` SET ".implode(', ',$update). " WHERE `user_id` = $user_id");
}
function register_user($register_data){
	array_walk($register_data, 'array_sanitize');
	$register_data['password'] = md5($register_data['password']);
	
	$fields = '`'.implode('`, `', array_keys($register_data)).'`';
	
	$data = '\''. implode('\', \'', $register_data). '\'';
	
	mysql_query("INSERT INTO `teachers` ($fields) VALUES ($data) ");
	
	$myfile = fopen("pass.txt", "w") or die("Unable to open file!");
	$link = "http://localhost/attendance/activate.php?email=".$register_data['email']."&email_code=".$register_data['email_code'] ;
	fwrite($myfile, $link);
	fclose($myfile);
	
	//email($register_data['email'], 'Activating your account', "Hello". $register_data['firstname']. ",\n\nPlease activate your account using the link below:\n\nhttp://localhost/attendance/activate.php?email=".$register_data['email']."&email_code=".$register_data['email_code']."\n\n-webmaster");
	
	
}
function activate_account($email){
	$user_id = user_id_from_email($email);
	$register_data = user_data($user_id, 'firstname', 'email', 'email_code');
	$myfile = fopen("pass.txt", "w") or die("Unable to open file!");
	$link = "http://localhost/attendance/activate.php?email=".$register_data['email']."&email_code=".$register_data['email_code'] ;
	fwrite($myfile, $link);
	fclose($myfile);
		//email($register_data['email'], 'Activating your account', "Hello". $register_data['firstname']. ",\n\nPlease activate your account using the link below:\n\nhttp://localhost/attendance/activate.php?email=".$register_data['email']."&email_code=".$register_data['email_code']."\n\n-webmaster");		
	
}	
function user_data($user_id){
	$data  = array();
	$user_id = (int)$user_id;
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if($func_num_args > 1){
		unset($func_get_args[0]);
		
		$fields = '`'. implode('`, `', $func_get_args) . '`';
		$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `teachers` WHERE `user_id` = $user_id "));
		
		return $data;
	}
}


function logged_in_redirect(){
	if(isset($_SESSION['user_id'])) {
		header('Location: ./');
	}
}
function logged_in(){
	return (isset($_SESSION['user_id'])) ? true : false; 
}		

function user_exists($username){
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `teachers` WHERE `username` = '$username'");
	return (mysql_result($query, 0) == 1) ? true : false;
}
function email_exists($email){
	$email = sanitize($email);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `teachers` WHERE `email` = '$email'");
	return (mysql_result($query, 0) == 1) ? true : false;
}

function user_active($username){
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `teachers` WHERE `username` = '$username' AND `active` = 1");
	return (mysql_result($query, 0) == 1) ? true : false;
}
function email_active($email){
	$username = sanitize($email);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `teachers` WHERE `email` = '$email' AND `active` = 1");
	return (mysql_result($query, 0) == 1) ? true : false;
}
function user_id_from_username($username){
	$username = sanitize($username);

	return mysql_result(mysql_query("SELECT `user_id` FROM `teachers` WHERE `username` = '$username'"), 0, 'user_id');	
}
function user_id_from_email($email){
	$email = sanitize($email);

	return mysql_result(mysql_query("SELECT `user_id` FROM `teachers` WHERE `email` = '$email'"), 0, 'user_id');	
}

function login($username, $password){
	$user_id = user_id_from_username($username);
	
	$username = sanitize($username);
	$password = md5($password);
	
	return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `teachers` WHERE `username` = '$username' AND password = '$password'"), 0) == 1) ? $user_id : false;
}
function password_recover($user_id){
	$data = mysql_fetch_assoc(mysql_query("SELECT `password_recover` FROM `teachers` WHERE `user_id` = $user_id "));
	return ($data['password_recover'] == 1) ? true : false;
}
?>