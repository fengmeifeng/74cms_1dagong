<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db_1 = new mysql($dbhost,$dbuser,$dbpass,'zhichang');
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset['page']=intval($aset['page']);
if($aset['page'] ==1 ){$aset['page']=0;}
$aset['pagesize']=intval($aset['pagesize']);
if ($aset['pagesize']==0)
{
$aset['pagesize']=10;
}
$aset['titlelen']=30;
$aset['infolen']=50;
if ($aset['displayorder'])
{
	if (strpos($aset['displayorder'],'>'))
	{
	$arr=explode('>',$aset['displayorder']);
	$arr[0]=preg_match('/pubdate|click|id/',$arr[0])?$arr[0]:"";
	$arr[1]=preg_match('/asc|desc/',$arr[1])?$arr[1]:"";
		if ($arr[0] && $arr[1])
		{
		$orderbysql=" ORDER BY ".$arr[0]." ".$arr[1];
		}
		if ($arr[0]=="pubdate")
		{
		$orderbysql.=" ,id DESC ";
		}
	}
}
$wheresql=" WHERE arcrank >= 0 and ismake = 1 ";
//isset($aset['topid'])?$wheresql.=" AND topid=".intval($aset['topid'])." ":'';
isset($aset['type_id'])?$wheresql.=" AND typeid=".intval($aset['type_id'])." ":'';
//isset($aset['attribute'])?$wheresql.=" AND focos=".intval($aset['attribute'])." ":'';
//isset($aset['img'])?$wheresql.=" AND Small_img<>'' ":'';
if (isset($aset['settr']))
{
$settr_val=strtotime("-".intval($aset['settr'])." day");
$wheresql.=" AND pubdate > ".$settr_val;
}
if (!empty($aset['key']))
{
$key=trim($aset['key']);
$wheresql.=" AND title like '%{$key}%'";
}
//---ffff
if (!empty($aset['typeid']))
{
	$typeid=intval($aset['typeid']);
	$result = $db_1->query("SELECT id FROM jplat_arctype where reid =".$typeid." and ishidden = 0 ORDER BY  id DESC");
	while($row = $db_1->fetch_array($result))
	{
		$typeidarr[] = $row;
	}
	if($typeidarr){//-------顶级菜单---搜索二级菜单
	foreach($typeidarr as $val){
		$typeres[]=$val['id'];
	}
	$typeid=implode(',',$typeres);
	//echo "<pre>";print_r($typeres);echo $typeidarr['id'];echo "<pre>";print_r($typeidarr);exit;
	$wheresql.=" AND typeid in ({$typeid})";
	
	}else{//---二级菜单
	$wheresql.=" AND typeid ={$typeid}";		
	}

}
//---ffff
$limit=" LIMIT ".abs($aset['page']).','.$aset['pagesize'];
//echo "SELECT id,typeid,title,description,pubdate,senddate,click,litpic FROM jplat_archives ".$wheresql.$orderbysql.$limit;exit;
$result = $db_1->query("SELECT id,typeid,title,description,pubdate,senddate,click,litpic FROM jplat_archives ".$wheresql.$orderbysql.$limit);
$list= array();
while($row = $db_1->fetch_array($result))
{
	$row['description']=str_replace('&nbsp;','',$row['description']);
		if ($aset['infolen']>0)
		{
		$row['description']=cut_str(strip_tags($row['description']),$aset['infolen'],0,$aset['dot']);
		}
	$row['pubdate']=date("Y-m-d",$row['pubdate']);
	$row['senddate']=date("Y-m-d",$row['senddate']);
	$list[] = $row;
}
$list=array_map('export_mystrip_tags',$list);
$androidresult['code']=1;
$androidresult['errormsg']='';
$androidresult['data']=android_iconv_utf8_array($list);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>