<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
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
	$yid =intval($aset['id']);
	if (empty($yid))
	{
	$result['result']=0;
	$result['errormsg']=android_iconv_utf8("职位id错误！");
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
		if($n=del_jobs($yid,$_SESSION['uid']))
		{
			$result['result']=1;
			$result['errormsg']='';
			$result['txt']=android_iconv_utf8("删除成功！");
			$jsonencode = json_encode($result);
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
}
?>