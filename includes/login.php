<?php
session_start();
require_once("../config.php");//引入配置文件
require_once('function.php');//引入函数库
date_default_timezone_set("Asia/Shanghai");//设置时区
error_reporting(0);//设置错误级别0
$pw=$_POST["password"];
$um=$_POST["username"];
if($pw=="" || $um==""){ 
echo "bad.1.用户名或密码不能为空";
exit();
}
$re=inject_check($pw);//检查sql注入
$re1=inject_check($um);//检查sql注入
if($re=="bad" || $re1=="bad"){exit();}
$con = mysql_connect($sqlip,$sqlid,$sqlpass);//连接数据库
mysql_query("set names utf8");//设置编码
mysql_select_db($sqlname);//选取数据库
  $sql="select * from sd_user where `username` = '$um'";
     $query=mysql_query($sql);
		 $us=is_array($row=mysql_fetch_array($query));
    $ps= $us ? md5($pw."sdshare")== $row[pwd] : FALSE;
    if($ps){
    	$_SESSION[id]=$row[id];
    	$_SESSION[user_shell]=md5($row[username].$row[pwd]."sdshare");
    	echo "ok.2.登陆成功";
    }else{
        echo "bad.1.用户名或密码错误";

    }



?>