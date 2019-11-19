<?php
require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
	$username=isset($aset['username'])?trim($aset['username']):"";
	$password=isset($aset['userpwd'])?trim($aset['userpwd']):"";
	$username=addslashes($username);
	$password=addslashes($password);
	$username=iconv("utf-8",QISHI_DBCHARSET,$username);
	$password=iconv("utf-8",QISHI_DBCHARSET,$password);
	if (empty($username) || empty($password))
	{
	$result['result']=0;
	$result['errormsg']=android_iconv_utf8('请填写用户名和密码');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	$account_type=1;
	if (preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$username))
	{
	$account_type=2;
	}
	elseif (preg_match("/^(13|15|18)\d{9}$/",$username))
	{
	$account_type=3;
	}
	if (!user_login($username,$password))
	{
	$result['result']=0;
	$result['errormsg']=android_iconv_utf8('用户名或密码错误');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
?>