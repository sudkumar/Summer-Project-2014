<div id="query_top_link">
</div>
<?php
if((isset($_POST) === true) and !empty($_POST) or isset($_SESSION['query_submited'])){
	$_SESSION['query_submited'] = 'yes';
	if(empty($_POST) and isset($_SESSION['post'])){
		$_POST = $_SESSION['post'];
	}
	$data = array();
	if(isset($_POST['course_no']) and !empty($_POST['course_no'])){
		if(course_registered($_POST['course_no']) === true){
			$course_no = sanitize($_POST['course_no']);
			if(!empty($_POST['roll_no'])){
				$roll_no = sanitize($_POST['roll_no']);
				$query = "SELECT * FROM `".$course_no."` WHERE `id` = roll_no ";
				$result = mysql_query($query);
				if(mysql_num_rows($result) == 1){
					while($row = mysql_fetch_array($result)) {
						$data[] = $row;
					}
				}
			}else if(isset($_POST['min_percentage']) and isset($_POST['max_percentage'])){

				$min_per = $_POST['min_percentage'];
				$max_per = $_POST['max_percentage'];
				$min_per = (empty($min_per))? 0: $min_per ;
				$max_per = (empty($max_per))? 100: $max_per ;
				if(is_numeric($min_per) and is_numeric($max_per)){
					$query = "SELECT * FROM `".$course_no."` WHERE `percentage` BETWEEN $min_per AND $max_per ORDER BY `id`";
					$result = mysql_query($query);
					if(mysql_num_rows($result) >= 1){
						while($row = mysql_fetch_array($result)) {
							$data[] = $row;
						}
					}
				}else{
					die("Percentage should be a numeric value");
				}
			}else{
				$query = "SELECT * FROM `".$course_no."`";
				$result = mysql_query($query);
				if(mysql_num_rows($result) >= 1){
					while($row = mysql_fetch_array($result)) {
						$data[] = $row;
					}
				}
			}
		}else{
			$errors[] =  "Course not found..";
		}
	}
	if(empty($data) and empty($errors)){
		?>
		<script type="text/javascript">
				document.getElementById("query_top_link").innerHTML = "<?php echo '<h1>No result found</h1>'; ?>";
		</script>
		<?php
	}if(!empty($data)){
		$fname = print_student_data($data);
		if(isset($_SESSION['file_path'])){
			unlink($_SESSION['file_path']);
			unset($_SESSION['file_path']);
		}
		$_SESSION['file_path'] = $fname;
		if(isset($_SESSION['email_data'])){
			unset($_SESSION['email_data']);
		}
		$_SESSION['email_data']	= retrieve_email($data);
		?>
		<script type="text/javascript">
				document.getElementById("query_top_link").innerHTML = '<a id="download" href="<?php echo $fname; ?>">Download file</a>';
		</script>
		<?php
	}
	if(!empty($errors)){
	?>
		<script type="text/javascript">
				document.getElementById("query_top_link").innerHTML = '<?php echo output_errors($errors); ?>';
		</script>
	<?php
		echo 'To register your course, send an mail to the <a href="mailto:adminofattendance@cse.iitk.ac.in">adminofattendance@cse.iitk.ac.in</a> with subject of "Register course".';
	}
	$_SESSION['post'] = $_POST;
}else{
	?>
		<script type="text/javascript">
				document.getElementById("query_top_link").innerHTML = "<?php echo '<h1>No query submitted</h1>'; ?>";
		</script>
	<?php
}
?>
