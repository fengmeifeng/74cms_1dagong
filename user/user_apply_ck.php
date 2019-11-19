<?php
 /*
 * 74cms 邀请面试
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
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'apply_ck';
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
if ($_SESSION['utype']!='1')
{
	exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		    <tr>
				<td width="20" align="right"></td>
				<td class="ajax_app">
					必须是企业会员才可以邀请面试！
				</td>
		    </tr>
		</table>');
}
		require_once(QISHI_ROOT_PATH.'include/fun_company.php');
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
$id=isset($_GET['id'])?intval($_GET['id']):exit("err");
$user_jobs=get_auditjobs($_SESSION['uid']);
if (count($user_jobs)==0)
{
	exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		    <tr>
				<td width="20" align="right"></td>
				<td class="ajax_app">
					申请失败，你没有发布招聘信息或者信息没有审核通过！
				</td>
		    </tr>
		</table>');
}
//--ff---搜索出还剩的查看次数
$sql_ck = "select look_num from ".table('company_profile')." where uid=".$_SESSION['uid']." LIMIT 1 ";
$row_ck = $db->getone($sql_ck);
if($row_ck['look_num']<= 0){
	exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		    <tr>
				<td width="20" align="right"></td>
				<td class="ajax_app">
					申请失败，你的申请次数已经用完，不能申请查看！
				</td>
		    </tr>
		</table>');}
//--ff

$setmeal=get_user_setmeal($_SESSION['uid']);
$resume=$db->getone("select * from ".table('resume')." WHERE id ='{$id}'  LIMIT 1");
$resume = array_map("addslashes", $resume);
if ($_CFG['operation_mode']=="3")
{
 	if ($_CFG['setmeal_to_points']=="1")
	{
		if (empty($setmeal) || ($setmeal['endtime']<time() && $setmeal['endtime']<>"0"))
		{
		$_CFG['operation_mode']="1";
		}
		elseif ($resume['talent']=='2' && $setmeal['interview_senior']<=0)
		{
		$_CFG['operation_mode']="1";
		}
		elseif (($resume['talent']=='1' || $resume['talent']=='3') && $setmeal['interview_ordinary']<=0)
		{
		$_CFG['operation_mode']="1";
		}
		else
		{
		$_CFG['operation_mode']="2";
		}
	}else{
		$_CFG['operation_mode']="2";
	}
}
if ($_CFG['operation_mode']=="2")
{
 			if (empty($setmeal) || ($setmeal['endtime']<time() && $setmeal['endtime']<>"0"))
			{
				$str="<a href=\"".get_member_url(1,true)."company_service.php?act=setmeal_list\">[申请服务]</a>";
				exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
				    <tr>
						<td width="20" align="right"></td>
						<td class="ajax_app">
							您的服务已到期。您可以 '.$str.'
						</td>
				    </tr>
				</table>');
			}
			elseif ($resume['talent']=='2' && $setmeal['interview_senior']<=0)
			{
				$str="<a href=\"".get_member_url(1,true)."company_service.php?act=setmeal_list\">[申请服务]</a>";
				exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
				    <tr>
						<td width="20" align="right"></td>
						<td class="ajax_app">
							你邀请高级人才面试次数已经超出了限制。您可以 '.$str.'
						</td>
				    </tr>
				</table>');
			}
			elseif ($resume['talent']=='1' && $setmeal['interview_ordinary']<=0)
			{
				$str="<a href=\"".get_member_url(1,true)."company_service.php?act=setmeal_list\">[申请服务]</a>";
				exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
				    <tr>
						<td width="20" align="right"></td>
						<td class="ajax_app">
							你邀请面试次数已经超出了限制。您可以 '.$str.'
						</td>
				    </tr>
				</table>');
			}
}
if ($act=="apply_ck")
{
	
	//企业申请查看简历时给 简历发布者 发送短息开始 By Z
	$query="select telephone from qs_resume where id=".$id;
	$row=$db->getone($query);
	$username=$row['telephone'];
	require_once(QISHI_ROOT_PATH.'include/msg_apply_ck.php');
	// var_dump($row['telephone']);exit;
	//企业申请查看简历时给 简历发布者 发送短息结束 By Z	
	if ($_CFG['operation_mode']=="2")
	{
		if ($resume['talent']=='2')
		{	
			$tip="提示：您还可以邀请<span> {$setmeal['interview_senior']}</span> 次高级人才面试";
		}
		else
		{	
			$tip="提示：您还可以邀请<span> {$setmeal['interview_ordinary']}</span> 次普通人才面试";
		}
	}
	elseif($_CFG['operation_mode']=="1")
	{
				$mypoints=get_user_points($_SESSION['uid']);
				$points_rule=get_cache('points_rule');
				$points=$resume['talent']=='2'?$points_rule['interview_invite_advanced']['value']:$points_rule['interview_invite']['value'];
				if  ($mypoints<$points)
				{
					$str="<a href=\"".get_member_url(1,true)."company_service.php?act=order_add\">[充值{$_CFG['points_byname']}]</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					$str1="<a href=\"".get_member_url(1,true)."company_service.php?act=setmeal_list\">[申请服务]</a>";
					if (!empty($setmeal) && $_CFG['setmeal_to_points']=="1")
					{
						exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
						    <tr>
								<td width="20" align="right"></td>
								<td class="ajax_app">
									你的服务已到期或超出服务条数。您可以 '.$str.$str1.'
								</td>
						    </tr>
						</table>');
					}
					else
					{
						exit("<table width='100%' border='0' cellspacing='0' cellpadding='0' class='tableall'>
						    <tr>
								<td width='20' align='right'></td>
								<td class='ajax_app'>
									你的{$_CFG['points_byname']}不足，请充值后下载。".$str."
								</td>
						    </tr>
						</table>");
					}
				}
				//$tip="邀请面试将扣除<span> {$points} </span>{$_CFG['points_quantifier']}{$_CFG['points_byname']}，您目前共有<span> {$mypoints}</span>{$_CFG['points_quantifier']}{$_CFG['points_byname']}";
	}
	//---必须下载简历才能申请----ff去掉
	//$row = $db->getone("select * from ".table('company_down_resume')." where company_uid={$_SESSION['uid']} and resume_id=".intval($_GET['id']));
	$row=1;
	if(!$row){
			
			//-------------------//
			if($_SESSION['utype']==1){
		if ($_CFG['operation_mode']=="2")
		{
			if ($resumeshow['talent']=='2')
			{	
				$tip="提示：您还可以下载<span> {$setmeal['download_resume_senior']}</span>份高级人才简历";
			}
			else
			{	
				$tip="提示：您还可以下载<span> {$setmeal['download_resume_ordinary']}</span>份普通人才简历";
			}
			
		}
		elseif($_CFG['operation_mode']=="1")
		{
			$points_rule=get_cache('points_rule');
			$points=$resumeshow['talent']=='2'?$points_rule['resume_download_advanced']['value']:$points_rule['resume_download']['value'];
			$mypoints=get_user_points($_SESSION['uid']);
			if  ($mypoints<$points)
			{
				$str="<a href=\"".get_member_url(1,true)."company_service.php?act=order_add\">[充值{$_CFG['points_byname']}]</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				$str1="<a href=\"".get_member_url(1,true)."company_service.php?act=setmeal_list\">[申请服务]</a>";
				if (!empty($setmeal) && $_CFG['setmeal_to_points']=="1")
				{
					exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
					    <tr>
							<td width="20" align="right"></td>
							<td class="ajax_app">
								你的服务已到期或超出服务条数。您可以 '.$str.$str1.'
							</td>
					    </tr>
					</table>');
				}
				else
				{
					exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
					    <tr>
							<td width="20" align="right"></td>
							<td class="ajax_app">
								你的'.$_CFG['points_byname'].' 不足，请充值后下载。'.$str.'
							</td>
					    </tr>
					</table>');
				}			
			}
			//$tip="下载此份简历将扣除<span> {$points}</span>{$_CFG['points_quantifier']}{$_CFG['points_byname']}，您目前共有<span> {$mypoints}</span>{$_CFG['points_quantifier']}{$_CFG['points_byname']}";
		}
	}elseif($_SESSION['utype']==3){
		if ($_CFG['operation_hunter_mode']=="2")
		{
			if ($resumeshow['talent']=='2')
			{	
				$tip="提示：您还可以下载<span> {$setmeal['download_resume_talent']}</span>份高级人才简历";
			}
		}
		elseif($_CFG['operation_hunter_mode']=="1")
		{
			$points_rule=get_cache('points_rule');
			$points=$points_rule['hunter_resume_download_huntered']['value'];
			$mypoints=get_user_points($_SESSION['uid']);
			if  ($mypoints<$points)
			{
				$str="<a href=\"".get_member_url(3,true)."hunter_service.php?act=order_add\">[充值{$_CFG['hunter_points_byname']}]</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
					    <tr>
							<td width="20" align="right"></td>
							<td class="ajax_app">
								你的'.$_CFG['hunter_points_byname'].' 不足，请充值后下载。'.$str.'
							</td>
					    </tr>
					</table>');			
			}
			//$tip="下载此份简历将扣除<span> {$points}</span>{$_CFG['hunter_points_quantifier']}{$_CFG['hunter_points_byname']}，您目前共有<span> {$mypoints}</span>{$_CFG['hunter_points_quantifier']}{$_CFG['hunter_points_byname']}";
		}
	}
	
?>
<script type="text/javascript">
$(".but100").hover(function(){$(this).addClass("but100_hover")},function(){$(this).removeClass("but100_hover")});

$("#ajax_download_r").click(function() {
		var id="<?php echo $id?>";
		var tsTimeStamp= new Date().getTime();
			$("#ajax_download_r").val("处理中...");
			$("#ajax_download_r").attr("disabled","disabled");
 			 var pms_notice=$("#pms_notice").attr("checked");
			 if(pms_notice) pms_notice=1;else pms_notice=0;
			 // echo $_CFG['website_dir'] ?>
		$.get("/user/user_download_resume.php", { "id":id,"pms_notice":pms_notice,"time":tsTimeStamp,"act":"download_save"},
 	 	function (data,textStatus)
	 	 {	
			if (data=="ok")
			{
			$(".ajax_download_tip").hide();
			$("#ajax_download_table").hide();
			$("#notice").hide();
			$("#download_ok").show();			 
					$("#download_ok .closed").click(function(){
						DialogClose();
					});
					//刷新联系地址 echo $_CFG['site_dir'] ?>
					$.get("/plus/ajax_contact.php", { "id": id,"time":tsTimeStamp,"act":"resume_contact"},
					function (data,textStatus)
					 {	
						$("#resume_contact").html(data);
					 }
					);
			}
			else
			{
			alert(data);
			}
			$("#ajax_download_r").val("下载简历");
			$("#ajax_download_r").attr("disabled","");
	 	 })
});
function DialogClose()
{
	$("#FloatBg").hide();
	$("#FloatBox").hide();
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall" id="ajax_download_table">
	  <tr style='width:100%; margin:0px auto;'>
			<div style='width:250px; margin:0px auto;'><h3>必须下载完成简历后 才可以邀请面试</h3></div>

    </tr>

   <!-- <tr>
		<td width="120" align="right">站内信通知对方：</td>
		<td class="ajax_app">
			
			<label><input type="checkbox" name="pms_notice" id="pms_notice" value="1"  checked="checked"/>
		  站内信通知
		   </label>
		</td>
    </tr>-->
    <tr align="center">
		<td></td>
		<td>
			<input type="button" name="Submit"  id="ajax_download_r" class="but130lan" value="下载简历" />
		</td>
    </tr>
</table>
<table id="notice" width="100%" border="0" style="border-top:1px #CCCCCC dotted;background-color: #EEEEEE; line-height: 230%;padding: 15px; margin-top: 10px; ">
    <tbody><tr>
	    <td class="ajax_download_tip"><?php echo $tip?>
	    </td>
    </tr>
</tbody>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall" id="download_ok" style="display:none">
    <tr>
		<td width="140" align="right"><img height="100" src="/files/images/14.gif" /></td>
		<td>
			<strong style="font-size:14px ; color:#0066CC;margin-left:20px">下载成功!</strong>
			<?php
				if($_SESSION['utype']==1){
			?>
			<div style="border-top:1px #CCCCCC solid; line-height:180%; margin-top:10px; padding-top:10px; height:50px;margin-left:20px"  class="dialog_closed">
			<a href="<?php echo get_member_url(1,true)?>company_recruitment.php?act=down_resume_list" >查看已下载简历</a><br />
			<?php
				}else{
			?>
			<div style="border-top:1px #CCCCCC solid; line-height:180%; margin-top:10px; padding-top:10px; height:50px;margin-left:20px"  class="dialog_closed">
			<?php echo $downresumeurl;?><br />
			<?php
				}
			?>
			<a href="javascript:void(0)"  class="DialogClose">下载完成</a>
			</div>
		</td>
    </tr>
</table>
		
			
			
<?php		
			//---------------------//
			die;
	}
?>
<script type="text/javascript">
$(".but100").hover(function(){$(this).addClass("but100_hover")},function(){$(this).removeClass("but100_hover")});
$("#but_invited").click(function() 
{
		var id="<?php echo $id?>";
		if ($("#jobs_id").val()=="")
		{
		alert("请选择面试职位！");
		}
		else
		{
			$("#but_invited").val("处理中...");
			$("#but_invited").attr("disabled","disabled");
			var tsTimeStamp= new Date().getTime();
			$("#ajax_download_r").attr("disabled","disabled");
 			 var pms_notice=$("#pms_notice").attr("checked");
			 if(pms_notice) pms_notice=1;else pms_notice=0;
			 // echo $_CFG['website_dir'] 
			$.get("/user/user_apply_ck.php", {"jobs_id": $("#jobs_id").val(),"id":id,"notes":$("#notes").val(),"pms_notice":pms_notice,"time":tsTimeStamp,"act":"invited_save"},
 			function (data,textStatus)
			 {
				if (data=="ok")
				{
				$(".ajax_invited_tip").hide();
				$("#ajax_invited_table").hide();
				$("#notice").hide();
				$("#invited_ok").show();				 
						$("#invited_ok .closed").click(function(){
							DialogClose();
						});
				}
				else if (data=="repeat")
				{
				$(".ajax_invited_tip").show();
				$("#ajax_invited_table").show();
				$("#notice").show();
				$("#invited_ok").hide();
				alert("您已经申请过联系方式，不能重复申请!");
				}
				else
				{
				$(".ajax_invited_tip").show();
				$("#ajax_invited_table").show();
				$("#notice").show();
				$("#invited_ok").hide();
				alert(data);
				}
				$("#but_invited").val("提交");
				$("#but_invited").attr("disabled","");
			 })
		}	 
});
function DialogClose()
{
	$("#FloatBg").hide();
	$("#FloatBox").hide();
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall" id="ajax_invited_table">
   <!--  <tr>
		<td width="120" align="right">面试职位：</td>
		<td>
			<select  name="jobs_id"  id="jobs_id">
				<?php 
				/*foreach ($user_jobs as $list)
				{
				?>
				<option value="<?php echo $list['id']?>"><?php echo $list['jobs_name']?> </option>
				<?php
				}*/
				?>
			</select>
		</td>
    </tr>
    <tr>
		<td width="120" align="right">其他描述：</td>
		<td>
			<textarea name="notes" id="notes" style="width:300px; height:80px;font-family:'microsoft yahei';font-size:12px;"></textarea>
          <br />
        其他说明填写：面试携带证件，联系人，乘车路线等...<br />
		</td>
    </tr>
   <tr>
		<td align="right">站内信通知对方：</td>
		<td>
			 <label><input type="checkbox" name="pms_notice" id="pms_notice" value="1"  checked="checked"/>
		  站内信通知
		   </label>
		</td>
    </tr>-->
     <tr>
		<td></td>
		<td align="center">
			总共可以申请查看10次，您现在还可以查看[<font style="color:#F00;"><?php echo $row_ck['look_num'];?></font>]次,确定要申请联系方式吗？
		</td>
    </tr>
    <tr>
		<td></td>
		<td align="center">
			<input type="button" name="Submit2"  id="but_invited" class="but130lan" value="申请查看联系方式" />
		</td>
    </tr>
    <tr>
		<td></td>
		<td align="center">
			<a href="/user/company/company_recruitment.php?act=apply_ck_list" target="_blank">查看我申请的联系方式</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo get_member_url(1)?>" >进入会员中心</a>
		</td>
    </tr>
</table>
<table id="notice" width="100%" border="0" style="border-top:1px #CCCCCC dotted;background-color: #EEEEEE; line-height: 230%;padding: 15px; margin-top: 10px; ">
    <tbody><tr>
	    <td class="ajax_invited_tip"><?php echo $tip?>
	    </td>
    </tr>
</tbody>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall" id="invited_ok" style="display:none">
    <tr>
		<td width="140" align="right"><img height="100" src="/files/images/14.gif" /></td>
		<td>
			<strong style="font-size:14px ; color:#0066CC;margin-left:20px">申请成功!</strong>
			<div style="border-top:1px #CCCCCC solid; line-height:180%; margin-top:10px; padding-top:10px; height:50px;margin-left:20px"  class="dialog_closed">
			<a href="<?php echo get_member_url(1,true)?>company_recruitment.php?act=apply_ck_list" >查看我申请的联系方式</a><br />
			<a href="javascript:void(0)"  class="DialogClose">申请成功</a>
			</div>
		</td>
    </tr>
</table>
<?php
}
 elseif ($act=="invited_save")
{
	$id=isset($_GET['id'])?intval($_GET['id']):exit("id err");
	//$jobs_id=isset($_GET['jobs_id'])?intval($_GET['jobs_id']):exit(" jobs_id err");
	$notes=isset($_GET['notes'])?trim($_GET['notes']):"";
	$pms_notice=intval($_GET['pms_notice']);
	if (check_apply_ck($id,$jobs_id,$_SESSION['uid']))
	{
	exit("repeat");
	}
	//$jobs=get_jobs_one($jobs_id);
	//$jobs = array_map("addslashes", $jobs);
	//echo $resume['id'];exit;
	$addarr['resume_id']=$resume['id'];
	$addarr['resume_addtime']=$resume['addtime'];
	if ($resume['display_name']=="2")
	{
	$addarr['resume_name']="N".str_pad($resume['id'],7,"0",STR_PAD_LEFT);	
	}
	elseif ($resume['display_name']=="3")
	{
	$addarr['resume_name']=cut_str($resume['fullname'],1,0,"**");
	}
	else
	{
	$addarr['resume_name']=$resume['fullname'];
	}
	$addarr['resume_uid']=$resume['uid'];
	$addarr['company_id']=$jobs['company_id'];
	$addarr['company_addtime']=$jobs['company_addtime'];
	$addarr['company_name']=$jobs['companyname'];
	$addarr['company_uid']=$_SESSION['uid'];
	$addarr['jobs_id']=$jobs['id'];
	$addarr['jobs_name']=$jobs['jobs_name'];
	$addarr['jobs_addtime']=$jobs['addtime'];	
	$addarr['notes']= $notes;
	if (strcasecmp(QISHI_DBCHARSET,"utf8")!=0)
	{
		$addarr['notes']=utf8_to_gbk($addarr['notes']);
	}
	$addarr['personal_look']= 1;
	$addarr['interview_addtime']=time();
	$resume_user=get_user_info($resume['uid']);
	$resume_user = array_map("addslashes", $resume_user);
	//echo "<pre>";print_r($addarr);exit;
	if ($_CFG['operation_mode']=="2")
	{
		inserttable(table('company_apply_ck'),$addarr);
		//--ff---申请成功发送邮箱
			/*$rand=mt_rand(100000, 999999);
			if (smtp_mail($email,"{$_CFG['site_name']}邮件提示","{$QISHI['site_name']}提醒您：<br>您正在进行邮箱验证，验证码为:<strong>{$rand}</strong>"))
			{
			$_SESSION['verify_email']=$email;
			$_SESSION['email_rand']=$rand;
			$_SESSION['sendemail_time']=time();
			exit("success");
			}
			else
			{
			exit("邮箱配置出错，请联系网站管理员");
			}*/
		//--ff---
		if ($resume['talent']=='2')
		{
			action_user_setmeal($_SESSION['uid'],"interview_senior");
			$setmeal=get_user_setmeal($_SESSION['uid']);
			write_memberslog($_SESSION['uid'],1,9002,$_SESSION['username'],"邀请了 {$resume_user['username']} 面试，还可以邀请高级人才 {$setmeal['interview_senior']} 次",2,1007,"邀请高级人才面试","1","{$setmeal['interview_senior']}");
			write_memberslog($_SESSION['uid'],1,6001,$_SESSION['username'],"邀请了 {$resume_user['username']} 面试");
		}
		else
		{				 
			action_user_setmeal($_SESSION['uid'],"interview_ordinary");
			$setmeal=get_user_setmeal($_SESSION['uid']);
			write_memberslog($_SESSION['uid'],1,9002,$_SESSION['username'],"邀请了 {$resume_user['username']} 面试，还可以邀请普通人才 {$setmeal['interview_ordinary']} 次",2,1006,"邀请普通人才面试","1","{$setmeal['interview_ordinary']}");
			write_memberslog($_SESSION['uid'],1,6001,$_SESSION['username'],"邀请了 {$resume_user['username']} 面试");				
		}			
	}		 
	elseif($_CFG['operation_mode']=="1")
	{
		$mypoints=get_user_points($_SESSION['uid']);
		$points_rule=get_cache('points_rule');
		$points=$resume['talent']=='2'?$points_rule['interview_invite_advanced']['value']:$points_rule['interview_invite']['value'];
		$ptype=$resumeshow['talent']=='2'?$points_rule['interview_invite_advanced']['type']:$points_rule['interview_invite']['type'];
		if  ($mypoints<$points)
		{
			exit("err");
		}
		inserttable(table('company_apply_ck'),$addarr);
		if ($points>0)
		{
			report_deal($_SESSION['uid'],$ptype,$points);
			$user_points=get_user_points($_SESSION['uid']);
			$operator=$ptype=="1"?"+":"-";
			if($resume['talent']=='2'){
				write_memberslog($_SESSION['uid'],1,9001,$_SESSION['username'],"邀请 {$resume_user['username']} 面试({$operator}{$points}),(剩余:{$user_points})",1,1007,"邀请高级人才面试","{$operator}{$points}","{$user_points}");
			}else{
				write_memberslog($_SESSION['uid'],1,9001,$_SESSION['username'],"邀请 {$resume_user['username']} 面试({$operator}{$points}),(剩余:{$user_points})",1,1006,"邀请普通人才面试","{$operator}{$points}","{$user_points}");
			}
			write_memberslog($_SESSION['uid'],1,6001,$_SESSION['username'],"邀请 {$resume_user['username']} 面试");
		}		
	}
	$mailconfig=get_cache('mailconfig');
	$sms=get_cache('sms_config');
	if ($mailconfig['set_invite']=="1" && $resume['email_notify']=='1' && $resume_user['email_audit']=="1")
	{
		dfopen("{$_CFG['website_dir']}plus/asyn_mail.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=set_invite&companyname={$jobs['companyname']}&email={$resume_user['email']}");				
	}
	//sms
	if ($sms['open']=="1"  && $sms['set_invite']=="1"  && $resume_user['mobile_audit']=="1")
	{
		dfopen("{$_CFG['website_dir']}plus/asyn_sms.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=set_invite&companyname={$jobs['companyname']}&mobile={$resume_user['mobile']}");		
	}
	//站内信
	if($pms_notice=='1'){
		$jobs_url=url_rewrite('QS_jobsshow',array('id'=>$jobs['id']),true,$jobs['subsite_id']);
		$company_url=url_rewrite('QS_companyshow',array('id'=>$jobs['company_id']),false);
		$message=$jobs['companyname']."邀请您参加公司面试，面试职位：<a href=\"{$jobs_url}\" target=\"_blank\"> {$jobs['jobs_name']} </a>，<a href=\"{$company_url}\" target=\"_blank\">点击查看公司详情</a>";
		write_pmsnotice($resume['uid'],$resume_user['username'],$message);
	}
	//微信
	/*
	if(intval($_CFG['weixin_apiopen'])==1){
		$user=$db->getone("select weixin_openid from ".table('members')." where uid ={$resume['uid']} limit 1");
		
		if($user['weixin_openid']!=""){
			$jobs_url=$_CFG['wap_domain']."/wap-jobs-show.php?id=".$jobs['id'];
			$template = array(
				'touser' => $user['weixin_openid'],
				'template_id' => "sdjPV1l3vyv_9mclCe6_Fm8UzyAadMI_w5iIC1DPFPE",
				'url' => $jobs_url,
				'topcolor' => "#7B68EE",
				'data' => array(
					'first' => array('value' => urlencode(gbk_to_utf8($jobs['companyname']."邀请您参加公司面试")),
									'color' => "#743A3A",
						),
					'job' => array('value' => urlencode(gbk_to_utf8($jobs['jobs_name'])),
									'color' => "#743A3A",
						),
					'company' => array('value' => urlencode(gbk_to_utf8($jobs['companyname'])),
									'color' => "#743A3A",
						),
					'time' => array('value' => urlencode(gbk_to_utf8("请点击查看")),
									'color' => "#743A3A",
						),
					'address' => array('value' => urlencode(gbk_to_utf8($jobs['contact']['address'])),
									'color' => "#743A3A",
						),
					'contact' => array('value' => urlencode(gbk_to_utf8($jobs['contact']['contact'])),
									'color' => "#743A3A",
						),
					'tel' => array('value' => urlencode($jobs['contact']['telephone']),
									'color' => "#743A3A",
						),
					'remark' => array('value' => urlencode("\\n".$notes),
									'color' => "#743A3A",
						)
					)
				);
			send_template_message(urldecode(json_encode($template)));
		}
	}*/
	exit("ok");
}
 
?>