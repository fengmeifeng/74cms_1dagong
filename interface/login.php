<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$username=isset($aset['username'])?trim($aset['username']):"";
	$password=isset($aset['userpwd'])?trim($aset['userpwd']):"";
	$username=addslashes($username);
	$password=addslashes($password);
	// echo $username;exit;
	$username=iconv("utf-8",QISHI_DBCHARSET,$username);
	// echo $username;exit;
	$password=iconv("utf-8",QISHI_DBCHARSET,$password);
	if (empty($username) || empty($password))
	{
	$result['code']=-1;
	$result['errormsg']=android_iconv_utf8('请填写用户名和密码');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	/*$account_type=1;
	if (preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$username))
	{
	$account_type=2;
	}
	elseif (preg_match("/^(13|15|18)\d{9}$/",$username))
	{
	$account_type=3;
	}*/
	if (user_login($username,$password))
	{
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=array('uid'=>$_SESSION['uid'],'username'=>$_SESSION['username'],'utype'=>$_SESSION['utype']);
	$jsonencode = android_iconv_utf8_array($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	else
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('用户名或密码错误');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
?>