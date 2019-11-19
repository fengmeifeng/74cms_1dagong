<?php
 /*
 * 74cms 申请职位
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'app';
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
if((empty($_SESSION['uid']) || empty($_SESSION['username']) || empty($_SESSION['utype'])) &&  $_COOKIE['QS']['username'] && $_COOKIE['QS']['password'] && $_COOKIE['QS']['uid'])
{
	require_once(QISHI_ROOT_PATH.'include/fun_user.php');
	if(check_cookie($_COOKIE['QS']['uid'],$_COOKIE['QS']['username'],$_COOKIE['QS']['password']))
	{
	update_user_info($_COOKIE['QS']['uid'],false,false);
	header("Location:".get_member_url($_SESSION['utype']));
	}
	else
	{
	unset($_SESSION['uid'],$_SESSION['username'],$_SESSION['utype'],$_SESSION['uqqid'],$_SESSION['activate_username'],$_SESSION['activate_email'],$_SESSION["openid"]);
	setcookie("QS[uid]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
	setcookie('QS[username]',"", time() - 3600,$QS_cookiepath, $QS_cookiedomain);
	setcookie('QS[password]',"", time() - 3600,$QS_cookiepath, $QS_cookiedomain);
	setcookie("QS[utype]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
	}
}
if ($_SESSION['uid']=='' || $_SESSION['username']=='')
{
	
	$captcha=get_cache('captcha');
	$smarty->assign('verify_userlogin',$captcha['verify_userlogin']);
	$smarty->display('plus/ajax_login.htm');
	exit();
}
if ($_SESSION['utype']!='2')
{
	exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		    <tr>
				<td width="20" align="right"></td>
				<td class="ajax_app">
					必须是个人会员才可以投简历！
				</td>
		    </tr>
		</table>');
}
require_once(QISHI_ROOT_PATH.'include/fun_personal.php');
$user=get_user_info($_SESSION['uid']);
if ($user['status']=="2") 
{
	exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		    <tr>
				<td width="20" align="right"></td>
				<td class="ajax_app">
					您的账号处于暂停状态，请联系管理员设为正常后进行操作！
				</td>
		    </tr>
		</table>');
}
if ($act=="app")
{		
		$id=isset($_GET['id'])?$_GET['id']:exit("id 丢失");
		$uid=isset($_GET['uid'])?$_GET['uid']:exit("uid 丢失");
		$jobs=app_get_hymq($id);
		if (empty($jobs))
		{
			exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
			    <tr>
					<td width="20" align="right"></td>
					<td class="ajax_app">
						投简历失败！
					</td>
			    </tr>
			</table>');
		}
		
		$resume_list=get_auditresume_list($_SESSION['uid']);
		//echo "<pre>";print_r($resume_list);exit;
		if (empty($resume_list))
		{
		$str="<a href=\"".get_member_url(2,true)."personal_resume.php?act=resume_list\">[查看我的简历]</a>";		
		exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
			    <tr>
					<td width="20" align="right"></td>
					<td class="ajax_app">
						投简历失败，您没有填写简历或者简历不可见 '.$str.'
					</td>
			    </tr>
			</table>');
		}
?>
<script type="text/javascript">
$(".but80").hover(function(){$(this).addClass("but80_hover")},function(){$(this).removeClass("but80_hover")});
//计算今天申请数量
var app_max="<?php echo $_CFG['apply_jobs_max'] ?>";
var app_today="<?php echo get_now_applyjobs_num($_SESSION['uid']) ?>";
$(".ajax_app_tip > span:eq(0)").html(app_max);
$(".ajax_app_tip > span:eq(1)").html(app_today);
$(".ajax_app_tip > span:eq(2)").html(app_max-app_today);
//验证
$("#ajax_app").click(function() {
	if (app_max-app_today==0 || app_max-app_today<0 )
	{
	alert("您今天投简历数量已经超出最大限制！");
	}
	else if ($("#app :checkbox[checked]").length>(app_max-app_today))
	{
	alert("您今天还可以投递"+(app_max-app_today)+"个简历，已选职位超出了最大限制！");
	}
	else if ($("#app :checkbox[checked]").length==0)
	{
	alert("请选择投递的企业！");
	}
	else if ($("#app :radio[checked]").length==0)
	{
	alert("请选择你的简历！");
	}
	else
	{
		$("#app").hide();
		$("#notice").hide();
		$("#waiting").show();
		var tsTimeStamp= new Date().getTime();
		 //alert(expire);
			 var jidArr=new Array();

			 var pms_notice=$("#pms_notice").attr("checked");
			 if(pms_notice) pms_notice=1;else pms_notice=0;
			 $("#app :checkbox[checked][name='jobsid']").each(function(index){jidArr[index]=$(this).val();});
		$.post("/user/user_apply_hymq.php", { "resumeid": $("#app :radio[checked]").val(),"jobsid": jidArr.join("-"),"notes": $("#notes").val(),"pms_notice":pms_notice,"time":tsTimeStamp,"act":"app_save"},

	 	function (data,textStatus)
	 	 {
			if (data=="ok")
			{
				$("#app").hide();
				$("#notice").hide();
				$("#waiting").hide();
				$("#app_ok").show();
					$("#app_ok .closed").click(function(){
					});
			}
			else if(data=="repeat")
			{
				$("#app").show();
				$("#notice").show();
				$("#waiting").hide();
				$("#app_ok").hide();
				alert("您投递过此职位，不能重复投递");
			}
			else
			{
				$("#app").show();
				$("#notice").show();
				$("#waiting").hide();
				$("#app_ok").hide();
				alert("投递失败！"+data);
			}
	 	 })
	}
});
function DialogClose()
{
	$("#FloatBg").hide();
	$("#FloatBox").hide();
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall" id="app">
    <tr>
		<td width="120" align="right">要投递的企业：</td>
		<td class="ajax_app">
			<ul>
			 <?php
			 
			 foreach($jobs as $j)
			 {
			 ?>
			 <li><label><input name="jobsid" type="checkbox" value="<?php echo $j['id']?>" checked="checked" /><?php echo $j['companyname']?></label>
			 <?php }?>
			 </li>
			 </ul>
		</td>
    </tr>
    <tr>
		<td width="120" align="right">选择简历：</td>
		<td>
			<ul>
			 <?php
			 foreach($resume_list as $resume)
			 {
			 ?>
			 <li><label><input name="resumeid" type="radio" value="<?php echo $resume['id']?>"  /><?php echo $resume['title']?></label>&nbsp;&nbsp;
			  <a href="<?php echo url_rewrite('QS_resumeshow',array('id'=>$resume['id']))?>" target="_blank">[预览]</a>
			 <?php 
			 }
			 ?>
			 </li>
			 </ul>
		</td>
    </tr>
   
    <tr>
		<td></td>
		<td>
			<input type="button" name="Submit"  id="ajax_app" class="but130lan" value="投递" />
		</td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="5" cellpadding="0" id="waiting"  style="display:none">
  <tr>
    <td align="center" height="60"><img src="/files/images/30.gif"  border="0"/></td>
  </tr>
  <tr>
    <td align="center" >请稍后...</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall" id="app_ok" style="display:none">
    <tr>
		<td width="140" align="right"><img height="100" src="/files/images/14.gif" /></td>
		<td>
			<strong style="font-size:14px ; color:#0066CC;margin-left:20px">投递成功!</strong>
			<div style="border-top:1px #CCCCCC solid; line-height:180%; margin-top:10px; padding-top:10px; height:50px;margin-left:20px"  class="dialog_closed">
			<a href="javascript:void(0)"  class="DialogClose">投递完成</a>
			</div>
		</td>
    </tr>
</table>
<?php
}

elseif ($act=="app_save")
{
	
	$jobsid=isset($_POST['jobsid'])?$_POST['jobsid']:exit("出错了");
	$resumeid=isset($_POST['resumeid'])?intval($_POST['resumeid']):exit("出错了");
	$notes=isset($_POST['notes'])?trim($_POST['notes']):"";
	$pms_notice=intval($_POST['pms_notice']);
	$jobsarr=app_get_hymq($jobsid);
	if (empty($jobsarr))
	{
	exit("职位丢失");
	}
	$resume_basic=get_resume_basic($_SESSION['uid'],$resumeid);
	if (empty($resume_basic))
	{
	exit("简历丢失");
	}
	$i=0;
	foreach($jobsarr as $jobs)
	 {
	 		if (check_hymq_apply($jobs['id'],$resumeid,$_SESSION['uid']))
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
			
	 		$addarr['resume_id']=$resumeid;//----简历的id
			$addarr['resume_name']=$personal_fullname;
			$addarr['personal_uid']=intval($_SESSION['uid']);
			$addarr['aid']=$jobs['id'];//--当前职位的id
			$addarr['companyname']=$jobs['companyname'];
			$addarr['title']=$jobs['companyname'];
			//$addarr['company_id']=$jobs['company_id'];
			$addarr['title']=$jobs['companyname'];
			$addarr['addtime']=time();
			$addarr['company_uid']=$jobs['uid'];
			
			/*$addarr['notes']= $notes;
			if (strcasecmp(QISHI_DBCHARSET,"utf8")!=0)
			{
			$addarr['notes']=utf8_to_gbk($addarr['notes']);
			}
			$addarr['apply_addtime']=time();
			$addarr['personal_look']=1;*/
			
			if (inserttable(table('bm_hymq'),$addarr))
			{
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
					//修正bug,求职者申请职位不发送短信
						dfopen("{$_CFG['website_dir']}plus/asyn_sms.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=jobs_apply&jobs_id=".$jobs['id']."&jobs_name=".$jobs['jobs_name'].'&jobs_uid='.$jobs['uid']."&personal_fullname=".$personal_fullname."&mobile=".$comuser['mobile']);
					}
					//站内信
					if($pms_notice=='1'){
						$user=$db->getone("select username from ".table('members')." where uid ={$jobs['uid']} limit 1");
						$jobs_url=url_rewrite('QS_jobsshow',array('id'=>$jobs['id']),true,$jobs['subsite_id']);
						$resume_url=url_rewrite('QS_resumeshow',array('id'=>$resumeid),false);
						$message=$personal_fullname."申请了您发布的职位：<a href=\"{$jobs_url}\" target=\"_blank\">{$jobs['jobs_name']}</a>,<a href=\"{$resume_url}\" target=\"_blank\">点击查看</a>";
						write_pmsnotice($jobs['uid'],$user['username'],$message);
					}
					write_memberslog($_SESSION['uid'],2,1301,$_SESSION['username'],"投递了简历，职位:{$jobs['jobs_name']}");
			}
			$i=$i+1;
	 }
	 if ($i==0)
	 {
	 exit("repeat");
	 }
	 else
	 {
	 exit("ok");
	 }
}

?>
