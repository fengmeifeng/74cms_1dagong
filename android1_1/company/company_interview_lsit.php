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
	$offset=intval($aset['start']);
	$aset['row']=intval($aset['row']);
	if ($aset['row']==0)
	{
	$aset['row']=5;
	}
	$joinsql=" LEFT JOIN ".table('resume')." as r ON i.resume_id=r.id ";
	$wheresql=" WHERE i.company_uid='{$_SESSION['uid']}' ";
	$list=get_interview($offset,$aset['row'],$joinsql.$wheresql);
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['result']=1;
	$androidresult['errormsg']='';
	$androidresult['list']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
}
?>