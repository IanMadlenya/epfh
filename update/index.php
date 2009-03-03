<?php

include("../config.php");

function epayment_updates($url, $post, $save_to, $cookie)
{
	$th = curl_init($url);
	$fp=fopen($save_to, "w");
	curl_setopt($th, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($th, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($th, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($th, CURLOPT_FILE, $fp);
	curl_setopt($th, CURLOPT_HEADER, 0);
	curl_setopt($th, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($th, CURLOPT_POST, 1) ;
	curl_setopt($th, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'); 
	curl_setopt($th, CURLOPT_POSTFIELDS, $post);
	curl_setopt($th, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($th, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($th, CURLOPT_COOKIEJAR, $cookie); 
	curl_setopt($th, CURLOPT_COOKIEFILE, $cookie);


	$data = curl_exec($th);
	//print_r(curl_getinfo($th));
	//print_r($data);
	curl_close($th);
	
	fclose($fp);
}

epayment_updates($update_url, $update_post, $update_file, $update_cookie);

header("Location: $project_url");

?>
