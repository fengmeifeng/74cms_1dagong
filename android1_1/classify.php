<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$categorytype=$_GET['categorytype'];
$listtop['id']='';
$listtop['parentid']='';
$listtop['categoryname']='不限';
$list[]=$listtop;
if ($categorytype=="jobs")
{
	$id=intval($_REQ['id']);
	$result = $db->query("SELECT id,parentid,categoryname FROM ".table('category_jobs')." where parentid=".$id." ORDER BY category_order desc,id asc".$limit);
	while($row = $db->fetch_array($result))
	{
	$row['categoryname']=$row['categoryname'];
	$list[] = $row;
	}
}
elseif ($categorytype=="district")
{
	$id=intval($_REQ['id']);
	$result = $db->query("SELECT id,parentid,categoryname FROM ".table('category_district')." where parentid=".$id." ORDER BY category_order desc,id asc".$limit);
	while($row = $db->fetch_array($result))
	{
	$row['categoryname']=$row['categoryname'];
	$list[] = $row;
	}
}
elseif ($categorytype=="settr")
{
	$list[] = array('id'=>'3','parentid'=>'0','categoryname'=>'3天内');
	$list[] = array('id'=>'7','parentid'=>'0','categoryname'=>'7天内');
	$list[] = array('id'=>'30','parentid'=>'0','categoryname'=>'30天内');
}
else
{
	$_CAT=get_cache('category');
	if (!empty($_CAT[$categorytype]))
	{
		foreach ($_CAT[$categorytype] as $cat)
		{
		$cat['categoryname']=$cat['categoryname'];
		unset($cat['stat_jobs'],$cat['stat_resume ']);
		$list[] = $cat;
		}
	}
	$list=array_map('export_mystrip_tags',$list);
}
$androidresult['result']=1;
$androidresult['errormsg']='';
$androidresult['list']=android_iconv_utf8_array($list);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>