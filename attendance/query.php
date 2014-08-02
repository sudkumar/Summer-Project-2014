<?php 
require './core/init.php'; 
protect_page();
include 'includes/header.php'?>
	<body id="query" onload="output()">
		<div id="big_wraper">
		<?php include 'includes/head_nav.php'?>
			<div id="main_body">
				<section id="main_section">
					<?php include 'includes/attendance.php' ?>
				</section>
				<?php include 'includes/aside.php'?>			
			</div>	
			<?php include 'includes/footer.php'?>
		</div>
		<script type="text/javascript">
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
				course = encodeURIComponent(document.getElementById('course_no').value);
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
			document.getElementById("course_no").value = document.getElementById("fillme"+i).innerHTML;
			document.getElementById("help").innerHTML = "";
			clearTimeout(myvar);
		}
	</script>
	</body>
</html>

