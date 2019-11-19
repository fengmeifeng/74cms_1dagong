<?php 
// error_reporting(0);
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
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
// $aset['district_cn']=iconv("gb2312","utf-8",$aset['district_cn']);
$wheresql=" WHERE audit=1 and deadline > ".$time;
//----fff
if (!empty($aset['jobcategory']))
{
	$dsql=$xsql="";
	$arr=explode(",",$aset['jobcategory']);
	$arr=array_unique($arr);
	if (count($arr)>10) exit();
	foreach($arr as $sid)
	{
		$cat=explode(".",$sid);
		if (intval($cat[2])===0)
		{
		$dsql.= " OR category =".intval($cat[1]);
		}
		else
		{
		$xsql.= " OR subclass =".intval($cat[2]);
		}
	}
	$wheresql.=" AND  (".ltrim(ltrim($dsql.$xsql),'OR').") ";
}
else
{
			if (isset($aset['category'])  && $aset['category']<>'')
			{
				if (strpos($aset['category'],"-"))
				{
					$or=$orsql="";
					$arr=explode("-",$aset['category']);
					$arr=array_unique($arr);
					if (count($arr)>10) exit();
					$sqlin=implode(",",$arr);
					if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
					{
					$wheresql.=" AND topclass IN  ({$sqlin}) ";
					}
				}
				else
				{
					$wheresql.=" AND topclass = ".intval($aset['category']);
				}
			}
			if (isset($aset['subclass'])  && $aset['subclass']<>'')
			{
				if (strpos($aset['subclass'],"-"))
				{
					$or=$orsql="";
					$arr=explode("-",$aset['subclass']);
					$arr=array_unique($arr);
					if (count($arr)>10) exit();
					$sqlin=implode(",",$arr);
					if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
					{
						$wheresql.=" AND category IN  ({$sqlin}) ";
					}
				}
				else
				{
					$wheresql.=" AND category = ".intval($aset['subclass']);
				}
			}
}
//----fff
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
$sql="SELECT id,uid,jobs_name,companyname,wage_cn,refreshtime,district_cn,category_cn FROM qs_jobs".$wheresql.$orderbysql.$limit;
// echo $sql;exit;
$result = $db->query($sql);

	$list= array();
	while($row = $db->fetch_array($result))
	{	
		// echo $row['refreshtime'];
		$row['refreshtime']=daterange(time(),$row['refreshtime'],'Y-m-d',"#FF3300");
		$list[] = $row;
	}

	// var_dump($list);exit;
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$androidresult['data']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);
	
?>