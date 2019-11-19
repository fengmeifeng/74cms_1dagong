<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset=array_map('addslashes',$aset);
require_once(ANDROID_ROOT_PATH.'include/common.user.inc.php');
if ($_SESSION['utype']<>'2')
{
	$result['result']=0;
	$result['list']=null;
	$result['errormsg']=android_iconv_utf8("请登录个人会员中心！");
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
}
else
{
	$pid = intval($aset['pid']);
	$uid = intval($_SESSION['uid']);
	if($aset['act']=="add"){
		$resume_search = $db->query("select `recentjobs`,`nature`,`nature_cn`,`district`,`sdistrict`,`district_cn`,`wage`,`wage_cn`,`intention_jobs`,`trade`,`trade_cn`,`complete_percent` from ".table('resume_tmp')." where `id`=".$pid);
		$return_data_arr = $db->fetch_array($resume_search);
		if(!$return_data_arr){
			$resume_search = $db->query("select `recentjobs`,`nature`,`nature_cn`,`district`,`sdistrict`,`district_cn`,`wage`,`wage_cn`,`intention_jobs`,`trade`,`trade_cn`,`complete_percent` from ".table('resume')." where `id`=".$pid);
			$return_data_arr = $db->fetch_array($resume_search);
		}
		foreach($return_data_arr as $k=>$v){
			$arr1[$k] = android_iconv_utf8($v);
		}
		$return_data_json = json_encode($arr1);
		$result['result']=1;
		$result['list']=$return_data_json;
		$result['errormsg']=android_iconv_utf8('获取数据成功');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	if($aset['act']=="save"){
		$aset['district']=intval($aset['district']);
		$aset['sdistrict']=intval($aset['sdistrict']);
		$aset['wage']=intval($aset['wage']);
		$setsqlarr['recentjobs']=trim($aset['recentjobs']);
		$setsqlarr['nature']=trim($aset['nature']);
		$setsqlarr['nature_cn']=trim($aset['nature_cn']);
		$setsqlarr['district']=trim($aset['district']);
		$setsqlarr['sdistrict']=trim($aset['sdistrict']);
		$setsqlarr['district_cn']=trim($aset['district_cn']);
		$setsqlarr['wage']=trim($aset['wage']);
		$setsqlarr['wage_cn']=trim($aset['wage_cn']);
		$setsqlarr['intention_jobs']=trim($aset['intention_jobs']);
		$setsqlarr['trade']=trim($aset['trade']);
		$setsqlarr['trade_cn']=trim($aset['trade_cn']);
		if (empty($setsqlarr['nature_cn']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('请选择期望岗位性质！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['district_cn']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('请选择期望工作地区！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['wage_cn']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('请选择期望薪资！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['intention_jobs']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('请选择期望从事的岗位！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['trade_cn']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('请选择期望从事的行业！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		$wheresql = "`id`=".$pid;
		$update_result1=updatetable(table('resume'),$setsqlarr,$wheresql);
		$update_result2=updatetable(table('resume_tmp'),$setsqlarr,$wheresql);
		check_resume($uid,$pid);
		//$update_result=$db->query("UPDATE qs_resume_tmp SET fullname = '".$setsqlarr['fullname']."' where id=".$pid);
		//$result_rows = mysql_affected_rows();
		if ($update_result1||$update_result2)
		{
			$result['result']=1;
			$result['list']=array('pid'=>$pid);
			$result['errormsg']=android_iconv_utf8('成功保存个人简历求职意向！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}else{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('保存个人简历求职意向失败！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
	}

	
	

	
}
?>