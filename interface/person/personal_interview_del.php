<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');

function del_jobs_apply($del_id,$uid)
{
	global $db;
	$uidsql=" AND personal_uid=".intval($uid)." ";
	if (!is_array($del_id)) $del_id=array($del_id);
	$sqlin=implode(",",$del_id);
	if (!preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin)) return false;
	//echo "Delete from ".table('personal_jobs_apply')." WHERE did IN (".$sqlin.") ".$uidsql."";exit;
	if (!$db->query("Delete from ".table('personal_jobs_apply')." WHERE did IN (".$sqlin.") ".$uidsql."")) return false;
	write_memberslog($_SESSION['uid'],2,1302,$_SESSION['username'],"删除了职位申请($sqlin)");
	return true;
}

$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	unset($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['userid'];exit;
	$did=isset($aset['did'])?$aset['did']:"";
	$did=addslashes($did);
	$did=iconv("utf-8",QISHI_DBCHARSET,$did);
	//echo $aset['page'];exit;
	
	
	if (empty($did))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该记录');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	
	if(del_jobs_apply($did,$userid)){
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=array('userid'=>$userid,'did'=>$did);
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