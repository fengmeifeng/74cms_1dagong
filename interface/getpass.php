<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$oldpass=isset($aset['oldpass'])?trim($aset['oldpass']):"";
	$oldpass=addslashes($oldpass);
	$oldpass=iconv("utf-8",QISHI_DBCHARSET,$oldpass);
	
	$newpass=isset($aset['newpass'])?trim($aset['newpass']):"";
	$newpass=addslashes($newpass);
	$newpass=iconv("utf-8",QISHI_DBCHARSET,$newpass);
	
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['oldpass'];exit;
	if (empty($userid) || empty($oldpass) || empty($newpass))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('请填写完整信息');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	$row = $db->getone("SELECT * FROM ".table('members')." WHERE uid='{$userid}' LIMIT 1");
	//echo $row['password'];exit;
	if(empty($row)){
	$result['code']=-2;
	$result['errormsg']=android_iconv_utf8('没有找到该用户');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	if(md5($oldpass) != $row['password'])
	{
	$result['code']=-1;
	$result['errormsg']=android_iconv_utf8('旧密码输入错误，请重新输入');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	$newpass=md5($newpass);
	if ($db->query( "UPDATE ".table('members')." SET password = '$newpass'  WHERE uid='".$userid."'"))
	{
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=array('userid'=>$userid,'username'=>$row['username'],'utype'=>$row['utype']);
	$jsonencode = android_iconv_utf8_array($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	
	}else{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('密码修改错误');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
?>