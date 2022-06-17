<?php
if(isset($_POST["update"])){
echo shell_exec("rm index.php");	
echo shell_exec("rm update.txt");	
echo shell_exec("wget https://raw.githubusercontent.com/eurowebpage/Raspberry/main/Pi/Web/Html/1/index.php");	
echo shell_exec("wget https://raw.githubusercontent.com/eurowebpage/Raspberry/main/Pi/Web/Html/1/update.txt");	
echo shell_exec("sync; echo 3 > /proc/sys/vm/drop_caches");	
header("Location: ./");
	
}
?>
