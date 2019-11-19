<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;

$sql="select id,uid,companyname,map_x,map_y from qs_company_profile where map_open=1 AND sdistrict=224 AND map_x !=''";

$result = $db->query($sql);

	$list= array();
	while($row = $db->fetch_array($result))
	{
		$list[] = $row;
	}
if($list){
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$androidresult['data']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
}else{
	$androidresult['code']=0;
	$androidresult['errormsg']='';
	$androidresult['data']='';
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
}
?>