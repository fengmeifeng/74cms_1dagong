<?php
/*
 * 74cms 猎头会员中心
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/shenhe_common.php');
$smarty->assign('leftmenu',"recruitment");
if ($act=='shenhe_company_list')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$perpage=20;
	//$joinsql=" LEFT JOIN  ".table('company_profile')." as c ON m.uid=c.uid ";//---
	$joinsql=" LEFT JOIN ".table('members')." AS m ON c.uid=m.uid  LEFT JOIN ".table('members_setmeal')." AS p ON c.uid=p.uid";
	$wheresql=" WHERE  m.utype=1 ";
	$_GET['audit']<>""? $wheresql.=" and c.audit = ".intval($_GET['audit']):'';
	$settr=intval($_GET['settr']);
/*	if($settr>0)
	{
	$settr_val=strtotime("-{$settr} day");
	$wheresql.=" AND d.down_addtime>{$settr_val} ";
	}*/
	$total_sql="SELECT COUNT(*) AS num FROM ".table('company_profile')." as c ".$joinsql.$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$certificate_dir="/data/certificate/";
	//echo "<pre>";print_r(get_company_list($offset,$perpage,$joinsql.$wheresql));exit;
	$smarty->assign('certificate_dir',$certificate_dir);
	
	$smarty->assign('title','企业会员审核 - 审核员中心 - '.$_CFG['site_name']);
	$smarty->assign('act',$act);
	$smarty->assign('list',get_company_list($offset,$perpage,$joinsql.$wheresql));
	$smarty->assign('page',$page->show(3));
	//echo $wheresql;exit;
	//echo "<pre>";print_r(get_company_list($offset,$perpage,$joinsql.$wheresql));exit;
	$smarty->display('member_shenhe/shenhe_company_list.htm');
}
elseif ($act=='del_company')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择企业会员！",1);
	$uid =intval($_REQUEST['uid']);
	if ($n=del_company($yid,$uid))
	{
	showmsg("删除成功！共删除 {$n} 行",2);
	}
	else
	{
	showmsg("删除失败！",0);
	}
}
elseif ($act=='shenhe_company')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择企业会员！",1);
	if ($n=shenhe_company($yid,$_SESSION['uid']))
	{
	showmsg("审核成功！共审核 {$n} 行",2);
	}
	else
	{
	showmsg("审核失败！",0);
	}
}
//----审核员修改企业会员信息
if ($act=='edit_company')
{
	$company_profile=get_company_one(intval($_GET['y_id']),intval($_GET['uid']));
	if (empty($company_profile)) showmsg("参数错误！",1);
	if($company_profile['age']){
		$jobs_age = explode("-", $company_profile['age']);
		$company_profile['minage'] = $jobs_age[0];
		$company_profile['maxage'] = $jobs_age[1];
	}
	$smarty->assign('user',$user);
	$smarty->assign('title','修改企业会员 - 审核员员中心 - '.$_CFG['site_name']);
	$smarty->assign('points_total',get_user_points(intval($_GET['uid'])));
	$smarty->assign('points',get_cache('points_rule'));
	$smarty->assign('company_profile',$company_profile);
	$smarty->display('member_shenhe/shenhe_company_edit.htm');
}
elseif ($act=='shenhe_company_profile_save')
{

	$company_profile=get_company_one(intval($_POST['id']),intval($_POST['uid']));
	//$uid=intval($_REQUEST['uid']);
	$setsqlarr['uid']=intval($_POST['uid']);
	$setsqlarr['companyname']=trim($_POST['companyname'])?utf8_to_gbk(trim($_POST['companyname'])):exit('您没有输入企业名称！');
	check_word($_CFG['filter'],$setsqlarr['companyname'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['nature']=trim($_POST['nature'])?intval($_POST['nature']):exit('您选择企业性质！');
	$setsqlarr['nature_cn']=utf8_to_gbk(trim($_POST['nature_cn']));
	$setsqlarr['trade']=trim($_POST['trade'])?intval($_POST['trade']):exit('您选择所属行业！');
	$setsqlarr['trade_cn']=utf8_to_gbk(trim($_POST['trade_cn']));
	$setsqlarr['district']=intval($_POST['district'])>0?intval($_POST['district']):exit('您选择所属地区！');
	$setsqlarr['sdistrict']=intval($_POST['sdistrict']);
	$setsqlarr['district_cn']=utf8_to_gbk(trim($_POST['district_cn']));
	if (intval($_POST['street'])>0)
	{
	$setsqlarr['street']=intval($_POST['street']);
	$setsqlarr['street_cn']=utf8_to_gbk(trim($_POST['street_cn']));
	}
	$setsqlarr['scale']=trim($_POST['scale'])?utf8_to_gbk(trim($_POST['scale'])):exit('您选择公司规模！');
	$setsqlarr['scale_cn']=utf8_to_gbk(trim($_POST['scale_cn']));
	$setsqlarr['registered']=utf8_to_gbk(trim($_POST['registered']));
	$setsqlarr['currency']=utf8_to_gbk(trim($_POST['currency']));
	$setsqlarr['address']=trim($_POST['address'])?utf8_to_gbk(trim($_POST['address'])):exit('请填写通讯地址！');
	check_word($_CFG['filter'],$setsqlarr['address'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['contact']=trim($_POST['contact'])?utf8_to_gbk(trim($_POST['contact'])):exit('请填写联系人！');
	check_word($_CFG['filter'],$setsqlarr['contact'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['telephone']=trim($_POST['telephone'])?utf8_to_gbk(trim($_POST['telephone'])):exit('请填写联系电话！');
	check_word($_CFG['filter'],$setsqlarr['telephone'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['email']=trim($_POST['email'])?utf8_to_gbk(trim($_POST['email'])):exit('请填写联系邮箱！');
	check_word($_CFG['filter'],$setsqlarr['email'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['website']=utf8_to_gbk(trim($_POST['website']));
	check_word($_CFG['filter'],$setsqlarr['website'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['contents']=trim($_POST['contents'])?utf8_to_gbk(trim($_POST['contents'])):exit('请填写公司简介！');
	check_word($_CFG['filter'],$setsqlarr['contents'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['yellowpages']=intval($_POST['yellowpages']);
	
	
	$setsqlarr['contact_show']=intval($_POST['contact_show']);
	$setsqlarr['email_show']=intval($_POST['email_show']);
	$setsqlarr['telephone_show']=intval($_POST['telephone_show']);
	$setsqlarr['address_show']=intval($_POST['address_show']);
	
	
	if ($_CFG['company_repeat']=="0")
	{
		$info=$db->getone("SELECT uid FROM ".table('company_profile')." WHERE companyname ='{$setsqlarr['companyname']}' AND uid<>'{$_POST['uid']}' LIMIT 1");
		if(!empty($info))
		{
			exit("{$setsqlarr['companyname']}已经存在，同公司信息不能重复注册");
		}
	}
	
	if ($company_profile)
	{
			$_CFG['audit_edit_com']<>"-1"?$setsqlarr['audit']=intval($_CFG['audit_edit_com']):'';
			if (updatetable(table('company_profile'), $setsqlarr," uid='{$setsqlarr['uid']}'"))
			{
				$jobarr['companyname']=$setsqlarr['companyname'];
				$jobarr['trade']=$setsqlarr['trade'];
				$jobarr['trade_cn']=$setsqlarr['trade_cn'];
				$jobarr['scale']=$setsqlarr['scale'];
				$jobarr['scale_cn']=$setsqlarr['scale_cn'];
				$jobarr['street']=$setsqlarr['street'];
				$jobarr['street_cn']=$setsqlarr['street_cn'];			
				if (!updatetable(table('jobs'),$jobarr," uid=".$setsqlarr['uid']."")) exit('修改公司名称出错！');
				if (!updatetable(table('jobs_tmp'),$jobarr," uid=".$setsqlarr['uid']."")) exit('修改公司名称出错！');
				if (!updatetable(table('jobfair_exhibitors'),array('companyname'=>$setsqlarr['companyname'])," uid=".$setsqlarr['uid']."")) exit('修改公司名称出错！');
				$soarray['trade']=$jobarr['trade'];
				$soarray['scale']=$jobarr['scale'];
				$soarray['street']=$setsqlarr['street'];
				updatetable(table('jobs_search_scale'),$soarray," uid=".$setsqlarr['uid']."");
				updatetable(table('jobs_search_wage'),$soarray," uid=".$setsqlarr['uid']."");
				updatetable(table('jobs_search_rtime'),$soarray," uid=".$setsqlarr['uid']."");
				updatetable(table('jobs_search_stickrtime'),$soarray," uid=".$setsqlarr['uid']."");
				updatetable(table('jobs_search_hot'),$soarray," uid=".$setsqlarr['uid']."");
				updatetable(table('jobs_search_key'),$soarray," uid=".$setsqlarr['uid']."");
				unset($setsqlarr);
				write_memberslog($_SESSION['uid'],$_SESSION['utype'],8001,$_SESSION['username'],"修改企业资料");
				exit("1");
				//showmsg("修改成功！",2);
			}
			else
			{
				exit("保存失败！");
			}
	}
	else
	{
			$setsqlarr['audit']=intval($_CFG['audit_add_com']);
			$setsqlarr['addtime']=$timestamp;
			$setsqlarr['refreshtime']=$timestamp;
			if (inserttable(table('company_profile'),$setsqlarr))
			{
				write_memberslog($_SESSION['uid'],$_SESSION['utype'],8001,$_SESSION['username'],"完善企业资料");
				exit("1");
			}
			else
			{
				exit("保存失败！");
			}
	}
}
unset($smarty);
?>