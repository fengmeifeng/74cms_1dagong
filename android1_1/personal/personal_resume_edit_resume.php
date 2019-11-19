<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset=array_map('addslashes',$aset);
require_once(ANDROID_ROOT_PATH.'include/common.user.inc.php');
if ($_SESSION['utype']<>'2')
{
	$result['result']=0;
	$result['list']=null;
	$result['errormsg']=android_iconv_utf8("请登录个人会员中心！");
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
}
else
{
	$pid = intval($aset['pid']);
	$search = $db->fetch_array($db->query("select `title`,`complete_percent`,`photo_img` from ".table('resume')." where id=".$pid." limit 1"));
	if(!$search){
		$search = $db->fetch_array($db->query("select `title`,`complete_percent`,`photo_img` from ".table('resume_tmp')." where id=".$pid." limit 1"));
	}
	$search['title'] = android_iconv_utf8($search['title']);
	$return_data_json = json_encode($search);
	$result['result']=1;
	$result['list']=$return_data_json;
	$result['errormsg']=android_iconv_utf8('获取数据成功');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
}
?>