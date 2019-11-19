<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset=array_map('addslashes',$aset);
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
	$arr['username']=$_SESSION['username'];
	$arr['oldpassword']=trim($aset['oldpassword']);
	$arr['password']=trim($aset['password']);
	$info=edit_password($arr);
	if ($info==-1)
	{
	$result['result']=0;
	$result['errormsg']=android_iconv_utf8("旧密码输入错误！");
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	if ($info==$_SESSION['username'])
	{
			//sendemail
			$mailconfig=get_cache('mailconfig');
			if ($mailconfig['set_editpwd']=="1" && $user['email_audit']=="1")
			{
			dfopen("{$_CFG['site_domain']}{$_CFG['site_dir']}plus/asyn_mail.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=set_editpwd&newpassword={$arr['password']}");
			}
			//sendemail
			//sms
			$sms=get_cache('sms_config');
			if ($sms['open']=="1" && $sms['set_editpwd']=="1"  && $user['mobile_audit']=="1")
			{
			dfopen("{$_CFG['site_domain']}{$_CFG['site_dir']}plus/asyn_sms.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=set_editpwd&newpassword={$arr['password']}");
			}
			$result['result']=1;
			$result['errormsg']=android_iconv_utf8("密码修改成功！");
			$jsonencode = json_encode($result);
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
	}
	
}
?>