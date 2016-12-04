<?php
	define('BASEPATH',dirname(dirname(__FILE__)));
	require_once("config.php");
	$sql=mysql_connect("127.0.0.1",USER,PASS);
	$db=mysql_select_db(DB,$sql);
	$time=time();
	if($_POST['key']&&(!$_POST['pa'])){
		if(KEY==$_POST['key']){
			$ip=trim($_SERVER['REMOTE_ADDR']);
			$ram=$_POST['ram'];
			$used=$_POST['used'];
			$uptime=$_POST['uptime'];
			$load=$_POST['load'];
			$valid=mysql_query("SELECT * FROM vps WHERE ip='".$ip."'");
			$is_valid=mysql_num_rows($valid);
			if(!$is_valid){
				mysql_query("INSERT INTO vps(ip,ram,used,uptime,aload,atime) VALUES('".$ip."','".$ram."','".$used."','".$uptime."','".$load."','".$time."') ");
			}else{
				mysql_query("UPDATE vps SET ram='".$ram."',used='".$used."',uptime='".$uptime."',aload='".$load."',atime='".$time."' WHERE ip='".$ip."'");
			}
		}else{
			echo "error";
		}
	}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>探针集合</title>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
		<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<style type="text/css">
			.container{
				margin-top: 50px;
			}
			#addvps {
				margin-bottom: 10px;
			}
		</style>
	</head>
</head>
<body>
<?php
		session_start();
		if(strlen(PA)){
			if($_SESSION['pa']!=PA){
				if($_POST['pa']){
					if(($_POST['pa']!=PA)){
						header("Location:".$_SERVER['SCRIPT_NAME']);
					}else{
						$_SESSION['pa']=PA;
					}
				}else{
?>	
			<div class="container">
				<div class="col-md-4 col-offset-4">
					<div class="row">
						<h2>密码</h2>
					</div>
					<form action="" method="post">
						<div class="input-group">
							<input type="password" name="pa" class="form-control">
							<span class="input-group-btn">
								<input type="submit" name="提交" class="btn btn-success">
							</span>
						</div>
					</form>
				</div>
			</div>
<?php
				return false;
				}
			}
		}
		$query=mysql_query("SELECT * FROM vps");
?>
<div class="container">
	<div id="addvps" class="input-group">
		<span class="input-group-addon">添加服务器 $</span>
		<input id="install_command" type="text" class="form-control" value="<?php echo 'wget -N --no-check-certificate http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"].'install.sh -O serverstatus_installer.sh && bash serverstatus_installer.sh http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].' '.KEY." && rm -f serverstatus_installer.sh"; ?>">
	</div>
	<table class="table table-striped">
		<tr>
			<th>ID</th>
			<th>IP</th>
			<th>Location</th>
			<th>Memory</th>
			<th>USED</th>
			<th>UPTIME</th>
			<th>LOAD</th>
			<th>STATUS</th>
		</tr>
<?php
			while($value=mysql_fetch_array($query)){
				echo "<tr>";
					echo "<td>".$value['id']."</td>";
					echo "<td>".$value['ip']."</td>";
					ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
					$loc=@file_get_contents("http://freeapi.ipip.net/".$value['ip']);
					$location=json_decode($loc,true);
					echo "<td>".$location[0].$location[1].$location[2].$location[3].$location[4]."</td>";
					echo "<td class=\"text-success\">".$value['ram']."</td>";
					echo "<td class=\"text-danger\">".$value['used']."</td>";
					echo "<td>".$value['uptime']."</td>";
					echo "<td>".$value['aload']."</td>";
					if ($time>$value['atime']+100) {//100s无计时，则不在线
						echo "<td><span class=\"label label-danger\">OFFLINE</span><span class=\"text-danger\">Last:".date("Y-m-d H:i:s",$value['atime'])."</span></td>";
					}else{
						echo "<td><span class=\"label label-success\">ONLINE</span></td>";
					}
				echo "</tr>";
			}
?>
	</table>
</div>
</body>
<?php
	}
?>
<footer>
	<script>
	$("#install_command").click(function(){ 
		$(this).select();
	});
	</script>
</footer>
</html>