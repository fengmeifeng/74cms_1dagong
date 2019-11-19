<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
//动态调整简历完整度
$return=$db->query("select * from qs_resume_education where pid=".$aset['resume_id']);
$list=array();
while($row=$db->fetch_array($return)){
	$list[]=$row;
}
if(count($list)==1){
	$db->query("update qs_resume set complete_percent=complete_percent-15 where id=".$aset['resume_id']);
}
//删除教育经历
$sql="delete from qs_resume_education where id in(".$aset['id'].")";
$row=$db->query($sql);

	if(!$row){
		$androidresult['code']=0;
		$androidresult['errormsg']='删除失败';
		$androidresult['data']='';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
	}else{
		$androidresult['code']=1;
		$androidresult['errormsg']='';
		$androidresult['data']='';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
	}

?>