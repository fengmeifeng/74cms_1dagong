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
$wheresql=" WHERE audit=1";
isset($aset['district_cn'])?$wheresql.=" AND district_cn like '%".$aset['district_cn']."%' ":'';//地区条件
isset($aset['wage'])?$wheresql.=" AND wage=".intval($aset['wage'])." ":'';//工资条件
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
if (!empty($aset['key']))
{
$key=trim($aset['key']);
$wheresql.=" AND companyname like '%".$key."%'";

}

//分站条件
if (!empty($aset['district_cn']))
{
	$wheresql.=" AND district_cn like '%".$aset['district_cn']."%'";
}
$orderbysql=" order by refreshtime desc";
$limit=" LIMIT ".abs($aset['start']).','.$aset['page_size'];
$sql="SELECT id,uid,companyname,nature_cn,refreshtime,trade_cn,district_cn,scale_cn FROM qs_company_profile".$wheresql.$orderbysql.$limit;
// echo $sql;exit;
$result = $db->query($sql);

	$list= array();
	while($row = $db->fetch_array($result))
	{
		$row['content']=str_replace('&nbsp;','',$row['content']);
			if ($aset['infolen']>0)
			{
			$row['content']=cut_str(strip_tags($row['content']),$aset['infolen'],0,$aset['dot']);
			}
		$row['addtime']=date("Y-m-d",$row['addtime']);
		$row['refreshtime']=date('Y-m-d H:i:s',$row['refreshtime']);
		$list[] = $row;
	}
	if(empty($list)){
		$androidresult['code']=0;
		$androidresult['errormsg']='搜索的职位或公司不存在';
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