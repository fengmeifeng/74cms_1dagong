<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;

isset($aset['uid'])?$wheresql.=" where uid=".intval($aset['uid'])." ":'';
isset($aset['img'])?$wheresql.=" AND Small_img<>'' ":'';

$sql="SELECT a.id, a.uid, a.sex_cn, a.birthdate, a.telephone, a.residence_cn, a.intention_jobs, a.wage_cn, a.district_cn, a.nature_cn, 
b.startyear,b.startmonth, b.endyear, b.endmonth, b.school, b.speciality, b.education_cn, c.startyear as w_startyear, c.startmonth as w_startmonth, c.endyear as w_endyear, c.endmonth as w_endmonth, c.jobs, c.achievements, c.companyname FROM (qs_resume as a left join qs_resume_education as b on a.uid=b.uid and a.id=b.pid) left join qs_resume_work as c on a.uid=c.uid and a.id=c.pid where a.uid=".$aset['uid']." and a.id=".$aset['pid'];
// echo $sql;exit;
$result = $db->query($sql);

	$list= array();
	while($row = $db->fetch_array($result))
	{
		$row['content']=str_replace('&nbsp;','',$row['content']);
			if ($aset['infolen']>0)
			{
			$row['content']=cut_str(strip_tags($row['content']),$aset['infolen'],0,$aset['dot']);
			}
		$row['addtime']=date("Y-m-d",$row['addtime']);
		$row['sta']=1;
		$list[] = $row;
	}
	// var_dump($list);exit;
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$androidresult['data']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);

?>