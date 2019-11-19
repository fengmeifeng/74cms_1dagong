<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db_1 = new mysql($dbhost,$dbuser,$dbpass,'zhichang');
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset['id']=$aset['id']?intval($aset['id']):0;
$sql = "select c.title,c.description,c.typeid,c.pubdate,c.senddate,c.writer,a.body from jplat_archives as c left join jplat_addonarticle as a on c.id=a.aid  WHERE  c.id=".intval($aset['id'])." AND  c.arcrank=0 LIMIT 1";
$val=$db_1->getone($sql);
if (empty($val))
{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('信息不存在！');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
}
$db_1->query("update jplat_archives set click=click+1 WHERE id=".intval($aset['id'])."  LIMIT 1");
//echo date('Y-m-d',1438590429);exit;
$val['pubdate']=date("Y-m-d",$val['pubdate']);
$val['senddate']=date("Y-m-d",$val['senddate']);
$categoryname = $db_1->getone("SELECT * FROM jplat_arctype WHERE id='{$val['typeid']}' ");
$val['typename']=$categoryname['typename'];
$val=array_map('export_mystrip_tags',$val);
$androidresult['code']=1;
$androidresult['errormsg']='';
$androidresult['data']=android_iconv_utf8_array($val);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>