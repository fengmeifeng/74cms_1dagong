<?php
//找回密码接口 By Z
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
// echo $dopost;exit;
// echo '111';exit; 
$dopost=$_GET['dopost'];	
if(!isset($dopost)) $dopost = 'step1';

if($dopost=='step1'){
	//模版---
	// echo 'okjinru';exit;
	$smarty->display("/user/zhaohuimima_qishi.htm");
	exit();
}if($dopost=='step2'){
	// echo 'step2ok';exit; 
	require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	// require_once(dirname(__FILE__)."/../config.php");
	require_once(QISHI_ROOT_PATH."/include/bb_duanxin.class.php"); 	//短信类
	if(!empty($_POST['sphone'])){
		// echo $_POST['sphone'];exit;
		if($_POST['sphone']!==""){
			$sphone=$_POST['sphone'];
			$user = $db->getone("SELECT * FROM `qs_members` WHERE username LIKE '$sphone' and utype=2 ");
			// var_dump($user);exit;
			if(!empty($user)){
				//echo "<pre>";print_r($user);exit;
				$mima=rand(100000,999999);	$pwd=MD5($mima);
				$query1 = "UPDATE `qs_members` SET password='$pwd' where username='".$sphone."' ";
				if($db->query($query1)){
				require_once(QISHI_ROOT_PATH.'user/duanxin_zhaohuimima.php');
				
					showmsg("密码修改成功！密码为随机6位数，稍后密码会以短信的方式发送给您！",2);
					//showmsg('密码修改成功！密码为随机6位数，稍后密码会以短信的方式发送给您！ ', '/home/', 0,5000);
					exit();
				}else{
					showmsg('密码修改失败！ ', '2');
					exit();
				}
				
			}else{
				showmsg('没有找到您的账户，请重试！ ', '2');
				exit();
			}
			
		
		}else{
			showmsg('手机号不能为空！ ', '2');
			exit();
		}
	}
	
}