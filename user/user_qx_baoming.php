<?php
 /*
 * 74cms 会员注册
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
$alias="QS_login";
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/fun_user.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$smarty->cache = false;
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'reg';
if ($act=='reg')
{
	
	if ($_CFG['closereg']=='1')showmsg("网站暂停会员注册，请稍后再次尝试！",1);
	if(intval($_GET['type'])==3 && $_PLUG['hunter']['p_install']==1){
		showmsg("管理员已关闭猎头模块,禁止注册！",1);
	}
	if(intval($_GET['type'])==4 && $_PLUG['train']['p_install']==1){
		showmsg("管理员已关闭培训模块,禁止注册！",1);
	}
	//----fff----2015-7-28---培训会员注册
	if(intval($_GET['member_type'])==4){
		$smarty->assign('title','会员注册 - '.$_CFG['site_name']);
		$captcha=get_cache('captcha');
		$smarty->assign('verify_userreg',$captcha['verify_userreg']);
		$smarty->display('user/reg_train.htm');
		exit;
	}
	//------ffff
	//-------审核员开通注册模式
	if(intval($_GET['type'])==5 && $_PLUG['shenhe']['p_install']==1){
		showmsg("管理员已关闭审核员模块,禁止注册！",1);
	}
	$smarty->assign('title','会员注册 - '.$_CFG['site_name']);
	$captcha=get_cache('captcha');
	$smarty->assign('verify_userreg',$captcha['verify_userreg']);
	$smarty->display('user/reg.htm');
}
unset($smarty);
?>