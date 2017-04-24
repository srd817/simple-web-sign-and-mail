<?php
require_once("config.php");
include_once('mysql.php');
$verify =$_GET['token'];
$nowtime = time();
my_config();
$query = "select id_client from client where status='0' and token='$verify'";
$result=mysql_query($query);
$row = mysql_fetch_array($result);
if($row!=false){
	
	$res=mysql_query("update client set status=1 where id_client=".$row['id_client']);
	if($res){
		$msg = 'error.';
		$msg = '激活成功！';
	}
	else{
		$msg = 'error.';	
	}
	
echo $msg;
}
?>
