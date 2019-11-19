<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;

isset($aset['uid'])?$wheresql.=" where uid=".intval($aset['uid'])." ":'';
isset($aset['img'])?$wheresql.=" AND Small_img<>'' ":'';

// $sql="SELECT a.id, a.uid, a.photo_img, a.sex_cn, a.birthdate, a.telephone, a.residence_cn, a.intention_jobs, a.wage_cn, a.district_cn, a.nature_cn, 
// b.startyear,b.startmonth, b.endyear, b.endmonth, b.school, b.speciality, b.education_cn, c.startyear as w_startyear, c.startmonth as w_startmonth, c.endyear as w_endyear, c.endmonth as w_endmonth, c.jobs, c.achievements, c.companyname FROM (qs_resume as a left join qs_resume_education as b on a.uid=b.uid and a.id=b.pid) left join qs_resume_work as c on a.uid=c.uid and a.id=c.pid where a.uid=".$aset['uid']." and a.id=".$aset['id'];
// echo $sql;exit;

//简历
$sql_1="select a.id, a.uid, a.photo_img, a.sex_cn, a.birthdate, a.telephone, a.residence_cn, a.intention_jobs, a.wage_cn, a.district_cn, a.nature_cn from qs_resume as a where a.uid=".$aset['uid']." and a.id=".$aset['id'];
$result_1 = $db->query($sql_1);
$list_1= array();
while($row = $db->fetch_array($result_1))
{
	$row['sta']=1;
	$row['residence_cn']=trim($row['residence_cn']);
	$list_1[] = $row;
}
//教育经历
$sql_2="select b.id,b.startyear,b.startmonth, b.endyear, b.endmonth, b.school, b.speciality, b.education_cn from qs_resume_education as b where b.uid=".$aset['uid']." and b.pid=".$aset['id'];
$result_2 = $db->query($sql_2);
$list_2= array();
while($row = $db->fetch_array($result_2))
{

	$list_2[] = $row;
	
}
//工作经历
$sql_3="select c.id,c.startyear, c.startmonth, c.endyear, c.endmonth, c.jobs, c.achievements, c.companyname from qs_resume_work as c where c.uid=".$aset['uid']." and c.pid=".$aset['id'];
$result_3 = $db->query($sql_3);
$list_3= array();
while($row = $db->fetch_array($result_3))
{
	$list_3[] = $row;
}
//培训经历
$sql_4="select id,startyear, startmonth, endyear, endmonth, agency, course, description from qs_resume_training  where uid=".$aset['uid']." and pid=".$aset['id'];
$result_4 = $db->query($sql_4);
$list_4= array();
while($row = $db->fetch_array($result_4))
{
	$list_4[] = $row;
}
$list=array($list_1);
if($list_2)
{
	$list=array($list_1,$list_2);
}
if($list_3)
{
	$list=array($list_1,$list_3);
}
if($list_4)
{
	$list=array($list_1,$list_4);
}
if($list_2 && $list_3)
{
	$list=array($list_1,$list_2,$list_3);
}
if($list_2 && $list_4)
{
	$list=array($list_1,$list_2,$list_4);
}
if($list_2 && $list_4 && $list_3)
{
	$list=array($list_1,$list_2,$list_3,$list_4);
}
	

	// var_dump($list);exit;
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$androidresult['data']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);

?>