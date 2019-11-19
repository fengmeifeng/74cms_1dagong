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
	$uid = $_SESSION['uid'];
	$setsqlarr['uid']=intval($uid);
	
	//$pid=inserttable(table('resume'),$setsqlarr,1);
	$total[0]=$db->get_total("SELECT COUNT(*) AS num FROM ".table('resume')." WHERE uid='{$uid}'");
	$total[1]=$db->get_total("SELECT COUNT(*) AS num FROM ".table('resume_tmp')." WHERE uid='{$uid}'");
	$total[2]=$total[0]+$total[1];
	if ($total[2]>=intval($_CFG['resume_max']))
	{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('您最多可以创建'.$_CFG["resume_max"].' 份简历,已经超出了最大限制！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	else
	{
		// $setsqlarr['addtime']=time();
		// $pid=inserttable(table('resume_tmp'),$setsqlarr,1);
		//$pid = $db->query("insert into qs_resume_tmp(`uid`) values(".$uid.")");
	
		$result['result']=1;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('可以创建！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
		
		
	}
}
?>