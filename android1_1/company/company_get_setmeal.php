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
	$uid = intval($_SESSION['uid']);
	$list = null;
	$setmeal_source = $db->query("select * from ".table('members_setmeal')." where uid=".$uid);
	while($row = $db->fetch_array($setmeal_source)){
		$list = $row;
		$list['starttime'] = date('Y-m-d',$row['starttime']);
		$list['endtime'] = date('Y-m-d',$row['endtime']);
	}
	$result['result']=1;
	$result['errormsg']=android_iconv_utf8("获取数据成功！");
	$result['list']=android_iconv_utf8_array($list);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);	
}
?>