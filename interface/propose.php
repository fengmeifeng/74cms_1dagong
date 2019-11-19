<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$sql="insert into qs_propose (addtime,userid,contents) VALUES ('".time()."','".intval($aset['userid'])."','".$aset['contents']."')";
// echo $sql;exit;
$insertid = $db->query($sql);


	
	if(!$insertid){
		$androidresult['code']=0;
		$androidresult['errormsg']='·þÎñÆ÷´íÎó';
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