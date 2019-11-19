<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
//require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');

function add_favorites($id,$uid)
{
	global $db,$timestamp;
		if (strpos($id,"-"))
		{
			$id=str_replace("-",",",$id);
			if (!preg_match("/^(\d{1,10},)*(\d{1,10})$/",$id)) return false;
		}
		else
		{
		$id=intval($id);
		}
	$sql = "select * from ".table('jobs')." WHERE id IN ({$id}) ";
	$jobs=$db->getall($sql);
	$i=0;
	foreach($jobs as $list)
	{
		$sql1 = "select jobs_id from ".table('personal_favorites')." where jobs_id=".$list['id']." AND personal_uid=".$uid."  LIMIT 1";
		if ($db->getone($sql1))
		{
		continue;
		}
		$setsqlarr['personal_uid']=$uid;
		$setsqlarr['jobs_id']=$list['id'];
		$setsqlarr['jobs_name']=addslashes($list['jobs_name']);
		$setsqlarr['addtime']=$timestamp;
		inserttable(table('personal_favorites'),$setsqlarr);
		$i=$i+1;
	}
	return $i;
}

$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	unset($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['userid'];exit;
	$jobsid=isset($aset['jobsid'])?trim($aset['jobsid']):"";
	$jobsid=addslashes($jobsid);
	$jobsid=iconv("utf-8",QISHI_DBCHARSET,$jobsid);
	//echo $aset['jobsid'];exit;
	
	if (empty($userid))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该用户');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	
	if(add_favorites($jobsid,$userid)==0)
	{
		$result['code']=-1;
		$result['errormsg']=android_iconv_utf8('收藏失败，收藏夹中已经存在此职位');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}else{
		///-----查找收藏的id
		$didarr=$db->getone("select did from ".table('personal_favorites')." where jobs_id=".$jobsid);
		//------
		$androidresult['code']=1;
		$androidresult['errormsg']='';
		$androidresult['data']=array("did"=>$didarr['did']);
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);	
	}
	

?>