<?php
 /*
 * 74cms 微简历
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
require_once(ADMIN_ROOT_PATH.'include/admin_simple_resume_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'list';
$smarty->assign('act',$act);
$smarty->assign('pageheader',"微简历");
if($act == 'list')
{
	check_permissions($_SESSION['admin_purview'],"simple_resume_list");	
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	$orderbysql=" order BY `refreshtime` DESC";
	if ($key && $key_type>0)
	{
		
		if     ($key_type==1)$wheresql=" WHERE uname like '%{$key}%'";
		if     ($key_type==3)$wheresql=" WHERE tel ='{$key}'";
		$orderbysql="";
	}
	else
	{
		if (!empty($_GET['audit']))
		{
		$wheresql=" WHERE audit=".intval($_GET['audit']);
		}
		if (!empty($_GET['addtime']))
		{
			$settr=strtotime("-".intval($_GET['addtime'])." day");
			$wheresql=empty($wheresql)?" WHERE addtime> ".$settr:$wheresql." AND addtime> ".$settr;
		}
		if ($_GET['deadline']<>'')
		{
			$deadline=intval($_GET['deadline']);
			$time=time();			
			if ($deadline==0)
			{			
			$wheresql=empty($wheresql)?" WHERE deadline< {$time} AND deadline<>0 ":"{$wheresql} AND deadline< {$time} AND deadline<>0 ";
			}
			else
			{
			$settr=strtotime("+{$deadline} day");
			$wheresql=empty($wheresql)?" WHERE deadline<{$settr} AND deadline>{$time} ":"{$wheresql} AND  deadline<{$settr} AND deadline>{$time}";
			}			
		}
		if (!empty($_GET['refreshtime']))
		{
			$settr=strtotime("-".intval($_GET['refreshtime'])." day");
			$wheresql=empty($wheresql)?" WHERE refreshtime> ".$settr:$wheresql." AND refreshtime> ".$settr;
		}
	}
		if ($_CFG['subsite']=="1" && $_CFG['subsite_filter_simple']=="1")
		{
			$wheresql.=empty($wheresql)?" WHERE ":" AND ";
			$wheresql.=" (subsite_id=0 OR subsite_id=".intval($_CFG['subsite_id']).") ";
		}
	$total_sql="SELECT COUNT(*) AS num FROM ".table('simple_resume').$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$list = get_simple_list($offset,$perpage,$wheresql.$orderbysql);
	$smarty->assign('key',$key);
	$smarty->assign('total',$total_val);
	$smarty->assign('list',$list);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('navlabel','list');
	$smarty->display('simple_resume/admin_simple.htm');
}
elseif($act == 'simple_del')
{
	check_permissions($_SESSION['admin_purview'],"simple_resume_del");
	check_token();
	$id=$_REQUEST['id'];
	if (empty($id))
	{
	adminmsg("您没有选择项目！",1);
	}
	if ($num=simple_del($id))
	{
	adminmsg("删除成功！共删除".$num."行",2);
	}
	else
	{
	adminmsg("删除失败！",0);
	}
}
elseif($act == 'simple_refresh')
{
	check_permissions($_SESSION['admin_purview'],"simple_resume_refresh");
	check_token();
	$id=$_REQUEST['id'];
	if (empty($id))
	{
	adminmsg("您没有选择项目！",1);
	}
	if ($num=simple_refresh($id))
	{
	adminmsg("刷新成功！共刷新 {$num}行 ",2);
	}
	else
	{
	adminmsg("刷新失败！",0);
	}
}
elseif($act == 'simple_audit')
{
	check_permissions($_SESSION['admin_purview'],"simple_resume_audit");
	check_token();
	$id=$_REQUEST['id'];
	$audit=intval($_POST['audit']);
	if (empty($id))
	{
	adminmsg("您没有选择项目！",1);
	}
	if ($num=simple_audit($id,$audit))
	{
	adminmsg("设置成功！共影响 {$num}行 ",2);
	}
	else
	{
	adminmsg("设置失败！",0);
	}
}
elseif($act == 'simple_add')
{
	get_token();
	check_permissions($_SESSION['admin_purview'],"simple_resume_add");
	$smarty->assign('navlabel','add');
	$smarty->assign('subsite',get_subsite_list());
	$smarty->display('simple_resume/admin_simple_add.htm');
}
elseif($act == 'simple_add_save')
{
	check_token();
	check_permissions($_SESSION['admin_purview'],"simple_resume_add");
	$setsqlarr['audit']=1;
	$setsqlarr['uname']=trim($_POST['uname'])?trim($_POST['uname']):adminmsg('您没有填写姓名！',1);
	$setsqlarr['age']=intval($_POST['age'])?intval($_POST['age']):adminmsg('您没有填写年龄！',1);
	$setsqlarr['sex']=intval($_POST['sex']);
	switch($setsqlarr['sex']){
		case 1:$setsqlarr['sex_cn']="男";break;
		case 2:$setsqlarr['sex_cn']="女";break;
	}
	$setsqlarr['district']=intval($_POST['district'])?intval($_POST['district']):adminmsg('您没有选择地区！',1);
	$setsqlarr['sdistrict']=intval($_POST['sdistrict'])?intval($_POST['sdistrict']):adminmsg('您没有选择地区！',1);
	$district_cn = explode("/",trim($_POST['district_cn']));
	$setsqlarr['district_cn']=$district_cn[0];
	$setsqlarr['sdistrict_cn']=$district_cn[1];
	$setsqlarr['category']=trim($_POST['category'])?trim($_POST['category']):adminmsg('您没有输入工种！',1);
	$setsqlarr['experience']=intval($_POST['experience'])?intval($_POST['experience']):adminmsg('您没有选择工作经验！',1);
	$experience = $db->getone("select c_name from ".table('category')." where c_id=".$setsqlarr['experience']);
	$setsqlarr['experience_cn']=$experience['c_name'];
	$setsqlarr['tel']=trim($_POST['tel'])?trim($_POST['tel']):adminmsg('您没有填写联系电话！',1);
	$setsqlarr['detailed']=trim($_POST['detailed']);
	$setsqlarr['addtime']=time();
	$setsqlarr['refreshtime']=time();
	$setsqlarr['deadline']=0;
	$setsqlarr['subsite_id']=intval($_POST['subsite_id']);
	$validity=intval($_POST['validity']);
	if ($validity>0)
	{
	$setsqlarr['deadline']=strtotime("{$validity} day");
	}
	$setsqlarr['pwd']=trim($_POST['pwd'])?trim($_POST['pwd']):adminmsg('您没有填写管理密码！',1);
	$setsqlarr['pwd_hash']=substr(md5(uniqid().mt_rand()),mt_rand(0,6),6);
	$setsqlarr['pwd']=md5(md5($setsqlarr['pwd']).$setsqlarr['pwd_hash'].$QS_pwdhash);
	$setsqlarr['addip']=$online_ip;
	require_once(QISHI_ROOT_PATH.'include/splitword.class.php');
	$sp = new SPWord();
	$setsqlarr['key']=$setsqlarr['uname'].$setsqlarr['address'].$setsqlarr['detailed'];
	$setsqlarr['key']="{$setsqlarr['uname']} ".$sp->extracttag($setsqlarr['key']);
	$setsqlarr['key']=$sp->pad($setsqlarr['key']);
	if($resumepid = inserttable(table('simple_resume'),$setsqlarr,1))
	{
		$link[0]['text'] = "返回列表";
		$link[0]['href'] = '?act=list';
		$link[1]['text'] = "继续添加";
		$link[1]['href'] = "?act=simple_add";
		adminmsg("添加成功！",2,$link);
	}
	else
	{
		adminmsg("添加失败！",0);
	}	
}
elseif($act == 'simple_edit')
{
	get_token();
	$id=intval($_REQUEST['id']);
	if (empty($id))
	{
	adminmsg("您没有选择项目！",1);
	}
	check_permissions($_SESSION['admin_purview'],"simple_resume_edit");
	$sql = "select * from ".table('simple_resume')." where id = '{$id}' LIMIT 1";
	$show=$db->getone($sql);
	$show['district_cn'] = $show['district_cn']."/".$show['sdistrict_cn'];
	$smarty->assign('show',$show);
	$smarty->assign('subsite',get_subsite_list());
	$smarty->display('simple_resume/admin_simple_edit.htm');
}
elseif($act == 'simple_edit_save')
{
	$id=intval($_POST['id']);
	if (empty($id))
	{
	adminmsg("您没有选择项目！",1);
	}
	if ($_POST['pwd'])
	{
		$info=$db->getone("select * from ".table('simple_resume')." where id = '{$id}' LIMIT 1");
		$setsqlarr['pwd']=md5(md5($_POST['pwd']).$info['pwd_hash'].$QS_pwdhash);
	}
	$setsqlarr['uname']=trim($_POST['uname'])?trim($_POST['uname']):adminmsg('您没有填写姓名！',1);
	$setsqlarr['age']=intval($_POST['age'])?intval($_POST['age']):adminmsg('您没有填写年龄！',1);
	$setsqlarr['sex']=intval($_POST['sex']);
	switch($setsqlarr['sex']){
		case 1:$setsqlarr['sex_cn']="男";break;
		case 2:$setsqlarr['sex_cn']="女";break;
	}
	$setsqlarr['district']=intval($_POST['district'])?intval($_POST['district']):adminmsg('您没有选择地区！',1);
	$setsqlarr['sdistrict']=intval($_POST['sdistrict'])?intval($_POST['sdistrict']):adminmsg('您没有选择地区！',1);
	$district_cn = explode("/",trim($_POST['district_cn']));
	$setsqlarr['district_cn']=$district_cn[0];
	$setsqlarr['sdistrict_cn']=$district_cn[1];
	$setsqlarr['category']=trim($_POST['category'])?trim($_POST['category']):adminmsg('您没有填写工种！',1);
	$setsqlarr['experience']=intval($_POST['experience'])?intval($_POST['experience']):adminmsg('您没有选择工作经验！',1);
	$experience = $db->getone("select c_name from ".table('category')." where c_id=".$setsqlarr['experience']);
	$setsqlarr['experience_cn']=$experience['c_name'];
	
	$setsqlarr['tel']=trim($_POST['tel'])?trim($_POST['tel']):adminmsg('您没有填写联系电话！',1);
	
	$setsqlarr['detailed']=trim($_POST['detailed']);
	$setsqlarr['refreshtime']=time();
	$setsqlarr['subsite_id']=intval($_POST['subsite_id']);
	$days=intval($_POST['days']);
	if ($days>0)
	{
	$time=$_POST['olddeadline']>time()?$_POST['olddeadline']:time();
	$setsqlarr['deadline']=strtotime("{$days} day",$time);
	}
	require_once(QISHI_ROOT_PATH.'include/splitword.class.php');
	$sp = new SPWord();
	$setsqlarr['key']=$setsqlarr['uname'].$setsqlarr['address'].$setsqlarr['detailed'];
	$setsqlarr['key']="{$setsqlarr['uname']} ".$sp->extracttag($setsqlarr['key']);
	$setsqlarr['key']=$sp->pad($setsqlarr['key']);
	if(updatetable(table('simple_resume'),$setsqlarr," id='{$id}' "))
	{
		$link[0]['text'] = "返回列表";
		$link[0]['href'] = '?act=list';
		adminmsg("修改成功！",2,$link);
	}
	else
	{
	adminmsg("修改失败！",0);
	}
}
?>