<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['userid'];exit;
	$resumeID=isset($aset['resumeID'])?intval($aset['resumeID']):"";
	$resumeID=addslashes($resumeID);
	$resumeID=iconv("utf-8",QISHI_DBCHARSET,$resumeID);
	//echo $aset['did'];exit;
	if (empty($resumeID))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该记录');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	function set_resume_entrust($resume_id)
	{
		global $db;
		$resume = $db->getone("select audit,uid,fullname,addtime from ".table('resume')." where id=".$resume_id);
		if($resume["audit"]=="1"){
			$has = $db->getone("select 1 from ".table('resume_entrust')." where id=".$resume_id);
			if(!$has){
				$setsqlarr['id'] = $resume_id;
				$setsqlarr['uid'] = $resume['uid'];
				$setsqlarr['fullname'] = $resume['fullname'];
				$setsqlarr['resume_addtime'] = $resume['addtime'];
				inserttable(table('resume_entrust'),$setsqlarr);
			}
		}
		else
		{
			$db->query("delete from ".table('resume_entrust')." where id=".$resume_id);
		}
		return true;
	}
	updatetable(table('resume'),array("entrust"=>1)," id='".intval($resumeID)."' AND uid='".intval($userid)."'");
	//echo date('Y-m-d H:i:s',1438583758);exit;
	if(set_resume_entrust($resumeID)){
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=array('userid'=>$userid,'resumeID'=>$resumeID);
	$jsonencode = android_iconv_utf8_array($result);
	$jsonencode = urldecode(json_encode($result));
	//exit($jsonencode);
	echo urldecode($jsonencode);
	}else{
	$result['code']=-1;
	$result['errormsg']=android_iconv_utf8('委托失败');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
?>