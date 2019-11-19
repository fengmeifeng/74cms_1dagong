<?php
/*
 * 74cms 企业会员中心ajax弹出框
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__) . '/shenhe_common.php');
if($act=="user_email"){
	$tpl='../../templates/'.$_CFG['template_dir']."member_shenhe/ajax_authenticate_email_box.htm";
	$contents=file_get_contents($tpl);
	$_SESSION['send_email_key']=mt_rand(100000, 999999);
	$contents=str_replace('{#$email#}',$user["email"],$contents);
	$contents=str_replace('{#$send_email_key#}',$_SESSION['send_email_key'],$contents);
	exit($contents);
}	
elseif($act=="user_mobile"){
	$tpl='../../templates/'.$_CFG['template_dir']."member_shenhe/ajax_authenticate_mobile_box.htm";
	$contents=file_get_contents($tpl);
	$_SESSION['send_mobile_key']=mt_rand(100000, 999999);
	$contents=str_replace('{#$mobile#}',$user["mobile"],$contents);
	$contents=str_replace('{#$send_mobile_key#}',$_SESSION['send_mobile_key'],$contents);
	exit($contents);
}
elseif($act=="old_mobile"){
	$tpl='../../templates/'.$_CFG['template_dir']."member_shenhe/ajax_authenticate_old_mobile_box.htm";
	$contents=file_get_contents($tpl);
	$_SESSION['send_mobile_key']=mt_rand(100000, 999999);
	$user["hid_mobile"] = substr($user["mobile"],0,3)."*****".substr($user["mobile"],7,4);
	$contents=str_replace('{#$mobile#}',$user["mobile"],$contents);
	$contents=str_replace('{#$hid_mobile#}',$user["hid_mobile"],$contents);
	$contents=str_replace('{#$send_mobile_key#}',$_SESSION['send_mobile_key'],$contents);
	exit($contents);
}
elseif($act=="edit_mobile"){
	$tpl='../../templates/'.$_CFG['template_dir']."member_shenhe/ajax_authenticate_edit_mobile_box.htm";
	$contents=file_get_contents($tpl);
	$_SESSION['send_mobile_key']=mt_rand(100000, 999999);
	$contents=str_replace('{#$send_mobile_key#}',$_SESSION['send_mobile_key'],$contents);
	exit($contents);
}
if($act=="company_profile_save_succeed"){
	$tpl='../../templates/'.$_CFG['template_dir']."member_shenhe/ajax_companyprofile_save_succeed_box.htm";
	$contents=file_get_contents($tpl);
	if($company_profile['map_open'] == '1'){
		$save_msg = '您接下来就可以发布职位啦！ <br />';
		$opt_button = '<div class="but130cheng " onclick="javascript:location.href=\'shenhe_jobs.php?act=addjobs\'">发布职位</div>';
	}else{ 
		$save_msg = '';
		$opt_button = '<div class="but130hui but_right" onclick="javascript:location.href=\'shenhe_jobs.php?act=addjobs\'">发布行业名企</div><div class="but130hui" style="margin-left:10px;" onclick="javascript:location.href=\'/user/shenhe/shenhe_company.php?act=shenhe_company_list&audit=\'">返回列表页</div>';
	}
	$contents=str_replace('{#$save_msg#}',$save_msg,$contents);
	$contents=str_replace('{#$opt_button#}',$opt_button,$contents);
	exit($contents);
}
unset($smarty);
?>