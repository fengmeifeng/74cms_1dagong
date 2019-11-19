<?php 
// error_reporting(0);
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
// echo 'zwl2';exit;
	 		$addarr['resume_id']=$aset['resumeid'];
			// $addarr['resume_name']=$aset['title'];
			$addarr['personal_uid']=$aset['person_uid'];
			// $addarr['jobs_id']=$aset['jobs_id'];
			// $addarr['jobs_name']=$aset['jobs_name'];
			// $addarr['company_name']=$aset['companyname'];
			// $addarr['company_uid']=$aset['company_uid'];
			$addarr['apply_addtime']=time();
			$addarr['personal_look']=1;
			$sql="select title from qs_resume where id=".$aset['resumeid'];
			// echo $sql;exit;
			$res=$db->getone($sql);
			// $addarr['resume_name']= empty($res['title'])? "我的简历":$res['title'];
			$addarr['resume_name']=$res['title'];
			// var_dump($addarr['resume_name']);exit;
// $wheresql=" WHERE audit=1 and deadline > ".$time AND nature=63;
$wheresql=" WHERE uid=".$aset['uid']." AND telephone_show=1";
isset($aset['district_cn'])?$wheresql.=" AND district_cn='".$aset['district_cn']."' ":'';//地区条件
isset($aset['wage'])?$wheresql.=" AND wage=".intval($aset['wage'])." ":'';//工资条件
// isset($aset['wage'])?$wheresql.=" AND wage=".intval($aset['wage'])." ":'';//工资条件
isset($aset['parentid'])?$wheresql.=" AND parentid=".intval($aset['parentid'])." ":'';
isset($aset['type_id'])?$wheresql.=" AND type_id=".intval($aset['type_id'])." ":'';
isset($aset['attribute'])?$wheresql.=" AND focos=".intval($aset['attribute'])." ":'';
isset($aset['uid'])?$wheresql.=" where uid=".intval($aset['uid'])." ":'';
isset($aset['img'])?$wheresql.=" AND Small_img<>'' ":'';
if (isset($aset['settr']))
{
$settr_val=strtotime("-".intval($aset['settr'])." day");
$wheresql.=" AND addtime > ".$settr_val;
}
/*if (!empty($aset['key']))
{
$key=trim($aset['key']);
//公司搜索与职位搜索分流
if($aset['operate_code']=="1"){//公司
	$wheresql.=" AND companyname like '%{$key}%'";
}elseif($aset['operate_code']=="2"){//职位
	$wheresql.=" AND jobs_name like '%{$key}%'";
}
}*/
$orderbysql=" order by refreshtime desc";
$limit=" LIMIT ".abs($aset['start']).','.$aset['page_size'];
//将接收到的职位ID转化成数组
$arr_id=explode(",",$aset['id']);
// echo 'zwl1';
// var_dump($arr_id);
foreach($arr_id as $v){
	$sql="select id, jobs_name, companyname, uid, company_id from qs_jobs where id=".$v;
	// echo $sql;
	$res=$db->getone($sql);
	$addarr['jobs_name']=$res['jobs_name'];
	$addarr['company_name']=$res['companyname'];
	$addarr['company_uid']=$res['uid'];
	$addarr['company_id']=$res['company_id'];
	$addarr['jobs_id']=$res['id'];
	// echo $addarr['company_name'];
	// var_dump($addarr);
	//判断是否已申请职位
	$check_apply=$db->getone("select did from qs_personal_jobs_apply where jobs_id='{$v}' AND resume_id='{$addarr['resume_id']}'");
	if(!empty($check_apply)){
		$androidresult['code']=2;
		$androidresult['errormsg']="职位重复申请";
		$jsonencode = json_encode($androidresult);
		$androidresult['data']=$addarr['jobs_name'];
		echo urldecode($jsonencode);
		exit;
	}
	$insertid=inserttable(table('personal_jobs_apply'),$addarr);
}
	if(!$insertid){
		$androidresult['code']=0;
		$androidresult['errormsg']='参数错误';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
		exit;
	}else{
	// var_dump($list);exit;
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
	}
?>