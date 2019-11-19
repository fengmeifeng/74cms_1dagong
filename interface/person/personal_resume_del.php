<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
//require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['userid'];exit;
	$resumeID=isset($aset['resumeID'])?trim($aset['resumeID']):"";
	$resumeID=addslashes($resumeID);
	$resumeID=iconv("utf-8",QISHI_DBCHARSET,$resumeID);
	//echo $aset['resumeID'];exit;
	if (empty($resumeID))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该记录');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	//删除简历
	function del_resume($uid,$aid)
	{
		global $db;
		$uid=intval($uid);
		if (!is_array($aid))$aid=array($aid);
		$sqlin=implode(",",$aid);
		if (!preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin)) return false;
		if (!$db->query("Delete from ".table('resume')." WHERE id IN ({$sqlin}) AND uid='{$uid}' ")) return false;
		//if (!$db->query("Delete from ".table('resume_tmp')." WHERE id IN ({$sqlin}) AND uid='{$uid}' ")) return false;
		if (!$db->query("Delete from ".table('resume_jobs')." WHERE pid IN ({$sqlin}) AND uid='{$uid}' ")) return false;
		if (!$db->query("Delete from ".table('resume_education')." WHERE pid IN ({$sqlin}) AND uid='{$uid}' ")) return false;
		if (!$db->query("Delete from ".table('resume_training')." WHERE pid IN ({$sqlin}) AND uid='{$uid}' ")) return false;
		if (!$db->query("Delete from ".table('resume_work')." WHERE pid IN ({$sqlin}) AND uid='{$uid}' ")) return false;
		if (!$db->query("Delete from ".table('resume_search_rtime')." WHERE id IN ({$sqlin}) AND uid='{$uid}' ")) return false;
		if (!$db->query("Delete from ".table('resume_search_key')." WHERE id IN ({$sqlin}) AND uid='{$uid}' ")) return false;
		if (!$db->query("Delete from ".table('resume_search_tag')." WHERE id IN ({$sqlin}) AND uid='{$uid}' ")) return false;
		//write_memberslog($_SESSION['uid'],2,1103,$_SESSION['username'],"通过手机客户端删除简历({$sqlin})");
		return true;
	}
	if(del_resume($userid,$resumeID)){
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=array('userid'=>$userid,'resumeID'=>$resumeID);
	$jsonencode = android_iconv_utf8_array($result);
	$jsonencode = urldecode(json_encode($result));
	//exit($jsonencode);
	echo urldecode($jsonencode);
	}else{
	$result['code']=-1;
	$result['errormsg']=android_iconv_utf8('删除失败');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
?>