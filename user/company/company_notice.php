<?php
/*
 * 74cms 企业会员中心
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/company_common.php');
$smarty->assign('leftmenu',"index");
if ($act=='notice')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$wheresql=" WHERE type_id='2' AND is_display='1'";
	$perpage=10;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('notice').$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$smarty->assign('title','公告 - 会员中心 - '.$_CFG['site_name']);
	$smarty->assign('notice',get_notice($offset, $perpage,$wheresql,30));
	if ($total_val>$perpage)$smarty->assign('page',$page->show(3));//分页符
	$smarty->display('member_company/company_notice.htm');
}
elseif ($act=='notice_show')
{
	$smarty->assign('show',get_notice_one($_GET['id']));
 	$smarty->assign('title','公告 - 会员中心 - '.$_CFG['site_name']); 
	$smarty->display('member_company/company_notice_show.htm');
}
unset($smarty);
?>