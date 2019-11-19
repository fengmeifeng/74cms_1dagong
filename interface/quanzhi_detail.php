<?php 
// error_reporting(0);
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
function DeleteHtml($str) 
{ 
$str = trim($str); 
$str = strip_tags($str,""); 
$str = ereg_replace("\t","",$str); 
$str = ereg_replace("\r\n","",$str); 
$str = ereg_replace("\r","",$str); 
$str = ereg_replace("\n","",$str); 
$str = ereg_replace(" "," ",$str); 
return trim($str); 
}
$aset=$_REQ;
$aset['page']=intval($aset['page']);
$aset['page_size']=intval($aset['page_size']);
if (empty($aset['page_size']))
{
$aset['page_size']=10;
}
if($aset['page']!=0){
	$aset['start']=($aset['page']-1)*$aset['page_size'];
}
$aset['titlelen']=30;
$aset['infolen']=50;
if ($aset['displayorder'])
{
	if (strpos($aset['displayorder'],'>'))
	{
	$arr=explode('>',$aset['displayorder']);
	$arr[0]=preg_match('/article_order|click|id/',$arr[0])?$arr[0]:"";
	$arr[1]=preg_match('/asc|desc/',$arr[1])?$arr[1]:"";
		if ($arr[0] && $arr[1])
		{
		$orderbysql=" ORDER BY ".$arr[0]." ".$arr[1];
		}
		if ($arr[0]=="article_order")
		{
		$orderbysql.=" ,id DESC ";
		}
	}
}
$time=time();
// $wheresql=" WHERE audit=1 and deadline > ".$time AND nature=63;
$wheresql=" WHERE id=".$aset['id'];
isset($aset['district_cn'])?$wheresql.=" AND district_cn='".$aset['district_cn']."' ":'';//地区条件
isset($aset['wage'])?$wheresql.=" AND wage=".intval($aset['wage'])." ":'';//工资条件
// isset($aset['wage'])?$wheresql.=" AND wage=".intval($aset['wage'])." ":'';//工资条件
isset($aset['parentid'])?$wheresql.=" AND parentid=".intval($aset['parentid'])." ":'';
isset($aset['type_id'])?$wheresql.=" AND type_id=".intval($aset['type_id'])." ":'';
isset($aset['attribute'])?$wheresql.=" AND focos=".intval($aset['attribute'])." ":'';
// isset($aset['uid'])?$wheresql.=" AND uid=".intval($aset['uid'])." ":'';
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
$sql="SELECT id,uid,companyname,district_cn,category_cn,jobs_name,wage_cn,refreshtime,click,amount,education_cn,
age,experience_cn,contents,uid FROM qs_jobs".$wheresql;
// echo $sql;exit;
$result = $db->query($sql);

	$list= array();
	while($row = $db->fetch_array($result))
	{
		$sql="select did from qs_personal_favorites where personal_uid='{$aset['uid']}' and jobs_id='{$row['id']}'";
		// echo $sql;
		$aa=$db->query($sql);
		while($row_1 = $db->fetch_array($aa)){
			$list_1=$row_1;
		}
		if($list_1){
			$row['shoucang_status']=1;
		}else{
			$row['shoucang_status']=0;
		}
		// var_dump($list_1);
		$row['did']=$list_1['did'];
		//公司号码
		$sql_phone="select telephone,telephone_show from qs_company_profile where uid=".$aset['company_id'];
		$res_phone=$db->getone($sql_phone);
		$row['telephone']=$res_phone['telephone'];
		$row['telephone_show']=$res_phone['telephone_show'];
		$row['refreshtime']=date("Y-m-d",$row['refreshtime']);
		///----fffff
		$row['contents'] = DeleteHtml($row['contents']);
		//-----fffff
		$list[] = $row;
	}
	if(!$list){
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
	$androidresult['data']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
	}
?>