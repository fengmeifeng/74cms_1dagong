<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
//require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');

//获取简历基本信息
function get_resume_basic($uid,$id)
{
	global $db;
	$id=intval($id);
	$uid=intval($uid);
	//echo "select wage,wage_cn,nature,nature_cn,district,district_cn,trade,trade_cn,intention_jobs from ".table('resume')." where id='{$id}'  AND uid='{$uid}' LIMIT 1 "."<br>";
	//echo $uid."<br>".$id;exit;
	$info=$db->getone("select wage,wage_cn,nature,nature_cn,district,district_cn,trade,trade_cn,intention_jobs,specialty from ".table('resume')." where id='{$id}'  AND uid='{$uid}' LIMIT 1 ");
	if (empty($info))
	{
	return false;
	}
	else
	{
	if($info['wage_cn'] != '面试'){$info['wage_cn'] = $info['wage_cn']."元/月";}
	//$info['age']=date("Y")-$info['birthdate'];
	//$info['number']="N".str_pad($info['id'],7,"0",STR_PAD_LEFT);
	//$info['lastname']=cut_str($info['fullname'],1,0,"**");
	return $info;
	}
}
//获取意向职位
function get_resume_jobs($pid)
{
	global $db;
	$pid=intval($pid);
	$sql = "select * from ".table('resume_jobs')." where pid='{$pid}'  LIMIT 20" ;
	return $db->getall($sql);
}
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	unset($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['userid'];exit;
	$resumeid=isset($aset['resumeid'])?$aset['resumeid']:"";
	$resumeid=addslashes($resumeid);
	$resumeid=iconv("utf-8",QISHI_DBCHARSET,$resumeid);
	//echo $aset['page'];exit;
	
	
	if (empty($resumeid))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该简历');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	$list=array();
	$list = get_resume_basic($userid,$resumeid);
	$resume_jobs=get_resume_jobs($resumeid);
	if ($resume_jobs)
	{
		foreach($resume_jobs as $rjob)
		{
		$jobsid[]=$rjob['topclass'].".".$rjob['category'].".".$rjob['subclass'];
		}
		$resume_jobs_id=implode(",",$jobsid);
	}
	$list['jobcategory']=$resume_jobs_id;
	//echo "<pre>";print_r($list);exit;
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['data']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
	
	

?>