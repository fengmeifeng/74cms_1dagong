<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;

switch($aset['operate_code']){
	case "title":
		$sql="update qs_resume set title=".$aset['title']." where id=".$aset['id'];
		break;
	case "person_info":
		$sql="update qs_resume set sex=".$aset['sex'].",
		sex_cn=".$aset['sex_cn'].",
		birthdate=".$aset['birthdate'].",
		telephone=".$aset['telephone'].",
		residence=".$aset['residence'].",
		residence_cn=".$aset['residence_cn']." where id=".$aset['id'];
		break;
	case "work_intention":
		$sql="update qs_resume set intention_jobs=".$aset['intention_jobs'].",
		wage_cn=".$aset['wage_cn'].",
		district_cn=".$aset['district_cn'].",
		nature_cn=".$aset['nature_cn'];
		break;
	case "pingjia":
		$sql="update qs_resume set specialty=".$aset['specialty'];
		break;
	case "education":
		$sql="update qs_resume_education set startyear=".$aset['startyear'].",
		startmonth=".$aset['startmonth'].",
		endyear=".$aset['endyear'].",
		endmonth=".$aset['endmonth'].",
		school=".$aset['school'].",
		speciality=".$aset['speciality'].",
		education_cn=".$aset['education_cn'];
		break;
	case "training":
		$sql="update qs_resume_training set startyear=".$aset['startyear'].",
		startmonth=".$aset['startmonth'].",
		endyear=".$aset['endyear'].",
		endmonth=".$aset['endmonth'].",
		agency=".$aset['agency'].",
		course=".$aset['course'].",
		description=".$aset['description'];
		break;
	case "work":
		$sql="update qs_resume_work set startyear=".$aset['startyear'].",
		startmonth=".$aset['startmonth'].",
		endyear=".$aset['endyear'].",
		endmonth=".$aset['endmonth'].",
		companyname=".$aset['companyname'].",
		jobs=".$aset['jobs'].",
		achievements=".$aset['achievements'];
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