<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset['id']=$aset['id']?intval($aset['id']):0;
$wheresql.=" AND  user_status=1 ";
$sql = "select * from ".table('company_profile')." WHERE  id='{$aset['id']}' {$wheresql} LIMIT  1";
$profile=$db->getone($sql);
$val=$db->getone($sql);
if (empty($val))
	{
		$result['result']=0;
		$result['errormsg']=android_iconv_utf8('信息不存在！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	else
	{
			$val['addtime']=date("Y-m-d",$val['addtime']);
			$val['refreshtime']=date("Y-m-d",$val['refreshtime']);
	}
	$db->query("update ".table('company_profile')." set click=click+1 WHERE id='{$aset['id']}'  LIMIT 1");
$androidresult['result']=1;
$androidresult['errormsg']='';
$val=array_map('export_mystrip_tags',$val);
$androidresult['list']=android_iconv_utf8_array($val);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>