<?php
/*
 * 74cms 企业会员中心
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/gifts_common.php');
$smarty->assign('leftmenu',"service");
if ($act=='gifts')
{	
	$smarty->assign('title','职业测试 - 个人会员中心 - '.$_CFG['site_name']);
	$smarty->assign('gifts',get_gifts($_SESSION['uid']));
	$captcha=get_cache('captcha');
	$smarty->assign('verify_gifts',$captcha['verify_gifts']);
	$smarty->display('member_personal/personal_gifts.htm');
}
//-----ffffff------开始-------
elseif($act == 'get_gifts'){
	//echo "获取账号";exit;
	$wheresql=" WHERE uid='".$_SESSION['uid']."' ";
	$sql="SELECT * FROM ".table('resume').$wheresql;
	$resume=get_resume_list($sql,12,true,true,true);
	if($resume){//---有简历
		foreach($resume as $key=>$val){
			//echo $val['complete_percent'];exit;
			if(intval($val['complete_percent']) < 40){///---达到40%以上
				
				showmsg("你填写的简历还不够完善！请添加工作经验等相关信息",1,$link);
			}else{
				//echo "符合条件！随机抽取一条记录";exit;
				if(intval($_CFG['subsite_id'])!="0")
				{
					$tid=$_CFG['subsite_id']?intval($_CFG['subsite_id']):1;
				}else{
					$tid=1;
				}
				//--------判断是否获取----每人只有一次
				$gifts_sql="select id from ".table("members_gifts")." where  uid=".$_SESSION['uid'];
				$gifts=$db->getone($gifts_sql);
				if(!$gifts){
					//echo "没有获取";exit;
					//$gifts_g="";
					//echo "select * from ".table("gifts")." where be=0 and t_id=".$tid." order by rand() limit 1";exit;
					$getgifts=$db->getone("select * from ".table("gifts")." where be=0 and t_id=".$tid." order by rand() limit 1");
					//echo "<pre>";print_r($getgifts);exit;
					if($getgifts){
						$setsqlarr['uid']=$_SESSION['uid'];
						$setsqlarr['account']=$getgifts['account'];
						$setsqlarr['giftsname']='职业测评';
						$setsqlarr['giftstid']=$getgifts['t_id'];
						//--剩余的数量
						//$total_sql="select COUNT(*) from ".table("gifts")." where be=0 and t_id=".$tid." order by rand() limit 1";
						//$total_val=$db->get_total($total_sql);
						//$setsqlarr['giftsamount']=$total_val;
						//--
						$res=inserttable(table('members_gifts'),$setsqlarr,true);
						//--是否被领取
						//echo $res;exit;
						$upsql['be']=1;
						$upsql['useuid']=$_SESSION['uid'];
						$res_be=updatetable(table('gifts'),$upsql,$getgifts);
						//print_r($res_be);exit;
						//--
						if($res){
							showmsg("获取成功",3,$link);
						}else{
						showmsg("获取失败",0,$link);	
						}
					}else{
						showmsg("测评帐号已经被抽取完了！",0,$link);
					}
				}else{///-------已经获取
					showmsg("您已经获取了账号，不能再次获取！",1,$link);	
				}
				echo $_CFG['subsite_id'];exit;
				
			}
		}
		
	}else{//----没有简历
		$link[0]['text'] = "填写简历基本信息";
		$link[0]['href'] = 'personal_resume.php?act=make1';
		showmsg("你还没有填写简历，还不能获取账号！",1,$link);
	}
	//echo $resume[0]['complete_percent'];echo "<pre>";print_r($resume);exit;
}
elseif($act =='ceping'){
	//echo "测评";exit;
	if ($_SESSION['uid']=='' || $_SESSION['username']=='')//-----判断是否登录
	{
		$captcha=get_cache('captcha');
		$smarty->assign('verify_userlogin',$captcha['verify_userlogin']);
		$smarty->display('plus/ajax_login.htm');
		exit();
	}
	///-0--成功之后修改使用时间----gifts表
	$get_gifts=" useuid=".$_SESSION['uid'];
	$up['usettime']=time();
	$res_uptime=updatetable(table('gifts'),$up,$get_gifts);
	//-----更新members_gifts表
	$members_gifts=" uid=".$_SESSION['uid'];
	$up_members['usetime']=time();
	$res_members=updatetable(table('members_gifts'),$up_members,$members_gifts);
	echo $res_members."<br>";echo $res_uptime;exit;
	//$smarty->display('member_personal/peixun.htm');
	
	
}
elseif($act =='ck_cep'){
	$smarty->display('member_personal/jobs_guide.htm');
}
//----------fffff---------结束
elseif ($act=='gifts_apy')
{
	$account=trim($_POST['account'])?trim($_POST['account']):showmsg("请填写卡号！",1);
	$pwd=trim($_POST['pwd'])?trim($_POST['pwd']):showmsg("请填写密码！",1);
	$captcha=get_cache('captcha');
	$postcaptcha = trim($_POST['postcaptcha']);
	if($captcha['verify_gifts']=='1' && empty($postcaptcha))
	{
		showmsg("请填写验证码",1);
 	}
	if ($captcha['verify_gifts']=='1' &&  strcasecmp($_SESSION['imageCaptcha_content'],$postcaptcha)!=0)
	{
		showmsg("验证码错误",1);
	}
	$info=$db->getone("select * from ".table('gifts')." where account='{$account}'  AND password='{$pwd}' LIMIT 1 ");
	if (empty($info))
	{
		showmsg("卡号或密码错误",0);
	}
	else
	{
		if ($info['usettime']>0)
		{
		showmsg("此张卡已被使用，不能重复使用",1);
		}
		else
		{
			$gifts_type=$db->getone("select * from ".table('gifts_type')." where t_id='{$info['t_id']}' LIMIT 1 ");
			if($gifts_type['t_endtime']!=0&&$gifts_type['t_endtime']<strtotime(date("Y-m-d"))){
				showmsg("此张卡已超过有效期，不能使用",1);
			}
			if($gifts_type['t_effective']==0){
				showmsg("此张卡已被管理员设置为不可用，请联系网站管理员",1);
			}
			if ($gifts_type['t_repeat']>0)
			{
				$total=$db->get_total("SELECT COUNT(*) AS num FROM ".table('members_gifts')." where uid='{$_SESSION['uid']}'");
				if ($total>=$gifts_type['t_repeat'])
				{
				showmsg("{$gifts_type['t_name']} 每个会员仅可以使用 {$gifts_type['t_repeat']} 次。",1);
				}
			}
			$db->query( "UPDATE ".table('gifts')." SET usettime = '".time()."',useuid= '{$_SESSION['uid']}'  where account='{$account}'");
			$setsqlarr['uid']=$_SESSION['uid'];
			$setsqlarr['usetime']=time();
			$setsqlarr['account']=$account;
			$setsqlarr['giftsname']=$gifts_type['t_name'];
			$setsqlarr['giftsamount']=$gifts_type['t_amount'];
			$setsqlarr['giftstid']=$gifts_type['t_id'];
			inserttable(table('members_gifts'),$setsqlarr);
			report_deal($_SESSION['uid'],1,$setsqlarr['giftsamount']);
			$user_points=get_user_points($_SESSION['uid']);
			$operator="+";
			write_memberslog($_SESSION['uid'],1,9001,$_SESSION['username'],"使用礼品卡({$account})充值({$operator}{$setsqlarr['giftsamount']})，(剩余:{$user_points})",1,1021,"礼品卡充值","{$operator}{$setsqlarr['giftsamount']}","{$user_points}");
			showmsg("充值成功！",2);	
					
		}
	}
}
elseif ($act=='feedback_save')
{
	$get_feedback=get_feedback($_SESSION['uid']);
	if (count($get_feedback)>=5) 
	{
	showmsg('反馈信息不能超过5条！',1);
	exit();
	}
	$setsqlarr['infotype']=intval($_POST['infotype']);
	$setsqlarr['feedback']=trim($_POST['feedback'])?trim($_POST['feedback']):showmsg("请填写内容！",1);
	$setsqlarr['uid']=$_SESSION['uid'];
	$setsqlarr['usertype']=$_SESSION['utype'];
	$setsqlarr['username']=$_SESSION['username'];
	$setsqlarr['addtime']=$timestamp;
	write_memberslog($_SESSION['uid'],1,7001,$_SESSION['username'],"添加了反馈信息");
	!inserttable(table('feedback'),$setsqlarr)?showmsg("添加失败！",0):showmsg("添加成功，请等待管理员回复！",2);
}
elseif ($act=='del_feedback')
{
	$id=intval($_GET['id']);
	del_feedback($id,$_SESSION['uid'])?showmsg('删除成功！',2):showmsg('删除失败！',1);
}

unset($smarty);
?>