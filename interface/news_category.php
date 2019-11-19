<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db_1 = new mysql($dbhost,$dbuser,$dbpass,'zhichang');
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
isset($aset['topid'])? $wheresqlarr['topid']=$aset['topid']:$wheresqlarr['topid']=0;
isset($aset['topid'])?'':$reid=" and reid = 0 ";
//$wheresqlarr['topid']=0;
	if (is_array($wheresqlarr))
	{
		//$where_set=' WHERE';
		$comma=$wheresql='';
		foreach ($wheresqlarr as $key => $value)
		{
		$wheresql .=$where_set. $comma.'`'.$key.'`'.'=\''.$value.'\'';
		$comma = ' AND ';
		$where_set='';
		}
	}
//echo "SELECT id,reid,topid,typename FROM jplat_arctype WHERE ".$wheresql." and ishidden = 0 ".$reid."  ORDER BY  id DESC";exit;
$result = $db_1->query("SELECT id,reid,topid,typename FROM jplat_arctype WHERE ".$wheresql." and ishidden = 0 ".$reid."  ORDER BY  id DESC");
$list=array();
while($row = $db_1->fetch_array($result))
{
$row['type_id']=$row['id'];
//unset($row['category_order'],$row['title'],$row['description'],$row['keywords'],$row['admin_set'],$row['id']);
$list[] = $row;
}
//$list=export_mystrip_tags($list);
$androidresult['code']=1;
$androidresult['errormsg']='';
$androidresult['data']=android_iconv_utf8_array($list);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>