<?php
 /*
 * 74cms WAP
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'reg';
$smarty->caching = false;
if ($act == 'reg')
{
	if ($_CFG['closereg']=='1')WapShowMsg("网站暂停会员注册，请稍后再次尝试！",1);
	$smarty->display("wap/wap_reg.html");
}
elseif ($act=='form')
{
	if ($_CFG['closereg']=='1')WapShowMsg("网站暂停会员注册，请稍后再次尝试！",1);
	if (intval($_GET['type'])==0)WapShowMsg("请选择注册类型！",1);
	if(intval($_GET['type'])>2){
		WapShowMsg("会员类型不正确，请重新选择！",1);
	}
	$smarty->assign('type',$_GET['type']);
	$captcha=get_cache('captcha');
	$smarty->assign('verify_userreg',$captcha['verify_userreg']);
	$smarty->display('wap/reg_form.html');
}
elseif ($act == 'do_reg')
{
	require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
	require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	require_once(QISHI_ROOT_PATH.'include/fun_user.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$username = isset($_POST['username'])?trim($_POST['username']):"";
	$password = isset($_POST['password'])?trim($_POST['password']):"";
	$member_type =intval($_POST['utype']);
	$email = isset($_POST['email'])?trim($_POST['email']):"";
	if($member_type =='1'){
		//echo "企业注册";exit;
		//------销售经理
		$xs_user = $_POST['xs_user'];
		$companyname=isset($_POST['companyname'])?trim($_POST['companyname']):exit("err");
		//----销售经理
		//-----地区
		$district=isset($_POST['district'])?intval($_POST['district']):exit("err");
		$sdistrict=isset($_POST['sdistrict'])?intval($_POST['sdistrict']):exit("err");
		$district_cn=isset($_POST['district_cn'])?trim($_POST['district_cn']):exit("err");
		//-----地区结束
		if (empty($username)||empty($password) ||empty($member_type)||empty($email) ||empty($companyname) || empty($district_cn))
		{
		$err="信息不完整";
		}
		elseif (strlen($username)<6 || strlen($username)>18)
		{
		$err="用户名长度为6-18个字符";
		}
		elseif (strlen($password)<6 || strlen($password)>18)
		{
		$err="密码长度为6-18个字符";
		}
		elseif ($password<>$_POST['password2'])
		{
		$err="两次输入的密码不同";
		}
		elseif (empty($email) || !ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$email))
		{
		$err="电子邮箱格式错误";
		}
		if (get_user_inusername($username))
		{
		$err="用户名已经存在";
		}
		if (get_user_companyname($companyname))
		{
		$err="企业名称已经注册过";
		}
		if (get_user_inemail($email))
		{
		$err="电子邮箱已经存在";
		}
		
		if ($err)
		{
		$smarty->assign('err_1',$err);
		$smarty->assign('type',$member_type);
		//$smarty->display("wap/reg_form.html");
		$smarty->display("wap/wap_reg.html");
		exit();
		}
	}elseif($member_type =='2'){//---个人
		
		//echo "个人注册";exit;
		$password=substr($username,-4);
		$sex=isset($_POST['sex'])?intval($_POST['sex']):exit("err");
		$sex_cn=isset($_POST['sex_cn'])?trim($_POST['sex_cn']):exit("err");
		$realname=isset($_POST['realname'])?trim($_POST['realname']):exit("err");
		$birthday=isset($_POST['birthday'])?intval($_POST['birthday']):exit("err");
		$residence=isset($_POST['residence'])?$_POST['residence']:exit("err");
		$residence_cn=isset($_POST['residence_cn'])?trim($_POST['residence_cn']):exit("err");
		if (empty($username)||empty($password)||empty($sex_cn)||empty($realname) || empty($birthday) ||empty($residence_cn))
		{
		$err="信息不完整";
		}
		elseif (!preg_match('/^1[34578][0-9]{9}$/',$username))
		{
		$err="填写的手机号码格式不正确";
		}
		if (get_user_inusername($username))
		{
		$err="用户名已经存在";
		}	
		if ($err)
		{
		$smarty->assign('err',$err);
		$smarty->assign('type',$member_type);
		$smarty->display("wap/wap_reg.html");
		exit();
		}	
		
	}
	
	$register=user_register($username,$password,$member_type,$email,true,$xs_user,$district_cn,$district,$sdistrict,$sex,$sex_cn,$realname,$birthday,$residence,$residence_cn,$companyname);
	//$register=user_register($username,$password,$member_type,$email,$mobile);
	if ($register>0)
	{
		$login_js=wap_user_login($username,$password);
		$mailconfig=get_cache('mailconfig');
		if ($mailconfig['set_reg']=="1")
		{
		dfopen($_CFG['website_dir']."plus/asyn_mail.php?uid=".$_SESSION['uid']."&key=".asyn_userkey($_SESSION['uid'])."&sendemail=".$email."&sendusername=".$username."&sendpassword=".$password."&act=reg");
		}
		if ($login_js)
		{
			header("location:".$login_js['qs_login']);
		}
	}
	else
	{
	header("location:wap/wap_reg.php");
	}
}
?>