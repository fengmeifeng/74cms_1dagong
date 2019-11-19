<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
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
		$orderbysql.=" ,show_order DESC ";
		}
	}
}else{
	
$orderbysql.=' ORDER BY  show_order desc';
}

$wheresql=" WHERE alias = 'app_banner' and is_display = 1 and deadline > ".time();
isset($aset['type_id'])?$wheresql.=" AND typeid=".intval($aset['type_id'])." ":'';
//---ffff

$limit=" LIMIT ".abs($aset['page']).','.$aset['pagesize'];
//echo "SELECT id,title,content,img_path,addtime FROM ".table('ad')." ".$wheresql.$orderbysql.$limit;exit;
$result = $db->query("SELECT id,note,title,img_path,addtime,show_order FROM ".table('ad')." ".$wheresql.$orderbysql.$limit);
$list= array();
while($row = $db->fetch_array($result))
{
	$row['img_path']="http://www.1dagong.com".$row['img_path'];
	$row['addtime']=daterange(time(),$row['addtime'],'Y-m-d',"#FF3300");
	$row['title']=$row['note'];
	$list[] = $row;
}
///------
$result1 = $db->query("SELECT id,note,img_path,addtime,show_order FROM ".table('ad')." WHERE alias = 'app_fangtan' and is_display = 1 and deadline > ".time()." ".$orderbysql." limit 1");
$li= array();

while($row1 = $db->fetch_array($result1))
{
	$row1['img_path']="http://www.1dagong.com".$row1['img_path'];
	$row1['addtime']=daterange(time(),$row1['addtime'],'Y-m-d',"#FF3300");
	$row1['title']=$row1['note'];
	$li[] = $row1;
	
}
///------
$list=array_map('export_mystrip_tags',$list);
$androidresult['code']=1;
$androidresult['errormsg']='';
$androidresult['banner']=android_iconv_utf8_array($list);
$androidresult['interview']=android_iconv_utf8_array($li);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>