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
	updatetable(table('resume'),array("entrust"=>0)," id='".intval($resumeID)."' AND uid='".intval($userid)."'");
	//echo date('Y-m-d H:i:s',1438583758);exit;
	if($db->query("delete from ".table("resume_entrust")." where id=".$resumeID." and  uid =".$userid."")){
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=array('userid'=>$userid,'resumeID'=>$resumeID);
	$jsonencode = android_iconv_utf8_array($result);
	$jsonencode = urldecode(json_encode($result));
	//exit($jsonencode);
	echo urldecode($jsonencode);
	}else{
	$result['code']=-1;
	$result['errormsg']=android_iconv_utf8('取消委任投递失败');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
?>