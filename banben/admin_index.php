<?php
 /*
 * 74cms 管理中心首页
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../data/config.php');
require_once(dirname(__FILE__).'/include/admin_common.inc.php');
$act=!empty($_REQUEST['act']) ? trim($_REQUEST['act']) : '';
if($act=='')
{
	$smarty->display('banben/admin_index.htm');
}
elseif($act=='top')
{
	$admininfo=get_admin_one($_SESSION['admin_name']);
	$smarty->assign('admin_rank', $admininfo['rank']);
	$smarty->assign('admin_name', $_SESSION['admin_name']);
	$smarty->display('banben/admin_top.htm');
}
elseif($act=='left')
{
	$smarty->display('banben/admin_left.htm');
}
elseif($act == 'main')
{
	
	$smarty->display('banben/admin_main.htm');
}
?>