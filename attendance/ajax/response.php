<?php

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

echo '<response>';

	$course = $_GET['course'];
	mysql_connect('localhost','root','');
	mysql_select_db('attendance');
	if(!empty($course)){
		$query = "SELECT `course_no` FROM `courses` WHERE `course_no` LIKE '".$course."%' LIMIT 5";
		$result = mysql_query($query);
		$courses = array();
		if(mysql_num_rows($result) >= 1){
		while($row = mysql_fetch_array($result)){
			$courses[] = $row;
		}
		foreach($courses as $count => $course_no){
				echo '<course_no>'.$course_no['course_no'].'</course_no>';
		}
		}
	}
echo '</response>';

?>