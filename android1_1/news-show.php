<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset['id']=$aset['id']?intval($aset['id']):0;
$sql = "select * from ".table('article')." WHERE  id=".intval($aset['id'])." AND  is_display=1 LIMIT 1";
$val=$db->getone($sql);
if (empty($val))
{
	$result['result']=0;
	$result['errormsg']=android_iconv_utf8('信息不存在！');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
}
$db->query("update ".table('article')." set click=click+1 WHERE id=".intval($aset['id'])."  LIMIT 1");
$val['addtime']=date("Y-m-d",$val['addtime']);
$categoryname = $db->getone("SELECT * FROM ".table('article_category')." WHERE id='{$val['type_id']}' ");
$val['categoryname']=$categoryname['categoryname'];
$val=array_map('export_mystrip_tags',$val);
$androidresult['result']=1;
$androidresult['errormsg']='';
$androidresult['list']=android_iconv_utf8_array($val);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>