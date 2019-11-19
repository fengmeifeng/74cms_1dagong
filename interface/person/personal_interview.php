<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
//require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
//面试邀请
function get_invitation($offset,$perpage,$get_sql= '',$total_val='')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT ".intval($offset).','.intval($perpage);
	$select="i.did,i.resume_id,i.resume_name,i.interview_addtime,i.jobs_id,i.company_id,j.subsite_id,j.jobs_name,j.companyname,j.district_cn,j.wage_cn,j.deadline,j.click";
	$sql="SELECT {$select} from ".table('company_interview')." AS i {$get_sql} ORDER BY did DESC {$limit}";
	$result = $db->query($sql);
	while($row = $db->fetch_array($result))
	{
		if (empty($row['companyname']))	
		{
			$jobs=$db->getone("select * from ".table('jobs_tmp')." WHERE id='{$row['jobs_id']}' LIMIT 1");
			$row['jobs_name']=$jobs['jobs_name'];
			//$row['addtime']=$jobs['addtime'];
			$row['companyname']=$jobs['companyname'];
			//$row['company_addtime']=$jobs['company_addtime'];
			$row['company_id']=$jobs['company_id'];
			//$row['wage_cn']=$jobs['wage_cn'];
			$row['district_cn']=$jobs['district_cn'];
			$row['deadline']=$jobs['deadline'];
			//$row['refreshtime']=$jobs['refreshtime'];
			$row['click']=$jobs['click'];
			$row['subsite_id'] = $jobs['subsite_id'];
		}
		//$row['company_url']=url_rewrite('QS_companyshow',array('id'=>$row['company_id']));
		//$row['jobs_url']=url_rewrite('QS_jobsshow',array('id'=>$row['jobs_id']),true,$row['subsite_id']);
		//简历title
		if($row['wage_cn'] =='面议'){$row['wage_cn']=$row['wage_cn'];}else{$row['wage_cn']=$row['wage_cn']."元/月";}
		$row['interview_addtime']=daterange(time(),$row['interview_addtime'],'Y-m-d',"#FF3300");
		$row['deadline']=date('Y-m-d',$row['deadline']);
		$resume_info = $db->getone("select * from ".table('resume')." where id=".intval($row['resume_id']));
		$row['title'] = $resume_info['title'];
		$row['total'] = $total_val;
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
function count_interview($uid,$look=NULL)
{
	global $db;
	$uid=intval($uid);
	$wheresql=" WHERE  resume_uid='{$uid}' ";
	if (intval($look)>0) $wheresql.=" AND  personal_look=".intval($look);
	$total_sql="SELECT COUNT(*) AS num FROM ".table('company_interview')." {$wheresql}";
	return $db->get_total($total_sql);
}

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
	$wheresql=" WHERE  i.resume_uid='{$userid}' ";
	$look=intval($aset['look']);
	if($look>0)
	{
	$wheresql.=" AND  i.personal_look={$look}";
	}
	$resume_id =intval($aset['resumeId']);
	if($resume_id>0)
	{
		$wheresql.=" AND  i.resume_id='{$resume_id}' ";	
		$sql="select title from ".table("resume")." where id=".intval($aset['resumeId'])." ";
		$row=$db->getone($sql);
		//$smarty->assign('resume_title',$row["title"]);
	}
	
	//----获取总数
	$total_sql="SELECT COUNT(*) AS num from ".table('company_interview')." AS i {$wheresql} ";
	$total_val=$db->get_total($total_sql);
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

	$joinsql=" LEFT JOIN  ".table('jobs')." AS j  ON  i.jobs_id=j.id ";
	//echo $joinsql.$wheresql;exit;
	$list=get_invitation($offset,$page,$joinsql.$wheresql,$total_val);
	//echo "<pre>";print_r($list);exit;
	$count[0]=count_interview($userid,1);  //未看
	$count[1]=count_interview($userid,2);  //已看
	$count[2]=$count[0]+$count[1];
	//$smarty->assign('count',$count);
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