<?php

function email($to, $subject, $body){
	mail($to, $subject, $body, "From : adminAttendance@cse.iitk.ac.in");
}

function instructure_email($to, $subject, $body){
	global $user_data;
	mail($to, $subject, $body, "From: Instructure- ".$user_data['firstname']." ".$user_data['lastname']);
}

function array_sanitize(&$item){
	$item = htmlentities(strip_tags(mysql_real_escape_string($item)));
}

function sanitize($data){
	return htmlentities(strip_tags(mysql_real_escape_string($data)));
}

function output_errors($errors){
	$output = array();
	foreach($errors as $error){
		$output[] = '<li>'. $error .'.</li>';
	}
	return '<ul style="font: bold 15px Arial; color: black; line-height: 30px; letter-spacing: 1.2px;  border: 1px solid black; border-radius: 5px;padding: 5px; background-color: #E0E0E0;">'. implode('',$output).'</ul>';
}

?>