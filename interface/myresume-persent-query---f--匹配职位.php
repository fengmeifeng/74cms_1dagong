<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
if(empty($aset['id'])){
	$androidresult['code']=0;
	$androidresult['errormsg']='传递参数错误';
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
	exit;
}
$sql="select complete_percent from qs_resume where id=".$aset['id'];

$result = $db->query($sql);

	$list= array();
	while($row = $db->fetch_array($result))
	{
		$list[] = $row;
	}
$res_1=$db->getone("select * from qs_resume where id=".$aset['id']." AND intention_jobs =''");
if($res_1){
	$list['jobs_sta']=0;
}else{
	$list['jobs_sta']=1;
}
$res_2=$db->getone("select * from qs_resume where id=".$aset['id']." AND specialty =''");
if($res_2){
	$list['spe_sta']=0;
}else{
	$list['spe_sta']=1;
}
$res_3=$db->getone("select * from qs_resume_education where id=".$aset['id']);
if($res_3){
	$list['edu_sta']=0;
}else{
	$list['edu_sta']=1;
}
$res_4=$db->getone("select * from qs_resume_training where id=".$aset['id']);
if($res_4){
	$list['tra_sta']=0;
}else{
	$list['tra_sta']=1;
}
$res_5=$db->getone("select * from qs_resume_work where id=".$aset['id']);
if($res_5){
	$list['wor_sta']=0;
}else{
	$list['wor_sta']=1;
}
//----fff---匹配职位的jobcategory
$res_6=$db->getall("select * from ".table('resume_jobs')." where pid=".intval($aset['id'])." order by id desc ");
//echo "<pre>";print_r($res_6);exit;
if($res_6){
	foreach($res_6 as $v)
	{
		$arr[]=$v['topclass'].".".$v['category'].".".$v['subclass'];
	}
	$list['jobcategory']= implode(',',$arr);
	//echo $list['jobcategory'];echo "<pre>";print_r($arr);exit;
}else{
	$list['jobcategory']=0;
}
//-----fff

	$list=array_map('export_mystrip_tags',$list);
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$androidresult['data']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
?>