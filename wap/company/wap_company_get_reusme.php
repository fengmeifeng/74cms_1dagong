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
require_once(dirname(__FILE__).'/../../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/fun_company.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'index';
if ($_SESSION['uid']=='' || $_SESSION['username']==''||intval($_SESSION['utype'])==2)
{
	header("Location: ../wap_login.php");
}
elseif ($act == 'index')
{
	$smarty->cache = false;
	$wheresql=" WHERE a.company_uid='{$_SESSION['uid']}' ";
	$perpage = 5;
	$count  = 0;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	$total_sql="SELECT COUNT(*) AS num FROM  ".table('personal_jobs_apply')." as a  {$wheresql}";
	$count=$db->get_total($total_sql);
	$limit=" LIMIT {$start},{$perpage}";
	$sql="select a.*,r.title,r.education_cn,r.birthdate,r.experience_cn,r.residence_cn from ".table("personal_jobs_apply")." as a left join ".table("resume")." as r on a.resume_id=r.id  $wheresql order by a.apply_addtime desc ".$limit;
	$apply=$db->getall($sql);
	foreach ($apply as $key=>$value) {
		$value["birthdate_"]=date('Y',time())-$value["birthdate"];
		$apply[$key]=$value;
	}
	$smarty->assign('apply',$apply);
	$smarty->display("wap/company/wap-get-resumes.html");	
}
elseif($act=="ajax_get_resume")
{
	$favoriteshtml="";
	$rows=intval($_GET['rows']);
	$offset=intval($_GET['offset']);
	$wheresql=" WHERE a.company_uid='{$_SESSION['uid']}' ";
	$favoritesarry=$db->getall("select a.*,r.title,r.education_cn,r.birthdate,r.experience_cn,r.residence_cn from ".table("personal_jobs_apply")." as a left join ".table("resume")." as r on a.resume_id=r.id  $wheresql order by a.apply_addtime desc limit $offset,$rows");
	if (!empty($favoritesarry) && $offset<=100)
	{
		foreach($favoritesarry as $list)
		{
			$list["birthdate_"]=date('Y',time())-$list["birthdate"];

			$favoriteshtml.='<div class="get_resume_box" onclick="window.location.href="../wap-resume-show.php?id='.$list["resume_id"].'
""><div class="get_resume_left"><div class="name_box"><div class="name_box_l">'.$list["title"].'</div><div class="name_box_r">'.date("Y-m-d",$list["apply_addtime"]).'</div><div class="clear"></div></div><div class="person_detail">'.$list["education_cn"].'|'.$list["birthdate_"].'|'.$list["experience_cn"].'|'.$list["residence_cn"].'<br />应聘职位：'.$list["jobs_name"].'</div></div><div class="get_resume_right"><img src="../images/34.gif" alt="" /></div><div class="clear"></div></div>';
		}
		exit($favoriteshtml);
	}
	else
	{
		exit('-1');
	}
}
elseif ($act == 'wait')
{
	WapShowMsg("开发中，敬请期待！",2);
}
?>