<?php

if(isset($_SESSION['email_data'])){
	$email = $_SESSION['email_data'];
	if(isset($_POST) and !empty($_POST)){
		if(isset($_POST['mailbody'], $_POST['mailsubject']) and !empty($_POST['mailbody']) and !empty($_POST['mailsubject'])){
			sendmail($email, $_POST['mailsubject'], $_POST['mailbody']);
			echo "<u><h1>Mail sent</h1></u>";
		}else{
			echo "<u><h1>Fields marked with an asterik are required.</h1></u>";
		}
	}
?>
<div id="mailDiv">

<form method="POST" action="">
	<ul>
		<li ><label for="mailsubject">Subject:*</label> <br>
			<textarea id="mailsubject" name="mailsubject" ><?php if(!empty($_POST['mailsubject'])){echo $_POST['mailsubject']; } ?> </textarea>
		</li>	
		<li ><label for="mailbody">Body:*</label><br>
			 <textarea id="mailbody"name="mailbody"><?php if(!empty($_POST['mailbody'])){echo $_POST['mailbody']; } ?></textarea>
		</li>
		<li ><input type="submit" id="submit" disabled value="Send">
		</li>
		<script type="text/javascript">
			document.onunload = disableSubmit;
			subject = document.getElementById("mailsubject");
			submit = document.getElementById("submit");
			body = document.getElementById("mailbody");
			function disableSubmit() {
				if(subject.value != "" && body.value != ""){
					submit.removeAttribute("disabled");
				}else{
					submit.setAttribute("disabled","disabled");
				}
			}
			setInterval(disableSubmit, 500);
		</script>
	</ul>
</form>
</div>
<?php	
}else{
	echo '<h1>Haven\'t received any student data.. !!!</h1>';
}

?>
