<?php 
require './core/init.php'; 

protect_page();
include 'includes/header.php'
?>
	<body id="home" onload="output()">
		<div id="big_wraper">
				<?php  include 'includes/head_nav.php' ?>
			<div id="main_body">
				<section id="main_section">

						<?php
							if(is_admin($_SESSION['user_id'])){ 
								include 'includes/adddrop.php' ;
							} else{
								include 'includes/home.php' ;
							}	
						?>
				</section>
				<?php  include 'includes/aside.php' ?>			
			</div>
				<?php  include 'includes/footer.php' ?>
		</div>	
	</body>
</html>
<?php

if(isset($_GET['passwordchanged']) and empty($_GET['passwordchanged'])){
	include 'includes/success_dialog_head.php';
?>
<script type="text/javascript"> success_msg = "Password successfully changed!!";</script>
<?php
	include 'includes/success_dialog_foot.php';	
}


?>

