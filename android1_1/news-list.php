<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset['start']=intval($aset['start']);
$aset['row']=intval($aset['row']);
if ($aset['row']==0)
{
$aset['row']=10;
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
$wheresql=" WHERE is_display=1";
isset($aset['parentid'])?$wheresql.=" AND parentid=".intval($aset['parentid'])." ":'';
isset($aset['type_id'])?$wheresql.=" AND type_id=".intval($aset['type_id'])." ":'';
isset($aset['attribute'])?$wheresql.=" AND focos=".intval($aset['attribute'])." ":'';
isset($aset['img'])?$wheresql.=" AND Small_img<>'' ":'';
if (isset($aset['settr']))
{
$settr_val=strtotime("-".intval($aset['settr'])." day");
$wheresql.=" AND addtime > ".$settr_val;
}
if (!empty($aset['key']))
{
$key=trim($aset['key']);
$wheresql.=" AND title like '%{$key}%'";
}
$limit=" LIMIT ".abs($aset['start']).','.$aset['row'];
$result = $db->query("SELECT id,title,content,addtime,click FROM ".table('article')." ".$wheresql.$orderbysql.$limit);
$list= array();
while($row = $db->fetch_array($result))
{
	$row['content']=str_replace('&nbsp;','',$row['content']);
		if ($aset['infolen']>0)
		{
		$row['content']=cut_str(strip_tags($row['content']),$aset['infolen'],0,$aset['dot']);
		}
	$row['addtime']=date("Y-m-d",$row['addtime']);
	$list[] = $row;
}
$list=array_map('export_mystrip_tags',$list);
$androidresult['result']=1;
$androidresult['errormsg']='';
$androidresult['list']=android_iconv_utf8_array($list);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>