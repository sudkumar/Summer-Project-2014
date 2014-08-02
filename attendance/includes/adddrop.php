<?php
	if(isset($_POST) and !empty($_POST)){
		if(isset($_POST['add_course_no']) and !empty($_POST['add_course_no']) and isset($_POST['add_course_name']) and !empty($_POST['add_course_name'])){
			$add = sanitize($_POST['add_course_no']);
			$name = sanitize($_POST['add_course_name']);
			if(course_registered($_POST['add_course_no']) === false){
				if($_FILES['file']['error'] == 4){
					$errors[] =  "Please select a file";
				}else{
					$filename = $_FILES['file']['name'];
					//$size = $_FILES['file']['size'];
					$type = $_FILES['file']['type'];
					$extension = substr($filename, strpos($filename, '.') + 1);

					if($extension === 'csv'){
					$temp_name = $_FILES['file']['tmp_name'];
						$location = 'uploads/';
						$newfilename = microtime();
						if(move_uploaded_file($temp_name, $location.$newfilename)){
							$query  = "INSERT INTO `courses` VALUES ('$add','$name')";

							if(mysql_query($query)){
								$query = "CREATE TABLE ".$add."(
									id int(10) NOT NULL ,
		   							student_name VARCHAR(32) NOT NULL,
		   							email VARCHAR(32) NOT NULL,
		   							class_conducted int(10) DEFAULT 0,
		   							class_attended int(10) DEFAULT 0,
		   							percentage int(10) DEFAULT 0,
		   							PRIMARY KEY ( id )
								) ";
								if(mysql_query($query)){
									$dataFile = fopen($location.$newfilename, 'r');
									$query = "INSERT INTO `".$add."` (id, student_name, email) VALUES ";
									$count = 0;
									while(($data = fgetcsv($dataFile, 1000, ",")) !== false) {
										if($count === 1){
											$id = $data[0];
											$student_name = $data[1];
											$email = $data[2];
											$query .= "($id, '$student_name', '$email'), ";
										}else{
											$count = 1;
										}
									}
									fclose($dataFile);
									$query = substr($query, 0, -2); //remove trailing comma and
									if(mysql_query($query)){
												echo '<h1 style="color: green;">Course Successfully Added...</h1>';
												unlink($location.$newfilename);
									}else{
												$errors[] =  "Error while parsing data from file...";
									}
								}else{
									$errors[] = "Error while creating course table.";
								}
							}else{
								$errors[] =  "Unable to register the course.";
							}

						}else{
							$errors[] = "Problem while uploading the file. Please try after some time.";
						}
					}else{
						$errors[] =  "File must be an excel document with extension of '.csv'.";
					}
				}
			}else{
				$errors[] =  "Course with Course No. ".$_POST['add_course_no']." already exists.";
			}
		}elseif(isset($_POST['drop_course_no']) and !empty($_POST['drop_course_no'])){
			$drop = sanitize($_POST['drop_course_no']);
			if(course_registered($drop)){
				mysql_query("DELETE FROM `courses` WHERE `course_no` = '$drop'");
				mysql_query("DROP TABLE `".$drop."`");
				echo "<h1>Course successfully droped..</h1>";

			}else{
				$errors[] = "Course not found.";
			}

		}else{
			$errors[] =  "Please enter fields.";
		}
	}
	if(!empty($errors)){
		echo output_errors($errors);
	}
?>


<input type="radio" name="adddrop" id="add" checked="checked"><label for="add">Add Course</label>
<input type="radio" name="adddrop" id="drop"><label for="drop">Drop Course</label><br>
<form  action="" method="POST" enctype="multipart/form-data" id="ADD">
	<span style="position: relative; top: -10px;">*</span><input type="text" name="add_course_no" class="course_no" value="<?php if(isset($_POST['add_course_no'])){ echo $_POST['add_course_no'] ; }?>" placeholder="Course No."><br>
	<span style="position: relative; top: -10px;">*</span><input type="text" name="add_course_name" class="course_no" value="<?php if(isset($_POST['add_course_name'])){ echo $_POST['add_course_name'] ; }?>" placeholder="Course Name"><br>
	<span style="position: relative; top: -10px;">*</span><input type="file" name="file" id="file" ><br>
	<input type="submit" id="submit" value="Add Course" >
</form>
<form action="" method="POST" enctype="multipart/form-data"   id="DROP" style="display: none;">
	<span style="position: relative; top: -10px;">*</span><input type="text" name="drop_course_no" id="drop_course_no" value="<?php if(isset($_POST['drop_course_no'])){ echo $_POST['drop_course_no'] ; }?>" placeholder="Course No."><span id="help"></span><br>
	<input type="submit"  id="submit" value="Drop Course" >
</form>



<script type="text/javascript">
	document.getElementById("add").onclick = function(){
		document.getElementById("DROP").style.display = "none";
		document.getElementById("ADD").style.display = "block";
	}
	document.getElementById("drop").onclick = function(){
		document.getElementById("ADD").style.display = "none";
		document.getElementById("DROP").style.display = "block";
	}
	xmlHttp = createXmlHttpRequestObject();
	function createXmlHttpRequestObject(){
		var xmlHttp;
		
		if(window.ActiveXObject){
			try{
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(e){
				xmlHttp = false;
			}
		}else{
			try{
				xmlHttp = new XMLHttpRequest();
			}catch(e){
				xmlHttp = false;
			}
		}
		
		if(!xmlHttp){
			
		}else{
			return xmlHttp;
		}
	}

	function output(){
		if(xmlHttp.readyState == 4 || xmlHttp.readyState == 0){
			course = encodeURIComponent(document.getElementById('drop_course_no').value);
			xmlHttp.open("GET", "ajax/response.php?course="+ course , true);
			xmlHttp.onreadystatechange = handleServerResponse;
			xmlHttp.send(null);
		}else{
			setTimeout('output()', 1000);
		}
	}
	function handleServerResponse(){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				xmlResponse = xmlHttp.responseXML;
				xmlDocumentElement = xmlResponse.documentElement;					
				message = xmlDocumentElement.childNodes;
				names = '';	
				for(i = 0; i < message.length; i++){
					names += '<u><span id="fillme'+i+'" onclick="fill('+i+')">'+message[i].firstChild.nodeValue+'</span></u>, ';
				}
				names = names.slice(0, -2);
				document.getElementById("help").innerHTML = names;
				myvar = setTimeout('output()',1000);
			}
		}
	}
	function fill(i){
		document.getElementById("drop_course_no").value = document.getElementById("fillme"+i).innerHTML;
		document.getElementById("help").innerHTML = "";
		clearTimeout(myvar);
	}
</script>