<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Connection: close");
#########################################################
$streamContext = stream_context_create([
'ssl' => [
'verify_peer'      => false,
'verify_peer_name' => false
]
]);
#########################################################
$filename_update = 'update.txt';
if (is_file($filename_update)) {
$message = "The file $filename_update exists";
} else {
$message = "The file $filename_update does not exist";
$file_update = shell_exec("wget https://raw.githubusercontent.com/eurowebpage/Raspberry/main/Pi/Web/Html/1/update.txt");
echo $file_update;
	
}
#########################################################
$last_reboot= shell_exec("uptime");
$last_reboot_2= exec("uptime -s");
$show_ram = shell_exec("free -m -t");
$info_cpu = shell_exec("lscpu");
$df_h = shell_exec("df -h");
$hostname = shell_exec("hostname");
$hostname_I = shell_exec("hostname -I");

$temperature_processeur = shell_exec("cat /sys/class/thermal/thermal_zone0/temp");
//$gpu_temp = exec('vcgencmd measure_volts core');
$cpu_temp = shell_exec("echo temp=$((`cat /sys/class/thermal/thermal_zone0/temp`/1000)).0\'C");

$temp = shell_exec('cat /sys/class/thermal/thermal_zone*/temp');
$temp = round($temp / 1000, 1);

$process_memo_info = shell_exec("cat /proc/meminfo");
$process_version = shell_exec("cat /proc/version");
$system_info = shell_exec("hostnamectl");
$os_release = shell_exec("cat /etc/os-release");
$raspberry_model = shell_exec("cat /sys/firmware/devicetree/base/model");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Raspberry PI info</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <style>  
  a#cRetour{
  border-radius:3px;
  padding:10px;
  font-size:15px;
  text-align:center;
  color:#fff;
  background:rgba(0, 0, 0, 0.25);
  position:fixed;
  right:20px;
  opacity:1;
  z-index:99999;
  transition:all ease-in 0.2s;
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
  text-decoration: none;
}
a#cRetour:before{ content: "\25b2"; }
a#cRetour:hover{
  background:rgba(0, 0, 0, 1);
  transition:all ease-in 0.2s;
}
a#cRetour.cInvisible{
  bottom:-35px;
  opacity:0;
  transition:all ease-in 0.5s;
}
 
a#cRetour.cVisible{
  bottom:20px;
  opacity:1;
  }  
    img {

  width: auto;
  height: auto;
}

  pre { 
overflow-x: auto; 
background : black;
color: white;
padding : 10px;
margin-top: 25px;
margin-bottom: 25px;
font-size: 16px;
    
}
p {
font-size: 16px;
}    

  </style>  
</head>
<body>
<div><a id="cRetour" class="cInvisible" href="#haut" title="back to the top"></a></div>
<div id="haut"></div>  
<div class="jumbotron text-center">
  <h1>Raspberry PI info V.0.0.3</h1>
</div>
  
<div class="container">

<?php
$update = file_get_contents("https://raw.githubusercontent.com/eurowebpage/Raspberry/main/Pi/Web/Html/1/update.txt", false, $streamContext);
$update_local = file_get_contents("update.txt");
if ($update_local == $update){
echo '<div class="alert alert-success">Version '.$update.' OK </div>';	
}else{
echo '<div class="alert alert-danger">Version '.$update.' pas à jours </div>';	
echo shell_exec("wget https://raw.githubusercontent.com/eurowebpage/Raspberry/main/Pi/Web/Html/1/index.php https://raw.githubusercontent.com/eurowebpage/Raspberry/main/Pi/Web/Html/1/update.txt");	
}
?>

<p>Version dist : <?php echo $update; ?> - version local : <?php echo $update_local; ?></p>

<pre>
<?php
$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
echo $rootDir."<br>";
$path = new SplFileInfo(__FILE__);
echo 'The real path is '.$path->getRealPath()."<br>";

echo URL."<br>";
$path = !empty($_REQUEST['path']) ? $_REQUEST['path'] : dirname(__FILE__); // the path the script should access
echo "Browsing Location: {$path}<br>";
echo getcwd()."<br>";
echo $_SERVER["DOCUMENT_ROOT"];
?>
</pre>
<hr>
<p>Info connexion  au cours des 1, 5 et 15 dernieres minutes </p>
<pre class="mt-2"><?php echo shell_exec("w"); ?></pre>
<p>Info Reboot :</p>
<pre>
 <?php echo $last_reboot_2 ;?><hr>
 <?php echo $last_reboot ;?>
</pre>
<p>Temp processeur :</p> <pre><?php echo  substr($temperature_processeur,0,2) ;?> C</pre>
<p>Raspberry model :</p> <pre><?php echo $raspberry_model ;?></pre>
<hr>
<p>Check the CPU temperature: </p><?php echo "<pre>$cpu_temp</pre>";?><hr>
<p>Full temp: </p><?php echo "<pre>$temp</pre>";?><hr>

<p>Ram :</p><?php echo "<pre>$show_ram</pre>";?><hr>
<p>Info CPU :</p><?php echo  "<pre>$info_cpu </pre>";?><hr>
<p>process_memo_info :</p> <?php echo "<pre>$process_memo_info </pre>";?><hr>
<p>process_version :</p> <?php echo "<pre>$process_version </pre>";?><hr>
<p>os_release :</p> <?php echo "<pre>$os_release </pre>";?><hr>
<p>system_info :</p> <?php echo "<pre>$system_info</pre>";?><hr>
<p><pre><?php
 $f = fopen("/sys/class/thermal/thermal_zone0/temp","r");
 $temp = fgets($f);
 echo 'SoC temperature is '.round($temp/1000);
 fclose($f);
?>
</p></pre>
<p>df -h :</p> <?php echo "<pre>$df_h</pre>";?><hr>
<p>Hostname :</p> <?php echo "<pre>$hostname</pre>";?><hr>
<p>Hostname -I :</p> <?php echo "<pre>$hostname_I</pre>";?><hr>



</div>
<footer class="mt-5">
<div class="py-5 bg-dark ">
<div class="container-fluid">
<p class="m-0 text-center text-white "><a href="https://eurowebpage.com" class="text-white" title="EUROWEBPAGE">Generated by EURO WEB PAGE LTD - Pi2G version 1.0</a> </p>
</div>
</div>
</footer>
<script>
document.addEventListener('DOMContentLoaded', function() {
window.onscroll = function(ev) {
document.getElementById("cRetour").className = (window.pageYOffset > 100) ? "cVisible" : "cInvisible";
};
});
</script>
</body>
</html>
