<?php
 /*
 * 74cms ajax返回
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(dirname(__FILE__)).'/include/plus.common.inc.php');
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : '';
if ($act=='qx_baoming')
{
	require_once(QISHI_ROOT_PATH.'include/fun_qx.php');
	//$name = !empty($_POST['name'])?trim($_POST['name']):exit('<h2><i class="fa fa-smile-o"></i>您没有填写姓名<a onclick="history.back()">返回</a></h2>');
	
	$name= utf8_to_gbk(trim($_POST['name']));
	$sex=trim($_POST['sex']);
	$sex= utf8_to_gbk($sex);
	$height= utf8_to_gbk(trim($_POST['height']));
	$weight= intval($_POST['weight']);
	$phone= intval($_POST['phone']);
	$brithday=utf8_to_gbk($_POST['brithday']);
	$depratment= utf8_to_gbk(trim($_POST['depratment']));
	$home= utf8_to_gbk(trim($_POST['home']));
	$hobby= utf8_to_gbk(trim($_POST['hobby']));
	$selected= utf8_to_gbk(trim($_POST['selected']));

	$register=user_register($name,$sex,$height,true,$weight,$phone,$brithday,$depratment,$home,$hobby,$selected);
	//个人用户注册成功发送短信开始 By Z
	/*if ($register>0 && $member_type==2){
		require_once(QISHI_ROOT_PATH.'include/msg_reg.php');
	}*/
	//个人用户注册成功发送短信结束 By Z
	
	//----判断是否报名过
	/*$sql = "select * from zt_qx_baoming where name = '{$name}' LIMIT 1";
	$res=$db->getone($sql);
	if($res){$html='<h2><i class="fa fa-smile-o"></i>'.$name.'报名失败！您已经报名了</h2>';}*/
	//----
	/*if(empty($name) || empty($sex) || empty($height) || empty($weight) || empty($phone) || empty($brithday) || empty($depratment) || empty($hobby) || empty($selected))
	{
		$html='<h2><i class="fa fa-smile-o"></i>'.$name.'报名失败！信息填写不完整！</h2>';
		exit($html);
	}*/
	if ($register>0)
	{
		$html='<h2><i class="fa fa-smile-o"></i>您好,<span style="color:#333;">'.$name.'</span>报名成功！感谢您的参与！！！</h2>';
		exit($html);
		$login_js=user_login($username,$password);
		$mailconfig=get_cache('mailconfig');
		if ($mailconfig['set_reg']=="1")
		{
		dfopen($_CFG['website_dir']."plus/asyn_mail.php?uid=".$_SESSION['uid']."&key=".asyn_userkey($_SESSION['uid'])."&sendemail=".$email."&sendusername=".$username."&sendpassword=".$password."&act=reg");
		}
		$ucjs=$login_js['uc_login'];
		$qsurl=$login_js['qs_login'];
		$qsjs="<script language=\"javascript\" type=\"text/javascript\">window.location.href=\"".$qsurl."\";</script>";
		 if ($ucjs || $qsurl)
			{
			exit($ucjs.$qsjs);
			}
			else
			{
			exit("err");
			}
	}
	else
	{
		$html='<h2><i class="fa fa-smile-o"></i>'.$name.'报名失败！有可能您已经报名了</h2>';
		exit($html);
	}
}
//---------七夕传情
elseif($act=='qx_msg')
{
	require_once(QISHI_ROOT_PATH.'include/fun_qx.php');
	$to= utf8_to_gbk(trim($_POST['to']));
	$contents= utf8_to_gbk(trim($_POST['contents']));
	$from= utf8_to_gbk(trim($_POST['from']));
	$addtime=time();
	$bg= utf8_to_gbk(trim($_POST['bg']));
	//exit($bg);
	$register=qx_register($to,$contents,$from,true,$addtime,$bg);
	//exit($register);
	if ($register>0)
	{
		//$url='http://www.1dagong.com/zt/qixi/index.php?act=chakan&id='.$register;
		//$html='<div>点击下方复制链接给你心爱的他(她)</div><h2 style="text-align:center;"><i class="fa fa-smile-o"></i><a href="'.$url.'">点击查看</a><br><input onclick="oCopy(this)"  value="'.$url.'" /> ';
		$html='<img src="/plus/url_qrcode_qx.php?url=http://www.1dagong.com/zt/qixi/index.php?id='.$register.'&act=chakan" alt="二维码" style=" position: relative;left: 50%;margin-left: -135px;" ></img><br><p style="text-align:center;">长按上方二维码保存图片<br>转发这张二维码给心仪的TA！</p>';
		exit($html);
	}
}
elseif ($act=='qx_xuanyan')
{
	
	require_once(QISHI_ROOT_PATH.'include/fun_qx.php');
	//$name = !empty($_POST['name'])?trim($_POST['name']):exit('<h2><i class="fa fa-smile-o"></i>您没有填写姓名<a onclick="history.back()">返回</a></h2>');
	
	$name= utf8_to_gbk(trim($_POST['name']));
	$gonghao=trim($_POST['gonghao']);
	$gonghao= utf8_to_gbk($gonghao);
	$contents= utf8_to_gbk(trim($_POST['contents']));
	$phone= intval($_POST['phone']);
	
	$register_1=set_xuanyan($name,$gonghao,$contents,true,$phone);
	//个人用户注册成功发送短信开始 By Z
	/*if ($register>0 && $member_type==2){
		require_once(QISHI_ROOT_PATH.'include/msg_reg.php');
	}*/
	//个人用户注册成功发送短信结束 By Z
	
	//----判断是否报名过
	/*$sql = "select * from zt_qx_baoming where name = '{$name}' LIMIT 1";
	$res=$db->getone($sql);
	if($res){$html='<h2><i class="fa fa-smile-o"></i>'.$name.'报名失败！您已经报名了</h2>';}*/
	//----
	/*if(empty($name) || empty($sex) || empty($height) || empty($weight) || empty($phone) || empty($brithday) || empty($depratment) || empty($hobby) || empty($selected))
	{
		$html='<h2><i class="fa fa-smile-o"></i>'.$name.'报名失败！信息填写不完整！</h2>';
		exit($html);
	}*/
	if ($register_1>0)
	{
		$html='<h2>很棒的爱情宣言，已为您挂在姻缘树上！</h2>
            <p>感谢您的参与，您已获得姻缘树幸运抽奖活动抽奖机会</p>
            <p>获奖名单将于8月19日12:00  公布在姻缘树页面。</p>';
		exit($html);
		$login_js=user_login($username,$password);
		$mailconfig=get_cache('mailconfig');
		if ($mailconfig['set_reg']=="1")
		{
		dfopen($_CFG['website_dir']."plus/asyn_mail.php?uid=".$_SESSION['uid']."&key=".asyn_userkey($_SESSION['uid'])."&sendemail=".$email."&sendusername=".$username."&sendpassword=".$password."&act=reg");
		}
		$ucjs=$login_js['uc_login'];
		$qsurl=$login_js['qs_login'];
		$qsjs="<script language=\"javascript\" type=\"text/javascript\">window.location.href=\"".$qsurl."\";</script>";
		 if ($ucjs || $qsurl)
			{
			exit($ucjs.$qsjs);
			}
			else
			{
			exit("err");
			}
	}
	else
	{
		$html='<h2><i class="fa fa-smile-o"></i>'.$name.'宣言失败！</h2>';
		exit($html);
	}
}
//---fff----体验员
elseif ($act=='bm_tiyan')
{
	
	require_once(QISHI_ROOT_PATH.'include/fun_qx.php');
	//$name = !empty($_POST['name'])?trim($_POST['name']):exit('<h2><i class="fa fa-smile-o"></i>您没有填写姓名<a onclick="history.back()">返回</a></h2>');
	$name= utf8_to_gbk(trim($_POST['name']));
	$age=utf8_to_gbk($_POST['age']);
	$typeid= intval($_POST['typeid']);
	$uid= intval($_POST['uid']);
	$work= utf8_to_gbk(trim($_POST['work']));
	$phone= $_POST['phone'];
	//echo $uid;echo $phone;exit;
	$register_1=bm_tiyanyuan($name,$age,$work,true,$phone,$typeid,$uid);
	//个人用户注册成功发送短信开始 By Z
	/*if ($register>0 && $member_type==2){
		require_once(QISHI_ROOT_PATH.'include/msg_reg.php');
	}*/
	//个人用户注册成功发送短信结束 By Z
	
	//----判断是否报名过
	/*$sql = "select * from zt_qx_baoming where name = '{$name}' LIMIT 1";
	$res=$db->getone($sql);
	if($res){$html='<h2><i class="fa fa-smile-o"></i>'.$name.'报名失败！您已经报名了</h2>';}*/
	//----
	/*if(empty($name) || empty($sex) || empty($height) || empty($weight) || empty($phone) || empty($brithday) || empty($depratment) || empty($hobby) || empty($selected))
	{
		$html='<h2><i class="fa fa-smile-o"></i>'.$name.'报名失败！信息填写不完整！</h2>';
		exit($html);
	}*/
	//exit($register_1);
	if ($register_1 > 0)
	{
		$html='<p>您申请<span><b>&ldquo;壹专家&rdquo;网站体验员 报名成功！</b></span></p>
					<p>感谢您对壹打工网的支持，我们会认真阅读您的申报资料。</p>
					<p>审核通过后，通知短信会发送至您的手机，客服人员也会与您联系。</p>';
		exit($html);
		$login_js=user_login($username,$password);
		$mailconfig=get_cache('mailconfig');
		if ($mailconfig['set_reg']=="1")
		{
		dfopen($_CFG['website_dir']."plus/asyn_mail.php?uid=".$_SESSION['uid']."&key=".asyn_userkey($_SESSION['uid'])."&sendemail=".$email."&sendusername=".$username."&sendpassword=".$password."&act=reg");
		}
		$ucjs=$login_js['uc_login'];
		$qsurl=$login_js['qs_login'];
		$qsjs="<script language=\"javascript\" type=\"text/javascript\">window.location.href=\"".$qsurl."\";</script>";
		 if ($ucjs || $qsurl)
			{
			exit($ucjs.$qsjs);
			}
			else
			{
			exit("err");
			}
	}
	elseif($register_1 = 0)
	{
		//$html='<h2><i class="fa fa-smile-o"></i>'.$name.'报名失败！</h2>';
		$html='<p><font style="color:#f00;">报名失败！名额已满</font></p>';
		exit($html);
	}
	else
	{
		
		$html='<p><font style="color:#f00;">报名失败！您已经报名过了！</font></p>';
		exit($html);
	}
}
//---fffff
//---fff----体验员----查找分别剩余人数
elseif ($act=='tiyan_num')
{
	$typeid= intval($_POST['typeid']);
	$sql = "select num from zt_tiyan_type where id='{$typeid}'  LIMIT 1";
	$val=$db->getone($sql);
	//exit($val['num']);
	exit($typeid);
}
elseif($act =='check_usname')
{
	require_once(QISHI_ROOT_PATH.'include/fun_user.php');
	$usname=trim($_POST['usname']);
	if (strcasecmp(QISHI_DBCHARSET,"utf8")!=0)
	{
	$usname=utf8_to_gbk($usname);
	}
	$user=get_user_inusername($usname);
	if (defined('UC_API'))
	{
		include_once(QISHI_ROOT_PATH.'uc_client/client.php');
		if (uc_user_checkname($usname)===1 && empty($user))
		{
		exit("true");
		}
		else
		{
		exit("false");
		}
	}
	empty($user)?exit("true"):exit("false");
}
//---fff----验证公司名称
elseif($act =='check_companyname')
{
	require_once(QISHI_ROOT_PATH.'include/fun_user.php');
	$companyname=trim($_POST['companyname']);
	if (strcasecmp(QISHI_DBCHARSET,"utf8")!=0)
	{
	$companyname=utf8_to_gbk($companyname);
	}
	$user=get_user_companyname($companyname);
	if (defined('UC_API'))
	{
		include_once(QISHI_ROOT_PATH.'uc_client/client.php');
		if (uc_user_checkcompanyname($companyname)===1 && empty($user))
		{
		exit("true");
		}
		else
		{
		exit("false");
		}
	}
	empty($user)?exit("true"):exit("false");
}
elseif ($act=="top_loginform")
{
	$contents='';
	if ($_COOKIE['QS']['username'] && $_COOKIE['QS']['password'])
	{
		//$contents='欢迎&nbsp;&nbsp;<a href="{#$user_url#}" style="color:#339900">{#$username#}</a> 登录！&nbsp;&nbsp;{#$pmscount_a#}&nbsp;&nbsp;&nbsp;&nbsp;<a href="{#$user_url#}" style="color:#0066cc">[会员中心]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{#$logout_url#}" style="color:#0066cc">[退出]</a>';
		if ($_COOKIE['QS']['utype']=='2')//--个人
			{
			$contents='<div class="fr htnav"><ul id="hyzxnav">	
						<li><a href="/user/personal/personal_index.php"><span>{#$username#}</span><i class="fa fa-sort-desc"></i></a>
                        <ul>
							<li><a href="/user/personal/personal_index.php" _fcksavedurl="{#$user_url#}">会员中心</a></li>
                            <li><a href="/user/personal/personal_resume.php?act=resume_list" _fcksavedurl="personal_resume.php?act=resume_list">我的简历</a></li> 
                            <li><a href="/user/personal/personal_apply.php?act=favorites" _fcksavedurl="personal_apply.php?act=favorites">收藏夹</a></li> 
                            <li><a href="/user/personal/personal_apply.php?act=apply_jobs" _fcksavedurl="personal_apply.php?act=apply_jobs">已申请的职位</a></li>
                            <li><a href="/user/personal/personal_apply.php?act=my_attention" _fcksavedurl="personal_apply.php?act=my_attention">浏览过的职位</a></li>
                            <li><a href="/user/personal/personal_user.php?act=userprofile" _fcksavedurl="personal_user.php?act=userprofile">基本资料</a></li> 
                            <li><a href="{#$logout_url#}" _fcksavedurl="{#$logout_url#}">退出</a></li> 
                        </ul> 
                    </li></ul></div>';
		}
	if ($_COOKIE['QS']['utype']=='1')//--企业
		{
			$contents='<div class="fr htnav"><ul id="hyzxnav">
						<li><a href="/user/company/company_index.php" _fcksavedurl="#"><span>{#$username#}</span><i class="fa fa-sort-desc"></i></a>
                        <ul>
							<li><a href="/user/company/company_index.php" _fcksavedurl="{#$user_url#}">会员中心</a></li>
                            <li><a href="/user/company/company_jobs.php?act=addjobs" _fcksavedurl="company_jobs.php?act=addjobs">发布职位</a></li> 
                            <li><a href="/user/company/company_info.php?act=company_profile" _fcksavedurl="company_info.php?act=company_profile">基本信息</a></li> 
                            <li><a href="/user/company/company_jobfair.php?act=jobfair" _fcksavedurl="company_jobfair.php?act=jobfair">展位预订</a></li> 
                            <li><a href="/user/company/company_jobfair.php?act=mybooth" _fcksavedurl="company_jobfair.php?act=mybooth">我的预定</a></li>
                            <li><a href="{#$logout_url#}" _fcksavedurl="{#$logout_url#}">退出</a></li> 
                        </ul> 
                    </li></ul></div>';
		}
		//----ffffff---培训会员
		if ($_COOKIE['QS']['utype']=='4')//--培训会员
		{
			$contents='<div class="fr htnav"><ul id="hyzxnav">
						<li><a href="{#$user_url#}" _fcksavedurl="#"><span>{#$username#}</span><i class="fa fa-sort-desc"></i></a>
                        <ul>
							<li><a href="{#$user_url#}" _fcksavedurl="{#$user_url#}">会员中心</a></li>
                            <li><a href="/user/train/train_course.php?act=addcourse" _fcksavedurl="/user/train/train_course.php?act=addcourse">发布课程</a></li> 
                            <li><a href="/user/train/train_teacher.php?act=add_teachers" _fcksavedurl="/user/train/train_teacher.php?act=add_teachers">添加讲师</a></li> 
                            <li><a href="/user/train/train_info.php?act=train_profile" _fcksavedurl="/user/train/train_info.php?act=train_profile">机构资料</a></li> 
                            <li><a href="/user/train/train_user.php?act=password_edit" _fcksavedurl="/user/train/train_user.php?act=password_edit">修改密码</a></li>
                            <li><a href="{#$logout_url#}" _fcksavedurl="{#$logout_url#}">退出</a></li> 
                        </ul> 
                    </li></ul></div>';
		}
		//--ffffff
		if ($_COOKIE['QS']['utype']=='5')//--审核员
		{
			$contents='<div class="fr htnav"><ul id="hyzxnav">
						<li><a href="{#$user_url#}" _fcksavedurl="#"><span>{#$username#}</span><i class="fa fa-sort-desc"></i></a>
                        <ul>
							<li><a href="{#$user_url#}" _fcksavedurl="{#$user_url#}">会员中心</a></li>
                            <li><a href="/user/shenhe/shenhe_jobs.php?act=addjobs" _fcksavedurl="/user/shenhe/shenhe_jobs.php?act=addjobs">发布行业名企</a></li> 
                            <li><a href="/user/shenhe/shenhe_jobs.php?act=jobs" _fcksavedurl="user/shenhe/shenhe_jobs.php?act=jobs">行业名企管理</a></li> 
                            <li><a href="/user/shenhe/shenhe_company.php?act=shenhe_company_list&audit=" _fcksavedurl="/user/shenhe/shenhe_company.php?act=shenhe_company_list&audit=">企业会员审核</a></li> 
                            <li><a href="/user/shenhe/shenhe_company_jobs.php?act=sheneh_company_jobs" _fcksavedurl="user/shenhe/shenhe_company_jobs.php?act=sheneh_company_jobs">职位审核</a></li>
                            <li><a href="{#$logout_url#}" _fcksavedurl="{#$logout_url#}">退出</a></li> 
                        </ul> 
                    </li></ul></div>';
		}
	}
	elseif ($_SESSION['activate_username'] && defined('UC_API'))
	{
		$contents=' &nbsp;&nbsp;您的帐号 {#$activate_username#} 需激活后才可以使用！ <a href="{#$activate_url#}" style="color:#339900">立即激活</a>';
	}
	else
	{	
		//$contents='欢迎来到{#$site_name#}！&nbsp;&nbsp;&nbsp;&nbsp;<a href="{#$login_url#}" style="color:#0066cc" >[登录]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{#$reg_url#}" style="color:#0066cc">[免费注册]</a>';
		$contents='<div class="login fr">
            <ul>
                <li><a href="/user/login.php">登录</a></li>
                    <li><a href="/user/user_reg.php">注册</a></li>
                    <li class="mobile"><a href="#"><i class="fa fa-mobile"></i>手机壹打工</a>
                    	<div class="app">
                        	<i class="fa fa-sort-asc"></i>
                        	<img src="/files/img/app.jpg" alt="" title="壹打工网客户端" />
                        </div>
                    </li></ul></div>';
	}
		$contents=str_replace('{#$activate_username#}',$_SESSION['activate_username'],$contents);
		$contents=str_replace('{#$site_name#}',$_CFG['site_name'],$contents);
		$contents=str_replace('{#$username#}',$_COOKIE['QS']['username'],$contents);
		$contents=str_replace('{#$pmscount#}',$_COOKIE['QS']['pmscount'],$contents);
		$contents=str_replace('{#$site_template#}',$_CFG['site_template'],$contents);
		if ($_COOKIE['QS']['utype']=='1')//--企业
		{
		$user_url=$_CFG['main_domain']."user/company/company_index.php";
			if($_COOKIE['QS']['pmscount']>0)
			 {
			 $pmscount_a='<a href="'.$_CFG['main_domain'].'user/company/company_user.php?act=pm&new=1" style="padding:1px 4px; background-color:#FF6600; color:#FFFFFF;text-decoration:none" title="短消息">消息 '.$_COOKIE['QS']['pmscount'].'</a>';
			 }
		}
		if ($_COOKIE['QS']['utype']=='2')//--个人
		{
			$user_url=$_CFG['main_domain']."user/personal/personal_index.php";
			if($_COOKIE['QS']['pmscount']>0)
			 {
			 $pmscount_a='<a href="'.$_CFG['main_domain'].'user/personal/personal_user.php?act=pm&new=1" style="padding:1px 4px; background-color:#FF6600; color:#FFFFFF;text-decoration:none" title="短消息">消息 '.$_COOKIE['QS']['pmscount'].'</a>';
			 }
		}
		if ($_COOKIE['QS']['utype']=='4')
		{
			//$user_url=$_CFG['main_domain']."user/train/train_index.php";
			$user_url="/user/train/train_index.php";
			if($_COOKIE['QS']['pmscount']>0)
			 {
			 $pmscount_a='<a href="'.$_CFG['main_domain'].'user/train/train_user.php?act=pm&new=1" style="padding:1px 4px; background-color:#FF6600; color:#FFFFFF;text-decoration:none" title="短消息">消息 '.$_COOKIE['QS']['pmscount'].'</a>';
			 }
		}
		if ($_COOKIE['QS']['utype']=='3')
		{
			$user_url=$_CFG['main_domain']."user/hunter/hunter_index.php";
			if($_COOKIE['QS']['pmscount']>0)
			 {
			 $pmscount_a='<a href="'.$_CFG['main_domain'].'user/hunter/hunter_user.php?act=pm&new=1" style="padding:1px 4px; background-color:#FF6600; color:#FFFFFF;text-decoration:none" title="短消息">消息 '.$_COOKIE['QS']['pmscount'].'</a>';
			 }
		}
		if ($_COOKIE['QS']['utype']=='5')//--审核员
		{
		$user_url=$_CFG['main_domain']."user/shenhe/shenhe_index.php";
			if($_COOKIE['QS']['pmscount']>0)
			 {
			 $pmscount_a='<a href="'.$_CFG['main_domain'].'user/company/company_user.php?act=pm&new=1" style="padding:1px 4px; background-color:#FF6600; color:#FFFFFF;text-decoration:none" title="短消息">消息 '.$_COOKIE['QS']['pmscount'].'</a>';
			 }
		}
		$contents=str_replace('{#$pmscount_a#}',$pmscount_a,$contents);
		$contents=str_replace('{#$user_url#}',$user_url,$contents);
		$contents=str_replace('{#$login_url#}',url_rewrite('QS_login',NULL,false),$contents);
		$contents=str_replace('{#$logout_url#}',url_rewrite('QS_login',NULL,false)."?act=logout",$contents);
		$contents=str_replace('{#$reg_url#}',$_CFG['main_domain']."user/user_reg.php",$contents);
		$contents=str_replace('{#$activate_url#}',$_CFG['main_domain']."user/user_reg.php?act=activate",$contents);
		exit($contents);
}
elseif ($act=="loginform")
{
	$contents='';
	if ($_COOKIE['QS']['username'] && $_COOKIE['QS']['password'])
	{
		$tpl='../templates/'.$_CFG['template_dir']."plus/login_success.htm";
	}
	elseif ($_SESSION['activate_username'] && defined('UC_API'))
	{
		$tpl='../templates/'.$_CFG['template_dir']."plus/login_activate.htm";
	}
	else
	{
		$tpl='../templates/'.$_CFG['template_dir']."plus/login_form.htm";
	}
		$contents=file_get_contents($tpl);
		$contents=str_replace('{#$activate_username#}',$_SESSION['activate_username'],$contents);
		$contents=str_replace('{#$site_name#}',$_CFG['site_name'],$contents);
		$contents=str_replace('{#$username#}',$_COOKIE['QS']['username'],$contents);
		$contents=str_replace('{#$pmscount#}',$_COOKIE['QS']['pmscount'],$contents);
		$contents=str_replace('{#$site_template#}',$_CFG['site_template'],$contents);
		$contents=str_replace('{#$website_dir#}',$_CFG['website_dir'],$contents);
		if ($_COOKIE['QS']['utype']=='1')
		{
			$user_url=$_CFG['main_domain']."user/company/company_index.php";
			 if($_COOKIE['QS']['pmscount']>0)
			 {
			 $pmscount_a='<a href="'.$_CFG['main_domain'].'user/company/company_user.php?act=pm&new=1" style="padding:1px 4px; background-color:#FF6600; color:#FFFFFF;text-decoration:none" title="短消息">消息 '.$_COOKIE['QS']['pmscount'].'</a>';
			 }
		}
		if ($_COOKIE['QS']['utype']=='2')
		{
			$user_url=$_CFG['main_domain']."user/personal/personal_index.php";
			 if($_COOKIE['QS']['pmscount']>0)
			 {
			 $pmscount_a='<a href="'.$_CFG['main_domain'].'user/personal/personal_user.php?act=pm&new=1" style="padding:1px 4px; background-color:#FF6600; color:#FFFFFF;text-decoration:none" title="短消息">消息 '.$_COOKIE['QS']['pmscount'].'</a>';
			 }
		}
		if ($_COOKIE['QS']['utype']=='4')
		{
			$user_url=$_CFG['main_domain']."user/train/train_index.php";
			 if($_COOKIE['QS']['pmscount']>0)
			 {
			 $pmscount_a='<a href="'.$_CFG['main_domain'].'user/train/train_user.php?act=pm&new=1" style="padding:1px 4px; background-color:#FF6600; color:#FFFFFF;text-decoration:none" title="短消息">消息 '.$_COOKIE['QS']['pmscount'].'</a>';
			 }
		}
		if ($_COOKIE['QS']['utype']=='3')
		{
			$user_url=$_CFG['main_domain']."user/hunter/hunter_index.php";
			 if($_COOKIE['QS']['pmscount']>0)
			 {
			 $pmscount_a='<a href="'.$_CFG['main_domain'].'user/hunter/hunter_user.php?act=pm&new=1" style="padding:1px 4px; background-color:#FF6600; color:#FFFFFF;text-decoration:none" title="短消息">消息 '.$_COOKIE['QS']['pmscount'].'</a>';
			 }
		}
		$contents=str_replace('{#$pmscount_a#}',$pmscount_a,$contents);
		$contents=str_replace('{#$user_url#}',$user_url,$contents);
		$contents=str_replace('{#$login_url#}',url_rewrite('QS_login',NULL,false),$contents);
		$contents=str_replace('{#$logout_url#}',url_rewrite('QS_login',NULL,false)."?act=logout",$contents);
		$contents=str_replace('{#$reg_url#}',$_CFG['main_domain']."user/user_reg.php",$contents);
		$contents=str_replace('{#$activate_url#}',$_CFG['main_domain']."user/user_reg.php?act=activate",$contents);
		exit($contents);
}elseif($act =="bottom_date_up"){
	$time=time();
	$date_up=date('Y-m-d H:i:s',$time);
	exit($date_up);
}
?>