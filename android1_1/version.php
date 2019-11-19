<?php 
define('IN_QISHI', true);
define('ANDROID_version', 1.1);
define('ANDROID_log', 'ÐÞ¸ÄÖ°Î»¼ìË÷BUG!');
define('ANDROID_url', 'http://www.1jobs.cn/android/apk/KnightCMS1.1.apk');
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
$aset=$_REQ;
if ($aset['version']<>ANDROID_version)
{
	$v['result']=3;
	$v['log']=android_iconv_utf8(ANDROID_log);
	$v['url']=ANDROID_url;
	$jsonencode = json_encode($v);
	echo urldecode($jsonencode);
	exit();
}
else
{
	$v['result']=1;
	$jsonencode = json_encode($v);
	echo urldecode($jsonencode);
	exit();
}
?>