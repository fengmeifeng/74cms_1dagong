<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;




$sql="update qs_resume set intention_jobs=".$aset['intention_jobs']." where id=".$aset['id']; 
// echo $sql;exit;
$effect_row = $db->query($sql);


	
	if(!$effect_row){
		$androidresult['code']=0;
		$androidresult['errormsg']='服务器错误';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
		exit;
	}else{
		$list=array_map('export_mystrip_tags',$list);
		$androidresult['code']=1;
		$androidresult['errormsg']='';
		$androidresult['data']='';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
	}
?>