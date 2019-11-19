<?php
 /*
 * 74cms 会员中心函数
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
 if(!defined('IN_QISHI'))
 {
 	die('Access Denied!');
 }
//注册会员
function user_register($username,$password,$member_type=0,$email,$uc_reg=true,$xs_user='',$district_cn='',$district='',$sdistrict='',$sex='',$sex_cn='',$realname='',$birthday='',$residence='',$residence_cn='',$companyname,$trainname)
{
	
	global $db,$timestamp,$_CFG,$online_ip,$QS_pwdhash;
	$member_type=intval($member_type);
	$ck_username=get_user_inusername($username);
	$ck_email=get_user_inemail($email);
	if ($member_type==0) 
	{
	return -1;
	}
	elseif (!empty($ck_username))
	{
	return -2;
	}
	elseif (!empty($ck_email) && $member_type==1)//--企业会员
	{
	return -3;
	}
	$pwd_hash=randstr();
	//$password_hash=md5(md5($password).$pwd_hash.$QS_pwdhash);
	$password_hash=md5($password);
	if($member_type=="1"){//----企业会员注册
	$setsqlarr['username']=$username;
	$setsqlarr['password']=$password_hash;
	$setsqlarr['pwd_hash']=$pwd_hash;
	$setsqlarr['email']=$email;
	$setsqlarr['utype']=intval($member_type);
	$setsqlarr['reg_time']=$timestamp;
	$setsqlarr['reg_ip']=$online_ip;
	//-----销售经理xs_user
	$setsqlarr['xs_user']=$xs_user;	
	$insert_id=inserttable(table('members'),$setsqlarr,true);
	//------------结束--------------------------------
	//---会员uid
	$setsqlarr_1['uid']=$insert_id;
	$setsqlarr_1['companyname']=$companyname;
	//-----地区district_cn
	$setsqlarr_1['district_cn']=$district_cn;
	$setsqlarr_1['district']=$district;
	$setsqlarr_1['sdistrict']=$sdistrict;
	$c=inserttable(table('company_profile'),$setsqlarr_1,true);}
	
	elseif($member_type=="2"){//----个人会员注册
	$setsqlarr['username']=$username;
	$setsqlarr['password']=$password_hash;
	$setsqlarr['pwd_hash']=$pwd_hash;
	$setsqlarr['utype']=intval($member_type);
	$setsqlarr['reg_time']=$timestamp;
	$setsqlarr['reg_ip']=$online_ip;
	$setsqlarr['mobile']=$username;
	$insert_id=inserttable(table('members'),$setsqlarr,true);
	//----结束
	$setsqlarr_2['uid']=$insert_id;
	$setsqlarr_2['sex']=$sex;
	$setsqlarr_2['sex_cn']=$sex_cn;
	$setsqlarr_2['realname']=$realname;
	$setsqlarr_2['birthday']=$birthday;
	$setsqlarr_2['residence']=$residence;
	$setsqlarr_2['residence_cn']=$residence_cn;
	$setsqlarr_2['phone']=$username;
	$p=inserttable(table('members_info'),$setsqlarr_2,true);}
	

	//------fffff
	if($member_type=="4"){//----培训会员注册
	$setsqlarr['username']=$username;
	$setsqlarr['password']=$password_hash;
	$setsqlarr['pwd_hash']=$pwd_hash;
	$setsqlarr['email']=$email;
	$setsqlarr['utype']=intval($member_type);
	$setsqlarr['reg_time']=$timestamp;
	$setsqlarr['reg_ip']=$online_ip;

	$insert_id=inserttable(table('members'),$setsqlarr,true);
	//------------结束--------------------------------
	//---会员uid
	$setsqlarr_1['uid']=$insert_id;
	$setsqlarr_1['trainname']=$trainname;
	//-----地区district_cn
	$setsqlarr_1['district_cn']=$district_cn;
	$setsqlarr_1['district']=$district;
	$setsqlarr_1['sdistrict']=$sdistrict;
	
	$setsqlarr_1['addtime']=time();
	$setsqlarr_1['refreshtime']=time();
	//echo "<pre>";print_r($setsqlarr_1);exit;
	$t=inserttable(table('train_profile'),$setsqlarr_1,true);}
	//------fffff
	
	//----
			if($member_type=="1")
			{
				if(!$db->query("INSERT INTO ".table('members_points')." (uid) VALUES ('{$insert_id}')"))  return false;
				if(!$db->query("INSERT INTO ".table('members_setmeal')." (uid) VALUES ('{$insert_id}')")) return false;
					
					$points=get_cache('points_rule');
					include_once(QISHI_ROOT_PATH.'include/fun_company.php');
					set_consultant($insert_id);
					if ($points['reg_points']['value']>0)
					{
						report_deal($insert_id,$points['reg_points']['type'],$points['reg_points']['value']);
						$operator=$points['reg_points']['type']=="1"?"+":"-";
						write_memberslog($insert_id,1,9001,$username,"新注册会员,({$operator}{$points['reg_points']['value']}),(剩余:{$points['reg_points']['value']})",1,1010,"注册会员系统自动赠送积分","{$operator}{$points['reg_points']['value']}","{$points['reg_points']['value']}");
						//积分变更记录
						write_setmeallog($insert_id,$username,"注册会员系统自动赠送：({$operator}{$points['reg_points']['value']}),(剩余:{$points['reg_points']['value']})",1,'0.00','1',1,1);
					
					}
					if ($_CFG['reg_service']>0){
						set_members_setmeal($insert_id,$_CFG['reg_service']);
						$setmeal=get_setmeal_one($_CFG['reg_service']);
						write_memberslog($insert_id,1,9002,$username,"注册会员系统自动赠送：{$setmeal['setmeal_name']}",2,1011,"开通服务(系统赠送)","-","-");
						//套餐变更记录
						write_setmeallog($insert_id,$username,"注册会员系统自动赠送：{$setmeal['setmeal_name']}",1,'0.00','1',2,1);
					}
			}
			elseif($member_type =='2'){//---个人会员
			//--fff从gbk转到utf-8
			$realname=iconv(QISHI_DBCHARSET,'utf-8//IGNORE',$realname);
			$username=iconv(QISHI_DBCHARSET,'utf-8//IGNORE',$username);
			$birthday=iconv(QISHI_DBCHARSET,'utf-8//IGNORE',$birthday);
			$residence_cn=iconv(QISHI_DBCHARSET,'utf-8//IGNORE',$residence_cn);
			$sex_cn=iconv(QISHI_DBCHARSET,'utf-8//IGNORE',$sex_cn);
			//echo $a;exit;
			//echo $username."<br>";
			//echo $realname."<br>";
			//echo $birthday."<br>";
			//echo $sex_cn."<br>";
			//echo $residence_cn."<br>";
			//exit;
			//同步数据--curl方法--------------------------------------------------------------------------------------------------------------------------------------------------
			/*
				1: 姓名
				2: 电话号码
				3: 生日
				4：公司
				5：性别
				tel_num ： 电话号码
			*/
			//echo $uname."<br>";echo $userid."<br>";echo $address."<br>";echo $syear."<br>";echo $sex."<br>";exit;
			//$url="http://60.173.200.45:61500/sdk/infoGetter.ashx?fun=set_cstm_info&templet=2&batch=1&col=field_text_001,field_text_003,field_text_005,field_text_007,field_text_013&info='','".$userid."','','".$qym."',''&tel_num=".$userid."&corp_code=1009";
			$url="http://60.173.200.172:61500/sdk/infoGetter.ashx?fun=set_cstm_info&templet=2&batch=1&col=field_text_001,field_text_003,field_text_005,field_text_007,field_text_013&info='".$realname."','".$username."','".$birthday."','".$residence_cn."','".$sex_cn."'&tel_num=".$username."&corp_code=1009";			
			//echo $url;exit;
			$id=scurl($url);		//执行curl操作
			
			if($id != 1){
				$setsqlarr_3['sphone']=iconv('utf-8',QISHI_DBCHARSET."//IGNORE",$username);
				$setsqlarr_3['sex']=iconv('utf-8',QISHI_DBCHARSET."//IGNORE",$sex_cn);
				$setsqlarr_3['fullname']=iconv('utf-8',QISHI_DBCHARSET."//IGNORE",$realname);
				$setsqlarr_3['syear']=$birthday;
				$setsqlarr_3['create_time']=time();
				//$setsqlarr_3['yixianggongsi']=$username;
				inserttable('bingbing_hjdata',$setsqlarr_3,true);
				
			}
			//如果$id不存在
			if(empty($id)){
				$setsqlarr_3['sphone']=iconv('utf-8',QISHI_DBCHARSET."//IGNORE",$username);
				$setsqlarr_3['sex']=iconv('utf-8',QISHI_DBCHARSET."//IGNORE",$sex_cn);
				$setsqlarr_3['fullname']=iconv('utf-8',QISHI_DBCHARSET."//IGNORE",$realname);
				$setsqlarr_3['syear']=$birthday;
				$setsqlarr_3['create_time']=time();
				//$setsqlarr_3['yixianggongsi']=$username;
				inserttable('bingbing_hjdata',$setsqlarr_3,true);
			}
			//同步数据-------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
		//--fff
			
			}elseif($member_type=='4'){
				if(!$db->query("INSERT INTO ".table('members_points')." (uid) VALUES ('{$insert_id}')"))  return false;
				if(!$db->query("INSERT INTO ".table('members_train_setmeal')." (uid) VALUES ('{$insert_id}')")) return false;
					$points=get_cache('points_rule');
					if ($points['trainreg_points']['value']>0)
					{
						include_once(QISHI_ROOT_PATH.'include/fun_train.php');
						report_deal($insert_id,$points['trainreg_points']['type'],$points['trainreg_points']['value']);
						$operator=$points['trainreg_points']['type']=="1"?"+":"-";
						write_memberslog($insert_id,4,9101,$username,"新注册会员,({$operator}{$points['trainreg_points']['value']}),(剩余:{$points['trainreg_points']['value']})");
						write_setmeallog($insert_id,$username,"注册会员系统自动赠送：({$operator}{$points['trainreg_points']['value']}),(剩余:{$points['trainreg_points']['value']})",1,'0.00','1',1,4);
					}
					if ($_CFG['train_reg_service']>0){
						include_once(QISHI_ROOT_PATH.'include/fun_train.php');
						set_members_setmeal($insert_id,$_CFG['train_reg_service']);
						$setmeal=get_setmeal_one($_CFG['train_reg_service']);
						write_memberslog($insert_id,4,9102,$username,"注册会员系统自动赠送：{$setmeal['setmeal_name']}");
						write_setmeallog($insert_id,$username,"注册会员系统自动赠送：{$setmeal['setmeal_name']}",1,'0.00','1',2,4);
					}
			}elseif($member_type=='3'){
				if(!$db->query("INSERT INTO ".table('members_points')." (uid) VALUES ('{$insert_id}')"))  return false;
				if(!$db->query("INSERT INTO ".table('members_hunter_setmeal')." (uid) VALUES ('{$insert_id}')")) return false;
					$points=get_cache('points_rule');
					if ($points['hunterreg_points']['value']>0)
					{
						include_once(QISHI_ROOT_PATH.'include/fun_hunter.php');
						report_deal($insert_id,$points['hunterreg_points']['type'],$points['hunterreg_points']['value']);
						$operator=$points['hunterreg_points']['type']=="1"?"+":"-";
						write_memberslog($insert_id,3,9201,$username,"新注册会员,({$operator}{$points['hunterreg_points']['value']}),(剩余:{$points['hunterreg_points']['value']})");
						write_setmeallog($insert_id,$username,"注册会员系统自动赠送：({$operator}{$points['hunterreg_points']['value']}),(剩余:{$points['hunterreg_points']['value']})",1,'0.00','1',1,3);
					}
					if ($_CFG['hunter_reg_service']>0){
						include_once(QISHI_ROOT_PATH.'include/fun_hunter.php');
						set_members_setmeal($insert_id,$_CFG['hunter_reg_service']);
						$setmeal=get_setmeal_one($_CFG['hunter_reg_service']);
						write_memberslog($insert_id,3,9202,$username,"注册会员系统自动赠送：{$setmeal['setmeal_name']}");
						write_setmeallog($insert_id,$username,"注册会员系统自动赠送：{$setmeal['setmeal_name']}",1,'0.00','1',2,3);
					}
			}
			//-----添加审核员权限
			elseif($member_type=='5'){
				if(!$db->query("INSERT INTO ".table('members_points')." (uid) VALUES ('{$insert_id}')"))  return false;
				if(!$db->query("INSERT INTO ".table('members_shenhe_setmeal')." (uid) VALUES ('{$insert_id}')")) return false;
					$points=get_cache('points_rule');
					if ($points['shenhereg_points']['value']>0)
					{
						include_once(QISHI_ROOT_PATH.'include/fun_shenhe.php');
						report_deal($insert_id,$points['shenhereg_points']['type'],$points['shenhereg_points']['value']);
						$operator=$points['shenhereg_points']['type']=="1"?"+":"-";
						write_memberslog($insert_id,3,9201,$username,"新注册会员,({$operator}{$points['shenhereg_points']['value']}),(剩余:{$points['shenhereg_points']['value']})");
						write_setmeallog($insert_id,$username,"注册会员系统自动赠送：({$operator}{$points['shenhereg_points']['value']}),(剩余:{$points['shenhereg_points']['value']})",1,'0.00','1',1,3);
					}
					if ($_CFG['shenhe_reg_service']>0){
						include_once(QISHI_ROOT_PATH.'include/fun_shenhe.php');
						set_members_setmeal($insert_id,$_CFG['shenhe_reg_service']);
						$setmeal=get_setmeal_one($_CFG['shenhe_reg_service']);
						write_memberslog($insert_id,3,9202,$username,"注册会员系统自动赠送：{$setmeal['setmeal_name']}");
						write_setmeallog($insert_id,$username,"注册会员系统自动赠送：{$setmeal['setmeal_name']}",1,'0.00','1',2,3);
					}
			}
			if(defined('UC_API') && $uc_reg)
			{
				include_once(QISHI_ROOT_PATH.'uc_client/client.php');
				$uc_reg_uid=uc_user_register($username,$password,$email);
			}
			write_memberslog($insert_id,$member_type,1000,$username,"注册成为会员");
return $insert_id;
}
//会员登录
function user_login($account,$password,$account_type=1,$uc_login=true,$expire=NULL)
{
	
	global $timestamp,$online_ip,$QS_pwdhash;
	$usinfo = $login = array();
	$success = false;
	//echo $account_type;exit;
	if ($account_type=="1")
	{
		$usinfo=get_user_inusername($account);
		
	}
	elseif ($account_type=="2")
	{
		$usinfo=get_user_inemail($account);
	}
	elseif ($account_type=="3")
	{
		$usinfo=get_user_inmobile($account);
	}
	//echo "<pre>";print_r($usinfo);exit;
	if (!empty($usinfo))
	{
		$pwd_hash=$usinfo['pwd_hash'];
		$usname=addslashes($usinfo['username']);
		//$pwd=md5(md5($password).$pwd_hash.$QS_pwdhash);
		$pwd=md5($password);
		//echo $usinfo['password'];echo $pwd;exit;
		if ($usinfo['password']==$pwd)
		{
		update_user_info($usinfo['uid'],true,true,$expire);
		$login['qs_login']=get_member_url($usinfo['utype']);//------会员跳转页面处理
		$success=true;
		//---fff
		write_memberslog($usinfo['uid'],$usinfo['utype'],1001,$usname,"成功登录");
		//---fff
		}
		else
		{
		$usinfo='';
		$success=false;
		}
		//echo $login['qs_login'];exit;
		//echo "<pre>";print_r($usinfo);exit;
	}
	if(defined('UC_API') && $uc_login)
	{
			include_once(QISHI_ROOT_PATH.'uc_client/client.php');
			$account=$usinfo['username']?$usinfo['username']:$account;
			list($uc_uid, $uc_username, $uc_password, $uc_email) = uc_user_login($account,$password);
			if ($uc_uid>0)
			{
				$login['uc_login']=uc_user_synlogin($uc_uid);
				if ($success==false)//UC成功74失败就注册，注册用户为UC的用户名，
				{
					global $_CFG;
					$_SESSION['activate_username']=$uc_username;
					$login['qs_login']=$_CFG['main_domain']."user/user_reg.php?act=activate";
				}
			}
			elseif($uc_uid === -1 && $success)//74成功，UC失败，就注册到UC
			{
					$uc_reg_uid = uc_user_register($usinfo['username'], $password, $usinfo['email']);
					if ($uc_reg_uid>0)
					{
					$login['uc_login']=uc_user_synlogin($uc_reg_uid);
					}
			}
	}
	return $login;	
}
//检测COOKIE
function check_cookie($uid,$name,$pwd){
 	global $db;
 	$row = $db->getone("SELECT COUNT(*) AS num FROM ".table('members')." WHERE uid='{$uid}' and username='{$name}' and password = '{$pwd}'");
 	if($row['num'] > 0)
	{
 	return true;
 	}else{
 	return false;
 	}
 }
 /**
  *
  * 更新用户信息
  *
  *
  */
 function update_user_info($uid,$record=true,$setcookie=true,$cookie_expire=NULL)
 {
 	global $timestamp, $online_ip,$db,$QS_cookiepath,$QS_cookiedomain,$_CFG;//3.4升级修改 引入变量$_CFG
	$user = get_user_inid($uid);
	if (empty($user))
	{
	return false;
	}
	else
	{
 	$_SESSION['uid'] = intval($user['uid']);
 	$_SESSION['username'] = addslashes($user['username']);
	$_SESSION['utype']=intval($user['utype']);
	}
	if ($setcookie)
	{
		$expire=intval($cookie_expire)>0?time()+3600*24*$cookie_expire:0;
		setcookie('QS[uid]',$user['uid'],$expire,$QS_cookiepath,$QS_cookiedomain);
		setcookie('QS[username]',addslashes($user['username']),$expire,$QS_cookiepath,$QS_cookiedomain);
		setcookie('QS[password]',$user['password'],$expire,$QS_cookiepath,$QS_cookiedomain);
		setcookie('QS[utype]',$user['utype'], $expire,$QS_cookiepath,$QS_cookiedomain);
	}
	if ($record)
	{
    	$last_login_time = $timestamp;
		$last_login_ip = $online_ip;
		$sql = "UPDATE ".table('members')." SET last_login_time = '$last_login_time', last_login_ip = '$last_login_ip' WHERE uid='{$_SESSION['uid']}'  LIMIT 1";
		$db->query($sql);
 		if (($_CFG['operation_mode']=='1'||($_CFG['operation_mode']=='3'&&$_CFG['setmeal_to_points']=='1')) && $_SESSION['utype']=="1" )
		{
			$rule=get_cache('points_rule');
			if ($rule['userlogin']['value']>0 )
			{
				$time=time();
				$today=mktime(0, 0, 0,date('m'), date('d'), date('Y'));
				$info=$db->getone("SELECT uid FROM ".table('members_handsel')." WHERE uid ='{$_SESSION['uid']}' AND htype='userlogin' AND addtime>{$today}  LIMIT 1");
				if(empty($info))
				{				
					$db->query("INSERT INTO ".table('members_handsel')." (uid,htype,addtime) VALUES ('{$_SESSION['uid']}', 'userlogin','{$time}')");
					require_once(QISHI_ROOT_PATH.'include/fun_company.php');
					report_deal($_SESSION['uid'],$rule['userlogin']['type'],$rule['userlogin']['value']);
					$user_points=get_user_points($_SESSION['uid']);
					$operator=$rule['userlogin']['type']=="1"?"+":"-";
					$_SESSION['handsel_userlogin']=$operator.$rule['userlogin']['value'];
					write_memberslog($_SESSION['uid'],1,9001,$_SESSION['username'],date("Y-m-d")." 第一次登录，({$operator}{$rule['userlogin']['value']})，(剩余:{$user_points})",1,1014,"会员每天第一次登录","{$operator}{$rule['userlogin']['value']}","{$user_points}");
				}
			}
		}elseif ($_CFG['operation_train_mode']=='1' && $_SESSION['utype']=='4' )
		{
			$rule=get_cache('points_rule');
			if ($rule['trainuserlogin']['value']>0 )
			{
				$time=time();
				$today=mktime(0, 0, 0,date('m'), date('d'), date('Y'));
				$info=$db->getone("SELECT uid FROM ".table('members_handsel')." WHERE uid ='{$_SESSION['uid']}' AND htype='userlogin' AND addtime>{$today}  LIMIT 1");
				if(empty($info))
				{				
					$db->query("INSERT INTO ".table('members_handsel')." (uid,htype,addtime) VALUES ('{$_SESSION['uid']}', 'userlogin','{$time}')");
					require_once(QISHI_ROOT_PATH.'include/fun_train.php');
					report_deal($_SESSION['uid'],$rule['trainuserlogin']['type'],$rule['trainuserlogin']['value']);
					$user_points=get_user_points($_SESSION['uid']);
					$operator=$rule['trainuserlogin']['type']=="1"?"+":"-";
					$_SESSION['handsel_userlogin']=$operator.$rule['trainuserlogin']['value'];
					write_memberslog($_SESSION['uid'],4,9101,$_SESSION['username'],date("Y-m-d")." 第一次登录，({$operator}{$rule['trainuserlogin']['value']})，(剩余:{$user_points})");
				}
			}
		}elseif ($_CFG['operation_hunter_mode']=='1' && $_SESSION['utype']=='3' )
		{
			$rule=get_cache('points_rule');
			if ($rule['hunteruserlogin']['value']>0 )
			{
				$time=time();
				$today=mktime(0, 0, 0,date('m'), date('d'), date('Y'));
				$info=$db->getone("SELECT uid FROM ".table('members_handsel')." WHERE uid ='{$_SESSION['uid']}' AND htype='userlogin' AND addtime>{$today}  LIMIT 1");
				if(empty($info))
				{				
					$db->query("INSERT INTO ".table('members_handsel')." (uid,htype,addtime) VALUES ('{$_SESSION['uid']}', 'userlogin','{$time}')");
					require_once(QISHI_ROOT_PATH.'include/fun_hunter.php');
					report_deal($_SESSION['uid'],$rule['hunteruserlogin']['type'],$rule['hunteruserlogin']['value']);
					$user_points=get_user_points($_SESSION['uid']);
					$operator=$rule['hunteruserlogin']['type']=="1"?"+":"-";
					$_SESSION['handsel_userlogin']=$operator.$rule['hunteruserlogin']['value'];
					write_memberslog($_SESSION['uid'],3,9201,$_SESSION['username'],date("Y-m-d")." 第一次登录，({$operator}{$rule['hunteruserlogin']['value']})，(剩余:{$user_points})");
				}
			}
		}
	}
	//消息
	$user_pmid=$db->getone("SELECT pmid FROM ".table('pms_sys_log')." WHERE loguid ='{$_SESSION['uid']}' ORDER BY `pmid` DESC  LIMIT 1");
	$user_pmid=intval($user_pmid['pmid']);
	$result = $db->query("SELECT * FROM ".table('pms_sys')." WHERE spmid>{$user_pmid} AND (spms_usertype='0' OR spms_usertype='{$_SESSION['utype']}') AND spms_type='1' ");
	while($row = $db->fetch_array($result))
	{
		$setsqlarr['msgtype']=1;
		$setsqlarr['msgtouid']=$_SESSION['uid'];
		$setsqlarr['msgtoname']=$_SESSION['username'];
		$setsqlarr['message']=$row['message'];
		$setsqlarr['dateline']=$timestamp;
		$setsqlarr['replytime']=$timestamp;
		$setsqlarr['new']=1;
		inserttable(table('pms'),$setsqlarr);
		$log['loguid']=$_SESSION['uid'];
		$log['pmid']=$row['spmid'];
		inserttable(table('pms_sys_log'),$log);
		unset($setsqlarr,$log);
	}
	//统计消息
	$pmscount=$db->get_total("SELECT COUNT(*) AS num FROM ".table('pms')." WHERE (msgfromuid='{$_SESSION['uid']}' OR msgtouid='{$_SESSION['uid']}') AND `new`='1' AND `replyuid`<>'{$_SESSION['uid']}'");
	setcookie('QS[pmscount]',$pmscount, $expire,$QS_cookiepath,$QS_cookiedomain);
	return true;
 }
function get_user_inemail($email)
{
	global $db;
	return $db->getone("select * from ".table('members')." where email = '{$email}' LIMIT 1");
}
//----fffff检查member_info表里姓名
/*
function get_user_inrealname($realname)
{
	global $db;
	return $db->getone("select * from ".table('members_info')." where realname = '{$realname}' LIMIT 1");
}*/
function get_user_companyname($companyname)
{
	global $db;
	$sql = "select * from ".table('company_profile')." where companyname = '{$companyname}' LIMIT 1";
	return $db->getone($sql);
}
///---fff-培训会员注册
function get_user_trainname($trainname)
{
	global $db;
	$sql = "select * from ".table('train_profile')." where trainname = '{$trainname}' LIMIT 1";
	return $db->getone($sql);
}

//---ffff
function get_user_inusername($username)
{
	global $db;
	$sql = "select * from ".table('members')." where username = '{$username}' LIMIT 1";
	return $db->getone($sql);
}
function get_user_inid($uid)
{
	global $db;
	$uid=intval($uid);
	$sql = "select * from ".table('members')." where uid = '{$uid}' LIMIT 1";
	return $db->getone($sql);
}
function get_user_inmobile($mobile)
{
	global $db;
	$sql = "select * from ".table('members')." where mobile = '{$mobile}' LIMIT 1";
	return $db->getone($sql);
}
function get_user_inqqopenid($openid)
{
	global $db;
	if (empty($openid))
	{
	return false;
	}
	$sql = "select * from ".table('members')." where qq_openid = '{$openid}' LIMIT 1";
	return $db->getone($sql);
}
function get_user_insina_access_token($access)
{
	global $db;
	if (empty($access))
	{
	return false;
	}
	$sql = "select * from ".table('members')." where sina_access_token = '{$access}' LIMIT 1";
	return $db->getone($sql);
}
function get_user_intaobao_access_token($access)
{
	global $db;
	if (empty($access))
	{
	return false;
	}
	$sql = "select * from ".table('members')." where taobao_access_token = '{$access}' LIMIT 1";
	return $db->getone($sql);
}
//激活用户名
function activate_user($usname,$pwd,$email,$member_type)
{
global $timestamp,$online_ip;
	if(defined('UC_API'))
	{
	include_once(QISHI_ROOT_PATH.'uc_client/client.php');
	list($activateuid, $username, $password, $email) = uc_user_login($usname,$pwd);
		if($activateuid > 0)
		{
		return user_register($usname,$pwd,$member_type,$email,false);
		}
		else
		{
		return -10;
		}
	}
return false;
}
//获取随机字符串
function randstr($length=6)
{
$hash='';
$chars= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz@#!~?:-='; 
$max=strlen($chars)-1;   
mt_srand((double)microtime()*1000000);   
for($i=0;$i<$length;$i++)   {   
$hash.=$chars[mt_rand(0,$max)];   
}   
return $hash;   
}
//修改密码
function edit_password($arr,$check=true)
{
	global $db,$QS_pwdhash;
	if (!is_array($arr))return false;
	$user_info=get_user_inusername($arr['username']);
	$pwd_hash=$user_info['pwd_hash'];
	//$password=md5($arr['oldpassword']).$pwd_hash.$QS_pwdhash);
	$password=md5($arr['oldpassword']);
	if ($check)
	{
		$row = $db->getone("SELECT * FROM ".table('members')." WHERE username='{$arr['username']}' and password = '{$password}' LIMIT 1");
		if(empty($row))
		{
			return -1;
		}
	}
	//$md5password=md5(md5($arr['password']).$pwd_hash.$QS_pwdhash);	
	$md5password=md5($arr['password']);	
	if ($db->query( "UPDATE ".table('members')." SET password = '$md5password'  WHERE username='".$arr['username']."'")) return $arr['username'];
	write_memberslog($_SESSION['uid'],$_SESSION['utype'],1004,$_SESSION['username'],"修改了密码");
	return false;
}

//获取会员登录日志
function get_user_loginlog($offset,$perpage,$get_sql= '')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT ".$offset.','.$perpage;
	$result = $db->query("SELECT * FROM ".table('members_log')." ".$get_sql." ORDER BY log_id DESC ".$limit);
	while($row = $db->fetch_array($result))
	{
	$row_arr[] = $row;
	}
	return $row_arr;
}
function get_loginlog_one($uid,$type)
{
	global $db;
	$result = $db->getone("SELECT * FROM ".table('members_log')." WHERE log_uid={$uid} AND log_type={$type} ORDER BY log_id DESC LIMIT 1,1");
	return $result;
}
//--ff
//curl函数
function scurl($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);        
	return curl_exec($ch);
	curl_close($ch);
}

?>