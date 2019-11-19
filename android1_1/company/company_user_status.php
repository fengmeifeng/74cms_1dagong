<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset=array_map('addslashes',$aset);
require_once(ANDROID_ROOT_PATH.'include/common.user.inc.php');
if ($_SESSION['utype']<>'1')
{
	$result['result']=0;
	$result['errormsg']=android_iconv_utf8("请登录企业会员中心！");
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
}
else
{
	$aset['status']=intval($aset['status']);
	if (!empty($aset['status']))
	{
	set_com_user_status($aset['status'],$_SESSION['uid']);
	$androidresult['result']=1;
	$androidresult['errormsg']='';
	$androidresult['status']=$aset['status'];
	$jsonencode = json_encode($androidresult);
	$jsonencode=urldecode($jsonencode);
	exit($jsonencode);
	}
	else
	{
	$user=get_user_inid($_SESSION['uid']);
 	$androidresult['result']=1;
	$androidresult['errormsg']='';
	$androidresult['status']=$user['status'];
	$jsonencode = json_encode($androidresult);
	$jsonencode=urldecode($jsonencode);
	exit($jsonencode);
	}
}
?>