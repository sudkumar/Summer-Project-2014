<?php
if(isset($_SESSION['file_path'])){
			unlink($_SESSION['file_path']);
			unset($_SESSION['file_path']);
}
?>
<form action="queryresult.php" method="POST">
	<ul> 
		<li ><label for="course_no">Course No.*:</label> <br>
			<input type="text" id="course_no" name="course_no"  placeholder="CS203"><span id="help"></span> 
		</li>	
		<li ><label for="min_percentage">Percentage:</label><br	>
			 <input type="text" id="min_percentage" name="min_percentage" placeholder="10"> <input type="text" id="max_percentage" name="max_percentage" placeholder="70"> 
		</li>
		<li ><label for="roll_no">Student's Roll No.: </label><br>
			<input type="text" id="roll_no" name="roll_no" placeholder="12889"> 
		</li>
		<li >
			
			<input type="submit" id="submit" name="submit" disabled value="Submit"> 
		</li>
		<script type="text/javascript">
			document.onunload = disableSubmit;
			course_no = document.getElementById("course_no");
			submit = document.getElementById("submit");
			min_percentage = document.getElementById("min_percentage");
			max_percentage = document.getElementById("max_percentage");
			roll_no = document.getElementById("roll_no");
			function disableSubmit() {
				min = min_percentage.value;
				max = max_percentage.value;
				if(course_no.value != "" ){
					submit.removeAttribute("disabled");
				}else{
					submit.setAttribute("disabled","disabled");
				}
				if(min != "" || max != ""){
					if ((min != ""  && (isNaN(min) || min < 0 || min >100)) || (max != "" && (isNaN(max) || max < 0 || max >100))) {
						submit.setAttribute("disabled","disabled");
					}
					roll_no.setAttribute("disabled","disabled");
					roll_no.setAttribute("placeholder","To enter here, remove percentage..");
					
				}else{
					roll_no.removeAttribute("disabled");
					roll_no.setAttribute("placeholder","12889");
				}
			}
			setInterval(disableSubmit, 500);
		</script>
	</ul>
	<span style="color: red;">*Fields marked with an asterik are required !!</span>
</form>