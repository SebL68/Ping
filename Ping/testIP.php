<?php
	$ip = $_GET["nom"];
	$ping = exec("ping -n 1 $ip");
	if(strpos($ping, "Minimum") !== false) {
		echo "<a target=_blank href='http://$ip'>$ip</a> : $ping";
	}else{
		echo "-1";
	}

?>