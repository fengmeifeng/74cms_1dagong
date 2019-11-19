<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset=array_map('addslashes',$aset);
require_once(ANDROID_ROOT_PATH.'include/common.user.inc.php');
$title = $aset['title'];
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
	$setsqlarr['title']=trim($aset['title']);
	if (empty($setsqlarr['title']))
	{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('简历名称不能为空！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	$wheresql = "`id`=".$pid;
	$update_result1=updatetable(table('resume_tmp'),$setsqlarr,$wheresql);
	$update_result2=updatetable(table('resume'),$setsqlarr,$wheresql);
	if ($update_result1||$update_result2){
		write_memberslog($uid,2,1101,$aset['username'],"通过手机客户端更改简历名称");
		$result['result']=1;
		$result['list']=array('pid'=>$pid);
		$result['errormsg']=android_iconv_utf8('成功更改简历名称');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('更改简历名称失败');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
}
?>