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
	// var_dump($list);exit;
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$androidresult['data']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
?>