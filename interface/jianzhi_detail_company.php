<?php 
// error_reporting(0);
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
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
$sql="SELECT uid,companyname,scale_cn,nature_cn,trade_cn,district_cn,contents,telephone,telephone_show FROM qs_company_profile".$wheresql;
// echo $sql;exit;
$result = $db->query($sql);

	$list= array();
	while($row = $db->fetch_array($result))
	{
		$row['refreshtime']=date("Y-m-d",$row['refreshtime']);
		$list[] = $row;
	}
$sql2="select id,uid,jobs_name,wage_cn from qs_jobs where uid=".$aset['id'].$limit;
// echo $sql2;
$result2 = $db->query($sql2);
	$list2= array();
	while($row = $db->fetch_array($result2))
	{
		// $row['refreshtime']=date("Y-m-d",$row['refreshtime']);
		$list2[] = $row;
	}
	if(empty($list)){
		$androidresult['code']=0;
		$androidresult['errormsg']='参数错误';
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
		exit;
	}else{
	// var_dump($list);exit;
	$list=array_map('export_mystrip_tags',$list);
	$list2=array_map('export_mystrip_tags',$list2);
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$androidresult['data']=android_iconv_utf8_array($list);
	$androidresult['data2']=android_iconv_utf8_array($list2);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
	}
?>