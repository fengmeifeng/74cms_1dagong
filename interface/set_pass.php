<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$userid = $_GET['userid'];
	$verify_code=isset($_GET['verify_code'])?trim($_GET['verify_code']):"0";
	if($verify_code=='0'){
		$result['code']=0;
		$result['errormsg']=android_iconv_utf8('手机验证码错误');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	$pwd01=$_GET['pwd01'];
	$pwd02=$_GET['pwd02'];
	if($pwd01!=$pwd02){
		$result['code']=-1;
		$result['errormsg']=android_iconv_utf8('两次输入的密码不相同');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);		
	}
	$row = $db->getone("SELECT * FROM ".table('members')." WHERE username='{$userid}' LIMIT 1");
	//echo $row['password'];exit;
	if(empty($row)){
	$result['code']=-2;
	$result['errormsg']=android_iconv_utf8('没有找到该用户');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}	
	$newpass=md5($pwd01);
	if ($db->query( "UPDATE ".table('members')." SET password = '$newpass'  WHERE username='".$userid."'"))
	{
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=array('userid'=>$userid,'username'=>$row['username'],'utype'=>$row['utype']);
	$jsonencode = android_iconv_utf8_array($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	
	}else{
	$result['code']=-3;
	$result['errormsg']=android_iconv_utf8('密码修改错误');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}	
	
	
?>