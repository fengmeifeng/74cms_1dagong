<?php
/*
 * 74cms 个人会员中心
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__) . '/personal_common.php');
$smarty->assign('leftmenu',"resume");
//简历列表
if ($act=='resume_list')
{
	$wheresql=" WHERE uid='".$_SESSION['uid']."' ";
	$sql="SELECT * FROM ".table('resume').$wheresql;
	$smarty->assign('title','我的简历 - 个人会员中心 - '.$_CFG['site_name']);
	$smarty->assign('act',$act);
	$smarty->assign('total',$total);
	$smarty->assign('resume_list',get_resume_list($sql,12,true,true,true));
	$smarty->display('member_personal/personal_resume_list.htm');
}
elseif ($act=='refresh')
{
		$resumeid = intval($_GET['id'])?intval($_GET['id']):showmsg("您没有选择简历！");
		$refrestime=get_last_refresh_date($_SESSION['uid'],"2001");
		$duringtime=time()-$refrestime['max(addtime)'];
		$space = $_CFG['per_refresh_resume_space']*60;
		$refresh_time = get_today_refresh_times($_SESSION['uid'],"2001");
		if($_CFG['per_refresh_resume_time']!=0&&($refresh_time['count(*)']>=$_CFG['per_refresh_resume_time']))
		{
		showmsg("每天最多只能刷新".$_CFG['per_refresh_resume_time']."次,您今天已超过最大刷新次数限制！",2);	
		}
		elseif($duringtime<=$space){
		showmsg($_CFG['per_refresh_resume_space']."分钟内不能重复刷新简历！",2);
		}
		else 
		{
		refresh_resume($resumeid,$_SESSION['uid'])?showmsg('操作成功！',2):showmsg('操作失败！',0);
		}
}
//删除简历
elseif ($act=='del_resume')
{
	if (intval($_GET['id'])==0)
	{
	exit('您没有选择简历！');
	}
	else
	{
	del_resume($_SESSION['uid'],intval($_GET['id']))?exit('success'):exit('fail');
	}
}
//创建简历-基本信息
elseif ($act=='make1')
{
	$uid=intval($_SESSION['uid']);
	$pid=intval($_REQUEST['pid']);
	$_SESSION['send_mobile_key']=mt_rand(100000, 999999);
	$smarty->assign('send_key',$_SESSION['send_mobile_key']);
	$smarty->assign('resume_basic',get_resume_basic($uid,$pid));
	$smarty->assign('resume_education',get_resume_education($uid,$pid));
	$smarty->assign('resume_work',get_resume_work($uid,$pid));
	$smarty->assign('resume_training',get_resume_training($uid,$pid));
	$smarty->assign('subsite',get_subsite_list());
	$smarty->assign('act',$act);
	$smarty->assign('pid',$pid);
	$smarty->assign('user',$user);
	$smarty->assign('userprofile',get_userprofile($_SESSION['uid']));	
	$smarty->assign('title','我的简历 - 个人会员中心 - '.$_CFG['site_name']);
	$captcha=get_cache('captcha');
	$smarty->assign('verify_resume',$captcha['verify_resume']);
	$smarty->assign('go_resume_show',$_GET['go_resume_show']);
	$smarty->display('member_personal/personal_make_resume_step1.htm');
}
//创建简历 -保存基本信息、求职意向
elseif ($act=='make1_save')
{
	$captcha=get_cache('captcha');
	$postcaptcha = trim($_POST['postcaptcha']);
	if($captcha['verify_resume']=='1' && empty($postcaptcha) && intval($_REQUEST['pid'])===0)
	{
		showmsg("请填写系统验证码",1);
 	}
	if ($captcha['verify_resume']=='1' && intval($_REQUEST['pid'])===0 &&  strcasecmp($_SESSION['imageCaptcha_content'],$postcaptcha)!=0)
	{
		showmsg("系统验证码错误",1);
	}
	$setsqlarr['uid']=intval($_SESSION['uid']);
	$setsqlarr['telephone']=trim($_POST['mobile'])?trim($_POST['mobile']):showmsg('请填写手机号！',1);
		
	if($user['mobile_audit']==0){
		$mobile_audit=0;
		$verifycode=trim($_POST['verifycode']);
		if($verifycode){
			if (empty($_SESSION['mobile_rand']) || $verifycode<>$_SESSION['mobile_rand'])
			{
				showmsg("手机验证码错误",1);
			}
			else
			{
				$verifysqlarr['mobile'] = $setsqlarr['telephone'];
				$verifysqlarr['mobile_audit'] = 1;
				$mobile_audit=1;
				updatetable(table('members'),$verifysqlarr," uid='{$setsqlarr['uid']}'");
				unset($verifysqlarr);
			}
		}
		unset($_SESSION['verify_mobile'],$_SESSION['mobile_rand']);
	}else{
		$mobile_audit=1;
	}
	
	$setsqlarr['subsite_id']=intval($_POST['subsite_id']);
	$setsqlarr['title']=trim($_POST['title'])?trim($_POST['title']):"未命名简历";
	check_word($_CFG['filter'],$_POST['title'])?showmsg($_CFG['filter_tips'],0):'';
	$setsqlarr['fullname']=trim($_POST['fullname'])?trim($_POST['fullname']):showmsg('请填写姓名！',1);
	check_word($_CFG['filter'],$_POST['fullname'])?showmsg($_CFG['filter_tips'],0):'';
	$setsqlarr['display_name']=intval($_POST['display_name']);
	$setsqlarr['sex']=trim($_POST['sex'])?intval($_POST['sex']):showmsg('请选择性别！',1);
	$setsqlarr['sex_cn']=trim($_POST['sex_cn']);
	$setsqlarr['birthdate']=intval($_POST['birthdate'])>1945?intval($_POST['birthdate']):showmsg('请正确填写出生年份',1);
	$setsqlarr['residence']=trim($_POST['residence'])?trim($_POST['residence']):showmsg('请选择现居住地！',1);
	$setsqlarr['residence_cn']=trim($_POST['residence_cn']);
	$setsqlarr['education']=intval($_POST['education'])?intval($_POST['education']):showmsg('请选择学历',1);
	$setsqlarr['education_cn']=trim($_POST['education_cn']);
	$setsqlarr['experience']=intval($_POST['experience'])?intval($_POST['experience']):showmsg('请选择工作经验',1);
	$setsqlarr['experience_cn']=trim($_POST['experience_cn']);
	$setsqlarr['email']=trim($_POST['email'])?trim($_POST['email']):showmsg('请填写邮箱！',1);
	check_word($_CFG['filter'],$_POST['email'])?showmsg($_CFG['filter_tips'],0):'';
	$setsqlarr['email_notify']=$_POST['email_notify']=="1"?1:0;
	$setsqlarr['height']=intval($_POST['height']);
	$setsqlarr['householdaddress']=trim($_POST['householdaddress']);
	$setsqlarr['householdaddress_cn']=trim($_POST['householdaddress_cn']);	
	$setsqlarr['marriage']=intval($_POST['marriage']);
	$setsqlarr['marriage_cn']=trim($_POST['marriage_cn']);;
	$setsqlarr['intention_jobs']=trim($_POST['intention_jobs'])?trim($_POST['intention_jobs']):showmsg('请选择意向职位！',1);
	$setsqlarr['trade']=$_POST['trade']?trim($_POST['trade']):showmsg('请选择期望行业！',1);
	$setsqlarr['trade_cn']=trim($_POST['trade_cn']);
	$setsqlarr['district']=trim($_POST['district'])?intval($_POST['district']):showmsg('请选择期望工作地区！',1);
	$setsqlarr['sdistrict']=intval($_POST['sdistrict']);
	$setsqlarr['district_cn']=trim($_POST['district_cn']);
	$setsqlarr['nature']=intval($_POST['nature'])?intval($_POST['nature']):showmsg('请选择期望岗位性质！',1);
	$setsqlarr['nature_cn']=trim($_POST['nature_cn']);
	$setsqlarr['wage']=intval($_POST['wage'])?intval($_POST['wage']):showmsg('请选择期望薪资！',1);
	$setsqlarr['wage_cn']=trim($_POST['wage_cn']);
	$setsqlarr['entrust']=intval($_POST['entrust']);
	$setsqlarr['refreshtime']=$timestamp;
	$setsqlarr['audit']=intval($_CFG['audit_resume']);
	$total=$db->get_total("SELECT COUNT(*) AS num FROM ".table('resume')." WHERE uid='{$_SESSION['uid']}'");
	if ($total>=intval($_CFG['resume_max']))
	{
	showmsg("您最多可以创建{$_CFG['resume_max']} 份简历,已经超出了最大限制！",1);
	}
	else
	{
	$setsqlarr['addtime']=$timestamp;
	$pid=inserttable(table('resume'),$setsqlarr,1);
	$searchtab['id'] = $pid;
	$searchtab['uid'] = $_SESSION['uid'];
	inserttable(table('resume_search_key'),$searchtab);
	inserttable(table('resume_search_rtime'),$searchtab);
	if (empty($pid))showmsg("保存失败！",0);
	//echo $_POST['intention_jobs_id'];exit;
	add_resume_jobs($pid,$_SESSION['uid'],$_POST['intention_jobs_id'])?"":showmsg('保存失败！',0);
	add_resume_trade($pid,$_SESSION['uid'],$_POST['trade'])?"":showmsg('保存失败！',0);
	check_resume($_SESSION['uid'],$pid);
	if(intval($_POST['entrust'])){
		set_resume_entrust($pid);
	}
	write_memberslog($_SESSION['uid'],2,1101,$_SESSION['username'],"创建了简历");
	
	if(!get_userprofile($_SESSION['uid'])){
		$infoarr['realname']=$setsqlarr['fullname'];
		$infoarr['sex']=$setsqlarr['sex'];
		$infoarr['sex_cn']=$setsqlarr['sex_cn'];
		$infoarr['birthday']=$setsqlarr['birthdate'];
		$infoarr['residence']=$setsqlarr['residence'];
		$infoarr['residence_cn']=$setsqlarr['residence_cn'];
		$infoarr['education']=$setsqlarr['education'];
		$infoarr['education_cn']=$setsqlarr['education_cn'];
		$infoarr['experience']=$setsqlarr['experience'];
		$infoarr['experience_cn']=$setsqlarr['experience_cn'];
		$infoarr['height']=$setsqlarr['height'];
		$infoarr['householdaddress']=$setsqlarr['householdaddress'];
		$infoarr['householdaddress_cn']=$setsqlarr['householdaddress_cn'];
		$infoarr['marriage']=$setsqlarr['marriage'];
		$infoarr['marriage_cn']=$setsqlarr['marriage_cn'];
		$infoarr['phone']=$setsqlarr['telephone'];
		$infoarr['email']=$setsqlarr['email'];
		$infoarr['uid']=intval($_SESSION['uid']);
		inserttable(table('members_info'),$infoarr);
	}
	header("Location: ?act=make1_succeed&pid=".$pid);
	}	
}
elseif($act=='make1_succeed'){
	$pid = intval($_GET['pid']);
	$smarty->assign('pid',$pid);
	$smarty->assign('title','我的简历 - 个人会员中心 - '.$_CFG['site_name']);
	$smarty->display('member_personal/personal_make_resume_step1_succeed.htm');
}
elseif($act=='ajax_get_interest_jobs'){
	global $_CFG;
	$uid=intval($_SESSION['uid']);
	$pid=intval($_GET['pid']);
	$html = "";
	$interest_id = get_interest_jobs_id_by_resume($uid,$pid);
	$jobs_list = get_interest_jobs_list($interest_id);
	if(!empty($jobs_list)){
		foreach($jobs_list as $k=>$v){
			$jobs_url = url_rewrite("QS_jobsshow",array("id"=>$v['id']));
			$company_url = url_rewrite("QS_companyshow",array("id"=>$v['company_id']));
			$html.='<div class="l1 link_bk"><a href="'.$jobs_url.'" target="_blank">'.$v["jobs_name"].'</a></div>
			  <div class="l2 link_bk"><a href="'.$company_url.'" target="_blank">'.$v["companyname"].'</a></div>
			  <div class="l3">'.$v["district_cn"].'</div>
			  <div class="l4">'.$v["wage_cn"].'</div>';
			  $html.='<div class="clear"></div>';
		}
		$html.='<div class="more link_lan"><a target="_blank" href="'.url_rewrite("QS_jobslist").'">更多职位>></a></div>';
	}
	exit($html);
}
elseif ($act=='ajax_save_basic')
{
	$setsqlarr['uid']=intval($_SESSION['uid']);
	$setsqlarr['telephone']=trim($_POST['mobile'])?trim($_POST['mobile']):exit('请填写手机号！');
	$go_verify=0;
	if($user['mobile_audit']==0){
		$verifycode=trim($_POST['verifycode']);
		if($verifycode){
			if (empty($_SESSION['mobile_rand']) || $verifycode<>$_SESSION['mobile_rand'])
			{
				exit("手机验证码错误");
			}
			else
			{
				$verifysqlarr['mobile'] = $setsqlarr['telephone'];
				$verifysqlarr['mobile_audit'] = 1;
				$go_verify=1;
				updatetable(table('members'),$verifysqlarr," uid='{$setsqlarr['uid']}'");
				unset($verifysqlarr);
			}
		}
		unset($_SESSION['verify_mobile'],$_SESSION['mobile_rand']);
	}
	$setsqlarr['title']=trim($_POST['title'])?utf8_to_gbk(trim($_POST['title'])):"未命名简历";
	check_word($_CFG['filter'],$setsqlarr['title'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['fullname']=trim($_POST['fullname'])?utf8_to_gbk(trim($_POST['fullname'])):exit('请填写姓名！');
	check_word($_CFG['filter'],$setsqlarr['fullname'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['display_name']=intval($_POST['display_name']);
	$setsqlarr['sex']=trim($_POST['sex'])?intval($_POST['sex']):exit('请选择性别！');
	$setsqlarr['sex_cn']=utf8_to_gbk(trim($_POST['sex_cn']));
	$setsqlarr['birthdate']=intval($_POST['birthdate'])>1945?intval($_POST['birthdate']):exit('请正确填写出生年份');
	$setsqlarr['residence']=trim($_POST['residence'])?utf8_to_gbk(trim($_POST['residence'])):exit('请选择现居住地！');
	$setsqlarr['residence_cn']=utf8_to_gbk(trim($_POST['residence_cn']));
	$setsqlarr['education']=intval($_POST['education'])?intval($_POST['education']):exit('请选择学历');
	$setsqlarr['education_cn']=utf8_to_gbk(trim($_POST['education_cn']));
	$setsqlarr['experience']=intval($_POST['experience'])?intval($_POST['experience']):exit('请选择工作经验');
	$setsqlarr['experience_cn']=utf8_to_gbk(trim($_POST['experience_cn']));
	$setsqlarr['email']=trim($_POST['email'])?utf8_to_gbk(trim($_POST['email'])):exit('请填写邮箱！');
	check_word($_CFG['filter'],$setsqlarr['email'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['email_notify']=$_POST['email_notify']=="1"?1:0;
	$setsqlarr['height']=intval($_POST['height']);
	$setsqlarr['householdaddress']=trim($_POST['householdaddress']);
	$setsqlarr['householdaddress_cn']=utf8_to_gbk(trim($_POST['householdaddress_cn']));	
	$setsqlarr['marriage']=intval($_POST['marriage']);
	$setsqlarr['marriage_cn']=utf8_to_gbk(trim($_POST['marriage_cn']));
	$setsqlarr['intention_jobs']=utf8_to_gbk(trim($_POST['intention_jobs']))?utf8_to_gbk(trim($_POST['intention_jobs'])):exit('请选择意向职位！');
	$setsqlarr['trade']=$_POST['trade']?trim($_POST['trade']):exit('请选择期望行业！');
	$setsqlarr['trade_cn']=utf8_to_gbk(trim($_POST['trade_cn']));
	$setsqlarr['district']=trim($_POST['district'])?intval($_POST['district']):exit('请选择期望工作地区！');
	$setsqlarr['sdistrict']=intval($_POST['sdistrict']);
	$setsqlarr['district_cn']=utf8_to_gbk(trim($_POST['district_cn']));
	$setsqlarr['nature']=intval($_POST['nature'])?intval($_POST['nature']):exit('请选择期望岗位性质！');
	$setsqlarr['nature_cn']=utf8_to_gbk(trim($_POST['nature_cn']));
	$setsqlarr['wage']=intval($_POST['wage'])?intval($_POST['wage']):exit('请选择期望薪资！');
	$setsqlarr['wage_cn']=utf8_to_gbk(trim($_POST['wage_cn']));
	$setsqlarr['refreshtime']=$timestamp;
	$_CFG['audit_edit_resume']!="-1"?$setsqlarr['audit']=intval($_CFG['audit_edit_resume']):"";
	updatetable(table('resume'),$setsqlarr," id='".intval($_REQUEST['pid'])."'  AND uid='{$setsqlarr['uid']}'");
	add_resume_jobs(intval($_REQUEST['pid']),$_SESSION['uid'],$_POST['intention_jobs_id'])?"":showmsg('保存失败！',0);
	add_resume_trade(intval($_REQUEST['pid']),$_SESSION['uid'],$_POST['trade'])?"":showmsg('保存失败！',0);
	check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
	if($_CFG['audit_edit_resume']!="-1"){
		set_resume_entrust(intval($_REQUEST['pid']));
	}
	write_memberslog($_SESSION['uid'],2,1105,$_SESSION['username'],"修改了简历({$setsqlarr['title']})");
	if($go_verify){
		$wheresql = " WHERE uid=".intval($_SESSION['uid']);
		$infoarr['phone']=$setsqlarr['telephone'];
		updatetable(table('members_info'),$infoarr,$wheresql);
		unset($infoarr);
		$infoarr['mobile']=$setsqlarr['telephone'];
		$infoarr['mobile_audit'] = 1;
		updatetable(table('members'),$infoarr,$wheresql);
	}
	exit("success");
}
//创建简历-第二步
elseif ($act=='make2')
{
	$uid=intval($_SESSION['uid']);
	$pid=intval($_REQUEST['pid']);
	$link[0]['text'] = "返回简历列表";
	$link[0]['href'] = '?act=resume_list';
	if ($uid==0 || $pid==0) showmsg('简历不存在！',1,$link);
	$resume_basic=get_resume_basic($uid,$pid);
	$link[0]['text'] = "填写简历基本信息";
	$link[0]['href'] = '?act=make1';
	if (empty($resume_basic)) showmsg("请先填写简历基本信息！",1,$link);
	$smarty->assign('resume_basic',$resume_basic);
	$smarty->assign('resume_education',get_resume_education($uid,$pid));
	$smarty->assign('resume_work',get_resume_work($uid,$pid));
	$smarty->assign('resume_training',get_resume_training($uid,$pid));
	$resume_jobs=get_resume_jobs($pid);
	if ($resume_jobs)
	{
		foreach($resume_jobs as $rjob)
		{
		$jobsid[]=$rjob['topclass'].".".$rjob['category'].".".$rjob['subclass'];
		}
		$resume_jobs_id=implode(",",$jobsid);
	}
	$smarty->assign('resume_jobs_id',$resume_jobs_id);
	$smarty->assign('act',$act);
	$smarty->assign('pid',$pid);
	$smarty->assign('title','我的简历 - 个人会员中心 - '.$_CFG['site_name']);
	$smarty->assign('go_resume_show',$_GET['go_resume_show']);
	
	$smarty->assign('subsite',get_subsite_list());
	$smarty->display('member_personal/personal_make_resume_step2.htm');
}
elseif ($act=='make2_photo_ready')
{	
	!$_FILES['photo']['name']?exit('请上传图片！'):"";
	require_once(QISHI_ROOT_PATH.'include/cut_upload.php');
	if (intval($_REQUEST['pid'])==0) exit('参数错误！');
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_REQUEST['pid']));
	if (empty($resume_basic['photo_img']))
	{
	$setsqlarr['photo_audit']=$_CFG['audit_resume_photo'];
	}
	else
	{
	$_CFG['audit_edit_photo']!="-1"?$setsqlarr['photo_audit']=intval($_CFG['audit_edit_photo']):"";
	}

	$up_res_original="../../data/photo/original/";
	$up_res_120="../../data/photo/120/";
	$up_res_thumb="../../data/photo/thumb/";
	make_dir($up_res_original.date("Y/m/d/"));
	make_dir($up_res_120.date("Y/m/d/"));
	make_dir($up_res_thumb.date("Y/m/d/"));
	$setsqlarr['photo_img']=_asUpFiles($up_res_original.date("Y/m/d/"),"photo",$_CFG['resume_photo_max'],'gif/jpg/bmp/png',true);
	$setsqlarr['photo_img']=date("Y/m/d/").$setsqlarr['photo_img'];
	if ($setsqlarr['photo_img'])
	{
		makethumb($up_res_original.$setsqlarr['photo_img'],$up_res_thumb.date("Y/m/d/"),280,350);
		!updatetable(table('resume'),$setsqlarr," id='".intval($_REQUEST['pid'])."' AND uid='".intval($_SESSION['uid'])."'")?exit("保存失败！"):'';
		exit($setsqlarr['photo_img']);
	} else {
		showmsg('保存失败！',1);
	}
}
elseif ($act=='make2_photo_save')
{	
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_REQUEST['pid']));
	if (empty($resume_basic)) showmsg("请先填写简历基本信息！",0);
	require_once(QISHI_ROOT_PATH.'include/cut_upload.php');
	require_once(QISHI_ROOT_PATH.'include/imageresize.class.php');
	$imgresize = new ImageResize();
	if($resume_basic['photo_img']){
		$up_res_original="../../data/photo/original/";
		$up_res_120="../../data/photo/120/";
		$up_res_thumb="../../data/photo/thumb/";
		$imgresize->load($up_res_thumb.$resume_basic['photo_img']);
		$imgresize->cut(intval($_POST['w']),intval($_POST['h']), intval($_POST['x']), intval($_POST['y']));
		$imgresize->save($up_res_thumb.$resume_basic['photo_img']);

		makethumb($up_res_thumb.$resume_basic['photo_img'],$up_res_120.date("Y/m/d/"),120,150);

		@unlink($up_res_original.$resume_basic['photo_img']);
		// @unlink($up_res_thumb.$resume_basic['photo_img']);

		check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
		showmsg("保存成功！",2);
	}else{
		showmsg("请上传图片！",1);
	}
}
elseif($act == "tag_save")
{
	if (intval($_POST['pid'])==0 ) showmsg('参数错误！',1);
	$setsqlarr['tag']=trim($_POST['tag']);
	$id=intval($_REQUEST['pid']);
	$tag=explode('|',$_POST['tag']);
	$tagindex=1;
	$tagsql['tag1']=$tagsql['tag2']=$tagsql['tag3']=$tagsql['tag4']=$tagsql['tag5']=0;
	if (!empty($tag) && is_array($tag))
	{
			foreach($tag as $v)
			{
				$vid=explode(',',$v);
				$tagsql['tag'.$tagindex]=intval($vid[0]);
				$tagindex++;
			}
			
	}
	$tagsql['id']=$id;
	$tagsql['uid']=$_SESSION['uid'];
	$setsqlarr['specialty']=!empty($_POST['specialty'])?$_POST['specialty']:showmsg('请填写自我描述！',1);
	check_word($_CFG['filter'],$_POST['specialty'])?showmsg($_CFG['filter_tips'],0):'';
	$_CFG['audit_edit_resume']!="-1"?$setsqlarr['audit']=intval($_CFG['audit_edit_resume']):"";
	updatetable(table('resume'),$setsqlarr," id='".intval($_POST['pid'])."' AND uid='".intval($_SESSION['uid'])."'");
	$info=$db->getone("select * from ".table('resume_search_tag')." where id='{$id}'  AND uid='".intval($_SESSION['uid'])."' LIMIT 1 ");
	if(empty($info)) {
		inserttable(table('resume_search_tag'),$tagsql);
	} else {
		updatetable(table('resume_search_tag'),$tagsql," id='{$id}' AND uid='".intval($_SESSION['uid'])."' ");
	}
	check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
	showmsg("保存成功！",2);
	// header('Location: ?act=edit_resume&pid='.$_REQUEST['pid']);
}
elseif($act == "set_entrust"){
	if (intval($_GET['pid'])==0 ) showmsg('参数错误！',1);
	updatetable(table('resume'),array("entrust"=>1)," id='".intval($_GET['pid'])."' AND uid='".intval($_SESSION['uid'])."'");
	set_resume_entrust(intval($_GET['pid']));
	showmsg("委托成功,系统将会在三天内为您自动投递合适的职位！",2);
}
elseif($act=="set_entrust_del")
{
	if (intval($_GET['pid'])==0 ) showmsg('参数错误！',1);
	updatetable(table('resume'),array("entrust"=>0)," id='".intval($_GET['pid'])."' AND uid='".intval($_SESSION['uid'])."'");
	$db->query("delete from ".table("resume_entrust")." where id=".intval($_GET['pid'])."");
	showmsg("取消委托成功！",2);
}
elseif($act=='save_education'){
	$id=intval($_POST['id']);
	$setsqlarr['uid'] = intval($_SESSION['uid']);
	$setsqlarr['pid'] = intval($_REQUEST['pid']);
	
	if ($setsqlarr['uid']==0 || $setsqlarr['pid']==0 ) exit('简历不存在！');
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_REQUEST['pid']));
	if (empty($resume_basic)) exit("请先填写简历基本信息！");
	$resume_education=get_resume_education($_SESSION['uid'],$_REQUEST['pid']);
	if (count($resume_education)>=6) exit('教育经历不能超过6条！');
	if(intval(($_POST['edu_start_year']))>intval($_POST['edu_end_year'])){
			exit('就读开始时间不允许大于毕业时间');
	}
	if(intval($_POST['edu_start_year']) == intval($_POST['edu_end_year']) && intval(($_POST['edu_start_month']))>=intval($_POST['edu_end_month'])){
		exit('就读开始月份不允许大于毕业时间');
	}
	
	$school = utf8_to_gbk(trim($_POST['school']));
	$speciality = utf8_to_gbk(trim($_POST['speciality']));
	$education_cn = utf8_to_gbk(trim($_POST['education_cn']));
	$setsqlarr['school'] = $school?$school:exit("请填写学校名称！");
	check_word($_CFG['filter'],$setsqlarr['school'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['speciality'] = $speciality?$speciality:exit("请填写专业名称！");
	check_word($_CFG['filter'],$setsqlarr['speciality'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['education'] = intval($_POST['education'])?intval($_POST['education']):exit("请选择获得学历！");
	$setsqlarr['education_cn'] = $education_cn?$education_cn:exit("请选择获得学历！");
	if(trim($_POST['edu_start_year'])==""||trim($_POST['edu_start_month'])==""||trim($_POST['edu_end_year'])==""||trim($_POST['edu_end_month'])==""){
		exit("请选择就读时间！");
	}
	$setsqlarr['startyear'] = intval($_POST['edu_start_year']);
	$setsqlarr['startmonth'] = intval($_POST['edu_start_month']);
	$setsqlarr['endyear'] = intval($_POST['edu_end_year']);
	$setsqlarr['endmonth'] = intval($_POST['edu_end_month']);
	if($id){
		updatetable(table("resume_education"),$setsqlarr,array("id"=>$id));
		exit("success");
	}else{
		$insert_id = inserttable(table("resume_education"),$setsqlarr,1);
		if($insert_id){
			check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
			exit("success");
		}else{
			exit("err");
		}
	}
	
}
elseif($act=='ajax_get_education_list'){
	$pid=intval($_GET['pid']);
	$uid=intval($_SESSION['uid']);
	$education_list = get_resume_education($uid,$pid);
	$html="";
	if($education_list){
		foreach ($education_list as $key => $value) {
			$html.='<div class="jl1">
				 	 <div class="l1">'.$value["startyear"].'年'.$value["startmonth"].'月-'.$value["endyear"].'年'.$value["endmonth"].'月</div>
					 <div class="l2">'.$value["school"].'</div>
					 <div class="l3">'.$value["speciality"].'</div>
					 <div class="l4">'.$value["education_cn"].'</div>
					 <div class="l5">
					 <a class="edit_education" href="javascript:void(0);" url="?act=edit_education&id='.$value["id"].'&pid='.$pid.'"></a>
					 <a class="del_education d" href="javascript:void(0);" pid="'.$pid.'" edu_id="'.$value["id"].'" ></a><div class="clear"></div>
					 </div>
					 <div class="clear"></div>
				</div>';
		}
		//-----fffff添加教育经历-
		$html.='<div style="width:118px; margin:0px auto;"><input type="button" name="" id="empty_add_education" value="添加经历"  class="but130lan_add"/></div>';
		//----fffff
	}else{
		$js='<script type="text/javascript">$("#add_education").hide();$(function(){$(".but130lan_add").hover(function(){$(this).addClass("hover")},function(){$(this).removeClass("hover");})})</script>';
		$html.='<div class="noinfo" id="education_empty_box">
		 	 <div class="txt">教育经历最能体现您的学历和专业能力，快来完成它吸引企业和HR青睐吧！</div>
			 <div class="addbut">
			 	<input type="button" name="" id="empty_add_education" value="添加经历"  class="but130lan_add"/>
			 </div>
		</div>';
		$html.=$js;
	}
	
	exit($html);
}
//创建简历-修改教育经历
elseif ($act=='edit_education')
{
	$uid=intval($_SESSION['uid']);
	$pid=intval($_REQUEST['pid']);
	if ($uid==0 || $pid==0) exit('简历不存在！');
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_REQUEST['pid']));
	if (empty($resume_basic)) exit("请先填写简历基本信息！");
	$id=intval($_GET['id'])?intval($_GET['id']):exit('参数错误！');
	$education_edit = get_resume_education_one($_SESSION['uid'],$pid,$id);
	foreach ($education_edit as $key => $value) {
		$education_edit[$key] = gbk_to_utf8($value);
	}
	$json_encode = json_encode($education_edit);
	exit($json_encode);
}
//创建简历-删除教育经历
elseif ($act=='del_education')
{
	$id=intval($_GET['id']);
	$sql="Delete from ".table('resume_education')." WHERE id='{$id}'  AND uid='".intval($_SESSION['uid'])."' AND pid='".intval($_REQUEST['pid'])."' LIMIT 1 ";
	if ($db->query($sql))
	{
	check_resume($_SESSION['uid'],intval($_REQUEST['pid']));//更新简历完成状态
	exit('删除成功！');
	}
	else
	{
	exit('删除失败！');
	}	
}
elseif($act=='save_work'){
	$id=intval($_POST['id']);
	$setsqlarr['uid'] = intval($_SESSION['uid']);
	$setsqlarr['pid'] = intval($_REQUEST['pid']);
	if ($setsqlarr['uid']==0 || $setsqlarr['pid']==0 ) exit('简历不存在！');
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_REQUEST['pid']));
	if (empty($resume_basic)) exit("请先填写简历基本信息！");
	$resume_work=get_resume_work($_SESSION['uid'],$_REQUEST['pid']);
	if (count($resume_work)>=6) exit('工作经历不能超过6条！');
	
	
	if(intval(($_POST['work_start_year']))>intval($_POST['work_end_year'])){
			exit('工作开始时间不允许大于工作结束时间');
	}
	if(intval($_POST['work_start_year']) == intval($_POST['work_end_year']) && intval(($_POST['work_start_month']))>=intval($_POST['work_end_month'])){
			exit('工作开始月份不允许大于工作结束时间');
	}
	
	$companyname = utf8_to_gbk(trim($_POST['companyname']));
	$jobs = utf8_to_gbk(trim($_POST['jobs']));
	$achievements = utf8_to_gbk(trim($_POST['achievements']));
	$setsqlarr['companyname'] = $companyname?$companyname:exit("请填写公司名称！");
	check_word($_CFG['filter'],$setsqlarr['companyname'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['jobs'] = $jobs?$jobs:exit("请填写职位名称！");
	check_word($_CFG['filter'],$setsqlarr['jobs'])?exit($_CFG['filter_tips']):'';
	if(trim($_POST['work_start_year'])==""||trim($_POST['work_start_month'])==""||trim($_POST['work_end_year'])==""||trim($_POST['work_end_month'])==""){
		exit("请选择任职时间！");
	}
	$setsqlarr['startyear'] = intval($_POST['work_start_year']);
	$setsqlarr['startmonth'] = intval($_POST['work_start_month']);
	$setsqlarr['endyear'] = intval($_POST['work_end_year']);
	$setsqlarr['endmonth'] = intval($_POST['work_end_month']);
	$setsqlarr['achievements'] = $achievements?$achievements:exit("请填写工作职责！");
	check_word($_CFG['filter'],$setsqlarr['achievements'])?exit($_CFG['filter_tips']):'';
	
	if($id){
		updatetable(table("resume_work"),$setsqlarr,array("id"=>$id));
		exit("success");
	}else{
		$insert_id = inserttable(table("resume_work"),$setsqlarr,1);
		if($insert_id){
			check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
			exit("success");
		}else{
			exit("err");
		}
	}
	
}
elseif($act=='ajax_get_work_list'){
	$pid=intval($_GET['pid']);
	$uid=intval($_SESSION['uid']);
	$work_list = get_resume_work($uid,$pid);
	$html="";
	if($work_list){
		foreach ($work_list as $key => $value) {
			$html.='<div class="jl2">
					 	 <div class="l1">'.$value["startyear"].'年'.$value["startmonth"].'月-'.$value["endyear"].'年'.$value["endmonth"].'月</div>
						 <div class="l2">'.$value["companyname"].'</div>
						 <div class="l3">'.$value["jobs"].'</div>
						 <div class="l4">
						 <a class="edit_work" href="javascript:void(0);" url="?act=edit_work&id='.$value["id"].'&pid='.$pid.'"></a>
						 <a class="del_work d" href="javascript:void(0);" pid="'.$pid.'" work_id="'.$value["id"].'" ></a><div class="clear"></div>
						 <div class="clear"></div>
						 </div>
						 <div class="l5">工作职责：</div>
						 <div class="l6">'.$value["achievements"].'
						 </div>
						 <div class="clear"></div>
					</div>';
		}
		//-----fffff添加工作经历-
		$html.='<div style="width:118px; margin:0px auto;"><input type="button" name="" id="empty_add_work" value="添加经历"  class="but130lan_add"/></div>';
		//----fffff
	}else{
		$js='<script type="text/javascript">$("#add_work").hide();$(function(){$(".but130lan_add").hover(function(){$(this).addClass("hover")},function(){$(this).removeClass("hover");})})</script>';
		$html.='<div class="noinfo" id="work_empty_box">	
			 	 <div class="txt">工作经历最能体现您丰富的阅历和出众的工作能力，是你薪酬翻倍的筹码哦HR青睐吧！</div>
				 <div class="addbut">
				 	<input type="button" name="" id="empty_add_work" value="添加经历"  class="but130lan_add"/>
				 </div>
			</div>';
		$html.=$js;
	}
	
	exit($html);
}
//创建简历-修改工作经历
elseif ($act=='edit_work')
{
	$uid=intval($_SESSION['uid']);
	$pid=intval($_REQUEST['pid']);
	if ($uid==0 || $pid==0) exit('简历不存在！');
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_REQUEST['pid']));
	if (empty($resume_basic)) exit("请先填写简历基本信息！");
	$id=intval($_GET['id'])?intval($_GET['id']):exit('参数错误！');
	$work_edit = get_resume_work_one($_SESSION['uid'],$pid,$id);
	foreach ($work_edit as $key => $value) {
		$work_edit[$key] = gbk_to_utf8($value);
	}
	$json_encode = json_encode($work_edit);
	exit($json_encode);
}
//创建简历-删除工作经历
elseif ($act=='del_work')
{
	$id=intval($_GET['id']);
	$sql="Delete from ".table('resume_work')." WHERE id='{$id}'  AND uid='".intval($_SESSION['uid'])."' AND pid='".intval($_REQUEST['pid'])."' LIMIT 1 ";
	if ($db->query($sql))
	{
	check_resume($_SESSION['uid'],intval($_REQUEST['pid']));//更新简历完成状态
	exit('删除成功！');
	}
	else
	{
	exit('删除失败！');
	}	
}
elseif($act=='save_training'){
	$id=intval($_POST['id']);
	$setsqlarr['uid'] = intval($_SESSION['uid']);
	$setsqlarr['pid'] = intval($_REQUEST['pid']);
	if ($setsqlarr['uid']==0 || $setsqlarr['pid']==0 ) exit('简历不存在！');
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_REQUEST['pid']));
	if (empty($resume_basic)) exit("请先填写简历基本信息！");
	$resume_work=get_resume_work($_SESSION['uid'],$_REQUEST['pid']);
	if (count($resume_work)>=6) exit('培训经历不能超过6条！');
	
	
	
	if(intval(($_POST['training_start_year']))>intval($_POST['training_end_year'])){
			exit('培训开始时间不允许大于培训结束时间');
	}
	if(intval($_POST['training_start_year']) == intval($_POST['training_end_year']) && intval(($_POST['training_start_month']))>=intval($_POST['training_end_month'])){
			exit('培训开始月份不允许大于培训结束时间');
	}
	
	
	
	$agency = utf8_to_gbk(trim($_POST['agency']));
	$course = utf8_to_gbk(trim($_POST['course']));
	$description = utf8_to_gbk(trim($_POST['description']));
	$setsqlarr['agency'] = $agency?$agency:exit("请填写培训机构！");
	check_word($_CFG['filter'],$setsqlarr['agency'])?exit($_CFG['filter_tips']):'';
	$setsqlarr['course'] = $course?$course:exit("请填写培训课程！");
	check_word($_CFG['filter'],$setsqlarr['course'])?exit($_CFG['filter_tips']):'';
	if(trim($_POST['training_start_year'])==""||trim($_POST['training_start_month'])==""||trim($_POST['training_end_year'])==""||trim($_POST['training_end_month'])==""){
		exit("请选择培训时间！");
	}
	$setsqlarr['startyear'] = intval($_POST['training_start_year']);
	$setsqlarr['startmonth'] = intval($_POST['training_start_month']);
	$setsqlarr['endyear'] = intval($_POST['training_end_year']);
	$setsqlarr['endmonth'] = intval($_POST['training_end_month']);
	$setsqlarr['description'] = $description?$description:exit("请填写培训内容！");
	check_word($_CFG['filter'],$setsqlarr['description'])?exit($_CFG['filter_tips']):'';
	
	if($id){
		updatetable(table("resume_training"),$setsqlarr,array("id"=>$id));
		exit("success");
	}else{
		$insert_id = inserttable(table("resume_training"),$setsqlarr,1);
		if($insert_id){
			check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
			exit("success");
		}else{
			exit("err");
		}
	}
	
}
elseif($act=='ajax_get_training_list'){
	$pid=intval($_GET['pid']);
	$uid=intval($_SESSION['uid']);
	$training_list = get_resume_training($uid,$pid);
	$html="";
	if($training_list){
		foreach ($training_list as $key => $value) {
			$html.='<div class="jl2">
			 	 <div class="l1">'.$value["startyear"].'年'.$value["startmonth"].'月-'.$value["endyear"].'年'.$value["endmonth"].'月</div>
				 <div class="l2">'.$value["agency"].'</div>
				 <div class="l3">'.$value["course"].'</div>
				 <div class="l4">
				 <a class="edit_training" href="javascript:void(0);" url="?act=edit_training&id='.$value["id"].'&pid='.$pid.'"></a>
				 <a class="del_training d" href="javascript:void(0);" pid="'.$pid.'" training_id="'.$value["id"].'" ></a><div class="clear"></div>
				 </div>
				 <div class="l5">培训内容：</div>
				 <div class="l6">'.$value["description"].'</div>
				 <div class="clear"></div>
			</div>';
		}
		//-----fffff添加培训经历-
		$html.='<div style="width:118px; margin:0px auto;"><input type="button" name="" id="empty_add_training" value="添加经历"  class="but130lan_add"/></div>';
		//----fffff
	}else{
		$js='<script type="text/javascript">$("#add_training").hide();$(function(){$(".but130lan_add").hover(function(){$(this).addClass("hover")},function(){$(this).removeClass("hover");})})</script>';
		$html.='<div class="noinfo" id="training_empty_box">	
		 	 <div class="txt">培训经历是你用于上进的最好的体现，快来说说令您难忘的学习经历吧！</div>
			 <div class="addbut">
			 	<input type="button" name="" id="empty_add_training" value="添加经历"  class="but130lan_add"/>
			 </div>
		</div>';
		$html.=$js;
	}
	exit($html);
}
//创建简历-修改培训经历
elseif ($act=='edit_training')
{
	$uid=intval($_SESSION['uid']);
	$pid=intval($_REQUEST['pid']);
	if ($uid==0 || $pid==0) exit('简历不存在！');
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_REQUEST['pid']));
	if (empty($resume_basic)) exit("请先填写简历基本信息！");
	$id=intval($_GET['id'])?intval($_GET['id']):exit('参数错误！');
	$training_edit = get_resume_training_one($_SESSION['uid'],$pid,$id);
	foreach ($training_edit as $key => $value) {
		$training_edit[$key] = gbk_to_utf8($value);
	}
	$json_encode = json_encode($training_edit);
	exit($json_encode);
}
//创建简历-删除培训经历
elseif ($act=='del_training')
{
	$id=intval($_GET['id']);
	$sql="Delete from ".table('resume_training')." WHERE id='{$id}'  AND uid='".intval($_SESSION['uid'])."' AND pid='".intval($_REQUEST['pid'])."' LIMIT 1 ";
	if ($db->query($sql))
	{
	check_resume($_SESSION['uid'],intval($_REQUEST['pid']));//更新简历完成状态
	exit('删除成功！');
	}
	else
	{
	exit('删除失败！');
	}	
}
elseif ($act=='edit_resume')
{
	$uid=intval($_SESSION['uid']);
	$pid=intval($_REQUEST['pid']);
	$_SESSION['send_mobile_key']=mt_rand(100000, 999999);
	$smarty->assign('send_key',$_SESSION['send_mobile_key']);
	$smarty->assign('resume_basic',get_resume_basic($uid,$pid));
	$smarty->assign('resume_education',get_resume_education($uid,$pid));
	$smarty->assign('resume_work',get_resume_work($uid,$pid));
	$smarty->assign('resume_training',get_resume_training($uid,$pid));
	$resume_jobs=get_resume_jobs($pid);
	if ($resume_jobs)
	{
		foreach($resume_jobs as $rjob)
		{
		$jobsid[]=$rjob['topclass'].".".$rjob['category'].".".$rjob['subclass'];
		}
		$resume_jobs_id=implode(",",$jobsid);
	}
	$smarty->assign('resume_jobs_id',$resume_jobs_id);
	$smarty->assign('act',$act);
	$smarty->assign('pid',$pid);
	$smarty->assign('user',$user);
	$smarty->assign('title','我的简历 - 个人会员中心 - '.$_CFG['site_name']);
	$captcha=get_cache('captcha');
	$smarty->assign('verify_resume',$captcha['verify_resume']);
	$smarty->assign('go_resume_show',$_GET['go_resume_show']);
	$smarty->display('member_personal/personal_resume_edit.htm');
}
elseif ($act=='save_resume_privacy')
{
	$uid=intval($_SESSION['uid']);
	$pid=intval($_REQUEST['pid']);
	$setsqlarr['display']=intval($_POST['display']);
	$setsqlarr['display_name']=intval($_POST['display_name']);
	$setsqlarr['photo_display']=intval($_POST['photo_display']);
	$wheresql=" uid='".$_SESSION['uid']."' ";
	!updatetable(table('resume'),$setsqlarr," uid='{$uid}' AND  id='{$pid}'");
	$setsqlarrdisplay['display']=intval($_POST['display']);
	!updatetable(table('resume_search_key'),$setsqlarrdisplay," uid='{$uid}' AND  id='{$pid}'");
	!updatetable(table('resume_search_rtime'),$setsqlarrdisplay," uid='{$uid}' AND  id='{$pid}'");
	!updatetable(table('resume_search_tag'),$setsqlarrdisplay," uid='{$uid}' AND  id='{$pid}'");
	write_memberslog($_SESSION['uid'],2,1104,$_SESSION['username'],"设置简历隐私({$pid})");
}
elseif ($act=='talent_save')
{
	$uid=intval($_SESSION['uid']);
	$pid=intval($_REQUEST['pid']);
	$resume=get_resume_basic($uid,$pid);
	if ($resume['complete_percent']<$_CFG['elite_resume_complete_percent'])
	{
	showmsg("简历完整指数小于{$_CFG['elite_resume_complete_percent']}%，禁止申请！",0);
	}
	$setsqlarr['talent']=3;
	$wheresql=" uid='{$uid}' AND id='{$pid}' ";
	updatetable(table('resume'),$setsqlarr,$wheresql);
	write_memberslog($uid,2,1107,$_SESSION['username'],"申请高级人才");
	showmsg('申请成功，请等待管理员审核！',2);
}
unset($smarty);
?>