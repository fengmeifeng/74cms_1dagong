<?php
 /*
 * 74cms WAP
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã��������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
*/
define('IN_QISHI', true);

require_once(dirname(__FILE__).'/../../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/fun_personal.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'apply';
if ($_SESSION['uid']=='' || $_SESSION['username']==''||intval($_SESSION['utype'])==1)
{
	header("Location: ../wap_login.php");
}
elseif ($act == 'apply')
{

	$wheresql=" WHERE a.personal_uid='{$_SESSION['uid']}' ";
	$perpage = 5;
	$count  = 0;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	$total_sql="SELECT COUNT(*) AS num FROM  ".table('personal_jobs_apply')." as a  {$wheresql}";
	$count=$db->get_total($total_sql);
	$limit=" LIMIT {$start},{$perpage}";
	$sql="select a.*,j.wage_cn from ".table("personal_jobs_apply")." as a left join ".table("jobs")." as j on a.jobs_id=j.id  $wheresql order by apply_addtime desc ".$limit;
	$apply=$db->getall($sql);

	$smarty->assign('apply',$apply);
	// $smarty->assign('pagehtml',wapmulti($count, $perpage, $page, $theurl));
	$smarty->display("wap/personal/wap-apply.html");	
}
elseif ($act == 'apply_add')
{
	$jobsid=intval($_POST["jobs_id"])?intval($_POST["jobs_id"]):exit("������");
	$resumeid=intval($_POST["resume_id"])?intval($_POST["resume_id"]):exit("������");
	
	$_POST=array_map("utf8_to_gbk", $_POST);
	$sql="select * from ".table("personal_jobs_apply")." where personal_uid=".intval($_SESSION['uid'])." and resume_id=".intval($_POST["resume_id"])." and jobs_id=".intval($_POST["jobs_id"])."";
	$row=$db->getone($sql);
		
		$resume_basic=get_resume_basic($_SESSION['uid'],$resumeid);
		$resume_basic = array_map("addslashes", $resume_basic);
		if (empty($resume_basic))
		{
		exit("������ʧ");
		}
	
	if($_SESSION['utype']!=2){
		exit("���˻�Ա���¼������ְλ");
	}
	elseif($row){
		exit("���Ѿ��������ְλ��");
	}
	else{
	
		if (check_jobs_apply($jobs['id'],$resumeid,$_SESSION['uid']))
			{
			 continue ;
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
			
		$setsqlarr["jobs_id"]=intval($_POST["jobs_id"]);
		$setsqlarr["jobs_name"]=$_POST["jobs_name"];
		$setsqlarr["company_id"]=intval($_POST["company_id"]);
		$setsqlarr["company_name"]=$_POST["company_name"];
		$setsqlarr["company_uid"]=intval($_POST["company_uid"]);
		$setsqlarr["resume_id"]=intval($_POST["resume_id"]);
		$setsqlarr["resume_name"]=$_POST["resume_title"];
		$setsqlarr["personal_uid"]=intval($_SESSION["uid"]);
		$setsqlarr["apply_addtime"]=time();
		if(inserttable(table('personal_jobs_apply'),$setsqlarr)){
		
			$sql="select * from ".table("jobs")." where  id = ".$setsqlarr["jobs_id"];
			$jobs=$db->getone($sql);
			
			
			$mailconfig=get_cache('mailconfig');					
					$jobs['contact']=$db->getone("select * from ".table('jobs_contact')." where pid='{$jobs['id']}' LIMIT 1 ");
					$sms=get_cache('sms_config');	
					$comuser=get_user_info($jobs['uid']);	
					if ($mailconfig['set_applyjobs']=="1"  && $comuser['email_audit']=="1" && $jobs['contact']['notify']=="1")
					{	
						dfopen("{$_CFG['website_dir']}plus/asyn_mail.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=jobs_apply&jobs_id={$jobs['id']}&jobs_name={$jobs['jobs_name']}&personal_fullname={$personal_fullname}&email={$comuser['email']}");
					}
					//sms	
					if ($sms['open']=="1"  && $sms['set_applyjobs']=="1"  && $comuser['mobile_audit']=="1")
					{
					//����bug,��ְ������ְλ�����Ͷ���
						dfopen("{$_CFG['website_dir']}plus/asyn_sms.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=jobs_apply&jobs_id=".$jobs['id']."&jobs_name=".$jobs['jobs_name'].'&jobs_uid='.$jobs['uid']."&personal_fullname=".$personal_fullname."&mobile=".$comuser['mobile']);
					}
					//վ����
					if($pms_notice=='1'){
						$user=$db->getone("select username from ".table('members')." where uid ={$jobs['uid']} limit 1");
						$user = array_map("addslashes", $user);
						$jobs_url=url_rewrite('QS_jobsshow',array('id'=>$jobs['id']),true,$jobs['subsite_id']);
						$resume_url=url_rewrite('QS_resumeshow',array('id'=>$resumeid),false);
						$message=$personal_fullname."��������������ְλ��<a href=\"{$jobs_url}\" target=\"_blank\">{$jobs['jobs_name']}</a>,<a href=\"{$resume_url}\" target=\"_blank\">����鿴</a>";
						write_pmsnotice($jobs['uid'],$user['username'],$message);
					}
					write_memberslog($_SESSION['uid'],2,1301,$_SESSION['username'],"Ͷ���˼�����ְλ:{$jobs['jobs_name']}");
					
					
					//΢��
					if(intval($_CFG['weixin_apiopen'])==1){
						$user=$db->getone("select weixin_openid from ".table('members')." where uid = {$jobs['uid']} limit 1");
						if($user['weixin_openid']!=""){
							$resume_url=$_CFG['wap_domain']."/wap-resume-show.php?id=".$resumeid;
							$template = array(
								'touser' => $user['weixin_openid'],
								'template_id' => "u_yoFifHb-ryYXMtNSlATj_Wfm1CWTKEjf8EkiM6dvY",
								'url' => $resume_url,
								'topcolor' => "#7B68EE",
								'data' => array(
									'first' => array('value' => urlencode(gbk_to_utf8("���յ���һ���¼������뼰ʱ��¼".$_CFG['site_name']."����")),
													'color' => "#743A3A",
										),
									'job' => array('value' => urlencode(gbk_to_utf8($jobs['jobs_name'])),
													'color' => "#743A3A",
										),
									'resuname' => array('value' => urlencode(gbk_to_utf8("--")),
													'color' => "#743A3A",
										),
									'realname' => array('value' => urlencode(gbk_to_utf8($personal_fullname)),
													'color' => "#743A3A",
										),
									'exp' => array('value' => urlencode(gbk_to_utf8($resume_basic['experience_cn'])),
													'color' => "#743A3A",
										),
									'lastjob' => array('value' => urlencode(gbk_to_utf8("--")),
													'color' => "#743A3A",
										),
									'remark' => array('value' => urlencode("\\n".$notes),
													'color' => "#743A3A",
										)
									)
								);
							send_template_message(urldecode(json_encode($template)));
						}
					}
		
		
			exit("ok");
		}else{
			exit("err");
		}
	}
	
}
?>