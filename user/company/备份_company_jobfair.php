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
$smarty->assign('leftmenu',"jobfair");
if ($act=='jobfair')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$oederbysql=" order BY `order` DESC,id DESC";
	$wheresql=" WHERE display=1 ";
	if ($_CFG['subsite']=="1" && $_CFG['subsite_filterjobfair']=="1")
	{
			$wheresql.=empty($wheresql)?" WHERE ":" AND ";
			$wheresql.=" (subsite_id=0 OR subsite_id=".intval($_CFG['subsite_id']).") ";
	}	
	$total_sql="SELECT COUNT(*) AS num FROM ".table('jobfair').$wheresql;
	$perpage=5;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$smarty->assign('title','招聘会 - 会员中心 - '.$_CFG['site_name']);
	$smarty->assign('jobfair',get_jobfair($offset,$perpage,$wheresql));
	if ($total_val>$perpage)$smarty->assign('page',$page->show(3));
	$smarty->display('member_company/company_jobfair_list.htm');
}
elseif ($act=='booth')
{
	$id=intval($_POST['id']);
	if(empty($id))
	{
	exit("ERR");
	}
		$time=time();
		$sql = "select * from ".table('jobfair')." where id='{$id}' limit 1";
		$jobfair=$db->getone($sql);
		if ($jobfair['predetermined_status']=="1" && $jobfair['holddates']>$time && $time>$jobfair['predetermined_start'] && ($jobfair['predetermined_end']=="0" || $jobfair['predetermined_end']>$time) && $jobfair['predetermined_web']=="1")
		{
					$user_points=get_user_points($_SESSION['uid']);
					if ($jobfair['predetermined_point']>$user_points)
					{
					$link[0]['text'] = "立即充值";
					$link[0]['href'] = 'company_service.php?act=order_add';
					$link[1]['text'] = "返回上一页";
					$link[1]['href'] = 'javascript:history.go(-1)';
					$link[2]['text'] = "会员中心首页";
					$link[2]['href'] = 'company_index.php?act=';
					showmsg("你的".$_CFG['points_byname']."不足，请充值后再预定！",0,$link);
					}
					if ($db->getone("select * from ".table('jobfair_exhibitors')." where jobfairid='{$id}' AND uid={$_SESSION['uid']} limit 1"))
					{
					$link[0]['text'] = "我预定的展位";
					$link[0]['href'] = '?act=mybooth';
					$link[1]['text'] = "返回上一页";
					$link[1]['href'] = 'javascript:history.go(-1)';
					showmsg("你已经预定过此招聘会的展位了，不能重复预定",1,$link);
					}
					$setsqlarr['jobfairid']=$id;
					$setsqlarr['uid']=intval($_SESSION['uid']);
					$setsqlarr['etypr']=1;
					$setsqlarr['eaddtime']=$timestamp;
					$setsqlarr['companyname']=$company_profile['companyname'];
					$setsqlarr['company_id']=$company_profile['id'];
					$setsqlarr['company_addtime']=$company_profile['addtime'];
					$setsqlarr['jobfair_title']=$jobfair['title'];
					$setsqlarr['jobfair_addtime']=$jobfair['addtime'];
					$setsqlarr['note']="{$_SESSION['username']} 预定了招聘会 《{$jobfair['title']}》 的展位，已成功扣除积分 {$jobfair['predetermined_point']}";	
					if (inserttable(table('jobfair_exhibitors'),$setsqlarr))
					{
					if ($jobfair['predetermined_point']>0)
					{
						report_deal($_SESSION['uid'],2,$jobfair['predetermined_point']);
						$user_points=get_user_points($_SESSION['uid']);					
						write_memberslog($_SESSION['uid'],1,9001,$_SESSION['username'],"预定了招聘会 《{$jobfair['title']}》 的展位，(-{$jobfair['predetermined_point']})，(剩余:{$user_points})");
					}				
					write_memberslog($_SESSION['uid'],1,1401,$_SESSION['username'],"预定了招聘会 《{$jobfair['title']}》 的展位");
					
					
					$link[0]['text'] = "我预定的展位";
					$link[0]['href'] = '?act=mybooth';
					$link[1]['text'] = "返回上一页";
					$link[1]['href'] = 'javascript:history.go(-1)';
					$link[2]['text'] = "会员中心首页";
					$link[2]['href'] = 'company_index.php?act=';
					showmsg("预定成功!	选择展位",2,$link);
					}
		}
}
elseif ($act=='mybooth')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$oederbysql=" order BY e.id DESC";
	$wheresql= " WHERE e.uid={$_SESSION['uid']} ";
	$settr=intval($_GET['settr']);
	if($settr>0)
	{
	$settr_val=strtotime("-".$settr." day");
	$wheresql.=" AND e.eaddtime>".$settr_val;
	}
	$joinsql=" LEFT JOIN  ".table('jobfair')." AS j ON  e.jobfairid=j.id ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('jobfair_exhibitors')." as e ".$joinsql.$wheresql;
	$perpage=10;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$smarty->assign('title','我预定的展位 - 招聘会 - 会员中心 - '.$_CFG['site_name']);
	$smarty->assign('list',get_jobfair_exhibitors($offset,$perpage,$joinsql.$wheresql));
	if ($total_val>$perpage)$smarty->assign('page',$page->show(3));
	$smarty->display('member_company/company_jobfair_exhibitors.htm');
}
unset($smarty);
?>