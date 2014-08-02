<?php 
require './core/init.php'; 
protect_page();
include 'includes/header.php'?>
	<body id="result">
		<div id="big_wraper">
		<?php include 'includes/head_nav.php'?>
			<div id="main_body">
				<section id="main_section">
					<?php 
							include 'includes/result.php';
						
					?>
				</section>
				<?php include 'includes/aside.php'?>			
			</div>	
			<?php include 'includes/footer.php'?>
		</div>
	</body>
</html>

