<?php
/*
IpLocation API
*/
include "ip/libs/iplocation.class.php";
function findstr($str, $substr)
{
$m = strlen($str);
$n = strlen($substr);
if ($m < $n) return false ;
for ($i=0; $i <=($m-$n+1); $i ++){
$sub = substr( $str, $i, $n);
if ( strcmp($sub, $substr) == 0) return true;
}
return false ;
}



#需要查询的IP
$ip = $_SERVER["REMOTE_ADDR"];
//返回格式
$format = "text";//默认text,json,xml,js
//返回编码
$charset = "gbk"; //默认utf-8,gbk或gb2312
#实例化(必须)
$ip_l=new ipLocation();
$address=$ip_l->getaddress($ip);

$address["area1"] = iconv('GB2312','utf-8',$address["area1"]);
$address["area2"] = iconv('GB2312','utf-8',$address["area2"]);

$add=$address["area1"]." ".$address["area2"];
$url = $_SERVER['HTTP_HOST'];        
if($url == 'm.1jobs.com'){   echo "<script language=\"JavaScript\">\r\n";    echo " location.replace(\"http://m.1jobs.com/wap/wap.php\");\r\n";   echo "</script>";   exit;        
}           
else if(false!==strpos($add,'安徽')){
  echo "<script language=\"JavaScript\">\r\n";    echo " location.replace(\"http://hefei.1dagong.com/index.html\");\r\n";   echo "</script>";   exit; 
  
}
else if(false!==strpos($add,'江苏')){
  echo "<script language=\"JavaScript\">\r\n";    echo " location.replace(\"http://suzhou.1dagong.com/index.html\");\r\n";   echo "</script>";   exit; 
}
else if(false!==strpos($add,'上海')){
  echo "<script language=\"JavaScript\">\r\n";    echo " location.replace(\"http://shanghai.1dagong.com/index.html\");\r\n";   echo "</script>";   exit; 
}
else if(false!==strpos($add,'河南')){
  echo "<script language=\"JavaScript\">\r\n";    echo " location.replace(\"http://zhengzhou.1dagong.com/index.html\");\r\n";   echo "</script>";   exit; 
}
else if(false!==strpos($add,'湖北')){
  echo "<script language=\"JavaScript\">\r\n";    echo " location.replace(\"http://wuhan.1dagong.com/index.html\");\r\n";   echo "</script>";   exit; 
}
else if(false!==strpos($add,'重庆')){
  echo "<script language=\"JavaScript\">\r\n";    echo " location.replace(\"http://chongqing.1dagong.com/index.html\");\r\n";   echo "</script>";   exit; 
}
else if(false!==strpos($add,'四川')){
  echo "<script language=\"JavaScript\">\r\n";    echo " location.replace(\"http://chongqing.1dagong.com/index.html\");\r\n";   echo "</script>";   exit; 
}

else {
  
    echo "<script language=\"JavaScript\">\r\n";    echo " location.replace(\"http://www.1dagong.com/index.html\");\r\n";   echo "</script>";   exit; 
}
?>
