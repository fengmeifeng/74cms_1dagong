<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
isset($aset['typeid'])? $wheresqlarr['id']=intval($aset['typeid']):'';
$wheresqlarr['parentid']=1;
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
$result = $db->query("SELECT * FROM ".table('article_category')." ".$wheresql." ORDER BY  category_order DESC");
$list=array();
while($row = $db->fetch_array($result))
{
$row['type_id']=$row['id'];
unset($row['category_order'],$row['title'],$row['description'],$row['keywords'],$row['admin_set'],$row['id']);
$list[] = $row;
}
//$list=export_mystrip_tags($list);
$androidresult['result']=1;
$androidresult['errormsg']='';
$androidresult['list']=android_iconv_utf8_array($list);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>