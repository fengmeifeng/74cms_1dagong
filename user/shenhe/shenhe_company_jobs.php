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
if ($act=='sheneh_company_jobs')
{
	$audit=intval($_GET['audit']);
	$deadline=intval($_GET['deadline']);
	$jobtype=intval($_GET['jobtype']);
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$perpage=20;
	//$joinsql=" LEFT JOIN  ".table('jobs_tmp')." as r ON d.resume_id=r.id ";
	//$wheresql=" WHERE  d.user_uid='{$_SESSION['uid']}' ";
	
	$wheresql.="";
	//echo "SELECT COUNT(*) AS num FROM ".table('jobs').$wheresql;exit;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('jobs').$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$smarty->assign('title','职位审核 - 审核员中心 - '.$_CFG['site_name']);
	$smarty->assign('act',$act);
	$smarty->assign('list',get_company_jobs($offset,$perpage,$joinsql.$wheresql));
	$smarty->assign('page',$page->show(3));
	$smarty->display('member_shenhe/shenhe_company_jobs.htm');
}
elseif ($act=='sheneh_company_jobs_tmp')
{
	$audit=intval($_GET['audit']);
	$deadline=intval($_GET['deadline']);
	$jobtype=intval($_GET['jobtype']);
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$perpage=20;
	//$joinsql=" LEFT JOIN  ".table('jobs_tmp')." as r ON d.resume_id=r.id ";
	//$wheresql=" WHERE  d.user_uid='{$_SESSION['uid']}' ";
	$wheresql.=" WHERE audit = {$audit} ";
	//echo "SELECT COUNT(*) AS num FROM ".table('jobs').$wheresql;exit;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('jobs_tmp').$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$smarty->assign('title','职位审核 - 审核员中心 - '.$_CFG['site_name']);
	$smarty->assign('act',$act);
	$smarty->assign('list',get_company_jobs_tmp($offset,$perpage,$joinsql.$wheresql));
	$smarty->assign('page',$page->show(3));
	$smarty->display('member_shenhe/shenhe_company_jobs.htm');
	
}
elseif ($act=='del_jobs')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择职位！",-1);
	$audit=intval($_GET['audit']);
	$jobstype=intval($_GET['jobstype']);
	//echo $_REQUEST['y_id'];exit;
	if ($n=del_company_jobs($yid,$_SESSION['uid'],$audit,$jobstype))
	{
	showmsg("删除成功！共删除 {$n} 行",2);
	}
	else
	{
	showmsg("删除失败！",0);
	}
}
elseif ($act=='shenhe_jobs')
{	
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择职位！",-1);
	$audit=$_REQUEST['audit'];//echo $audit;exit;
	$uid=$_REQUEST['uid'];
	$deadline=intval($_GET['deadline']);
	$jobstype=$_GET['jobstype'];
	//echo $deadline;exit;
	if($yid){
	if ($n=shenhe_company_jobs($yid,$uid,$audit,$deadline,$jobstype))
	{
	showmsg("审核成功！共审核 {$n} 个职位",2);
	}
	else
	{
	showmsg("审核失败！",0);
	}}
}
elseif ($act=='refreshtime_jobs')
{
	
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择职位！",-1);
	//$audit =!empty($_REQUEST['audit'])?$_REQUEST['audit']:showmsg("你没有选择职位！",-1);
	//echo $_REQUEST['y_id'];exit;
	if ($n=refreshtime_company_jobs($yid,$_SESSION['uid']))
	{
	showmsg("刷新成功！共刷新 {$n} 个职位",2);
	}
	else
	{
	showmsg("刷新失败！",0);
	}
}
//----审核员修改企业会员发布的职位信息
elseif ($act=='edit_jobs')
{
	
	$jobs=get_company_jobs_one(intval($_GET['y_id']),intval($_GET['uid']));
	if (empty($jobs)) showmsg("参数错误！",1);
	if($jobs['age']){
		$jobs_age = explode("-", $jobs['age']);
		$jobs['minage'] = $jobs_age[0];
		$jobs['maxage'] = $jobs_age[1];
	}
	$smarty->assign('user',$user);
	$smarty->assign('title','修改职位 - 审核员员中心 - '.$_CFG['site_name']);
	$smarty->assign('points_total',get_user_points(intval($_GET['uid'])));
	$smarty->assign('points',get_cache('points_rule'));
	$smarty->assign('jobs',$jobs);
	$smarty->display('member_shenhe/shenhe_company_editjobs.htm');
}
elseif ($act=='editjobs_save')
{
	
	$id=intval($_POST['id']);
	$add_mode=trim($_POST['add_mode']);
	$days=intval($_POST['days']);
	$uid=intval($_POST['uid']);	
	/*if ($add_mode=='1')
	{
					$points_rule=get_cache('points_rule');
					$user_points=get_user_points($uid);
					$total=0;
					if($points_rule['jobs_edit']['type']=="2" && $points_rule['jobs_edit']['value']>0)
					{
					$total=$points_rule['jobs_edit']['value'];
					}
					if($points_rule['jobs_daily']['type']=="2" && $points_rule['jobs_daily']['value']>0)
					{
					$total=$total+($days*$points_rule['jobs_daily']['value']);
					}
					if ($total>$user_points)
					{
					$link[0]['text'] = "返回上一页";
					$link[0]['href'] = 'javascript:history.go(-1)';
					$link[1]['text'] = "立即充值";
					$link[1]['href'] = 'company_service.php?act=order_add';
					showmsg("你的".$_CFG['points_byname']."不足，请充值后再发布！",0,$link);
					}
	}
	elseif ($add_mode=='2')
	{
					$link[0]['text'] = "立即开通服务";
					$link[0]['href'] = 'company_service.php?act=setmeal_list';
					$link[1]['text'] = "会员中心首页";
					$link[1]['href'] = 'company_index.php?act=';
				$setmeal=get_user_setmeal($uid);
				if ($setmeal['endtime']<time() && $setmeal['endtime']<>"0")
				{					
					showmsg("您的套餐已经到期，请重新开通",1,$link);
				}
	}*/

	$setsqlarr['jobs_name']=!empty($_POST['jobs_name'])?trim($_POST['jobs_name']):showmsg('您没有填写职位名称！',1);
	check_word($_CFG['filter'],$_POST['jobs_name'])?showmsg($_CFG['filter_tips'],0):'';
	$setsqlarr['nature']=intval($_POST['nature']);
	$setsqlarr['nature_cn']=trim($_POST['nature_cn']);
	$setsqlarr['topclass']=trim($_POST['topclass']);
	$setsqlarr['category']=!empty($_POST['category'])?intval($_POST['category']):showmsg('请选择职位类别！',1);
	$setsqlarr['subclass']=trim($_POST['subclass']);
	$setsqlarr['category_cn']=trim($_POST['category_cn']);
	$setsqlarr['amount']=intval($_POST['amount']);
	$setsqlarr['district']=!empty($_POST['district'])?intval($_POST['district']):showmsg('请选择工作地区！',1);
	$setsqlarr['sdistrict']=intval($_POST['sdistrict']);
	$setsqlarr['district_cn']=trim($_POST['district_cn']);
	$setsqlarr['wage']=intval($_POST['wage'])?intval($_POST['wage']):showmsg('请选择薪资待遇！',1);		
	$setsqlarr['wage_cn']=trim($_POST['wage_cn']);
	$setsqlarr['negotiable']=intval($_POST['negotiable']);
	$setsqlarr['tag']=trim($_POST['tag']);
	$setsqlarr['sex']=intval($_POST['sex']);
	$setsqlarr['sex_cn']=trim($_POST['sex_cn']);
	$setsqlarr['education']=intval($_POST['education'])?intval($_POST['education']):showmsg('请选择学历要求！',1);		
	$setsqlarr['education_cn']=trim($_POST['education_cn']);
	$setsqlarr['experience']=intval($_POST['experience'])?intval($_POST['experience']):showmsg('请选择工作经验！',1);		
	$setsqlarr['experience_cn']=trim($_POST['experience_cn']);
	$setsqlarr['graduate']=intval($_POST['graduate']);
	$setsqlarr['age']=trim($_POST['minage'])."-".trim($_POST['maxage']);
	$setsqlarr['contents']=!empty($_POST['contents'])?trim($_POST['contents']):showmsg('您没有填写职位描述！',1);
	check_word($_CFG['filter'],$_POST['contents'])?showmsg($_CFG['filter_tips'],0):'';
	/*if ($add_mode=='1'){
		$setsqlarr['setmeal_deadline']=0;
		$setsqlarr['add_mode']=1;
	}elseif($add_mode=='2'){
		$setmeal=get_user_setmeal($uid);
		$setsqlarr['setmeal_deadline']=$setmeal['endtime'];
		$setsqlarr['setmeal_id']=$setmeal['setmeal_id'];
		$setsqlarr['setmeal_name']=$setmeal['setmeal_name'];
		$setsqlarr['add_mode']=2;
	}*/
	if ($days>0)
	{
		if (intval($_POST['olddeadline'])>=time())
		{
			 $setsqlarr['deadline']=intval($_POST['olddeadline'])+($days*(60*60*24));
		}
		else
		{
			 $setsqlarr['deadline']=strtotime("{$days} day");
		}
	}
	$setsqlarr['key']=$setsqlarr['jobs_name'].$company_profile['companyname'].$setsqlarr['category_cn'].$setsqlarr['district_cn'].$setsqlarr['contents'];
	require_once(QISHI_ROOT_PATH.'include/splitword.class.php');
	$sp = new SPWord();
	$setsqlarr['key']="{$setsqlarr['jobs_name']} {$company_profile['companyname']} ".$sp->extracttag($setsqlarr['key']);
	$setsqlarr['key']=$sp->pad($setsqlarr['key']);
	if ($company_profile['audit']=="1")
	{
	$_CFG['audit_verifycom_editjob']<>"-1"?$setsqlarr['audit']=intval($_CFG['audit_verifycom_editjob']):'';
	}
	else
	{
	$_CFG['audit_unexaminedcom_editjob']<>"-1"?$setsqlarr['audit']=intval($_CFG['audit_unexaminedcom_editjob']):'';
	}
	$setsqlarr_contact['contact']=!empty($_POST['contact'])?trim($_POST['contact']):showmsg('您没有填写联系人！',1);
	check_word($_CFG['filter'],$_POST['contact'])?showmsg($_CFG['filter_tips'],0):'';
	$setsqlarr_contact['telephone']=!empty($_POST['telephone'])?trim($_POST['telephone']):showmsg('您没有填写联系电话！',1);
	check_word($_CFG['filter'],$_POST['telephone'])?showmsg($_CFG['filter_tips'],0):'';
	$setsqlarr_contact['address']=!empty($_POST['address'])?trim($_POST['address']):showmsg('您没有填写联系地址！',1);
	check_word($_CFG['filter'],$_POST['address'])?showmsg($_CFG['filter_tips'],0):'';
	$setsqlarr_contact['email']=!empty($_POST['email'])?trim($_POST['email']):showmsg('您没有填写联系邮箱！',1);
	check_word($_CFG['filter'],$_POST['email'])?showmsg($_CFG['filter_tips'],0):'';
	$setsqlarr_contact['notify']=trim($_POST['notify']);
	
  	$setsqlarr_contact['contact_show']=intval($_POST['contact_show']);
	$setsqlarr_contact['email_show']=intval($_POST['email_show']);
	$setsqlarr_contact['telephone_show']=intval($_POST['telephone_show']);
	$setsqlarr_contact['address_show']=intval($_POST['address_show']);
	
	if (!updatetable(table('jobs'), $setsqlarr," id='{$id}' AND uid='{$uid}' ")) showmsg("保存失败！",0);
	if (!updatetable(table('jobs_tmp'), $setsqlarr," id='{$id}' AND uid='{$uid}' ")) showmsg("保存失败！",0);
	if (!updatetable(table('jobs_contact'), $setsqlarr_contact," pid='{$id}' ")){
		showmsg("保存失败！",0);
	}
	if ($add_mode=='1')
	{
		if ($points_rule['jobs_edit']['value']>0)
		{
		report_deal($uid,$points_rule['jobs_edit']['type'],$points_rule['jobs_edit']['value']);
		$user_points=get_user_points($uid);
		$operator=$points_rule['jobs_edit']['type']=="1"?"+":"-";
		write_memberslog($_SESSION['uid'],1,9001,$_SESSION['username'],"修改职位：<strong>{$setsqlarr['jobs_name']}</strong>，({$operator}{$points_rule['jobs_edit']['value']})，(剩余:{$user_points})",1,1002,"修改招聘信息","{$operator}{$points_rule['jobs_edit']['value']}","{$user_points}");
		}
		if ($days>0 && $points_rule['jobs_daily']['value']>0)
		{
		$points_day=intval($_POST['days'])*$points_rule['jobs_daily']['value'];
		report_deal($uid,$points_rule['jobs_daily']['type'],$points_day);
		$user_points=get_user_points($uid);
		$operator=$points_rule['jobs_daily']['type']=="1"?"+":"-";
		write_memberslog($_SESSION['uid'],1,9001,$_SESSION['username'],"延长职位({$_POST['jobs_name']})有效期为{$_POST['days']}天，({$operator}{$points_day})，(剩余:{$user_points})",1,1002,"修改招聘信息","{$operator}{$points_day}","{$user_points}");
		}
	}	 
	$link[0]['text'] = "职位列表";
	$link[0]['href'] = '?act=sheneh_company_jobs';
	$link[1]['text'] = "查看修改结果";
	$link[1]['href'] = "?act=edit_jobs&id={$id}&uid={$uid}";
	$link[2]['text'] = "会员中心首页";
	$link[2]['href'] = "shenhe_index.php";
	//
	$searchtab['nature']=$setsqlarr['nature'];
	$searchtab['sex']=$setsqlarr['sex'];
	$searchtab['topclass']=$setsqlarr['topclass'];
	$searchtab['category']=$setsqlarr['category'];
	$searchtab['subclass']=$setsqlarr['subclass'];
	$searchtab['district']=$setsqlarr['district'];
	$searchtab['sdistrict']=$setsqlarr['sdistrict'];
	$searchtab['education']=$setsqlarr['education'];
	$searchtab['experience']=$setsqlarr['experience'];
	$searchtab['wage']=$setsqlarr['wage'];
	//
	updatetable(table('jobs_search_wage'),$searchtab," id='{$id}' AND uid='{$uid}' ");
	updatetable(table('jobs_search_rtime'),$searchtab," id='{$id}' AND uid='{$uid}' ");
	updatetable(table('jobs_search_stickrtime'),$searchtab," id='{$id}' AND uid='{$uid}' ");
	updatetable(table('jobs_search_hot'),$searchtab," id='{$id}' AND uid='{$uid}' ");
	updatetable(table('jobs_search_scale'),$searchtab," id='{$id}' AND uid='{$uid}'");
	$searchtab['key']=$setsqlarr['key'];
	$searchtab['likekey']=$setsqlarr['jobs_name'].','.$company_profile['companyname'];
	updatetable(table('jobs_search_key'),$searchtab," id='{$id}' AND uid='{$uid}' ");
	unset($searchtab);
		$tag=explode('|',$setsqlarr['tag']);
		$tagindex=1;
		foreach($tag as $v)
		{
		$vid=explode(',',$v);
		$tagsql['tag'.$tagindex]=intval($vid[0]);
		$tagindex++;
		}
		$tagsql['id']=$id;
		$tagsql['uid']=$uid;
		$tagsql['topclass']=$setsqlarr['topclass'];
		$tagsql['category']=$setsqlarr['category'];
		$tagsql['subclass']=$setsqlarr['subclass'];
		$tagsql['district']=$setsqlarr['district'];
		$tagsql['sdistrict']=$setsqlarr['sdistrict'];
	updatetable(table('jobs_search_tag'),$tagsql," id='{$id}' AND uid='{$uid}' ");
	distribution_jobs($id,$uid);
	write_memberslog($_SESSION['uid'],$_SESSION['utype'],2002,$_SESSION['username'],"修改了职位：{$setsqlarr['jobs_name']}，职位ID：{$id}");
	showmsg("修改成功！",2,$link);
}
unset($smarty);
?>