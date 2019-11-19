<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;

// $res=$db->getone("select photo_img from qs_resume where id=".$aset['id']);
// if($res['photo_img'] != $_FILES['img']['name']){	//新图片
	// $file=SITE_NAME.'/data/uploadimg/'.time().'.jpg';
	// move_uploaded_file($_FILES["img"]["tmp_name"],$file);
// }
// if(!empty($_FILES['img']['name'])){
	// $file=SITE_NAME.'/data/uploadimg/'.time().'.jpg';
	// move_uploaded_file($_FILES["img"]["tmp_name"],$file);
	// $sql="update qs_resume 
// set fullname='{$aset['fullname']}', title='{$aset['title']}', sex={$aset['sex']}, sex_cn='{$aset['sex_cn']}', 
// birthdate='{$aset['birthdate']}', residence_cn='{$aset['residence_cn']}', education_cn='{$aset['education_cn']}', 
// experience_cn='{$aset['experience_cn']}', telephone='{$aset['telephone']}', email='{$aset['email']}', photo_img='{$file}' 
// where id={$aset['id']}";
// }else{
	// $sql="update qs_resume 
// set fullname='{$aset['fullname']}', title='{$aset['title']}', sex={$aset['sex']}, sex_cn='{$aset['sex_cn']}', 
// birthdate='{$aset['birthdate']}', residence_cn='{$aset['residence_cn']}', education_cn='{$aset['education_cn']}', 
// experience_cn='{$aset['experience_cn']}', telephone='{$aset['telephone']}', email='{$aset['email']}' 
// where id={$aset['id']}";
// }


///-------1获取居住地id--开始---ffff
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
///-------1获取居住地id--结束---ffff

///-------2获取学历id--开始---ffff
		$sql_edu="SELECT * FROM qs_category WHERE c_alias ='QS_education' and c_name ='".trim($aset['education_cn'])."'";
		$res_edu=$db->getall($sql_edu);
		foreach($res_edu as $v)
		{
			 $education=$v['c_id'];
		}
		//echo $education;echo "<pre>";print_r($res_edu);exit;
///-------2获取学历id--结束---ffff

///-------3获取经验id--开始---ffff
		$sql_exp="SELECT * FROM qs_category WHERE c_alias ='QS_experience' and c_name ='".trim($aset['experience_cn'])."'";
		$res_exp=$db->getall($sql_exp);
		foreach($res_exp as $v)
		{
			 $experience=$v['c_id'];
		}
		//echo $experience;echo "<pre>";print_r($res_exp);exit;
///-------3获取经验id--结束---ffff
///----fffffff----性别判断
if(trim($aset['sex_cn']) == '女'){$aset['sex'] =2;}else{$aset['sex'] =1;}
///----fffffff
$sql="update qs_resume 
set fullname='{$aset['fullname']}', title='{$aset['title']}', sex='{$aset['sex']}', sex_cn='{$aset['sex_cn']}', 
birthdate='{$aset['birthdate']}', residence='{$residence}',residence_cn='{$aset['residence_cn']}', education='{$education}', education_cn='{$aset['education_cn']}', 
experience='{$experience}',experience_cn='{$aset['experience_cn']}', telephone='{$aset['telephone']}', email='{$aset['email']}' 
where id={$aset['id']}";
// echo urldecode($aset['experience_cn'])."----".$aset['experience_cn'];exit;
// echo $_FILES["img"]["size"];exit;
$bool = $db->query($sql);

	if(!$bool){
		$androidresult['code']=0;
		$androidresult['errormsg']='服务器错误';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
		exit;
	}else{
		$androidresult['code']=1;
		$androidresult['errormsg']='';
		$androidresult['data']='';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
	}
?>