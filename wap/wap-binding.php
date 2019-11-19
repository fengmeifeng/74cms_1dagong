<?php
define('IN_QISHI', true);
$alias="QS_login";
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/fun_user.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$smarty->caching = false;
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'binding';
if($act == 'binding'){
	$smarty->assign("from",$_GET['from']);
	$smarty->display('wap/wap-binding.html');
}elseif($act == 'binding_save'){
	$fromUsername = trim($_POST['from']);
	if(empty($fromUsername)){
		$smarty->assign("from",$_POST['from']);
		$smarty->assign('err',"绑定失败！请返回微信重新绑定");
		$smarty->display('wap/wap-binding.html');
		die;
	}
	$username = trim($_POST['username']);
	if(empty($username)){
		$smarty->assign("from",$_POST['from']);
		$smarty->assign('err',"请输入用户名");
		$smarty->display('wap/wap-binding.html');
		die;
	}
	$password = trim($_POST['password']);
	if(empty($password)){
		$smarty->assign("from",$_POST['from']);
		$smarty->assign('err',"请输入密码");
		$smarty->display('wap/wap-binding.html');
		die;
	}
	
	$usinfo = $db->getone("select * from ".table('members')." where username = '{$username}' LIMIT 1");
	
					if(!empty($usinfo)){
						if($usinfo['weixin_openid'] <> ""){
							$smarty->assign("from",$_POST['from']);
							$smarty->assign('err',"您已绑定了微信帐号");
							$smarty->display('wap/wap-binding.html');
							die;
						}
						$success = false;
						$pwd_hash=$usinfo['pwd_hash'];
						$usname=$usinfo['username'];
						// $pwd=md5(md5($password).$pwd_hash.$QS_pwdhash);
						$pwd=md5($password);
						if ($usinfo['password']==$pwd)
						{
							$success == true;
							$db->query("update ".table('members')." set `weixin_openid`='".$fromUsername."',bindingtime=".time()." where uid=".$usinfo['uid']);
							require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
							
							if (wap_user_login($username,$password))
										{	
												if(!empty($_SESSION['url'])){
													header("location:".$_SESSION['url']);
													unset($_SESSION['url']);
													die;
												}
											$smarty->display('wap/wap-binding-success.html');
											die;
										}
						}
						else
						{
							$success = false;
						}
						if($success == false){
								$smarty->assign("from",$_POST['from']);
								$smarty->assign('err',"用户名或密码错误!");
								$smarty->display('wap/wap-binding.html');
						}
					}else{
							$smarty->assign("from",$_POST['from']);
							$smarty->assign('err',"用户名或密码错误!");
							$smarty->display('wap/wap-binding.html');
					}
		
}
?>