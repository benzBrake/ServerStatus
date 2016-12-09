<?php
	define('BASEPATH',dirname(dirname(__FILE__)));
	require_once("config.php");
	$sql=mysql_connect(DB_HOST,DB_USER,DB_PASS);
	$db=mysql_select_db(DB_NAME,$sql);
	$sst=DB_PREFIX."_status";
	$time=time();
	if($_POST['key']&&(!$_POST['pa'])){
		if(POST_TOKEN==$_POST['key']){
			$ip=trim($_SERVER['REMOTE_ADDR']);
			$hostname=$_POST['hostname'];
			$ram=$_POST['ram'];
			$ram_used=$_POST['ram_used'];
			$disk=round($_POST['disk'] * 100,0);
			$uptime=$_POST['uptime'];
			$load=$_POST['load'];
			$valid=mysql_query("SELECT * FROM $sst WHERE ip='".$ip."'");
			$is_valid=mysql_num_rows($valid);
			if(!$is_valid){
				mysql_query("INSERT INTO $sst(hostname,ip,ram,ram_used,disk,uptime,aload,atime) VALUES('".$hostname."','".$ip."','".$ram."','".$ram_used."','".$disk."','".$uptime."','".$load."','".$time."') ");
			}else{
				mysql_query("UPDATE $sst SET hostname='".$hostname."',ram='".$ram."',ram_used='".$ram_used."',disk='".$disk."',uptime='".$uptime."',aload='".$load."',atime='".$time."' WHERE ip='".$ip."'");
			}
		}else{
			echo "error";
		}
	}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>ServerStatus</title>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="https://tz.cloudcpp.com/css/dark.css" title="dark">
		<link rel="stylesheet" href="https://tz.cloudcpp.com/css/light.css" title="light">
		<style>
			body {
				padding-top: 70px;
				padding-bottom: 30px;
			}
			table #r1 {
				cursor: pointer;
			}
		</style>
		<!--[if lt IE 9]>
			<script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>
</head>
<body>
	<div role="navigation" class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<div class="navbar-header">
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">ServerStatus</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">Theme<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#" onclick="setActiveStyleSheet('dark')">Dark</a></li>
								<li><a href="#" onclick="setActiveStyleSheet('light')">Light</a></li>
							</ul>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
<?php
		if(strlen(LOGIN_PASS)){
			if($_SESSION['pa']!=LOGIN_PASS){
				if($_POST['pa']){
					if(($_POST['pa']!=LOGIN_PASS)){
						header("Location:".$_SERVER['SCRIPT_NAME']);
					}else{
						$_SESSION['pa']=LOGIN_PASS;
					}
				}else{
?>
			<div class="container">
				<div class="col-md-4 col-offset-4">
					<div class="row">
						<h2>Password:</h2>
					</div>
					<form action="" method="post">
						<div class="input-group">
							<input type="password" name="pa" class="form-control">
							<span class="input-group-btn">
								<input type="submit" name="OK" class="btn btn-success">
							</span>
						</div>
					</form>
				</div>
			</div>
			<center>Copyright  <a href="http://git.oschina.net/supercell/service_count">Egist</a> & <a href="https://github.com/Char1sma/ServerStatus">Char1sma</a></center>
<?php
				return false;
				}
			}
		}
		$query=mysql_query("SELECT * FROM $sst");
?>
<div class="container">
	<div id="addvps" class="input-group">
		<span class="input-group-addon">Add Server #</span>
		<input id="install_command" type="text" class="form-control" value="<?php echo 'wget -N --no-check-certificate http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"].'install.sh -O serverstatus_installer.sh && bash serverstatus_installer.sh http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].' '.POST_TOKEN." && rm -f serverstatus_installer.sh"; ?>">
	</div>
	<div class="container content">
	<table class="table table-striped table-condensed table-hover">
		<thead>
		<tr>
			<th id="id">ID</th>
			<th id="hostname">HOSTNAME</th>
			<th>RAM</th>
			<th>DISK</th>
			<th>UPTIME</th>
			<th>LOAD</th>
			<th>STATUS</th>
		</tr>
		</thead>
<?php
		while($value=mysql_fetch_array($query)){
			echo "<tr id=\"r1\" data-toggle=\"collapse\" data-target=\"#rt".$value['id']."\" class=\"accordion-toggle odd\">";
			echo "<td>".$value['id']."</td>";
			echo "<td>".$value['hostname']."</td>";
			$persent = round( $value['ram_used']/$value ['ram'] * 100 , 2)."%";
			echo '<td><div class="progress">
  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:'.$persent.';">'.$persent.'</div></div></td>';
  			echo '<td><div class="progress">
  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:'.$value['disk'].'%;">'.$value['disk'].'%</div></div></td>';
			echo "<td>".$value['uptime']."</td>";
			echo "<td>".$value['aload']."</td>";
			if ($time>$value['atime']+100) {//if not assert after 100s,show offline
				echo "<td><span class=\"label label-danger\" title=\"".date("Y-m-d H:i:s",$value['atime'])."\">OFFLINE</span></td>";
			}else{
				echo "<td><span class=\"label label-success\">ONLINE</span></td>";
			}
			echo "</tr>";
			echo '<tr class="expandRow even"><td colspan="12">';
			echo "<div class=\"accordian-body collapse\" id=\"rt".$value['id']."\">";
			if (DISPLAY_IP) {
				$result="";
				if (IP_TOKEN!="") {
					$result=@file_get_contents('http://'.$_SERVER['HTTP_HOST']."/ip.php?token=".IP_TOKEN."&ip=".$value['ip']);
				} else {
					$result=@file_get_contents('http://'.$_SERVER['HTTP_HOST']."/ip.php?ip=".$value['ip']);
				}
				if (strpos(strtolower($result),"error")=== false) {
					$location=json_decode($result,true);
					echo "<div id=\"expand_ip\">IP:".$value['ip']." - ".$location[0].$location[1].$location[2]." ".$location[3]."</div>";
				} else {
					echo "<div id=\"expand_ip\">IP:".$value['ip']." - $result</div>";
				}
				
			}
			echo "<div id=\"expand_ram\">RAM:".$value['ram_used']."M/".$value['ram']."M</div>";
			echo '<div id="expand_custom"></div></div></td></tr>';
		}
?>
	</table>
</div>
</body>
<?php
	}
?>
<footer>
	<center>Copyright  <a href="http://git.oschina.net/supercell/service_count">Egist</a> & <a href="https://github.com/Char1sma/ServerStatus">Char1sma</a></center>
	<script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
	<script>
	$("#install_command").click(function(){ 
		$(this).select();
	});
	function setActiveStyleSheet(title) {
		var i, a, main;
		for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
			if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
				a.disabled = true;
				if(a.getAttribute("title") == title) a.disabled = false;
			}
		}
	}
	function getActiveStyleSheet() {
		var i, a;
		for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
			if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title") && !a.disabled)
				return a.getAttribute("title");
		}
		return null;
	}
	function getPreferredStyleSheet() {
		var i, a;
		for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
			if(a.getAttribute("rel").indexOf("style") != -1	&& a.getAttribute("rel").indexOf("alt") == -1 && a.getAttribute("title"))
				return a.getAttribute("title");
		}
	return null;
	}
	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}
	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ')
				c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0)
				return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	window.onload = function(e) {
		var cookie = readCookie("style");
		var title = cookie ? cookie : getPreferredStyleSheet();
		setActiveStyleSheet(title);
	}
	window.onunload = function(e) {
		var title = getActiveStyleSheet();
		createCookie("style", title, 365);
	}
	var cookie = readCookie("style");
	var title = cookie ? cookie : getPreferredStyleSheet();
	setActiveStyleSheet(title);
	</script>
</footer>
</html>