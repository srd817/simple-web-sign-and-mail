<?php
include_once("config.php");

function my_config(){
global $server, $username, $password, $database, $timezone;
$conn=mysql_connect($server,$username,$password);
if (!$conn){
    die("连接数据库失败：" . mysql_error());
}
if(!mysql_select_db($database, $conn))
{
	die("could not open database");
}
}
?>