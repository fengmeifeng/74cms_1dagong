<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
//动态调整简历完整度
$return=$db->query("select id from qs_resume_training where pid=".$aset['pid']);
if($db->num_rows()==0){
	$db->query("update qs_resume set complete_percent=complete_percent+15 where id=".$aset['pid']);
}



$sql="insert into qs_resume_training (uid,pid,startyear,startmonth,endyear,endmonth,agency,course,description) 
VALUES(".$aset['uid'].",".$aset['pid'].",".$aset['startyear'].",".$aset['startmonth'].",".$aset['endyear'].",".$aset['endmonth'].",'".$aset['agency']."','".$aset['course']."','".$aset['description']."')"; 
// echo $sql;exit;
$effect_row = $db->query($sql);


	
	if(!$effect_row){
		$androidresult['code']=0;
		$androidresult['errormsg']='服务器错误';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
		exit;
	}else{
		$androidresult['code']=1;
		$androidresult['errormsg']='';
		$androidresult['data']='';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
	}
?>