<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
require_once(ANDROID_ROOT_PATH.'include/common.user.inc.php');
if ($_SESSION['utype']<>'2')
{
	$result['result']=0;
	$result['list']=null;
	$result['errormsg']=android_iconv_utf8("请登录个人会员中心！");
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
}
else
{
	$uid_search = $db->fetch_array($db->query("select `uid` from ".table('members')." where username='".$aset['username']."'"));
	$uid = intval($uid_search['uid']);
	$yid =intval($aset['id']);
	if (empty($yid))
	{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8("简历id错误！");
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	if($n=del_resume($uid,$yid))
	{
		$result['result']=1;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8("删除成功！");
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
}
?>