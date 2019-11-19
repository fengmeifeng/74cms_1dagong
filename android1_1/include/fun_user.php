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
function user_register($username,$password,$member_type=0,$email,$uc_reg=true)
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
	elseif (!empty($ck_email))
	{
	return -3;
	}
	$pwd_hash=randstr();
	$password_hash=md5(md5($password).$pwd_hash.$QS_pwdhash);
	$setsqlarr['username']=$username;
	$setsqlarr['password']=$password_hash;
	$setsqlarr['pwd_hash']=$pwd_hash;
	$setsqlarr['email']=$email;
	$setsqlarr['utype']=intval($member_type);
	$setsqlarr['reg_time']=$timestamp;
	$setsqlarr['reg_ip']=$online_ip;
	$insert_id=inserttable(table('members'),$setsqlarr,true);
			if($member_type=="1")
			{
				if(!$db->query("INSERT INTO ".table('members_points')." (uid) VALUES ('{$insert_id}')"))  return false;
				if(!$db->query("INSERT INTO ".table('members_setmeal')." (uid) VALUES ('{$insert_id}')")) return false;
					$points=get_cache('points_rule');
							if ($points['reg_points']['value']>0)
							{
								report_deal($insert_id,$points['reg_points']['type'],$points['reg_points']['value']);
								$operator=$points['reg_points']['type']=="1"?"+":"-";
								write_memberslog($insert_id,1,9001,$username,"从手机客户端新注册会员,({$operator}{$points['reg_points']['value']}),(剩余:{$points['reg_points']['value']})");
							}
							if ($_CFG['reg_service']>0)
							{
								set_members_setmeal($insert_id,$_CFG['reg_service']);
								$setmeal=get_setmeal_one($_CFG['reg_service']);
								write_memberslog($insert_id,1,9002,$username,"从手机客户端注册会员系统自动赠送：{$setmeal['setmeal_name']}");
							}
			}
			write_memberslog($insert_id,$member_type,1000,$username,"从手机客户端注册成为会员");
return $insert_id;
}
//会员登录
function user_login($account,$password,$account_type=1,$uc_login=true,$expire=NULL)
{
	global $timestamp,$online_ip,$QS_pwdhash;
	$usinfo = $login = array();
	$success = false;
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
	if (!empty($usinfo))
	{
		$pwd_hash=$usinfo['pwd_hash'];
		$usname=$usinfo['username'];
		$pwd=md5(md5($password).$pwd_hash.$QS_pwdhash);
		if ($usinfo['password']==$pwd)
		{
		update_user_info($usinfo['uid'],true);
		write_memberslog($usinfo['uid'],$usinfo['utype'],1001,$usinfo['username'],"从手机客户端成功登录");
		return true;
		}
		else
		{
		return false;
		}
	}
	return false;
}
function set_members_setmeal($uid,$setmealid)
{
	global $db,$timestamp;
	$setmeal=$db->getone("select * from ".table('setmeal')." WHERE id = ".intval($setmealid)." AND display=1 LIMIT 1");
	if (empty($setmeal)) return false;
	$setsqlarr['effective']=1;
	$setsqlarr['setmeal_id']=$setmeal['id'];
	$setsqlarr['setmeal_name']=$setmeal['setmeal_name'];
	$setsqlarr['days']=$setmeal['days'];
	$setsqlarr['starttime']=$timestamp;
		if ($setmeal['days']>0)
		{
		$setsqlarr['endtime']=strtotime("".$setmeal['days']." days");
		}
		else
		{
		$setsqlarr['endtime']="0";	
		}
	$setsqlarr['expense']=$setmeal['expense'];
	$setsqlarr['jobs_ordinary']=$setmeal['jobs_ordinary'];
	$setsqlarr['download_resume_ordinary']=$setmeal['download_resume_ordinary'];
	$setsqlarr['download_resume_senior']=$setmeal['download_resume_senior'];
	$setsqlarr['interview_ordinary']=$setmeal['interview_ordinary'];
	$setsqlarr['interview_senior']=$setmeal['interview_senior'];
	$setsqlarr['talent_pool']=$setmeal['talent_pool'];
	$setsqlarr['added']=$setmeal['added'];
	if (!updatetable(table('members_setmeal'),$setsqlarr," uid='{$uid}'")) return false;
	$setmeal_jobs['setmeal_deadline']=$setsqlarr['endtime'];
	$setmeal_jobs['setmeal_id']=$setsqlarr['setmeal_id'];
	$setmeal_jobs['setmeal_name']=$setsqlarr['setmeal_name'];
	if (!updatetable(table('jobs'),$setmeal_jobs," uid='{$uid}' AND add_mode='2' ")) return false;
	if (!updatetable(table('jobs_tmp'),$setmeal_jobs," uid='{$uid}' AND add_mode='2' ")) return false;
	distribution_jobs_uid($uid);
	return true;
}
function get_setmeal($apply=false)
{
	global $db;
	if ($apply)
	{
	$wheresql=" AND apply=1";
	}
	$sql = "select * from ".table('setmeal')." WHERE display=1 {$wheresql} ORDER BY show_order desc";
	return $db->getall($sql);
}
function get_setmeal_one($id)
{
	global $db;
	$id=intval($id);
	$sql = "select * from ".table('setmeal')."  WHERE id='{$id}'  LIMIT 1";
	return $db->getone($sql);
}
function write_memberslog($uid,$utype,$type,$username,$str)
{
 	global $db,$online_ip;
 	$sql = "INSERT INTO ".table('members_log')." (log_uid,log_username,log_utype,log_type,log_addtime,log_ip,log_value) VALUES ( '{$uid}','{$username}','{$utype}','{$type}', '".time()."','{$online_ip}','{$str}')";
	return $db->query($sql);
}
//检测COOKIE
 function update_user_info($uid,$record=true)
 {
 	global $timestamp,$db,$QS_cookiepath,$QS_cookiedomain;
	$user = get_user_inid($uid);
	if (empty($user))
	{
	return false;
	}
	else
	{
 	$_SESSION['uid'] = intval($user['uid']);
 	$_SESSION['username'] = $user['username'];
	$_SESSION['utype']=intval($user['utype']);
	}
	if ($record)
	{
		$last_login_time = time();
		$last_login_ip = '手机客户端';
		$sql = "UPDATE ".table('members')." SET last_login_time = '$last_login_time', last_login_ip = '$last_login_ip' WHERE uid='{$_SESSION[uid]}'  LIMIT 1";
		$db->query($sql);
		if ($_SESSION['utype']=="1")
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
				report_deal($_SESSION['uid'],$rule['userlogin']['type'],$rule['userlogin']['value']);
				$user_points=get_user_points($_SESSION['uid']);
				$operator=$rule['userlogin']['type']=="1"?"+":"-";
				$_SESSION['handsel_userlogin']=$operator.$rule['userlogin']['value'];
				write_memberslog($_SESSION['uid'],1,9001,$_SESSION['username'],date("Y-m-d")." 第一次登录(手机客户端)，({$operator}{$rule['userlogin']['value']})，(剩余:{$user_points})");
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
		$setsqlarr['dateline']=time();
		$setsqlarr['replytime']=time();
		$setsqlarr['new']=1;
		inserttable(table('pms'),$setsqlarr);
		$log['loguid']=$_SESSION['uid'];
		$log['pmid']=$row['spmid'];
		inserttable(table('pms_sys_log'),$log);
		unset($setsqlarr,$log);
	}
	return true;
 }
function get_user_inemail($email)
{
	global $db;
	return $db->getone("select * from ".table('members')." where email = '{$email}' LIMIT 1");
}
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
function get_userprofile($uid)
{
	global $db;
	$uid=intval($uid);
	$sql = "select * from ".table('members_info')." where uid ='{$uid}' LIMIT 1";
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
function report_deal($uid,$i_type=1,$points=0)
{
	global $db,$timestamp;
	$points=intval($points);
	$uid=intval($uid);
	$points_val=get_user_points($uid);
	if ($i_type==1)
	{
	$points_val=$points_val+$points;
	}
	if ($i_type==2)
	{
	$points_val=$points_val-$points;
	$points_val=$points_val<0?0:$points_val;
	}
	$sql = "UPDATE ".table('members_points')." SET points= '{$points_val}' WHERE uid='{$uid}' LIMIT 1";
	if (!$db->query($sql))return false;
	return true;
}
function get_user_points($uid)
{
	global $db;
	$uid=intval($uid);
	$points=$db->getone("select points from ".table('members_points')." where uid ='{$uid}' LIMIT 1");
	return $points['points'];
}
function get_jobs($offset,$perpage,$get_sql= '',$countresume=false)
{
	global $db,$timestamp;
	$row_arr = array();
	if(isset($offset)&&!empty($perpage))
	{
	$limit=" LIMIT {$offset},{$perpage}";
	}
	$result = $db->query($get_sql.$limit);
	while($row = $db->fetch_array($result))
	{
		unset($row['key'],$row['subsite_id'],$row['robot'],$row['user_status'],$row['display'],$row['tpl'],$row['map_x'],$row['map_y']);
		$row['addtime']=date("Y-m-d H:i",$row['addtime']);
		$row['deadline']=date("Y-m-d H:i",$row['deadline']);
		$row['refreshtime']=date("Y-m-d H:i",$row['refreshtime']);
		$row['company_addtime']=date("Y-m-d H:i",$row['company_addtime']);
		$row['countresume']="应聘简历 ({$row['countresume']})";		
		if ($row['audit']=='1')
		{
		$row['audit']='审核通过';
		}
		elseif($row['audit']=='2')
		{
		$row['audit']='审核中';
		}
		else
		{
		$row['audit']='审核未通过';
		}
		$row_arr[] = $row;
	}
	return $row_arr;
}
//删除职位
function del_jobs($del_id,$uid)
{
	global $db;
	$return=0;
	$uidsql=" AND uid=".intval($uid)."";
	if (!is_array($del_id)) $del_id=array($del_id);
	$sqlin=implode(",",$del_id);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
	if (!$db->query("Delete from ".table('jobs')." WHERE id IN ({$sqlin}) {$uidsql}")) return false;
	$return=$return+$db->affected_rows();
	if (!$db->query("Delete from ".table('jobs_tmp')." WHERE id IN ({$sqlin}) {$uidsql}")) return false;
	$return=$return+$db->affected_rows();
	if (!$db->query("Delete from ".table('jobs_contact')." WHERE pid IN ({$sqlin}) ")) return false;
	if (!$db->query("Delete from ".table('promotion')." WHERE cp_jobid IN ({$sqlin}) ")) return false;
	if (!$db->query("Delete from ".table('jobs_search_hot')." WHERE id IN ({$sqlin}) {$uidsql}")) return false;
	if (!$db->query("Delete from ".table('jobs_search_key')." WHERE id IN ({$sqlin}) {$uidsql}")) return false;
	if (!$db->query("Delete from ".table('jobs_search_rtime')." WHERE id IN ({$sqlin}) {$uidsql}")) return false;
	if (!$db->query("Delete from ".table('jobs_search_scale')." WHERE id IN ({$sqlin}) {$uidsql}")) return false;
	if (!$db->query("Delete from ".table('jobs_search_stickrtime')." WHERE id IN ({$sqlin}) {$uidsql}")) return false;
	if (!$db->query("Delete from ".table('jobs_search_wage')." WHERE id IN ({$sqlin}) {$uidsql}")) return false;
	if (!$db->query("Delete from ".table('jobs_search_tag')." WHERE id IN ({$sqlin}) {$uidsql}")) return false;
	write_memberslog($_SESSION['uid'],1,2003,$_SESSION['username'],"删除职位({$sqlin})");
	}
	return $return;
}
//激活或者暂停职位
function activate_jobs($idarr,$display,$uid)
{
	global $db;
	$display=intval($display);	
	$uid=intval($uid);
	$uidsql=" AND uid='{$uid}'";
	if (!is_array($idarr)) $idarr=array($idarr);
	$sqlin=implode(",",$idarr);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
	if (!$db->query("update ".table('jobs')."  SET display='{$display}' WHERE id IN ({$sqlin}) {$uidsql}")) return false;
	if (!$db->query("update ".table('jobs_tmp')."  SET display='{$display}' WHERE id IN ({$sqlin}) {$uidsql}")) return false;
	distribution_jobs($idarr,$uid);
	write_memberslog($_SESSION['uid'],1,2005,$_SESSION['username'],"将职位激活状态设为:{$display},职位ID为：{$sqlin}");
	return true;
	}
	return false;
}
function refresh_jobs($id,$uid)
{
	global $db;
	$uid=intval($uid);
	if (!is_array($id)) $id=array($id);
	$time=time();
	$sqlin=implode(",",$id);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
	if (!$db->query("update  ".table('company_profile')."  SET refreshtime='{$time}' WHERE uid='{$uid}' LIMIT 1 ")) return false;
	if (!$db->query("update  ".table('jobs')."  SET refreshtime='{$time}' WHERE id IN ({$sqlin})  AND uid='{$uid}'")) return false;
	if (!$db->query("update  ".table('jobs_tmp')."  SET refreshtime='{$time}' WHERE id IN ({$sqlin})  AND uid='{$uid}'")) return false;
	if (!$db->query("update  ".table('jobs_search_hot')."  SET refreshtime='{$time}' WHERE id IN ({$sqlin})  AND uid='{$uid}'")) return false;
	if (!$db->query("update  ".table('jobs_search_key')."  SET refreshtime='{$time}' WHERE id IN ({$sqlin})  AND uid='{$uid}'")) return false;
	if (!$db->query("update  ".table('jobs_search_rtime')."  SET refreshtime='{$time}' WHERE id IN ({$sqlin})  AND uid='{$uid}'")) return false;
	if (!$db->query("update  ".table('jobs_search_scale')."  SET refreshtime='{$time}' WHERE id IN ({$sqlin})  AND uid='{$uid}'")) return false;
	if (!$db->query("update  ".table('jobs_search_stickrtime')."  SET refreshtime='{$time}' WHERE id IN ({$sqlin})  AND uid='{$uid}'")) return false;
	if (!$db->query("update  ".table('jobs_search_wage')."  SET refreshtime='{$time}' WHERE id IN ({$sqlin})  AND uid='{$uid}'")) return false;
	return true;
	}
	return false;
}
function get_down_resume($offset,$perpage,$get_sql= '')
{
	global $db;
	$limit=" LIMIT ".intval($offset).','.intval($perpage);
	$selectstr=" d.*,r.sex_cn,r.fullname,r.display_name,r.experience_cn,r.district_cn,r.education_cn,r.intention_jobs,r.talent,r.addtime,r.refreshtime ";
	$result = $db->query("SELECT ".$selectstr." FROM ".table('company_down_resume')." as d {$get_sql} ORDER BY d.down_addtime DESC ".$limit);
	while($row = $db->fetch_array($result))
	{
		if (empty($row['fullname']))
		{
			$resume=$db->getone("select * from ".table('resume_tmp')." WHERE id='{$row['resume_id']}' LIMIT 1");
			$row['sex_cn']=$resume['sex_cn'];
			$row['fullname']=$resume['fullname'];
			$row['display_name']=$resume['display_name'];
			$row['experience_cn']=$resume['experience_cn'];
			$row['district_cn']=$resume['district_cn'];
			$row['education_cn']=$resume['education_cn'];
			$row['intention_jobs']=$resume['intention_jobs'];
			$row['talent']=$resume['talent'];
			$row['addtime']=$resume['addtime'];
			$row['refreshtime']=$resume['refreshtime'];
		}
		$row['intention_jobs']=cut_str($row['intention_jobs'],30,0,"...");
		if ($row['display_name']=="2")
		{
		$row['fullname']="N".str_pad($row['resume_id'],7,"0",STR_PAD_LEFT);
		}
		elseif ($row['display_name']=="3")
		{
		$row['fullname']=cut_str($row['fullname'],1,0,"**");
		}
		$row['fullname']=$row['fullname']."的简历";
		$row['addtime']=date("Y-m-d H:i",$row['addtime']);
		$row['refreshtime']=date("Y-m-d H:i",$row['refreshtime']);
		$row_arr[] = $row;
	}
	return $row_arr;
}
function get_apply_jobs($offset,$perpage,$get_sql= '')
{
	global $db;
	$limit=" LIMIT {$offset},{$perpage}";
	$selectstr=" a.*,r.sex_cn,r.experience_cn,r.district_cn,r.education_cn,r.intention_jobs,r.specialty,r.click,r.refreshtime,r.addtime as  resume_addtime";
	$result = $db->query("SELECT {$selectstr} FROM ".table('personal_jobs_apply')." as a {$get_sql} ORDER BY a.did DESC {$limit}");
	while($row = $db->fetch_array($result))
	{
		if (empty($row['sex_cn']))
		{
			$resume=$db->getone("select * from ".table('resume_tmp')." WHERE id='{$row['resume_id']}' LIMIT 1");
			$row['sex_cn']=$resume['sex_cn'];
			$row['experience_cn']=$resume['experience_cn'];
			$row['district_cn']=$resume['district_cn'];
			$row['education_cn']=$resume['education_cn'];
			$row['intention_jobs']=$resume['intention_jobs'];
			$row['click']=$resume['click'];
			$row['refreshtime']=$resume['refreshtime'];
			$row['resume_addtime']=$resume['addtime'];
		}
		$row['specialty']=cut_str($row['specialty'],30,0,"...");
		$row['apply_addtime']=date("Y-m-d H:i",$row['apply_addtime']);		
		$row_arr[] = $row;
	}
	return $row_arr;
}
function get_interview($offset,$perpage,$get_sql= '')
{
	global $db;
	$row_arr = array();
	if(isset($offset)&&!empty($perpage)) $limit=" LIMIT ".$offset.','.$perpage;
	$selectstr="i.*,r.fullname,r.display_name,r.sex_cn,r.education_cn,r.experience_cn,r.intention_jobs,r.district_cn,r.refreshtime";
	$result = $db->query("SELECT  {$selectstr}  FROM ".table('company_interview')." as i {$get_sql} ORDER BY  i.did DESC ".$limit);
	while($row = $db->fetch_array($result))
	{
		if (empty($row['sex_cn']))
		{
			$resume=$db->getone("select * from ".table('resume_tmp')." WHERE id='{$row['resume_id']}' LIMIT 1");
			$row['sex_cn']=$resume['sex_cn'];
			$row['fullname']=$resume['fullname'];
			$row['display_name']=$resume['display_name'];
			$row['experience_cn']=$resume['experience_cn'];
			$row['district_cn']=$resume['district_cn'];
			$row['education_cn']=$resume['education_cn'];
			$row['intention_jobs']=$resume['intention_jobs'];
			$row['talent']=$resume['talent'];
			$row['addtime']=$resume['addtime'];
			$row['refreshtime']=$resume['refreshtime'];
		}
		if ($row['personal_look']=='1')
		{
		$row['personal_look']='未查看';
		}
		else
		{
		$row['personal_look']='已查看';
		}
		$row['interview_addtime']=date("Y-m-d H:i",$row['interview_addtime']);		
		$row['intention_jobs']=cut_str($row['intention_jobs'],30,0,"...");
		$row_arr[] = $row;
	}
	return $row_arr;
}
function get_favorites($offset,$perpage,$get_sql= '')
{
	global $db;
	$row_arr = array();
	if(isset($offset)&&!empty($perpage)) $limit=" LIMIT ".$offset.','.$perpage;
	$selectstr="f.*,r.fullname,r.display_name,r.sex_cn,r.education_cn,r.experience_cn,r.intention_jobs,r.district_cn,r.addtime,r.refreshtime";
	$result = $db->query("SELECT ".$selectstr."  FROM ".table('company_favorites')." AS f ".$get_sql." ORDER BY f.did DESC ".$limit);
	while($row = $db->fetch_array($result))
	{
		if (empty($row['sex_cn']))
		{
			$resume=$db->getone("select * from ".table('resume_tmp')." WHERE id='{$row['resume_id']}' LIMIT 1");
			$row['sex_cn']=$resume['sex_cn'];
			$row['fullname']=$resume['fullname'];
			$row['display_name']=$resume['display_name'];
			$row['experience_cn']=$resume['experience_cn'];
			$row['district_cn']=$resume['district_cn'];
			$row['education_cn']=$resume['education_cn'];
			$row['intention_jobs']=$resume['intention_jobs'];
			$row['talent']=$resume['talent'];
			$row['addtime']=$resume['addtime'];
			$row['refreshtime']=$resume['refreshtime'];
		}
		$row['intention_jobs']=cut_str($row['intention_jobs'],30,0,"...");
		if ($row['display_name']=="2")
		{
		$row['fullname']="N".str_pad($row['resume_id'],7,"0",STR_PAD_LEFT);
		}
		elseif ($row['display_name']=="3")
		{
		$row['fullname']=cut_str($row['fullname'],1,0,"**");
		}
		$row_arr[] = $row;
	}
	return $row_arr;
}
function edit_password($arr,$check=true)
{
	global $db,$QS_pwdhash;
	if (!is_array($arr))return false;
	$user_info=get_user_inusername($arr['username']);
	$pwd_hash=$user_info['pwd_hash'];
	$password=md5(md5($arr['oldpassword']).$pwd_hash.$QS_pwdhash);
	if ($check)
	{
		$row = $db->getone("SELECT * FROM ".table('members')." WHERE username='{$arr['username']}' and password = '{$password}' LIMIT 1");
		if(empty($row))
		{
			return -1;
		}
	}
	$md5password=md5(md5($arr['password']).$pwd_hash.$QS_pwdhash);	
	if ($db->query( "UPDATE ".table('members')." SET password = '$md5password'  WHERE username='".$arr['username']."'"))
	{
	write_memberslog($_SESSION['uid'],$_SESSION['utype'],1004,$_SESSION['username'],"通过手机客户端修改了密码");
	return $arr['username'];
	}
}
function get_com_downresume($offset,$perpage,$get_sql='')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT ".intval($offset).','.intval($perpage);
	$select="d.*,c.id,c.companyname,c.addtime,c.district_cn,c.trade_cn,c.nature_cn";
	$sql="SELECT {$select} from ".table('company_down_resume')." AS d {$get_sql} ORDER BY did DESC {$limit}";
	$result = $db->query($sql);
	while($row = $db->fetch_array($result))
	{
	$row['down_addtime']=date("Y-m-d H:i",$row['down_addtime']);	
	$row_arr[] = $row;
	}
	return $row_arr;
}
function set_com_user_status($status,$uid)
{
	global $db;
	$status=intval($status);
	$uid=intval($uid);
	if (!$db->query("UPDATE ".table('members')." SET status= {$status} WHERE uid={$uid} LIMIT 1")) return false;
	if (!$db->query("UPDATE ".table('company_profile')." SET user_status= {$status} WHERE uid={$uid} ")) return false;
	if (!$db->query("UPDATE ".table('jobs')." SET user_status= {$status} WHERE uid={$uid} ")) return false;
	if (!$db->query("UPDATE ".table('jobs_tmp')." SET user_status= {$status} WHERE uid={$uid} ")) return false;
	distribution_jobs_uid($uid);
	write_memberslog($_SESSION['uid'],1,1003,$_SESSION['username'],"通过手机客户端修改帐号状态");
	return true;
}
function distribution_jobs($id,$uid)
{
	global $db,$_CFG;
	$uid=intval($uid);
	$uidsql=" AND uid='{$uid}' ";
	if (!is_array($id))$id=array($id);
	$time=time();
	foreach($id as $v)
	{
		$v=intval($v);
		$t1=$db->getone("select * from ".table('jobs')." where id='{$v}' {$uidsql} LIMIT 1");
		$t2=$db->getone("select * from ".table('jobs_tmp')." where id='{$v}' {$uidsql} LIMIT 1");
		if ((empty($t1) && empty($t2)) || (!empty($t1) && !empty($t2)))
		{
		continue;
		}
		else
		{
				$j=!empty($t1)?$t1:$t2;
				if (!empty($t1) &&  $j['audit']=="1" && $j['display']=="1" && $j['user_status']=="1")
				{
					if ($_CFG['outdated_jobs']=="1")
					{
						if ($j['deadline']>$time && ($j['setmeal_deadline']=="0" || $j['setmeal_deadline']>$time))
						{
						continue;
						}
					}
					else
					{
					continue;
					}
				}
				elseif (!empty($t2))
				{
						if ($j['audit']!="1" || $j['display']!="1" || $j['user_status']!="1")
						{
						continue;
						}
						else
						{
								if ($_CFG['outdated_jobs']=="1" && ($j['deadline']<$time || ($j['setmeal_deadline']<$time && $j['setmeal_deadline']!="0")))
								{
									continue;
								}
						}
				}
				//检测完毕
				$j=array_map('addslashes',$j);
				if (!empty($t1))
				{
					$db->query("Delete from ".table('jobs_tmp')." WHERE id='{$v}' {$uidsql}  LIMIT 1");
					$db->query("Delete from ".table('jobs')." WHERE id='{$v}' {$uidsql}  LIMIT 1");
					if (inserttable(table('jobs_tmp'),$j))
					{
						$db->query("Delete from ".table('jobs_search_hot')." WHERE id='{$v}' {$uidsql} LIMIT 1");
						$db->query("Delete from ".table('jobs_search_key')." WHERE id='{$v}' {$uidsql} LIMIT 1");
						$db->query("Delete from ".table('jobs_search_rtime')." WHERE id='{$v}' {$uidsql} LIMIT 1");
						$db->query("Delete from ".table('jobs_search_scale')." WHERE id='{$v}' {$uidsql} LIMIT 1");
						$db->query("Delete from ".table('jobs_search_stickrtime')." WHERE id='{$v}' {$uidsql} LIMIT 1");
						$db->query("Delete from ".table('jobs_search_wage')." WHERE id='{$v}' {$uidsql} LIMIT 1");
						$db->query("Delete from ".table('jobs_search_tag')." WHERE id='{$v}' {$uidsql} LIMIT 1");
					}
				}
				else
				{
					$db->query("Delete from ".table('jobs')." WHERE id='{$v}' {$uidsql} LIMIT 1");
					$db->query("Delete from ".table('jobs_tmp')." WHERE id='{$v}' {$uidsql} LIMIT 1");
					if (inserttable(table('jobs'),$j))
					{
						$searchtab['id']=$j['id'];
						$searchtab['uid']=$j['uid'];
						$searchtab['subsite_id']=$j['subsite_id'];
						$searchtab['recommend']=$j['recommend'];
						$searchtab['emergency']=$j['emergency'];
						$searchtab['nature']=$j['nature'];
						$searchtab['sex']=$j['sex'];
						$searchtab['category']=$j['category'];
						$searchtab['subclass']=$j['subclass'];
						$searchtab['trade']=$j['trade'];
						$searchtab['district']=$j['district'];
						$searchtab['sdistrict']=$j['sdistrict'];
						$searchtab['street']=$j['street'];
						$searchtab['officebuilding']=$j['officebuilding'];
						$searchtab['education']=$j['education'];
						$searchtab['experience']=$j['experience'];
						$searchtab['wage']=$j['wage'];
						$searchtab['refreshtime']=$j['refreshtime'];
						$searchtab['scale']=$j['scale'];
						//--
						inserttable(table('jobs_search_wage'),$searchtab);
						inserttable(table('jobs_search_scale'),$searchtab);
						//--
						$searchtab['map_x']=$j['map_x'];
						$searchtab['map_y']=$j['map_y'];
						inserttable(table('jobs_search_rtime'),$searchtab);
						unset($searchtab['map_x'],$searchtab['map_y']);
						//--
						$searchtab['stick']=$j['stick'];
						inserttable(table('jobs_search_stickrtime'),$searchtab);
						unset($searchtab['stick']);
						//--
						$searchtab['click']=$j['click'];
						inserttable(table('jobs_search_hot'),$searchtab);
						unset($searchtab['click']);
						//--
						$searchtab['key']=$j['key'];
						$searchtab['map_x']=$j['map_x'];
						$searchtab['map_y']=$j['map_y'];
						$searchtab['likekey']=$j['jobs_name'].','.$j['companyname'];
						inserttable(table('jobs_search_key'),$searchtab);
						unset($searchtab);
						$tag=explode('|',$j['tag']);
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
						$tagsql['id']=$j['id'];
						$tagsql['uid']=$j['uid'];
						$tagsql['subsite_id']=$j['subsite_id'];
						$tagsql['category']=$j['category'];
						$tagsql['subclass']=$j['subclass'];
						$tagsql['district']=$j['district'];
						$tagsql['sdistrict']=$j['sdistrict'];
						inserttable(table('jobs_search_tag'),$tagsql);
					}
				}		
		}
	}
}
function distribution_jobs_uid($uid)
{
	global $db;
	$uid=intval($uid);
	$result = $db->query("select id from ".table('jobs')." where uid={$uid} UNION ALL select id from ".table('jobs_tmp')." where uid={$uid} ");
	while($row = $db->fetch_array($result))
	{
	$id[] = $row['id'];
	}
	if (!empty($id))
	{
	return distribution_jobs($id,$uid);
	}
}
function get_invitation($offset,$perpage,$get_sql= '')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT ".intval($offset).','.intval($perpage);
	$select="i.*,j.jobs_name,j.addtime,j.companyname,j.company_addtime,j.district_cn,j.wage_cn,j.deadline,j.refreshtime,j.click";
	$sql="SELECT {$select} from ".table('company_interview')." AS i {$get_sql} ORDER BY did DESC {$limit}";
	$result = $db->query($sql);
	while($row = $db->fetch_array($result))
	{
		if (empty($row['companyname']))
		{
			$jobs=$db->getone("select * from ".table('jobs_tmp')." WHERE id='{$row['jobs_id']}' LIMIT 1");
			$row['jobs_name']=$jobs['jobs_name'];
			$row['addtime']=$jobs['addtime'];
			$row['companyname']=$jobs['companyname'];
			$row['company_addtime']=$jobs['company_addtime'];
			$row['company_id']=$jobs['company_id'];
			$row['wage_cn']=$jobs['wage_cn'];
			$row['district_cn']=$jobs['district_cn'];
			$row['deadline']=$jobs['deadline'];
			$row['refreshtime']=$jobs['refreshtime'];
			$row['click']=$jobs['click'];
		}
	$row['interview_addtime']=date("Y-m-d H:i",$row['interview_addtime']);	
	$row_arr[] = $row;
	}
	return $row_arr;
}
function get_per_apply_jobs($offset,$perpage,$get_sql= '')
{
	global $db;
	$limit=" LIMIT ".intval($offset).','.intval($perpage);
	$select=" a.*,j.jobs_name,j.addtime,j.company_id,j.companyname,j.company_addtime,j.wage_cn,j.district_cn,j.deadline,j.refreshtime,j.click";
	$sql="SELECT {$select} FROM ".table('personal_jobs_apply')." AS a{$get_sql} ORDER BY a.did DESC ".$limit;
	$result = $db->query($sql);
	while($row = $db->fetch_array($result))
	{
		if (empty($row['companyname']))
		{
			$jobs=$db->getone("select * from ".table('jobs_tmp')." WHERE id='{$row['jobs_id']}' LIMIT 1");
			$row['addtime']=$jobs['addtime'];
			$row['companyname']=$jobs['companyname'];
			$row['company_addtime']=$jobs['company_addtime'];
			$row['company_id']=$jobs['company_id'];
			$row['wage_cn']=$jobs['wage_cn'];
			$row['district_cn']=$jobs['district_cn'];
			$row['deadline']=$jobs['deadline'];
			$row['refreshtime']=$jobs['refreshtime'];
			$row['click']=$jobs['click'];
		}
		$row['apply_addtime']=date("Y-m-d H:i",$row['apply_addtime']);	
		$row_arr[] = $row;
	}
return $row_arr;
}
function get_per_favorites($offset,$perpage,$get_sql= '')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT {$offset},{$perpage}";
	$select=" f.*,j.jobs_name,j.addtime as jobs_addtime,j.companyname,j.company_addtime,j.company_id,j.wage_cn,j.district_cn,j.deadline,j.refreshtime,j.click";
	$result = $db->query("SELECT {$select} FROM ".table('personal_favorites')." AS f {$get_sql} ORDER BY f.did DESC {$limit}");
	while($row = $db->fetch_array($result))
	{
		if (empty($row['companyname']))
		{
			$jobs=$db->getone("select * from ".table('jobs_tmp')." WHERE id='{$row['jobs_id']}' LIMIT 1");
			$row['jobs_name']=$jobs['jobs_name'];
			$row['jobs_addtime']=$jobs['addtime'];
			$row['companyname']=$jobs['companyname'];
			$row['company_addtime']=$jobs['company_addtime'];
			$row['company_id']=$jobs['company_id'];
			$row['wage_cn']=$jobs['wage_cn'];
			$row['district_cn']=$jobs['district_cn'];
			$row['deadline']=$jobs['deadline'];
			$row['refreshtime']=$jobs['refreshtime'];
			$row['click']=$jobs['click'];
		}
	$row_arr[] = $row;
	}
	return $row_arr;
}
function set_per_user_status($status,$uid)
{
	global $db;
	if (!$db->query("UPDATE ".table('members')." SET status= ".intval($status)." WHERE uid=".intval($uid)." LIMIT 1")) return false;
	if (!$db->query("UPDATE ".table('resume')." SET user_status= ".intval($status)." WHERE uid=".intval($uid)." ")) return false;
	if (!$db->query("UPDATE ".table('resume_tmp')." SET user_status= ".intval($status)." WHERE uid=".intval($uid)." ")) return false;
	distribution_resume_uid($uid);
	write_memberslog($_SESSION['uid'],2,1003,$_SESSION['username'],"修改帐号状态({$status})");
	return true;
}
function distribution_resume($id,$uid)
{
	global $db;
	$uid=intval($uid);
	if (!is_array($id))$id=array($id);
	$time=time();
	foreach($id as $v)
	{
		$v=intval($v);
		$t1=$db->getone("select * from ".table('resume')." where id='{$v}' AND uid='{$uid}' LIMIT 1");
		$t2=$db->getone("select * from ".table('resume_tmp')." where id='{$v}' AND uid='{$uid}' LIMIT 1");
		if ((empty($t1) && empty($t2)) || (!empty($t1) && !empty($t2)))
		{
		exit("resume_tmp err");
		}
		else
		{
				$j=!empty($t1)?$t1:$t2;
				if (!empty($t1) &&  $t1['audit']=="1"  && $t1['user_status']=="1" && $t1['complete']=="1")
				{
					continue;
				}
				if (!empty($t2) && ($t2['audit']!="1" || $t2['user_status']!="1"  || $t2['complete']!="1"))
				{
					continue;
				}
				$j=array_map('addslashes',$j);
				if (!empty($t1))
				{
					$db->query("Delete from ".table('resume')." WHERE id='{$v}' LIMIT 1");
					$db->query("Delete from ".table('resume_tmp')." WHERE id='{$v}' LIMIT 1");
					if (inserttable(table('resume_tmp'),$j))
					{
						$db->query("Delete from ".table('resume_search_rtime')." WHERE id='{$v}' LIMIT 1");
						$db->query("Delete from ".table('resume_search_key')." WHERE id='{$v}' LIMIT 1");
						$db->query("Delete from ".table('resume_search_tag')." WHERE id='{$v}' LIMIT 1");
					}
				}
				else
				{
					$db->query("Delete from ".table('resume')." WHERE id='{$v}' LIMIT 1");
					$db->query("Delete from ".table('resume_tmp')." WHERE id='{$v}' LIMIT 1");
					if (inserttable(table('resume'),$j))
					{
						$searchtab['id']=$j['id'];
						$searchtab['display']=$j['display'];
						$searchtab['uid']=$j['uid'];
						$searchtab['subsite_id']=$j['subsite_id'];
						$searchtab['sex']=$j['sex'];
						$searchtab['nature']=$j['nature'];
						$searchtab['marriage']=$j['marriage'];
						$searchtab['experience']=$j['experience'];
						$searchtab['district']=$j['district'];
						$searchtab['sdistrict']=$j['sdistrict'];
						$searchtab['wage']=$j['wage'];
						$searchtab['education']=$j['education'];
						$searchtab['photo']=$j['photo'];
						$searchtab['refreshtime']=$j['refreshtime'];
						$searchtab['talent']=$j['talent'];
						inserttable(table('resume_search_rtime'),$searchtab);
						$searchtab['key']=$j['key'];
						$searchtab['likekey']=$j['intention_jobs'].','.$j['recentjobs'].','.$j['specialty'].','.$j['fullname'];
						inserttable(table('resume_search_key'),$searchtab);
						unset($searchtab);
						$tag=explode('|',$j['tag']);
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
						$tagsql['id']=$j['id'];
						$tagsql['uid']=$j['uid'];
						$tagsql['subsite_id']=$j['subsite_id'];
						$tagsql['experience']=$j['experience'];
						$tagsql['district']=$j['district'];
						$tagsql['sdistrict']=$j['sdistrict'];
						$tagsql['education']=$j['education'];
						inserttable(table('resume_search_tag'),$tagsql);
					}
				}		
		}
	}
}
function distribution_resume_uid($uid)
{
	global $db;
	$uid=intval($uid);
	$result = $db->query("select id from ".table('resume')." where uid={$uid} UNION ALL select id from ".table('resume_tmp')." where uid={$uid} ");
	while($row = $db->fetch_array($result))
	{
	$id[] = $row['id'];
	}
	if (!empty($id))
	{
	return distribution_resume($id,$uid);
	}
}
function get_resume_list($wheresql,$titlele=12)
{
		global $db;
		$result = $db->query("{$wheresql} LIMIT 30");
		while($row = $db->fetch_array($result))
		{
			$row['title']=cut_str($row['title'],$titlele,0,"...");
			$row['number']="N".str_pad($row['id'],7,"0",STR_PAD_LEFT);
			$row['lastname']=cut_str($row['fullname'],1,0,"**");
			if ($row['talent']=="2")
			{
			$talent='高级人才';
			}
			else
			{
			$talent='普通人才';
			}
			$row['fullname']="{$row['fullname']}({$talent})";
				if ($row['audit']=='1')
				{
				$row['audit']='审核通过';
				}
				elseif($row['audit']=='2')
				{
				$row['audit']='审核中';
				}
				else
				{
				$row['audit']='审核未通过';
				}
			if ($row['complete_percent']>60)
			{
			$row['complete_percent']="{$row['complete_percent']}% , 有效简历";
			}
			else
			{
			$row['complete_percent']="{$row['complete_percent']}% , 无效简历";
			}
			$row['refreshtime']=date("Y-m-d H:i",$row['refreshtime']);
			$row['addtime']=date("Y-m-d H:i",$row['addtime']);
			$row_arr[] = $row;			
		}
		return $row_arr;
}
function refresh_resume($uid,$pid)
{
	global $db;
	$time=time();
	$uid=intval($uid);
	if (!$db->query("update  ".table('resume')."  SET refreshtime='{$time}'  WHERE id='{$pid}'")) return false;
	if (!$db->query("update  ".table('resume_tmp')."  SET refreshtime='{$time}'  WHERE id='{$pid}'")) return false;
	if (!$db->query("update  ".table('resume_search_rtime')."  SET refreshtime='{$time}'  WHERE id='{$pid}'")) return false;
	if (!$db->query("update  ".table('resume_search_key')."  SET refreshtime='{$time}'  WHERE id='{$pid}'")) return false;
	write_memberslog($_SESSION['uid'],2,1102,$_SESSION['username'],"通过手机客户端刷新了简历");
	return true;
}
function del_resume($uid,$aid)
{
	global $db;
	$uid=intval($uid);
	if (!is_array($aid))$aid=array($aid);
	$sqlin=implode(",",$aid);
	if (!preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin)) return false;
	if (!$db->query("Delete from ".table('resume')." WHERE id IN ({$sqlin}) AND uid='{$uid}' ")) return false;
	if (!$db->query("Delete from ".table('resume_tmp')." WHERE id IN ({$sqlin}) AND uid='{$uid}' ")) return false;
	if (!$db->query("Delete from ".table('resume_jobs')." WHERE pid IN ({$sqlin}) AND uid='{$uid}' ")) return false;
	if (!$db->query("Delete from ".table('resume_education')." WHERE pid IN ({$sqlin}) AND uid='{$uid}' ")) return false;
	if (!$db->query("Delete from ".table('resume_training')." WHERE pid IN ({$sqlin}) AND uid='{$uid}' ")) return false;
	if (!$db->query("Delete from ".table('resume_work')." WHERE pid IN ({$sqlin}) AND uid='{$uid}' ")) return false;
	if (!$db->query("Delete from ".table('resume_search_rtime')." WHERE id IN ({$sqlin}) AND uid='{$uid}' ")) return false;
	if (!$db->query("Delete from ".table('resume_search_key')." WHERE id IN ({$sqlin}) AND uid='{$uid}' ")) return false;
	if (!$db->query("Delete from ".table('resume_search_tag')." WHERE id IN ({$sqlin}) AND uid='{$uid}' ")) return false;
	write_memberslog($_SESSION['uid'],2,1103,$_SESSION['username'],"通过手机客户端删除简历({$sqlin})");
	return true;
}
function get_auditresume_list($uid,$titlele=12)
{
		global $db;
		$uid=intval($uid);
		$result = $db->query("SELECT * FROM ".table('resume')." WHERE uid='{$uid}' UNION ALL SELECT * FROM ".table('resume_tmp')."  WHERE uid='{$uid}' AND audit=1 AND user_status=1 AND complete=1");
		while($row = $db->fetch_array($result))
		{
			$rows['title']=cut_str($row['title'],$titlele,0,"...");
			$rows['id']=$row['id'];
			$row_arr[] = $rows;
		}
		return $row_arr;
}
function check_jobs_apply($jobs_id,$resume_id,$p_uid)
{
	global $db;
	$sql = "select did from ".table('personal_jobs_apply')." WHERE personal_uid = '".intval($p_uid)."' AND jobs_id='".intval($jobs_id)."'  AND resume_id='".intval($resume_id)."' LIMIT 1";
	return $db->getone($sql);
}
function get_resume_basic($uid,$id)
{
	global $db;
	$id=intval($id);
	$uid=intval($uid);
	$info=$db->getone("select * from ".table('resume')." where id='{$id}'  AND uid='{$uid}' LIMIT 1 ");
	if (empty($info))
	{
	$info=$db->getone("select * from ".table('resume_tmp')." where id='{$id}'  AND uid='{$uid}' LIMIT 1 ");
	}
	if (empty($info))
	{
	return false;
	}
	else
	{
	$info['age']=date("Y")-$info['birthdate'];
	$info['number']="N".str_pad($info['id'],7,"0",STR_PAD_LEFT);
	$info['lastname']=cut_str($info['fullname'],1,0,"**");
	$info['tagcn']=preg_replace("/\d+/", '',$info['tag']);
	$info['tagcn']=preg_replace('/\,/','',$info['tagcn']);
	$info['tagcn']=preg_replace('/\|/','&nbsp;&nbsp;&nbsp;',$info['tagcn']);
	return $info;
	}
}
function check_down_resumeid($resume_id,$company_uid)
{
	global $db;
	$company_uid=intval($company_uid);
	$resume_id=intval($resume_id);
	$sql = "select did from ".table('company_down_resume')." WHERE company_uid = '{$company_uid}' AND resume_id='{$resume_id}' LIMIT 1";
	$info=$db->getone($sql);
	if (empty($info))
	{
	return false;
	}
	else
	{
	return true;
	}
}
function get_resume_basic_id($id)
{
	global $db;
	$id=intval($id);
	$ta1=$db->getone("select * from ".table('resume')." where id='{$id}' LIMIT 1 ");
	$ta2=$db->getone("select * from ".table('resume_tmp')." where id='{$id}' LIMIT 1 ");
	$val=!empty($ta1)?$ta1:$ta2;
	if ($val['display_name']=="2")
	{
	$val['fullname']="N".str_pad($val['id'],7,"0",STR_PAD_LEFT);
	}
	elseif ($val['display_name']=="3")
	{
	$val['fullname']=cut_str($val['fullname'],1,0,"**");
	}
	return $val;
}
function get_user_setmeal($uid)
{
	global $db;
	$uid=intval($uid);
	$sql = "select * from ".table('members_setmeal')."  WHERE uid='{$uid}' AND  effective=1 LIMIT 1";
	return $db->getone($sql);
}
function add_down_resume($resume_id,$company_uid,$resume_uid,$resume_name)
{
	global $db,$timestamp;
	$resume_id=intval($resume_id);
	$company_uid=intval($company_uid);
	$resume_uid=intval($resume_uid);
	$resume_name=trim($resume_name);
	$company=get_company($company_uid);
	$sql = "INSERT INTO ".table('company_down_resume')." (resume_id,resume_uid,resume_name,company_uid,company_name,down_addtime) VALUES ('{$resume_id}','{$resume_uid}','{$resume_name}','{$company_uid}','{$company['companyname']}','{$timestamp}')";
	return $db->query($sql);
}
function get_company($uid)
{
	global $db;
	$sql = "select * from ".table('company_profile')." where uid=".intval($uid)." LIMIT 1 ";
	return $db->getone($sql);
}
function asyn_userkey($uid)
{
	global $db;
	$sql = "select * from ".table('members')." where uid = '".intval($uid)."' LIMIT 1";
	$user=$db->getone($sql);
	return md5($user['username'].$user['pwd_hash'].$user['password']);
}
function action_user_setmeal($uid,$action)
{
	global $db;
	$sql="update ".table('members_setmeal')." set `".$action."`=".$action."-1  WHERE uid=".intval($uid)."  AND  effective=1 LIMIT 1";
    return $db->query($sql);
}
function select_category($data){
	global $db;
	$search = $db->query("select c_name from ".table('category')." where c_id=".$data);
	$result = $db->fetch_array($search);
	return $result['c_name'];
}
//检查简历的完成程度
function check_resume($uid,$pid)
{
	global $db,$timestamp,$_CFG;
	$uid=intval($uid);
	$pid=intval($pid);
	$percent=0;
	$resume_basic=get_resume_basic($uid,$pid);
	$resume_intention=$resume_basic['intention_jobs'];
	$resume_specialty=$resume_basic['specialty'];
	$resume_education=get_resume_education($uid,$pid);
	if (!empty($resume_basic))$percent=$percent+15;
	if (!empty($resume_intention))$percent=$percent+15;
	if (!empty($resume_specialty))$percent=$percent+15;
	if (!empty($resume_education))$percent=$percent+15;
	if ($resume_basic['photo_img'] && $resume_basic['photo_audit']=="1"  && $resume_basic['photo_display']=="1")
	{
	$setsqlarr['photo']=1;
	}
	else
	{
	$setsqlarr['photo']=0;
	}
	if ($percent<60)
	{
		$setsqlarr['complete_percent']=$percent;
		$setsqlarr['complete']=2;
	}
	else
	{
		$resume_work=get_resume_work($uid,$pid);
		$resume_training=get_resume_training($uid,$pid);
		$resume_photo=$resume_basic['photo_img'];
		if (!empty($resume_work))$percent=$percent+13;
		if (!empty($resume_training))$percent=$percent+13;
		if (!empty($resume_photo))$percent=$percent+14;
		$setsqlarr['complete']=1;
		$setsqlarr['complete_percent']=$percent;
		require_once(QISHI_ROOT_PATH.'include/splitword.class.php');
		$sp = new SPWord();
		$setsqlarr['key']=$resume_basic['intention_jobs'].$resume_basic['recentjobs'].$resume_basic['specialty'];		
		$setsqlarr['key']="{$resume_basic['fullname']} ".$sp->extracttag($setsqlarr['key']);
		$setsqlarr['key']=str_replace(","," ",$resume_basic['intention_jobs'])." {$setsqlarr['key']} {$resume_basic['education_cn']}";
		$setsqlarr['key']=$sp->pad($setsqlarr['key']);	
		if (!empty($resume_education))
		{
			foreach($resume_education as $li)
			{
			$setsqlarr['key']="{$li['school']} {$setsqlarr['key']} {$li['speciality']}";
			}
		}
		$setsqlarr['refreshtime']=$timestamp;
	}
	updatetable(table('resume'),$setsqlarr,"uid='{$uid}' AND id='{$pid}'");
	updatetable(table('resume_tmp'),$setsqlarr,"uid='{$uid}' AND id='{$pid}'");
	distribution_resume($pid,$uid);
	if ($percent>=60)
	{
		$j=get_resume_basic($uid,$pid);
		$searchtab['sex']=$j['sex'];
		$searchtab['nature']=$j['nature'];
		$searchtab['marriage']=$j['marriage'];
		$searchtab['experience']=$j['experience'];
		$searchtab['district']=$j['district'];
		$searchtab['sdistrict']=$j['sdistrict'];
		$searchtab['wage']=$j['wage'];
		$searchtab['education']=$j['education'];
		$searchtab['photo']=$j['photo'];
		$searchtab['refreshtime']=$j['refreshtime'];
		$searchtab['talent']=$j['talent'];
		updatetable(table('resume_search_rtime'),$searchtab,"uid='{$uid}' AND id='{$pid}'");
		$searchtab['key']=$j['key'];
		$searchtab['likekey']=$j['intention_jobs'].','.$j['recentjobs'].','.$j['specialty'].','.$j['fullname'];
		updatetable(table('resume_search_key'),$searchtab,"uid='{$uid}' AND id='{$pid}'");
		unset($searchtab);
		$tag=explode('|',$j['tag']);
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
		$tagsql['id']=$j['id'];
		$tagsql['uid']=$j['uid'];
		$tagsql['experience']=$j['experience'];
		$tagsql['district']=$j['district'];
		$tagsql['sdistrict']=$j['sdistrict'];
		$tagsql['education']=$j['education'];
		updatetable(table('resume_search_tag'),$tagsql,"uid='{$uid}' AND id='{$pid}'");
	}
}
//获取教育经历列表
function get_resume_education($uid,$pid)
{
	global $db;
	if (intval($uid)!=$uid) return false;
	$sql = "SELECT * FROM ".table('resume_education')." WHERE  pid='".intval($pid)."' AND uid='".intval($uid)."' ";
	return $db->getall($sql);
}
//获取：工作经历
function get_resume_work($uid,$pid)
{
	global $db;
	$sql = "select * from ".table('resume_work')." where pid='".$pid."' AND uid=".intval($uid)."" ;
	return $db->getall($sql);
}
//获取：培训经历列表
function get_resume_training($uid,$pid)
{
	global $db;
	$sql = "select * from ".table('resume_training')." where pid='".intval($pid)."' AND  uid='".intval($uid)."' ";
	return $db->getall($sql);
}
function get_user_info($uid)
{
	global $db;
	$uid=intval($uid);
	$sql = "select * from ".table('members')." where uid = '{$uid}' LIMIT 1";
	return $db->getone($sql);
}
function get_company_info($uid)
{
	global $db;
	$uid=intval($uid);
	$sql = "select * from ".table('company_profile')." where uid = '{$uid}' LIMIT 1";
	return $db->getone($sql);
}
?>