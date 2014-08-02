<header id="top_header">
	<div id="heading">
		<h1>Online Attendance System</h1>
	</div>
	<div id="username">
		<ul>
			<li onmouseover="colorAnchor(event)" onmouseout="normalAnchor(event)">	
				<h1 id="teachername"><?php
					echo "Hi ".$user_data['firstname'];
					if(isset($_SESSION['file_path'])){
						unlink($_SESSION['file_path']);
						unset($_SESSION['file_path']);
					}
				?></h1>
				<span id="darrow" >&#8250;</span>
				<ul>
					<li><a href="logout.php">Log Out</a></li>
					<li><a href="changepassword.php">Change Password</a></li>
				</ul>
			</li>
		</ul>
		<script type="text/javascript">
			function colorAnchor(event){
				var anchor = document.getElementById("teachername");
				var dArrow = document.getElementById("darrow");
				// for mozila
				dArrow.style.MozTransition = "-moz-transform .5s";
				dArrow.style.MozTransform = "rotate(-90deg) translateY(-5px)";
				// for chrome, safari, opera
				dArrow.style.WebkitTransition = "-webkit-transform .5s";
				dArrow.style.WebkitTransform = "rotate(-90deg) translateY(-5px)";
				// for explorer
				dArrow.style.msTransition = "-ms-transform .5s";
				dArrow.style.msTransform = "rotate(-90deg) translateY(-5px)";
			}

			function normalAnchor(event){
				var anchor = document.getElementById("teachername");
				var dArrow = document.getElementById("darrow");
				// for mozila
				dArrow.style.MozTransition = "-moz-transform .5s";
				dArrow.style.MozTransform = "rotate(90deg) translateY(0px)";
				// for chrome, safari, opera
				dArrow.style.WebkitTransition = "-webkit-transform .5s";
				dArrow.style.WebkitTransform = "rotate(90deg) translateY(0px)";
				// for explorer
				dArrow.style.msTransition = "-ms-transform .5s";
				dArrow.style.msTransform = "rotate(90deg) translateY(0px)";
			}
		</script>
	</div>
</header>
<nav id="top_menu">
	<ul>
		<?php if(is_admin($_SESSION['user_id'])){ ?>
		<li id="navAddDrop"><a href=".">Add/Drop</a></li>
		<?php } else{ ?>
		<li id="navhome"><a href=".">Home</a></li>
		<?php } ?>
		<li id="navattendance"><a href="query.php">Attendance</a></li>
		<li id="navqueryresult"><a href="queryresult.php">Query Result</a></li>
		<li id="navsendmail"><a href="sendmail.php">Send mail</a></li>
	</ul>
</nav>