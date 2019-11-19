<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_POST;

$crashLog_contents=$aset['crashLog_contents'];
$dir=QISHI_ROOT_PATH.'data/upload_crashLog/'.date('Y-m-d',time());
if(!is_dir($dir)) mkdir($dir);
$file=QISHI_ROOT_PATH.'data/upload_crashLog/'.date('Y-m-d',time()).'/'.date('Y-m-d-H-i-s',time()).'.txt';
// echo $file.'<br />';
// echo $crashLog_contents;exit;
$act=fopen($file,"w");
fwrite($act,$crashLog_contents);
fclose($act);
// echo $sql;exit;
if(file_exists($file)){
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$androidresult['data']='';
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
}else{
	$androidresult['code']=0;
	$androidresult['errormsg']='日志上传失败';
	$androidresult['data']='';
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
}
?>