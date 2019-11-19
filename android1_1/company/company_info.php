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
	$result['result']=1;
	$result['errormsg']='';
	$count_jobs[0]=$db->get_total("SELECT COUNT(*) AS num FROM ".table('jobs')." WHERE uid='{$_SESSION['uid']}'");
	$count_jobs[1]=$db->get_total("SELECT COUNT(*) AS num FROM ".table('jobs_tmp')." WHERE uid='{$_SESSION['uid']}'");
	$count_jobs=$count_jobs[0]+$count_jobs[1];
	$count_jobs="共{$count_jobs}条";
	$count_downresume=$db->get_total("SELECT COUNT(*) AS num FROM ".table('company_down_resume')." as d WHERE  d.company_uid='{$_SESSION['uid']}'");
	$count_downresume="共{$count_downresume}条";
	$count_receivedresume=$db->get_total("SELECT COUNT(*) AS num FROM ".table('personal_jobs_apply')." AS a WHERE a.company_uid='{$_SESSION['uid']}'");
	$count_receivedresume="共{$count_receivedresume}条";
	$count_interview=$db->get_total("SELECT COUNT(*) AS num FROM ".table('company_interview')." as i  WHERE i.company_uid='{$_SESSION['uid']}'");
	$count_interview="共{$count_interview}条";
	$count_favorites=$db->get_total("SELECT COUNT(*) AS num FROM ".table('company_favorites')." AS f  WHERE f.company_uid='{$_SESSION['uid']}'");
	$count_favorites="共{$count_favorites}条";
	$points = $db->query("select `points` from ".table('members_points')." where uid=".intval($_SESSION['uid']));
	$points = $db->fetch_array($points);
	$setmeal = $db->query("select `setmeal_id`,`setmeal_name` from ".table('members_setmeal')." where uid=".intval($_SESSION['uid'])); 
	$setmeal = $db->fetch_array($setmeal);
	$list=array('username'=>$_SESSION['username'],'count_jobs'=>$count_jobs,'count_downresume'=>$count_downresume,'count_receivedresume'=>$count_receivedresume,'count_interview'=>$count_interview,'count_favorites'=>$count_favorites,'operation_mode'=>$_CFG['operation_mode'],'points'=>$points['points'],'setmeal_id'=>$setmeal['setmeal_id'],'setmeal_name'=>$setmeal['setmeal_name']);
	$list=array_map('export_mystrip_tags',$list);
	
	$result['list']=android_iconv_utf8_array($list);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);	
}
?>