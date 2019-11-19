<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
//增加意向职位
function add_resume_jobs($pid,$uid,$str)
{
	global $db;
	$db->query("Delete from ".table('resume_jobs')." WHERE pid='".intval($pid)."'");
	$str=trim($str);
	$arr=explode(",",$str);
	if (is_array($arr) && !empty($arr))
	{
		foreach($arr as $a)
		{
		$a=explode(".",$a);
		$setsqlarr['uid']=intval($uid);
		$setsqlarr['pid']=intval($pid);
		$setsqlarr['topclass']=intval($a[0]);
		$setsqlarr['category']=intval($a[1]);
		$setsqlarr['subclass']=intval($a[2]);
			if (!inserttable(table('resume_jobs'),$setsqlarr))return false;
		}
	}
	return true;
}
switch($aset['operate_code']){
	case "title":
		$sql="update qs_resume set title='".$aset['title']."' where id=".$aset['id'];
		break;
	case "person_info":
		$sql="update qs_resume set sex=".$aset['sex'].",
		sex_cn='".$aset['sex_cn']."',
		birthdate=".$aset['birthdate'].",
		telephone='".$aset['telephone']."',
		residence=".$aset['residence'].",
		residence_cn='".$aset['residence_cn']."' where id=".$aset['id'];
		break;
	case "work_intention":
		///-------1添加期望职位id--开始
		add_resume_jobs($aset['id'],$aset['uid'],$aset['intention_jobs_id']);
		///-------1添加期望职位id--结束
		
		///-------2添加期望薪资id--开始---ffff
		$sql_wage="SELECT * FROM qs_category WHERE c_alias ='QS_wage' and c_name ='".trim($aset['wage_cn'])."'";
		$res_wage=$db->getall($sql_wage);
		foreach($res_wage as $v)
		{
			 $wage=$v['c_id'];
		}
		//echo $wage;echo "<pre>";print_r($res_wage);exit;
		///-------2添加期望薪资id--结束---ffff
		
		///-------3添加职位性质--开始---ffff
		$sql_nature="SELECT * FROM ".table('category')." WHERE c_alias ='QS_jobs_nature' and c_name ='".trim($aset['nature_cn'])."'";
		$res_nature=$db->getall($sql_nature);
		foreach($res_nature as $v)
		{
			$nature=$v['c_id'];
		}
		//echo $nature;echo "<pre>";print_r($res_nature);exit;
		///-------3添加职位性质--结束---ffff
		
		///-------4添加期望地区--开始---ffff
		$str=trim($aset['district_cn']);
		//echo iconv(QISHI_DBCHARSET,"utf-8",trim($aset['district_cn']));exit;
		if(preg_match('/(.*)\/{1}([^\/]*)/i',$str))
		{
			$district_cn = preg_replace('/(.*)\/{1}([^\/]*)/i', '$2',$str);
			
		}else
		{
			$district_cn=$str;
		}
		//echo iconv(QISHI_DBCHARSET,"utf-8",trim($district_cn));exit;
		$sql_distric="SELECT * FROM ".table('category_district')." WHERE categoryname like '%".$district_cn."%'";
		$res_distric=$db->getall($sql_distric);
		foreach($res_distric as $v)
		{
			 $district=$v['parentid'];
			 $sdistrict=$v['id'];
		}
		//echo $district."<br>";echo $sdistrict;echo "<pre>";print_r($res_distric);exit;
		///-------4添加期望地区--结束---ffff
		
		$sql="update qs_resume set intention_jobs='".$aset['intention_jobs']."',
		wage='".$wage."',
		wage_cn='".$aset['wage_cn']."',
		district='".$district."',
		sdistrict='".$sdistrict."',
		district_cn='".$aset['district_cn']."',
		nature='".$nature."',
		nature_cn='".$aset['nature_cn']."',
		trade='".$aset['c_id']."',
		trade_cn='".$aset['c_name']."' where id=".$aset['id'];
		// echo $sql;exit;
		break;
	case "pingjia":
		$sql="update qs_resume set specialty='".$aset['specialty']."' where id=".$aset['id'];
		break;
	case "education":
		$sql="update qs_resume_education set startyear=".$aset['startyear'].",
		startmonth=".$aset['startmonth'].",
		endyear=".$aset['endyear'].",
		endmonth=".$aset['endmonth'].",
		school='".$aset['school']."',
		speciality='".$aset['speciality']."',
		education_cn='".$aset['education_cn']."' where id=".$aset['id'];
		break;
	case "training":
		$sql="update qs_resume_training set startyear=".$aset['startyear'].",
		startmonth=".$aset['startmonth'].",
		endyear=".$aset['endyear'].",
		endmonth=".$aset['endmonth'].",
		agency='".$aset['agency']."',
		course='".$aset['course']."',
		description='".$aset['description']."' where id=".$aset['id'];
		break;
	case "work":
		$sql="update qs_resume_work set startyear=".$aset['startyear'].",
		startmonth=".$aset['startmonth'].",
		endyear=".$aset['endyear'].",
		endmonth=".$aset['endmonth'].",
		companyname='".$aset['companyname']."',
		jobs='".$aset['jobs']."',
		achievements='".$aset['achievements']."' where id=".$aset['id'];
		break;
}

// echo $sql;exit;
if($result = $db->query($sql)){

	
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$androidresult['data']=$aset['operate_code'];
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
}
?>