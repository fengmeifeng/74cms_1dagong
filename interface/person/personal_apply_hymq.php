<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
//require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/fun_personal.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	unset($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['userid'];exit;
	$resumeID=isset($aset['resumeID'])?trim($aset['resumeID']):"";
	$resumeID=addslashes($resumeID);
	$resumeID=iconv("utf-8",QISHI_DBCHARSET,$resumeID);
	//echo $aset['resumeID'];exit;
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
	$jobsarr=app_get_hymq($jobsid);
	if (empty($jobsarr))
	{
	//exit("职位丢失");
	$result['code']=2;
	$result['errormsg']=android_iconv_utf8('职位丢失');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	$resume_basic=get_resume_basic($userid,$resumeID);
	if (empty($resume_basic))
	{
	//exit("简历丢失");
	$result['code']=3;
	$result['errormsg']=android_iconv_utf8('简历丢失');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	foreach($jobsarr as $jobs)
	 {
		 //-------fffff
		 if (check_hymq_apply($jobs['id'],$resumeID,$userid))
			{
				$result['code']=4;
				$result['errormsg']=android_iconv_utf8('你已经申请了该名企');
				$jsonencode = urldecode(json_encode($result));
				exit($jsonencode);
			}
			if ($resume_basic['display_name']=="2")
			{
				$personal_fullname="N".str_pad($resume_basic['id'],7,"0",STR_PAD_LEFT);
			}
			elseif($resume_basic['display_name']=="3")
			{
				$personal_fullname=cut_str($resume_basic['fullname'],1,0,"**");
			}
			else
			{
				$personal_fullname=$resume_basic['fullname'];
			}
			
	 		$addarr['resume_id']=$resumeID;//----简历的id
			$addarr['resume_name']=$personal_fullname;
			$addarr['personal_uid']=intval($userid);
			$addarr['aid']=$jobs['id'];//--当前职位的id
			$addarr['companyname']=$jobs['companyname'];
			$addarr['title']=$jobs['companyname'];
			//$addarr['company_id']=$jobs['company_id'];
			$addarr['title']=$jobs['companyname'];
			$addarr['addtime']=time();
			$addarr['company_uid']=$jobs['uid'];
	 }
	//echo "<pre>"; print_r($addarr);exit;
	if (inserttable(table('bm_hymq'),$addarr))
	{
		$androidresult['code']=1;
		$androidresult['errormsg']='';
		$androidresult['date']=array('userid'=>$userid,'resumeID'=>$resumeID,'jobsid'=>$jobsid);
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
	}else{
		$result['code']=-1;
		$result['errormsg']=android_iconv_utf8('申请失败');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	

?>