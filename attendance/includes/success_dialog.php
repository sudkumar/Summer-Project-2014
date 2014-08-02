<DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Dialog Boxes</title>
		<meta charset="utf-8" >
		<style type="text/css">
			 #dialogoverlay{
				display: none;
				opacity: .8;
				position: fixed;
				top: 0px;
				left: 0px;
				background: #FFF;
				width: 100%
				z-index: 10;
			 }
			 #dialogbox{
				display: none;
				position: fixed;
				background: #000;
				border-radius: 7px;
				width: 550px;
				z-index: 10;
			 }
			 #dialogbox > div{ background: #FFF; margin: 8px;}
			 #dialogbox > div > #dialogboxhead{ background: #666; font-size: 19px; padding: 10px; color:#CCC;}
			 #dialogbox > div > #dialogboxbody{ background: #333; padding: 20px; color: #FFF}
			 #dialogbox > div > #dialogboxfoot{ background: #666; padding: 10px; text-align: right;}
			 #press{
				width: 75px;
				padding: 3px;
				border: 1px solid black; 
				border-radius: 5px; 
				font: bold 15px "Comic Sans MS", cursive;
			}	
			#press:hover{
				outline: none;
				border-color: #606060;
				box-shadow: 0 0 10px #00FFFF;
				cursor: pointer;
			}
		</style>
		
	</head>
	<body >
		<div id="dialogoverlay"></div>
			<div id="dialogbox">
				<div>
					<div id="dialogboxhead">
					</div>
					<div id="dialogboxbody">
					</div>
					<div id="dialogboxfoot">
					</div>
				</div>
			</div>
			<script type="text/javascript">
			function CustomAlert(){ 
				this.render = function(dialog){ 
					var winW = window.innerWidth; 
					var winH = window.innerHeight; 
					var dialogoverlay = document.getElementById('dialogoverlay'); 
					var dialogbox = document.getElementById('dialogbox'); 
					dialogoverlay.style.display = "block"; 
					dialogoverlay.style.height = winH+"px"; 
					dialogoverlay.style.width = winW+"px";
					dialogbox.style.left = (winW/2) - (550 * .5)+"px"; 
					dialogbox.style.top = "100px"; 
					dialogbox.style.display = "block"; 
					document.getElementById('dialogboxhead').innerHTML = "Success..."; 
					document.getElementById('dialogboxbody').innerHTML = dialog; 
					document.getElementById('dialogboxfoot').innerHTML = '<button onclick="Alert.ok()" id="press" >OK</button>'; 
				}; this.ok = function(){ 
					document.getElementById('dialogbox').style.display = "none"; 
					document.getElementById('dialogoverlay').style.display = "none"; 
				}; 
			} var  Alert = new CustomAlert();
			success_msg = 'Your password has been successfully changed!!';
			Alert.render(success_msg);
		</script>
		
			
	</body>
</html>