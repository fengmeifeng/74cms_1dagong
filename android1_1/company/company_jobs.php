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
	$jobtype=intval($aset['jobtype']);
	$wheresql=" WHERE uid='{$_SESSION['uid']}' ";
	$orderby=" order by refreshtime desc";
	if($jobtype===1)
	{
	$tabletype="jobs";
	}
	elseif($jobtype===2)
	{
	$tabletype="jobs_tmp";
	}
	else
	{
	$tabletype="all";
	}
	if ($tabletype=="all")
	{
	$total_sql="SELECT COUNT(*) AS num FROM ".table('jobs').$wheresql." UNION ALL  SELECT COUNT(*) AS num FROM ".table('jobs_tmp').$wheresql;
	}
	else
	{
	$total_sql="SELECT COUNT(*) AS num FROM ".table($tabletype).$wheresql;
	}
	if ($tabletype=="all")
	{
	$sql="SELECT * FROM ".table('jobs').$wheresql." UNION ALL SELECT * FROM ".table('jobs_tmp').$wheresql.$orderby;
	}
	else
	{
	$sql="SELECT * FROM ".table($tabletype).$wheresql.$orderby;
	}
	//$a=var_export($_POST, true);
	//@file_put_contents('1.txt', $sql, LOCK_EX);
	$list=get_jobs($offset,$aset['row'],$sql,true);
	$androidresult['result']=1;
	$androidresult['errormsg']='';
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['list']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
}
?>