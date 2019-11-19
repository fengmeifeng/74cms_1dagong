<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
require_once(ANDROID_ROOT_PATH.'include/common.user.inc.php');
if ($_SESSION['utype']<>'2')
{
	$result['result']=0;
	$result['errormsg']=android_iconv_utf8("只有个人会员才能投递简历！");
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
}
if ($_GET['act']=='app')
{
	$user=get_user_inid($_SESSION['uid']);
	if ($user['status']=="2") 
	{
		$result['result']=0;
		$result['errormsg']=android_iconv_utf8("您的账号处于暂停状态，请先设为正常后进行操作！！");
		$jsonencode = json_encode($result);
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	$resume_list=get_auditresume_list($_SESSION['uid']);
	if (empty($resume_list))
	{
		$result['result']=0;
		$result['errormsg']=android_iconv_utf8("申请职位失败，您没有填写简历或者简历不可见！");
		$jsonencode = json_encode($result);
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	else
	{
		$androidresult['result']=1;
		$androidresult['errormsg']='';
		$androidresult['list']=android_iconv_utf8_array($resume_list);
		$jsonencode = json_encode($androidresult);
		echo urldecode($jsonencode);
	}
}
elseif($_GET['act']=='app_save')
{
		
		$jid=intval($aset['jid']);
		$rid=intval($aset['rid']);
		if (empty($jid) || empty($rid))
		{
			$result['result']=0;
			$result['errormsg']=android_iconv_utf8("申请职位失败，参数错误！");
			$jsonencode = json_encode($result);
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		else
		{
			if (check_jobs_apply($jid,$rid,$_SESSION['uid']))
			{
				$result['result']=0;
				$result['errormsg']=android_iconv_utf8("您已经投递过了，不能重复投递！");
				$jsonencode = json_encode($result);
				$jsonencode = urldecode(json_encode($result));
				exit($jsonencode);
			}
			else
			{
				$jobs=$db->getone("select * from ".table('jobs')." where id = '{$jid}' LIMIT 1");
				$resume_basic=get_resume_basic($_SESSION['uid'],$rid);
				if (empty($jobs) || empty($resume_basic))
				{
					$result['result']=0;
					$result['errormsg']=android_iconv_utf8("信息不存在！");
					$jsonencode = json_encode($result);
					$jsonencode = urldecode(json_encode($result));
					exit($jsonencode);
				}
				else
				{	
						$personal_fullname=$resume_basic['display_name']=="1"?$resume_basic['fullname']:$resume_basic['number'];
						$addarr['resume_id']=$rid;
						$addarr['resume_name']=$personal_fullname;
						$addarr['personal_uid']=intval($_SESSION['uid']);
						$addarr['jobs_id']=$jobs['id'];
						$addarr['jobs_name']=$jobs['jobs_name'];
						$addarr['company_id']=$jobs['company_id'];
						$addarr['company_name']=$jobs['companyname'];
						$addarr['company_uid']=$jobs['uid'];
						$addarr['notes']='';
						$addarr['apply_addtime']=time();
						$addarr['personal_look']=1;
						if (inserttable(table('personal_jobs_apply'),$addarr))
						{
								$mailconfig=get_cache('mailconfig');					
								$jobs['contact']=$db->getone("select * from ".table('jobs_contact')." where pid='{$jobs['id']}' LIMIT 1 ");
								$sms=get_cache('sms_config');	
								$comuser=get_user_inid($jobs['uid']);	
								if ($mailconfig['set_applyjobs']=="1"  && $comuser['email_audit']=="1" && $jobs['contact']['notify']=="1")
								{	
									dfopen("{$_CFG['site_domain']}{$_CFG['site_dir']}plus/asyn_mail.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=jobs_apply&jobs_id={$jobs['id']}&jobs_name={$jobs['jobs_name']}&personal_fullname={$personal_fullname}&email={$comuser['email']}");
								}
								//sms			
								if ($sms['open']=="1"  && $sms['set_applyjobs']=="1"  && $comuser['mobile_audit']=="1")
								{
								dfopen($_CFG['site_domain'].$_CFG['site_dir']."plus/asyn_sms.php?uid=".$_SESSION['uid']."&key=".asyn_userkey($_SESSION['uid'])."&act=jobs_apply&jobs_id=".$jobs['id']."&jobs_name=".$jobs['jobs_name']."&personal_fullname=".$personal_fullname."&mobile=".$comuser['mobile']);
								}
								//sms
								write_memberslog($_SESSION['uid'],2,1301,$_SESSION['username'],"通过手机客户端申请了职位:{$jobs['jobs_name']}");
						}
						$androidresult['result']=1;
						$androidresult['errormsg']='';
						$androidresult['txt']=android_iconv_utf8_array('投递成功！');
						$jsonencode = json_encode($androidresult);
						echo urldecode($jsonencode);
					
				}
			}
		}
	
}
?>