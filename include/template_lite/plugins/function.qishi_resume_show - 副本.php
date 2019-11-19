<?php
function tpl_function_qishi_resume_show($params, &$smarty)
{
global $db,$_CFG,$QS_cookiepath,$QS_cookiedomain;
$arr=explode(',',$params['set']);
foreach($arr as $str)
{
$a=explode(':',$str);
	switch ($a[0])
	{
	case "简历ID":
		$aset['id'] = $a[1];
		break;
	case "列表名":
		$aset['listname'] = $a[1];
		break;
	}
}
$aset=array_map("get_smarty_request",$aset);
$aset['id']=$aset['id']?intval($aset['id']):0;
$aset['listname']=$aset['listname']?$aset['listname']:"list";
$wheresql=" WHERE  id=".$aset['id']."";
$val=$db->getone("select * from ".table('resume').$wheresql." LIMIT  1");
if(intval($_SESSION['utype'])==1){
	$company_profile = $db->getone("select companyname from ".table('company_profile')." where uid=".intval($_SESSION['uid']));
}
if ($val && (intval($_GET['subsite_id']) == $val['subsite_id']))
{
	setcookie('QS[view_resume_log]['.$val['id'].']',$val['id'],0,$QS_cookiepath,$QS_cookiedomain);
	if(intval($_SESSION['uid'])>0 && intval($_SESSION['utype'])==1){
		//检查企业是否被个人屏蔽过
		$company_profile = $db->getone("select companyname from ".table('company_profile')." where uid=".intval($_SESSION['uid']));
		$shield_company = $db->getall("select comkeyword from ".table('personal_shield_company')." where pid=".$val['id']." and uid=".$val['uid']);
		foreach ($shield_company as $key => $value) {
			if(!empty($value['comkeyword']) && stristr($company_profile['companyname'],$value['comkeyword'])){
				header("HTTP/1.1 404 Not Found"); 
				$smarty->display("404.htm");
				exit();
			}
		}
		//检查是否查看过
		$check = check_view_log(intval($_SESSION['uid']),$val['id']);
		if(!$check){
			add_view_log(intval($_SESSION['uid']),$val['id']);
			$sql="select * from ".table("personal_jobs_apply")." where resume_id=$val[id] and company_uid=".intval($_SESSION['uid'])." ";
			if($db->getone($sql)){
				$db->query("update ".table("personal_jobs_apply")." set personal_look=2 where  resume_id=$val[id] and company_uid=".intval($_SESSION['uid'])."");
			}
		}else{
			$db->query("update ".table("personal_jobs_apply")." set personal_look=2 where  resume_id=$val[id] and company_uid=".intval($_SESSION['uid'])."");
		}

	}
	if ($val['display_name']=="2")
	{
		$val['fullname']="N".str_pad($val['id'],7,"0",STR_PAD_LEFT);
		$val['fullname_']=$val['fullname'];		
	}
	elseif($val['display_name']=="3")
	{
		$val['fullname']=cut_str($val['fullname'],1,0,"**");
		$val['fullname_']=$val['fullname'];	
	}
	else
	{
		$val['fullname_']=$val['fullname'];
		$val['fullname']=$val['fullname'];
	}
	$val['education_list']=get_this_education($val['uid'],$val['id']);
	$val['work_list']=get_this_work($val['uid'],$val['id']);
	$val['training_list']=get_this_training($val['uid'],$val['id']);
	$val['age']=date("Y")-$val['birthdate'];
	if ($val['photo']=="1" && $val['photo_display']=="1")// 判断是否显示照片
	{
	$val['photosrc']=$_CFG['resume_photo_dir_thumb'].$val['photo_img'];
	}
	else
	{
	$val['photosrc']=$_CFG['resume_photo_dir_thumb']."no_photo.gif";
	}
	// $val['tagcn']=preg_replace("/\d+/", '',$val['tag']);
	// $val['tagcn']=preg_replace('/\,/','',$val['tagcn']);
	// $val['tagcn']=preg_replace('/\|/','&nbsp;&nbsp;&nbsp;',$val['tagcn']);
	if ($val['tag'])
	{
		$tag=explode('|',$val['tag']);
		$taglist=array();
		if (!empty($tag) && is_array($tag))
		{
			foreach($tag as $t)
			{
			$tli=explode(',',$t);
			$taglist[]=array($tli[0],$tli[1]);
			}
		}
		$val['tag']=$taglist;
	}
	else
	{
	$val['tag']=array();
	}
	if(intval($_GET['apply'])==1){
		$val['apply'] = 1;
		$apply = $db->getone("select * from ".table('personal_jobs_apply')." where `resume_id`=".$val['id']);
		$val['jobs_name'] = $apply['jobs_name'];
		$val['jobs_url'] = url_rewrite('QS_jobsshow',array('id'=>$apply['jobs_id']),true,$val['subsite_id']);
	}else{
		$val['apply'] = 0;
	}
}
else
{
	header("HTTP/1.1 404 Not Found"); 
	$smarty->display("404.htm");
	exit();
}
$smarty->assign($aset['listname'],$val);
}
function get_this_education($uid,$pid)
{
	global $db;
	$sql = "SELECT * FROM ".table('resume_education')." WHERE uid='".intval($uid)."' AND pid='".intval($pid)."' ";
	return $db->getall($sql);
}
function get_this_work($uid,$pid)
{
	global $db;
	$sql = "select * from ".table('resume_work')." where uid=".intval($uid)." AND pid='".$pid."' " ;
	return $db->getall($sql);
}
function get_this_training($uid,$pid)
{
	global $db;
	$sql = "select * from ".table('resume_training')." where uid='".intval($uid)."' AND pid='".intval($pid)."'";
	return $db->getall($sql);
}
function check_view_log($uid,$resumeid){
	global $db;
	$result = $db->getone("select * from ".table("view_resume")." where `uid`=".$uid." and `resumeid`=".$resumeid);
	return $result;
}
function add_view_log($uid,$resumeid){
	$setsqlarr['uid'] = $uid;
	$setsqlarr['resumeid'] = $resumeid;
	$setsqlarr['addtime'] = time();
	inserttable(table("view_resume"),$setsqlarr);
}
?>