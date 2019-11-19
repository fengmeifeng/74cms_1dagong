<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
	$result['code']=1;
	$result['errormsg']='';
	$result[0]=$db->get_total("SELECT COUNT(*) AS num FROM ".table('personal_jobs_apply')." WHERE personal_uid='{$aset['uid']}'");//已申请职位
	$result[1]=$db->get_total("SELECT COUNT(*) AS num FROM ".table('company_interview')." WHERE resume_uid='{$aset['uid']}'");//面试邀请
	//echo "SELECT COUNT(*) AS num FROM ".table('view_resume')." WHERE uid='{$aset['uid']}'";exit;
	$sql=" select id from ".table('resume')." where uid = '{$aset['uid']}'";
	$res=$db->getall($sql);
	//echo "<pre>";print_r($res);exit;
	$list=array();
	foreach($res as $v)
	{
		$list[]=$v['id'];
	}
	$val=implode(',',$list);
	//echo $val;echo "<pre>";print_r($list);exit;
	if($val){
		$result[2]=$db->get_total("SELECT COUNT(*) AS num FROM ".table('view_resume')." WHERE resumeid in ({$val})");//谁在关注我	
	}else{
		$result[2]=0;
		}
	//$result[2]=$db->get_total("SELECT COUNT(*) AS num FROM ".table('view_resume')." WHERE uid='{$aset['uid']}'");//谁在关注我
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);	

?>