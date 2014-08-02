<?php
if(mail("sudhir@localhost", "Test mail", "Hello, how are you ?", "From: luckysud4@gmail.com")){
	echo "Mail sent";
}else{
	echo "Problem while sending mail";
}
?>