<?php
 /*
 * 74cms ajax 会员中心
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(dirname(__FILE__)).'/include/plus.common.inc.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : ''; 
if($act == 'edit_apply')
{
	$id=intval($_GET['id']);
	if ($id>0)
	{
	$setsqlarr['personal_look']=2;
	updatetable(table('personal_jobs_apply'),$setsqlarr," did='".$id."' LIMIT 1");
			$sql="select m.username from ".table('personal_jobs_apply')." AS a JOIN ".table('members')." AS m ON a.personal_uid=m.uid WHERE a.did='{$id}' LIMIT 1";
			$user=$db->getone($sql);
			write_memberslog($_SESSION['uid'],1,2006,$_SESSION['username'],"查看了 {$user['username']} 的职位申请");
	exit("ok");
	}
}
elseif($act == 'edit_interview')
{
	$id=intval($_GET['id']);
	if ($id>0)
	{
	$setsqlarr['personal_look']=2;
	if (updatetable(table('company_interview'),$setsqlarr," did='".$id."' LIMIT 1"))exit("ok");
	}
}
//---ff修改申请是否查看
elseif($act == 'edit_look')
{
	$id=intval($_GET['id']);
	if ($id>0)
	{
	$setsqlarr['personal_look']=2;
	if (updatetable(table('company_apply_ck'),$setsqlarr," did='".$id."' LIMIT 1"))exit("ok");
	}
}
elseif($act == 'edit_apply_ck')
{
	$id=intval($_GET['id']);
	
	if ($id>0)
	{
		
	$setsqlarr['company_apply']=1;
	if (updatetable(table('company_apply_ck'),$setsqlarr," did='".$id."' LIMIT 1"))
		//--
		$sql = "select c.did,c.company_uid,p.look_num from ".table('company_apply_ck')." as c join ".table('company_profile')." as p on c.company_uid=p.uid where c.did=".$id." LIMIT 1 ";
		$row = $db->getone($sql);
		if($row['look_num']>0 && $row['look_num']<=10){$setsqlarr_c['look_num']=$row['look_num']-1;}
		if (updatetable(table('company_profile'),$setsqlarr_c," uid='".$row['company_uid']."' LIMIT 1"))
		{exit("ok");}
		//--
		
	}
}
//---ff
?>