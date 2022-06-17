<?php
date_default_timezone_set("Europe/Brussels");
setlocale(LC_TIME, 'fra_fra');
$datelog =  strftime('%Y-%m-%d %H:%M:%S');
//$proxy = "1.1.1.1:12121";
$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
$url = "https://www.google.pt/search?q=anonymous";
	try {
$ch = curl_init();
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,15);
curl_setopt($ch, CURLOPT_HTTP_VERSION,'CURL_HTTP_VERSION_1_1' );
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD,'USER:PASS');
curl_setopt($ch, CURLOPT_USERAGENT,$useragent);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
$result = curl_exec ($ch);
//curl_close ($ch);

	    if (curl_errno($ch)) {
			echo curl_error($ch);
			die();
		}
		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($http_code == intval(200)){
			echo "OK : " . $http_code;
			
		}
		else{
			echo "Ressource introuvable : " . $http_code;
		}
	} catch (\Throwable $th) {
		throw $th;
	} finally {
		curl_close($ch);
	}
?>
