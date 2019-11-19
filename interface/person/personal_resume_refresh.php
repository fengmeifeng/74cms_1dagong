<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['userid'];exit;
	$resumeID=isset($aset['resumeID'])?intval($aset['resumeID']):"";
	$resumeID=addslashes($resumeID);
	$resumeID=iconv("utf-8",QISHI_DBCHARSET,$resumeID);
	//echo $aset['did'];exit;
	if (empty($resumeID))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该记录');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	function update_resume($pid,$uid)
	{
		global $db;
		$time=time();
		$uid=intval($uid);	
		if (!$db->query("update  ".table('resume')."  SET refreshtime='{$time}'  WHERE id='{$pid}' AND uid='{$uid}'")) return false;
		if (!$db->query("update  ".table('resume_search_rtime')."  SET refreshtime='{$time}'  WHERE id='{$pid}' AND uid='{$uid}'")) return false;
		if (!$db->query("update  ".table('resume_search_key')."  SET refreshtime='{$time}'  WHERE id='{$pid}' AND uid='{$uid}'")) return false;
		write_memberslog($_SESSION['uid'],2,1102,$_SESSION['username'],"刷新了id为{$pid}的简历");
	
		//write_refresh_log($_SESSION['uid'],2001);		
		return true;
	}
	//echo date('Y-m-d H:i:s',1438583758);exit;
	if(update_resume($resumeID,$userid)){
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=array('userid'=>$userid,'resumeID'=>$resumeID);
	$jsonencode = android_iconv_utf8_array($result);
	$jsonencode = urldecode(json_encode($result));
	//exit($jsonencode);
	echo urldecode($jsonencode);
	}else{
	$result['code']=-1;
	$result['errormsg']=android_iconv_utf8('刷新失败');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
?>