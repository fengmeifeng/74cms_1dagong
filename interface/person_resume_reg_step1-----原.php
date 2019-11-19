<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_POST;
// $img_stream=file_get_contents('php://input');

// $file=QISHI_ROOT_PATH.'data/upload_img/'.time().'.jpg';
// $act=fopen($file,"w");
// fwrite($act,$img_stream);
// fclose($act);
$file=QISHI_ROOT_PATH.'data/upload_img/'.time().'.jpg';
move_uploaded_file($_FILES["img"]["tmp_name"],$file);

$sql="insert into qs_resume 
(uid,fullname,sex,sex_cn,birthdate,residence_cn,education_cn,experience_cn,telephone,email,photo_img) VALUES 
('".$aset['uid']."','".$aset['fullname']."','".$aset['sex']."','".$aset['sex_cn']."','".$aset['birthdate']."','".$aset['residence_cn']."
','".$aset['education_cn']."','".$aset['experience_cn']."','".$aset['telephone']."','".$aset['email']."','".$file."')";
// echo urldecode($aset['experience_cn'])."----".$aset['experience_cn'];exit;
// echo $_FILES["img"]["size"];exit;
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
		$res = $db->getone("select id from qs_resume where uid=".$aset['uid']." order by id desc limit 1");
		$androidresult['data']=$res['id'];
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
	}
?>