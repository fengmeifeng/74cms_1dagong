<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
// $img_stream=file_get_contents('php://input');

// $file=QISHI_ROOT_PATH.'data/upload_img/'.time().'.jpg';
// $act=fopen($file,"w");
// fwrite($act,$img_stream);
// fclose($act);
$uid=$aset['uid'];
//居住地、学历、工作经验 中文转ID
/*
$residence_cn_arr = explode('/',$aset['residence_cn']);
$aset['residence_cn'] = $residence_cn_arr[1];
$residence_row = $db->getone("select id,parentid from qs_category_district where categoryname='{$aset['residence_cn']}'");
$residence = $residence_row['parentid'].'.'.$residence_row['id'];
$residence_shen_row = $db->getone("select categoryname from qs_category_district where id={$residence_row[parentid]}");
$residence_cn = $residence_shen_row['categoryname'].'/'.$aset['residence_cn'];
*/
//--------获取地区id
$str=trim($aset['residence_cn']);
		//echo iconv(QISHI_DBCHARSET,"utf-8",trim($aset['residence_cn']));exit;
		if(preg_match('/(.*)\/{1}([^\/]*)/i',$str))
		{
			$district_cn = preg_replace('/(.*)\/{1}([^\/]*)/i', '$2',$str);
			
		}else
		{
			$district_cn=$str;
		}
		$sql_distric="SELECT * FROM ".table('category_district')." WHERE categoryname like '%".$district_cn."%'";
		$res_distric=$db->getall($sql_distric);
		foreach($res_distric as $v)
		{
			 $residence=$v['parentid'].".".$v['id'];
			 //$district=$v['parentid'];
			 //$sdistrict=$v['id'];
		}
		$residence_cn=trim($aset['residence_cn']);
///----fffffff----性别判断
if(trim($aset['sex_cn']) == '女'){$aset['sex'] =2;}else{$aset['sex'] =1;}
///----fffffff		
$education_row = $db->getone("select c_id from qs_category where c_name='{$aset['education_cn']}'");
$education = $education_row['c_id'];
$experience_row = $db->getone("select c_id from qs_category where c_name='{$aset['experience_cn']}'");
$experience = $experience_row['c_id'];
$sql="insert into qs_resume 
(uid,fullname,title,sex,sex_cn,birthdate,residence,residence_cn,education,education_cn,experience,experience_cn,telephone,email) VALUES 
('".$aset['uid']."','".$aset['fullname']."','".$aset['title']."','".$aset['sex']."','".$aset['sex_cn']."','".$aset['birthdate']."','".$residence."','".$residence_cn."
','".$education."','".$aset['education_cn']."','".$experience."','".$aset['experience_cn']."','".$aset['telephone']."','".$aset['email']."')";
// echo urldecode($aset['experience_cn'])."----".$aset['experience_cn'];exit;
// echo $_FILES["img"]["size"];exit;
 //echo $residence,$residence_cn,$education,$experience,$sql;exit;

//echo iconv(QISHI_DBCHARSET,"utf-8",$sql);exit;
$bool = $db->query($sql);
$insertid=$db->insert_id();
if($insertid != 0){
	$db->query("update qs_resume set complete_percent=complete_percent+40 where id=".$insertid);
}
	
	if(!$bool){
		$androidresult['code']=0;
		$androidresult['errormsg']='服务器错误';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
		exit;
	}else{
		$list=array_map('export_mystrip_tags',$list);
		$androidresult['code']=1;
		$androidresult['errormsg']='';
		$res = $db->getone("select id from qs_resume where uid=".$uid." order by id desc limit 1");
		$androidresult['data']=$res['id'];
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
	}
?>