<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;

$img_stream=$_REQUEST['img'];
$file=QISHI_ROOT_PATH.'data/upload_img/'.time().'.jpg';
$act=fopen($file,"w");
fwrite($act,$img_stream);
fclose($act);
$sql="update qs_members set avatars=".$file." where uid=".$aset['uid'];
$db->query($sql);
// echo $sql;exit;
if(file_exists($file)){
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$androidresult['data']='';
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
}else{
	$androidresult['code']=0;
	$androidresult['errormsg']='图片上传失败';
	$androidresult['data']='';
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
}
?>