<?php
//企业找回密码--ffff
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
// echo $dopost;exit;
// echo '111';exit; 
$dopost=$_GET['dopost'];	
if(!isset($dopost)) $dopost = 'step1';

if($dopost=='step1'){
	//模版---
	// echo 'okjinru';exit;
	$smarty->display("/user/getpass_c.htm");
	exit();
}if($dopost=='step2'){
	// echo 'step2ok';exit; 
	require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	// require_once(dirname(__FILE__)."/../config.php");
	//require_once(QISHI_ROOT_PATH."/include/bb_duanxin.class.php"); 	//短信类
		if(!empty($_POST['email'])){
			$email=trim($_POST['email']);
			//--ffff验证邮箱格式
			$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
			if ( preg_match( $pattern, $email ) )
			{
			//---fff
			$user = $db->getone("SELECT * FROM `qs_members` WHERE email = '$email' and utype=1 ");
			//var_dump($user);exit;
			if(!empty($user)){
				//echo "<pre>";print_r($user);exit;
				//$mima=mt_rand(100000,999999);
				$mima=getRandomString(6);
				$pwd=MD5($mima);
				$query1 = "UPDATE `qs_members` SET password='$pwd' where email='".$email."' ";
				if($db->query($query1)){
				require_once(dirname(__FILE__).'/../include/common.inc.php');
					if ($_SESSION['sendemail_time'] && (time()-$_SESSION['sendemail_time'])<10)
					{
					exit("请60秒后再进行找回！");
					}
			
					if (smtp_mail($email,"{$_CFG['site_name']}邮件找回密码","{$QISHI['site_name']}提醒您：<br>您正在进行邮箱找回密码，你的新密码为:<strong>".$mima."</strong>"))
					{//---发送成功
						showmsg("密码修改成功！密码为随机6位数，稍后密码会以邮箱的方式发送给您！",2);
						//showmsg('密码修改成功！密码为随机6位数，稍后密码会以短信的方式发送给您！ ', '/home/', 0,5000);
						exit();
					}
					else
					{
					exit("邮箱配置出错，请联系网站管理员");
					}
					
				}else{
					showmsg('密码修改失败！ ', '2');
					exit();
				}
				
			}else{
				showmsg('没有找到您的账户，请重试！ ', '2');
				exit();
			}
			
			}else{
				showmsg('邮箱格式不对,请输入正确的邮箱！ ', '2');
				exit();
			}
		}else{
			showmsg('邮箱不能为空,请输入邮箱！ ', '2');
			exit();
		}
	
}