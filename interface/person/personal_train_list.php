<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
//require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
//获取：培训经历列表
function get_resume_training($uid,$pid,$limit)
{
	global $db;
	$sql = "select * from ".table('resume_training')." where pid='".intval($pid)."' AND  uid='".intval($uid)."' ".$limit;
	return $db->getall($sql);
}
//获取 单条 培训经历
function get_resume_training_one($uid,$pid,$id)
{
	global $db;
	$sql = "select * from ".table('resume_training')." where id='".intval($id)."' AND uid='".intval($uid)."'  AND pid='".intval($pid)."'  LIMIT 1 ";
	return $db->getone($sql);
}
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	unset($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['userid'];exit;
	//$resume_id =intval($aset['resumeId']);
	$resume_id=isset($aset['resume_id'])?trim($aset['resume_id']):"";
	$resume_id=addslashes($resume_id);
	$resume_id=iconv("utf-8",QISHI_DBCHARSET,$resume_id);
	
	$page=isset($aset['page'])?trim($aset['page']):"";
	$page=addslashes($page);
	$page=iconv("utf-8",QISHI_DBCHARSET,$page);
	//echo $aset['page'];exit;
	$pagesize=isset($aset['pagesize'])?trim($aset['pagesize']):"";
	$pagesize=addslashes($pagesize);
	$pagesize=iconv("utf-8",QISHI_DBCHARSET,$pagesize);
	//echo $aset['pagesize'];exit;
	
	if (empty($userid))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该用户');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	if (empty($resume_id))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该用户的简历信息');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	$wheresql=" WHERE  uid='{$userid}' ";
	
	//----获取总数
	$total_sql="SELECT COUNT(*) AS num from ".table('resume_education')." {$wheresql} ";
	$total_val=$db->get_total($total_sql);
	//----获取总数结合苏
	//----fff---分页
	//$page 当前页数
	//$total_val 总条数
	//$pagesize 每页显示条数
	if(!$page) $page = 1;
	if(!$pagesize) $pagesize = 10;
	$maxpage = ceil($total_val / $pagesize);
	/*if($maxpage>0)
	{
		if($page > $maxpage) $page = $maxpage;
	}*/
	$offset = ($page - 1) * $pagesize;

	//echo $wheresql;exit;
	$limit=' limit '.$offset.','.$pagesize;
	$list=get_resume_training($userid,$resume_id,$limit);
	//echo "<pre>";print_r($list);exit;
	if (empty($list))
	{
	$list=array();
	}
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['data']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);

?>