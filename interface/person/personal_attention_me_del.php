<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
//require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');

$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	unset($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$id=isset($aset['id'])?intval($aset['id']):"";
	$id=addslashes($id);
	$id=iconv("utf-8",QISHI_DBCHARSET,$id);
	//echo $aset['id'];exit;
	
	if (empty($id))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到记录');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	function del_view_resume($del_id)
	{
		global $db;
		if (!is_array($del_id)) $del_id=array($del_id);
		$sqlin=implode(",",$del_id);
		if (!preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin)) return false;
		if (!$db->query("Delete from ".table('view_resume')." WHERE id IN ({$sqlin}) ")) return false;
		return true;
	}
	if(del_view_resume($id)){
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=array('id'=>$id);
	$jsonencode = android_iconv_utf8_array($result);
	$jsonencode = urldecode(json_encode($result));
	//exit($jsonencode);
	echo urldecode($jsonencode);
	}else{
	$result['code']=-1;
	$result['errormsg']=android_iconv_utf8('删除失败');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}

?>