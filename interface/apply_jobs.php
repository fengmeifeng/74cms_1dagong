<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['userid'];exit;
	$did=isset($aset['did'])?trim($aset['did']):"";
	$did=addslashes($did);
	$did=iconv("utf-8",QISHI_DBCHARSET,$did);

	function get_apply_jobs($id,$uid)
	{
		function get_apply_jobs($offset,$perpage,$get_sql= '')
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
			$row['refreshtime']=$jobs['refreshtime'];
			$row['click']=$jobs['click'];
			$row['subsite_id'] = $jobs['subsite_id'];
		}
		$resume = $db->getone("select title from ".table('resume')." where id=".$row['resume_id']);
		$row['resume_name'] = $resume['title'];
		$row['company_url']=url_rewrite('QS_companyshow',array('id'=>$row['company_id']));
		$row['jobs_url']=url_rewrite('QS_jobsshow',array('id'=>$row['jobs_id']),true,$row['subsite_id']);
		$row_arr[] = $row;
	}
return $row_arr;
}
	}
	if(update_resume($did,$userid)){
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=array('userid'=>$userid,'did'=>$did);
	$jsonencode = android_iconv_utf8_array($result);
	$jsonencode = urldecode(json_encode($result));
	//exit($jsonencode);
	echo urldecode($jsonencode);
	}else{
	$result['code']=-1;
	$result['errormsg']=android_iconv_utf8('Ë¢ÐÂÊ§°Ü');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
?>