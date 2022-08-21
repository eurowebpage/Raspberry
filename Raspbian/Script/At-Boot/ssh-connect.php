<?php
$dt = new DateTime("now", new DateTimeZone('Europe/Brussels'));
$date_local = $dt->format('m/d/Y, H:i:s');
$raspberry_model = shell_exec("cat /sys/firmware/devicetree/base/model");
$hostname_I = shell_exec("hostname -I");
$mac_address = shell_exec('cat /sys/class/net/eth0/address');
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

$from = "info@email";
$to = "info@email";

$subject = "Pi ssh connect";
//$message = "Pi Mac Address $mac_address";
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From:" . $from;

$message = '<html><body>';
$message .= '<h1 style="color:#f40;">Pi SSH connect</h1>';
$message .= '<p style="color:#080;font-size:18px;">With Mac adress '.$mac_address.'</p>';
$message .= '<p>Ip Pi '.$hostname_I.'</p>';
$message .= '<p>Pi model '.$raspberry_model.'</p>';
$message .= '<p>Time local '.$date_local.'</p>';
$message .= '</body></html>';
if(mail($to,$subject,$message, $headers)) {
echo "The email message was sent.";
} else {
echo "The email message was not sent.";
}
?>
