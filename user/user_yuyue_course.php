<?php
 /*
 * 74cms 申请课程
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
/*if((empty($_SESSION['uid']) || empty($_SESSION['username']) || empty($_SESSION['utype'])) &&  $_COOKIE['QS']['username'] && $_COOKIE['QS']['password'] && $_COOKIE['QS']['uid'])
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
					必须是个人会员才可以申请课程！
				</td>
		    </tr>
		</table>');
}*/
require_once(QISHI_ROOT_PATH.'include/fun_personal.php');
$user=get_user_info($_SESSION['uid']);
/*if ($user['status']=="2") 
{
	exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		    <tr>
				<td width="20" align="right"></td>
				<td class="ajax_app">
					您的账号处于暂停状态，请联系管理员设为正常后进行操作！
				</td>
		    </tr>
		</table>');
}*/

//$smarty->display('plus/ajax_yuyue.htm');exit();

if ($act=="app")
{		
		$id=isset($_GET['id'])?$_GET['id']:exit("id 丢失");
		$course=app_get_course($id);
		if (empty($course))
		{
			exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
			    <tr>
					<td width="20" align="right"></td>
					<td class="ajax_app">
						预约课程失败！
					</td>
			    </tr>
			</table>');
		}
?>
<script type="text/javascript">
$(".but80").hover(function(){$(this).addClass("but80_hover")},function(){$(this).removeClass("but80_hover")});
//计算今天申请数量
var app_max="30";
var app_today="<?php echo get_now_applycour_num($_SESSION['uid']) ?>";
$(".ajax_app_tip > span:eq(0)").html(app_max);
$(".ajax_app_tip > span:eq(1)").html(app_today);
$(".ajax_app_tip > span:eq(2)").html(app_max-app_today);
//验证
$("#ajax_app").click(function() {
	
	if (app_max-app_today==0 || app_max-app_today<0 )
	{
	alert("您今天预约课程数量已经超出最大限制！");
	return false;
	}
	else if($("#datepicker").val()=="" || $("#datepicker").val()=="请输入预约服务日期")
	{
		alert("请选择预约服务日期！");
		return false;
	}
	else if($("#time1").val()=="" || $("#time1").val()=="请输入预约服务时间")
	{
		alert("请选择预约服务时间！");
		return false;
	}
	else if ($("#contacts").val()=="" || $("#contacts").val()=="请输入联系人姓名")
	{
	alert("请填写联系人！");
	return false;
	}
	else if ($("#phone").val()=="" || $("#phone").val()=="请输入联系人手机号")
	{
	alert("请填写手机号码！");
	return false;
	}
	else
	{
		$("#app").hide();
		$("#notice").hide();
		$("#waiting").show();
		 var tsTimeStamp= new Date().getTime();
		 var courseid=$("#courseid").val();
		 var uid="<?php echo $_SESSION['uid'];?>";
		$.post("/user/user_yuyue_course.php", { "uid": uid,"courseid": courseid,"contacts": $("#contacts").val(),"sex":$("#sex").val(),"phone": $("#phone").val(),"datepicker": $("#datepicker").val(),"time1":$("#time1").val(),"time":tsTimeStamp,"act":"app_save"},
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
				alert("您预约过此课程，不能重复申请");
			}
			else
			{
				$("#app").show();
				$("#notice").show();
				$("#waiting").hide();
				$("#app_ok").hide();
				alert("预约失败！"+data);
			}
	 	 })
	}
});
function DialogClose()
{
	$("#FloatBg").hide();
	$("#FloatBox").hide();
}
$('#out').live('click', function() {
	$(".FloatBg").remove();
	$(".FloatBox").remove();
});
function refresh(){
windowl.location.href=window.location.href;
}
</script>
<!--<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall" id="app">
    <tr>
		<td width="120" align="right">要申请的课程：</td>
		<td class="ajax_app">
			<ul>
			 <li><label><input name="courseid" id="courseid" type="hidden" value="<?php //echo $course['id']?>" /><?php //echo $course['course_name']?></label>
			 </li>
			 </ul>
		</td>
    </tr>
    <tr>
		<td width="120" align="right">真实姓名：</td>
		<td>
			<input name="realname" id="realname"  class="input_text_150" maxlength="30"/>
		</td>
    </tr>
     <tr>
		<td width="120" align="right">联系电话：</td>
		<td>
			<input name="mobile" id="mobile"  class="input_text_150" maxlength="15"/>
		</td>
    </tr>
     <tr>
		<td width="120" align="right">邮箱：</td>
		<td>
			<input name="email" id="email" class="input_text_150" maxlength="40"/>
		</td>
    </tr>
    <tr>
		<td align="right">其他说明：</td>
		<td>
			<textarea name="notes" id="notes"  style="width:300px; height:60px; line-height:180%; font-size:12px;"></textarea>
		</td>
    </tr>
    <tr>
		<td></td>
		<td>
			<input type="button" name="Submit"  id="ajax_app" class="but130lan" value="申请" />
		</td>
    </tr>
</table>-->
<!--<script type="text/javascript" src="/files/yuyue/js/jquery-1.9.0.min_v20150602185253.js"></script>-->
<!--<script type="text/javascript" src="/files/js/jquery.js"></script>-->
<script type="text/javascript" src="/files/yuyue/js/jquery-ui.min_v20150602185253.js"></script> 
<script type="text/javascript" src="/files/yuyue/js/reserve_v20150611144846.js" charset="gbk"></script>
<link href="/files/css/login.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/files/yuyue/css/jquery-ui.min_v20150602214557.css"/>
<link rel="stylesheet" type="text/css" href="/files/yuyue/css/jquery-ui.theme.min_v20150623172441.css"/>
<link type="text/css" rel="stylesheet" href="/files/yuyue/css/base_v20150424140418.css" media="all"/>
<link type="text/css" rel="stylesheet" href="/files/yuyue/css/hyliststyle_v20150715104141.css" media="all"/>
<div class="login_pop_box" id="app">
	<h2 id="h2">免费预约</h2>
	<div class="hkcon"><?php echo $course['trainname']?><br/><span><?php echo $course['course_name']?></span>&nbsp;&nbsp;&nbsp;&nbsp;<i>4</i>人预约</div>
	
                <input name="courseid" id="courseid" type="hidden" value="<?php echo $course['id'];?>"/>
                <input name="ms_java" id="ms_java" type="hidden" value="70314404"/>
		        <!-- &#x9884;&#x7EA6;&#x9632;&#x5237; -->		        

				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tk">
				 <!-- <tr>
				    <td>&nbsp;</td>
				    <td style="color:#a1a1a1; font-size:14px;"></td>
				    <td valign="middle" class="servicetime"><a id="man" class="xzl" onclick="sel_sex(this); clickLog('from=Huangye_detail_yuyue_male_popup&amp;cateid=104&amp;cityid=1')">&#x5148;&#x751F;</a> <a id="women" class="xzr" onclick="sel_sex(this); clickLog('from=Huangye_detail_yuyue_female_popup&amp;cateid=104&amp;cityid=1')">&#x5973;&#x58EB;</a>
				      <input id="sex" type="hidden" name="contactGender" value="0" /></td>
				    <td>&nbsp;</td>
			      </tr>-->
					<tr>
						<td width="38"><i class="bg_tk1"></i></td>
					    <td width="60" style="color:#a1a1a1; font-size:14px;">&#x65E5;&nbsp;&nbsp;&nbsp;&nbsp;&#x671F;</td>
					    <td width="196" valign="middle" class="servicetime">
					    	<input id="datepicker" type="text" class="phoinp tkinput grayfont" readonly="readonly" value="&#x8BF7;&#x8F93;&#x5165;&#x9884;&#x7EA6;&#x670D;&#x52A1;&#x65E5;&#x671F;" onfocus="$(this).removeClass('grayfont'); if(this.value=='&#x8BF7;&#x8F93;&#x5165;&#x9884;&#x7EA6;&#x670D;&#x52A1;&#x65E5;&#x671F;'){this.value='';}" autocomplete="false">
					    	<i id="vr_date" class="cwtx" style="display:none;">&#x8BF7;&#x9009;&#x62E9;&#x9884;&#x7EA6;&#x670D;&#x52A1;&#x65E5;&#x671F;</i>
					    	<span id="selecttime"></span></td>
					    <td width="284">&nbsp;</td>
					</tr>
					<tr>
						<td><i class="bg_tk2"></i></td>
						<td width="60" style="color:#a1a1a1; font-size:14px;">&#x65F6;&nbsp;&nbsp;&nbsp;&nbsp;&#x95F4;</td>
				    	<td width="196" valign="middle" class="servicetime zdex10">
				    		<input id="time1" type="text" class="phoinp tkinput grayfont" readonly="readonly" value="&#x8BF7;&#x8F93;&#x5165;&#x9884;&#x7EA6;&#x670D;&#x52A1;&#x65F6;&#x95F4;" onclick="sel_time()" onfocus="$(this).removeClass('grayfont'); if(this.value=='&#x8BF7;&#x8F93;&#x5165;&#x9884;&#x7EA6;&#x670D;&#x52A1;&#x65F6;&#x95F4;'){this.value='';}" autocomplete="false">
				    		<i id="vr_time" class="cwtx" style="display:none;">&#x8BF7;&#x9009;&#x62E9;&#x9884;&#x7EA6;&#x670D;&#x52A1;&#x65F6;&#x95F4;</i>
				    		<span id="selecttime" onclick="sel_time()"></span>
							<div class="timeaf none">
								<div class="time_up"><i></i>
									<ul>
										<li class="nobo">08:00</li>
										<li class="nobo">09:00</li>
										<li class="nobo">10:00</li>
										<li class="nobo">11:00</li>
										<li calss="nobo">12:00</li>
										<li class="nobo">13:00</li>
										<li class="nobo">14:00</li>
										<li class="nobo">15:00</li>
										<li class="nobo">16:00</li>
										<li class="nobo"> </li>
									</ul>
								</div>
								<div class="time_up bot0"><i></i>
									<ul>
								        <li>17:00</li>
								        <li>18:00</li>
								        <li>19:00</li>
								        <li>20:00</li>
								        <li>21:00</li>
								        <li class="nobo">22:00</li>
								        <li class="nobo">23:00</li>
								        <li class="nobo">24:00</li>
								        <li class="nobo"> </li>
								        <li class="nobo"> </li>
								    </ul>
								</div>
							</div>
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><i class="bg_tk3"></i></td>
						<td width="60" style="color:#a1a1a1; font-size:14px;">&#x8054;&nbsp;&#x7CFB;&nbsp;&#x4EBA;</td>
						<td width="196" valign="middle" class="servicetime">
							<input id="contacts" type="text" name="contactName" class="phoinp tkinput grayfont" value="&#x8BF7;&#x8F93;&#x5165;&#x8054;&#x7CFB;&#x4EBA;&#x59D3;&#x540D;" onkeyup="valContacts()" onfocus="$(this).removeClass('grayfont'); if(this.value=='&#x8BF7;&#x8F93;&#x5165;&#x8054;&#x7CFB;&#x4EBA;&#x59D3;&#x540D;'){this.value='';}" onblur="valContacts()">
							<i id="con_wrong" class="cwtx" style="display:none;">&#x8BF7;&#x8F93;&#x5165;&#x6B63;&#x786E;&#x8054;&#x7CFB;&#x4EBA;&#x59D3;&#x540D;</i>
							<span id="selecttime_t" style="display:none;"></span>
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><i class="bg_tk4"></i></td>
						<td width="60" style="color:#a1a1a1; font-size:14px;">&#x624B;&nbsp;&#x673A;&nbsp;&#x53F7;</td>
						<td width="196" valign="middle" class="servicetime">
							<input id="phone" type="text" name="phone" class="phoinp tkinput grayfont"  value="&#x8BF7;&#x8F93;&#x5165;&#x8054;&#x7CFB;&#x4EBA;&#x624B;&#x673A;&#x53F7;"  onfocus="$(this).removeClass('grayfont'); if(this.value=='&#x8BF7;&#x8F93;&#x5165;&#x8054;&#x7CFB;&#x4EBA;&#x624B;&#x673A;&#x53F7;'){this.value='';}" onkeyup="valPhone()" oninput="valPhone();" onblur="valPhone()">
							<i id="cwtx" class="cwtx" style="display:none;">&#x8BF7;&#x8F93;&#x5165;&#x6B63;&#x786E;&#x624B;&#x673A;&#x53F7;&#x7801;</i>
							<span id="selecttime_t" style="display:none;"></span>
						</td>
						<td><input id="reset" type="button" class="codel_t none" title="60&#x79D2;&#x540E;&#x91CD;&#x65B0;&#x83B7;&#x53D6;" value="60&#x79D2;&#x540E;&#x91CD;&#x65B0;&#x83B7;&#x53D6;"/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td><a  style="float:left;"href="javascript:;" id='ajax_app' class="queren" onclick="var ele = $(this);if(ele.hasClass('queren_h')){return;}else{beforFree();submitOrder()}">&#x786E;&#x8BA4;</a><a  style=""href="javascript:;" id="out" class="out" onclick="window.parent.closebtn('iframe_id')">&#x53D6;&#x6D88;</a></td>
						<td>&nbsp;</td>
					</tr>
				</table>
			
</div>
<!--<table id="notice" width="100%" border="0" style="border-top:1px #CCCCCC dotted;background-color: #EEEEEE; line-height: 230%;padding: 15px; margin-top: 10px; ">
    <tbody><tr>
	    <td class="ajax_app_tip">您每天可以预约<span></span>门课程，今天已经预约了<span></span>门，还可以预约<span></span>门
	    </td>
    </tr>
</tbody>
</table>-->
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
			<strong style="font-size:14px ; color:#0066CC;margin-left:20px">预约成功!</strong>
			<div style="border-top:1px #CCCCCC solid; line-height:180%; margin-top:10px; padding-top:10px; height:50px;margin-left:20px"  class="dialog_closed">
			<a href="javascript:void(0)"  class="DialogClose"  onclick="return refresh()">预约完成</a>
			</div>
		</td>
    </tr>
</table>
<?php
}
elseif ($act=="app_save")
{
	//echo "申请课程";exit;
	$courseid=isset($_POST['courseid'])?$_POST['courseid']:exit("出错了");
	$uid=isset($_POST['uid'])?intval($_POST['uid']):exit("出错了");
	$realname=isset($_POST['contacts'])?trim($_POST['contacts']):exit("出错了");
	$sex=isset($_POST['sex'])?intval($_POST['sex']):exit("出错了");
	$mobile=isset($_POST['phone'])?trim($_POST['phone']):exit("出错了");
	$datepicker=isset($_POST['datepicker'])?$_POST['datepicker']:exit("出错了");
	$time1=isset($_POST['time1'])?$_POST['time1']:exit("出错了");
	//$email=isset($_POST['email'])?trim($_POST['email']):exit("出错了");
	//if (!preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$email)) exit('邮箱格式不正确');
	//$notes=isset($_POST['notes'])?trim($_POST['notes']):"";
	$course=app_get_course($courseid);
	$course=array_map("addslashes",$course);
	if (empty($course))
	{
	exit("课程丢失");
	}
			///---------不能重复预约
			//exit($course['id']);
 			if (check_course_yuyue($mobile,$course['id']))
			{
			exit('repeat');
			}
			///-----fffffff
			//exit($datepicker." ".$time1.":00");
			$addarr['realname']=$realname;
			$addarr['email']=$email;
			$addarr['yuyue_time']=$datepicker." ".$time1.":00";
			$addarr['sex']=$sex;
			$addarr['mobile']=$mobile;
			$addarr['personal_uid']=intval($_SESSION['uid']);
			$addarr['course_id']=$course['id'];
			$addarr['course_name']=$course['course_name'];
			$addarr['train_id']=$course['train_id'];
			$addarr['train_name']=$course['trainname'];
			$addarr['train_uid']=$course['uid'];
			$addarr['notes']= $notes;
			if (strcasecmp(QISHI_DBCHARSET,"utf8")!=0)
			{
			$addarr['notes']=utf8_to_gbk($addarr['notes']);
			$addarr['realname']=utf8_to_gbk($addarr['realname']);
			$addarr['mobile']=utf8_to_gbk($addarr['mobile']);
			}
			$addarr['apply_addtime']=time();
			$addarr['personal_look']=1;
			//echo"<pre>";print_r($addarr);exit;
			if (inserttable(table('personal_course_apply'),$addarr))
			{
					$mailconfig=get_cache('mailconfig');					
					$course['contact']=$db->getone("select notify  from ".table('course_contact')." where pid='{$course['id']}' LIMIT 1 ");
					$sms=get_cache('sms_config');	
					$trainuser=get_user_info($course['uid']);	
					if ($mailconfig['set_applycou']=='1'  && $trainuser['email_audit']=='1' && $course['contact']['notify']=='1')
					{	
						dfopen("/plus/asyn_mail.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=set_applycou&course_id={$course['id']}&coursename={$course['course_name']}&personal_fullname={$realname}&email={$trainuser['email']}");
					}
					//sms	
					if ($sms['open']=="1"  && $sms['set_applycou']=="1"  && $trainuser['mobile_audit']=="1")
					{
						dfopen("/plus/asyn_sms.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=set_applycou&course_id={$course['id']}&coursename={$course['course_name']}&personal_fullname={$realname}&mobile={$trainuser['mobile']}");
					}
					//write_memberslog($_SESSION['uid'],2,s,$_SESSION['username'],"预约课程，课程:{$course['course_name']}");
			}
	 exit("ok");
}
?>
