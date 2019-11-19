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
	//echo $aset['resumeID'];exit;
	$display=isset($aset['display'])?intval($aset['display']):"";
	$display=addslashes($display);
	$display=iconv("utf-8",QISHI_DBCHARSET,$display);
	if (empty($resumeID))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该简历');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	//------------------fffff执行
	$setsqlarr['display']=$display;
	//$setsqlarr['display_name']=intval($_POST['display_name']);
	//$setsqlarr['photo_display']=intval($_POST['photo_display']);
	$wheresql=" uid='".$userid."' ";
	!updatetable(table('resume'),$setsqlarr," uid='{$userid}' AND  id='{$resumeID}'");
	$setsqlarrdisplay['display']=$display;
	!updatetable(table('resume_search_key'),$setsqlarrdisplay," uid='{$userid}' AND  id='{$resumeID}'");
	!updatetable(table('resume_search_rtime'),$setsqlarrdisplay," uid='{$userid}' AND  id='{$resumeID}'");
	!updatetable(table('resume_search_tag'),$setsqlarrdisplay," uid='{$userid}' AND  id='{$resumeID}'");
	//write_memberslog($_SESSION['uid'],2,1104,$_SESSION['username'],"设置简历隐私({$resumeID})");
	///------------ffffff
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=array('userid'=>$userid,'resumeID'=>$resumeID);
	$jsonencode = android_iconv_utf8_array($result);
	$jsonencode = urldecode(json_encode($result));
	//exit($jsonencode);
	echo urldecode($jsonencode);
	
?>