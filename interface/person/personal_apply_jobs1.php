<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
//require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');

function get_apply_jobs($offset,$perpage,$get_sql= '',$total='')
{
	global $db;
	$limit=" LIMIT ".intval($offset).','.intval($perpage);
	$select=" a.*,j.subsite_id,j.jobs_name,j.addtime,j.company_id,j.companyname,j.company_addtime,j.wage_cn,j.district_cn,j.deadline,j.refreshtime,j.click";
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
			//$row['refreshtime']=$jobs['refreshtime'];
			$row['refreshtime']=daterange(time(),$jobs['refreshtime'],'Y-m-d',"#FF3300");
			$row['click']=$jobs['click'];
			$row['subsite_id'] = $jobs['subsite_id'];
		}
		$resume = $db->getone("select title from ".table('resume')." where id=".$row['resume_id']);
		$row['resume_name'] = $resume['title'];
		//----ffffff
		$row['apply_addtime']=daterange(time(),$row['apply_addtime'],'Y-m-d',"#FF3300");
		if($row['wage_cn'] !='面议'){$row['wage_cn']=$row['wage_cn']."元/月";}
		$row['refreshtime']=daterange(time(),$row['refreshtime'],'Y-m-d',"#FF3300");
		$row['total']=$total;
		//----ffffff
		//$row['company_url']=url_rewrite('QS_companyshow',array('id'=>$row['company_id']));
		//$row['jobs_url']=url_rewrite('QS_jobsshow',array('id'=>$row['jobs_id']),true,$row['subsite_id']);
		$row_arr[] = $row;
	}
return $row_arr;
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
	$wheresql=" WHERE a.personal_uid='{$userid}' and a.jobs_id <> 0 and a.company_id <> 0 ";
	
	//----获取总数
	$total_sql="SELECT COUNT(*) AS num FROM ".table('personal_jobs_apply')." AS a {$wheresql} ";
	$total_val=$db->get_total($total_sql);
	//----获取总数结合苏
	//----fff---分页
	//$page 当前页数
	//$total_val 总条数
	//$pagesize 每页显示条数
	
	if(!$page) $page = 1;
	if(!$pagesize) $pagesize = 10;
	$maxpage = ceil($total_val / $pagesize);
	/*
	
	if($maxpage>0)
	{
		if($page > $maxpage) $page = $maxpage;
	}*/
	$offset = ($page - 1) * $pagesize;
	//echo $page."<br>";echo $pagesize."<br>";echo $offset;exit;
	$joinsql=" LEFT JOIN ".table('jobs')." AS j ON a.jobs_id=j.id ";
	$list=get_apply_jobs($offset,$pagesize,$joinsql.$wheresql,$total_val);
	echo "<pre>";print_r($list);exit;
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