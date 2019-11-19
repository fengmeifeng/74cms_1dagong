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
	$result['errormsg']=android_iconv_utf8("请登录个人会员中心！");
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
}
else
{
	$setsqlarr['realname']=trim($aset['realname']);
	$setsqlarr['sex']=trim($aset['sex']);
	$setsqlarr['birthday']=trim($aset['birthday']);
	$setsqlarr['addresses']=trim($aset['addresses']);
	$setsqlarr['phone']=trim($aset['phone']);
	$setsqlarr['qq']=trim($aset['qq']);
	$setsqlarr['msn']=trim($aset['msn']);
	$setsqlarr['profile']=trim($aset['profile']);
	if (empty($setsqlarr['realname']))
	{
		$list=get_userprofile($_SESSION['uid']);
		if (empty($list))
		{
		$list='{}';
		}
		$androidresult['result']=1;
		$androidresult['errormsg']='';
		$androidresult['list']=android_iconv_utf8_array($list);
		$jsonencode = json_encode($androidresult);
		$jsonencode=urldecode($jsonencode);
		exit($jsonencode);
	}
	else
	{
		if (get_userprofile($_SESSION['uid']))
		{
			$wheresql=" uid='".intval($_SESSION['uid'])."'";
			write_memberslog($_SESSION['uid'],1,1005,$_SESSION['username'],"通过手机客户端修改了个人资料");
			!updatetable(table('members_info'),$setsqlarr,$wheresql);
			$androidresult['result']=2;
			$androidresult['errormsg']='';
			$androidresult['txt']=android_iconv_utf8_array('修改成功');
			$jsonencode = json_encode($androidresult);
			$jsonencode=urldecode($jsonencode);
			exit($jsonencode);
		}
		else
		{
			write_memberslog($_SESSION['uid'],1,1005,$_SESSION['username'],"通过手机客户端修改了个人资料");
			$setsqlarr['uid']=intval($_SESSION['uid']);
			!inserttable(table('members_info'),$setsqlarr);
			$androidresult['result']=2;
			$androidresult['errormsg']='';
			$androidresult['txt']=android_iconv_utf8_array('修改成功');
			$jsonencode = json_encode($androidresult);
			$jsonencode=urldecode($jsonencode);
			exit($jsonencode);
		}
	}
	
}
?>