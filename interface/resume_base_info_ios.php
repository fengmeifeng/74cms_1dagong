<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;

$sql="select * from qs_resume where id={$aset['id']}";
// echo $sql;exit;
$arr=$db->query($sql);
while($row=$db->fetch_array($arr)){
	$list[]=$row;
}

	
	if(!$list){
		$androidresult['code']=0;
		$androidresult['errormsg']='·þÎñÆ÷´íÎó';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
		exit;
	}else{
		$list=array_map('export_mystrip_tags',$list);
		$androidresult['code']=1;
		$androidresult['errormsg']='';
		$androidresult['data']=android_iconv_utf8_array($list);
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
	}
?>