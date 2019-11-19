<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
//获取意向职位
function get_resume_jobs($pid)
{
	global $db;
	$pid=intval($pid);
	$sql = "select * from ".table('resume_jobs')." where pid='{$pid}'  LIMIT 20" ;
	return $db->getall($sql);
}
isset($aset['uid'])?$wheresql.=" where uid=".intval($aset['uid'])." ":'';
isset($aset['img'])?$wheresql.=" AND Small_img<>'' ":'';

// $sql="SELECT a.id, a.uid, a.photo_img, a.sex_cn, a.birthdate, a.telephone, a.residence_cn, a.intention_jobs, a.wage_cn, a.district_cn, a.nature_cn, 
// b.startyear,b.startmonth, b.endyear, b.endmonth, b.school, b.speciality, b.education_cn, c.startyear as w_startyear, c.startmonth as w_startmonth, c.endyear as w_endyear, c.endmonth as w_endmonth, c.jobs, c.achievements, c.companyname FROM (qs_resume as a left join qs_resume_education as b on a.uid=b.uid and a.id=b.pid) left join qs_resume_work as c on a.uid=c.uid and a.id=c.pid where a.uid=".$aset['uid']." and a.id=".$aset['id'];
// echo $sql;exit;


$resume_jobs=get_resume_jobs($aset['id']);
	if ($resume_jobs)
	{
		foreach($resume_jobs as $rjob)
		{
		$jobsid[]=$rjob['topclass'].".".$rjob['category'].".".$rjob['subclass'];
		}
		$resume_jobs_id=implode(",",$jobsid);
	}

//intention_jobs_id
//期望职位
$sql_1="select a.id, a.uid,a.trade,a.trade_cn,a.intention_jobs,a.intention_jobs,a.wage,a.wage_cn, a.district_cn,a.district,a.sdistrict, a.nature,a.nature_cn from qs_resume as a where a.uid=".$aset['uid']." and a.id=".$aset['id'];
$result_1 = $db->query($sql_1);
$list= array();

while($row = $db->fetch_array($result_1))
{
	//$row['sta']=1;
	$row['wage_cn'] = $row['wage_cn'] !='面试'?$row['wage_cn']."元/月":$row['wage_cn'];
	$list[] = $row;
}
$list[0]['intention_jobs_id']=$resume_jobs_id;

	// var_dump($list);exit;
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$androidresult['data']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);

?>