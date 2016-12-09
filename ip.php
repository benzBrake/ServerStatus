<?php
	define('BASEPATH',dirname(dirname(__FILE__)));
	require_once("config.php");
	$sql=mysql_connect(DB_HOST,DB_USER,DB_PASS);
	mysql_select_db(DB_NAME,$sql);
	$table=DB_PREFIX."_location";
	if(IP_TOKEN == '' || $_GET['token'] && (IP_TOKEN == $_GET['token'])){
		$ip=trim($_SERVER['REMOTE_ADDR']);
		if($_GET['ip']){
			$ip=trim($_GET['ip']);
			if(!filter_var($ip, FILTER_VALIDATE_IP)) {
				die('Error: IP Address is not valid.');
			}
		}
		mysql_query("set names utf8");
		$query=mysql_query("SELECT * FROM $table WHERE ip='".$ip."' LIMIT 1");
		$is_valid=mysql_num_rows($query);
		if(!$is_valid){
			ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
			$loc=@file_get_contents("http://freeapi.ipip.net/".$ip);
			if ($loc && $loc!='') {
				$location=json_decode($loc,true);
				if ($location[1] == $location[2]) {
					$location[2]="";
				}
				if ($location[0] == $location[1]) {
					$location[1]="";
				}
				mysql_query("INSERT INTO $table(ip,country,province,city,isp) VALUES('".$ip."','".$location[0]."','".$location[1]."','".$location[2]."','".$location[4]."') ");
				echo '["'.$location[0].'","'.$location[1].'","'.$location[2].'","'.$location[4].'"]';
			} else {
				die ('Error: Connected api faild!');
			}
		} else {
			while($value=mysql_fetch_array($query)){
				echo '["'.$value['country'].'","'.$value['province'].'","'.$value['city'].'","'.$value['isp'].'"]';
			}
		}
	}
?>