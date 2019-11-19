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
	$result['errormsg']=android_iconv_utf8("请登录个人会员中心！");
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
	$tabletype=intval($_GET['tabletype']);
	if($tabletype===1)
	{
	$table="resume";
	}
	elseif($tabletype===2)
	{
	$table="resume_tmp";
	}
	else
	{
	$table="all";
	}
	$wheresql=" WHERE uid='".$_SESSION['uid']."' ";
	if ($table=="all")
	{
	$sql="SELECT * FROM ".table('resume').$wheresql." UNION ALL SELECT * FROM ".table('resume_tmp').$wheresql;
	}
	else
	{
	$sql="SELECT * FROM ".table($table).$wheresql;
	}
	$list=get_resume_list($sql,12);	
	if (empty($list))
	{
	$list=array();
	}
	$androidresult['result']=1;
	$androidresult['errormsg']='';
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['list']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
}
?>