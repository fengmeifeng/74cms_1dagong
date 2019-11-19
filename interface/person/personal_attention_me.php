<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
//require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');

$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	unset($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['userid'];exit;
	$page=isset($aset['page'])?trim($aset['page']):"";
	$page=addslashes($page);
	$page=iconv("utf-8",QISHI_DBCHARSET,$page);
	//echo $aset['page'];exit;
	$pagesize=isset($aset['pagesize'])?trim($aset['pagesize']):"";
	$pagesize=addslashes($pagesize);
	$pagesize=iconv("utf-8",QISHI_DBCHARSET,$pagesize);
	//echo $aset['pagesize'];exit;
	
	if (empty($userid))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该用户');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
function get_view_resume($offset,$perpage,$get_sql= '',$userid)
{
	global $db;
	$limit=" LIMIT {$offset},{$perpage}";
	$selectstr=" a.*,r.subsite_id,r.id as resume_id,r.uid as resume_uid,r.title ";
	$result = $db->query("SELECT {$selectstr} FROM ".table('view_resume')." as a {$get_sql} ORDER BY a.id DESC {$limit}");
	while($row = $db->fetch_array($result))
	{
		//echo $userid;exit;
		if($row['resume_uid']!=intval($userid)){
			continue;
		}
		$row['title'] = cut_str($row['title'],13,0,"..");
		$company_profile = $db->getone("select `id`,`companyname`,`district_cn` from ".table('company_profile')." where `uid`=".$row['uid']);
		$row['companyname'] = $company_profile['companyname'];
		$row['district_cn'] = $company_profile['district_cn'];
		$row['company_id'] = $company_profile['id'];
		$row['companyname'] = cut_str($row['companyname'],13,0,"..");
		$row['addtime']=daterange(time(),$row['addtime'],'Y-m-d',"#FF3300");
		//$row['company_url'] = url_rewrite("QS_companyshow",array('id'=>$company_profile['id']),false);
		//$row['url'] = url_rewrite("QS_resumeshow",array('id'=>$row['resumeid']),true,$row['subsite_id']);
	
		$jobs = $db->getall("select * from ".table('jobs')." where `uid`=".$row['uid'].$wheresql);
		foreach ($jobs as $key1 => $value1) {
			$row['jobslist'][$key1]['jobsname'] = $value1['jobs_name'];
			//$row['jobslist'][$key1]['jobs_url'] = url_rewrite("QS_jobsshow",array('id'=>$value1['id']),true,$value1['subsite_id']);
		}
		if($row['resume_uid']){
			$downlog = $db->getone("select did from ".table('company_down_resume')." where resume_id={$row['resumeid']} and resume_uid={$row['resume_uid']} and company_uid={$row['uid']}");
			if(intval($downlog)){
				$row['hasdown'] = 1;
			}else{
				$row['hasdown'] = 0;
			}
		}
		
		$row_arr[] = $row;
	}
	return $row_arr;
}
function get_auditresume_list($uid,$titlele=12)
{
		global $db;
		$uid=intval($uid);
		$result = $db->query("SELECT * FROM ".table('resume')." WHERE uid='{$uid}'".$wheresql);
		while($row = $db->fetch_array($result))
		{
			//$row['resume_url']=url_rewrite('QS_resumeshow',array('id'=>$row['id']),true,$row['subsite_id']);
			$row['title']=cut_str($row['title'],$titlele,0,"...");
			$row['number']="N".str_pad($row['id'],7,"0",STR_PAD_LEFT);
			$row['lastname']=cut_str($row['fullname'],1,0,"**");
			$row_arr[] = $row;
		}
		return $row_arr;
}


	//$wheresql=" WHERE a.personal_uid='{$userid}' ";
	
	//----获取总数
	$resume = get_auditresume_list($userid);
	foreach($resume as $k=>$v){
		$rid[] = $v['id'];
	}
	//echo "<pre>";print_r($rid);exit;
	if(!empty($rid)){
		$rid_str = implode(",",$rid);
		$total_sql="SELECT COUNT(*) AS num FROM ".table('view_resume')." AS a where resumeid in (".$rid_str.")";
		$total_val=$db->get_total($total_sql);
		$wheresql=" where a.resumeid in (".$rid_str.") ";
		//echo $wheresql;exit;
	}else{
		$total_val = 0;
	}
	//----获取总数结合苏
	//----fff---分页
	//$page 当前页数
	//$total_val 总条数
	//$pagesize 每页显示条数
	if(!$page) $page = 1;
	if(!$pagesize) $pagesize = 10;
	$maxpage = ceil($total_val / $pagesize);
	/*if($maxpage>0)
	{
		if($page > $maxpage) $page = $maxpage;
	}*/
	$offset = ($page - 1) * $pagesize;

	$joinsql=" LEFT JOIN  ".table('resume')." AS r  ON  a.resumeid=r.id ";
	$list=get_view_resume($offset,$pagesize,$joinsql.$wheresql,$userid);
	//echo "<pre>";print_r($list);exit;
	if (empty($list))
	{
	$list=array();
	}
	$androidresult['code']=1;
	$androidresult['errormsg']='';
	$list=array_map('export_mystrip_tags',$list);
	$androidresult['data']=android_iconv_utf8_array($list);
	$jsonencode = json_encode($androidresult);
	echo urldecode($jsonencode);

?>