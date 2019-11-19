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
$limit=" LIMIT ".abs($aset['page']).','.$aset['pagesize'];
isset($aset['typeid'])? $wheresqlarr['reid']=intval($aset['typeid']):$wheresql='where topid = 0 and reid= 0 ';

	if (is_array($wheresqlarr))
	{
		$where_set=' WHERE';
		$comma=$wheresql='';
		foreach ($wheresqlarr as $key => $value)
		{
		$wheresql .=$where_set. $comma.'`'.$key.'`'.'=\''.$value.'\'';
		$comma = ' AND ';
		$where_set='';
		}
	}
$result = $db_1->query("SELECT id,reid,topid,typename FROM jplat_arctype ".$wheresql." and ishidden = 0 ORDER BY  id DESC".$limit);
while($row = $db_1->fetch_array($result))
{
//$row['type_id']=$row['id'];
//unset($row['category_order'],$row['title'],$row['description'],$row['keywords'],$row['admin_set'],$row['id']);
$list[] = $row;
}
//-----没有二级栏目
if(!$list){

//echo "SELECT id,typeid,title,description,pubdate,senddate,click,litpic FROM jplat_archives ".$wheresql.$orderbysql.$limit;exit;
$result1 = $db_1->query("SELECT id,typeid,title,description,pubdate,senddate,click,litpic FROM jplat_archives WHERE arcrank >= 0 and ismake = 1 and typeid =".intval($aset['typeid'])." order by senddate desc".$limit);
$list1= array();
while($row = $db_1->fetch_array($result1))
{
	$row['description']=str_replace('&nbsp;','',$row['description']);
		if ($aset['infolen']>0)
		{
		$row['description']=cut_str(strip_tags($row['description']),$aset['infolen'],0,$aset['dot']);
		}
	$row['pubdate']=date("Y-m-d",$row['pubdate']);
	$row['senddate']=date("Y-m-d",$row['senddate']);
	$list1[] = $row;
}
$list1=array_map('export_mystrip_tags',$list1);
$androidresult['code']=1;
$androidresult['errormsg']='';
$androidresult['data']=android_iconv_utf8_array($list1);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
exit;	
}
//-----没有二级
//$list=export_mystrip_tags($list);
$androidresult['code']=1;
$androidresult['errormsg']='';
$androidresult['data']=android_iconv_utf8_array($list);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>