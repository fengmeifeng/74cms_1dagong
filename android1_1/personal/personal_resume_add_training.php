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
	$uid = $_SESSION['uid'];
	$pid = intval($aset['pid']);
	if($aset['act']=="add"){
		$resume_search = $db->query("select * from ".table('resume_training')." where `pid`=".$pid);
		while($row = $db->fetch_array($resume_search)){
			$return_data_arr[] = $row;
		}
		foreach($return_data_arr as $k=>$v){
			foreach($v as $k1=>$v1){
				$arr1[$k][$k1] = android_iconv_utf8($v1);
			}
		}
		$return_data_json = json_encode($arr1);
		$result['result']=1;
		$result['list']=$return_data_json;
		$result['errormsg']=android_iconv_utf8('获取数据成功');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	
	// if($aset['act']=="add"){
		// $eid = intval($aset['eid']);
		// $resume_search = $db->query("select * from ".table('resume_education')." where `id`=".$eid);
		// $return_data_arr = $db->fetch_array($resume_search);
		// foreach($return_data_arr as $k=>$v){
			// $arr1[$k] = android_iconv_utf8($v);
		// }
		// $return_data_json = json_encode($arr1);
		// $result['result']=1;
		// $result['list']=$return_data_json;
		// $result['errormsg']=android_iconv_utf8('获取数据成功');
		// $jsonencode = urldecode(json_encode($result));
		// exit($jsonencode);
	// }
	if($aset['act']=="save"){
		$eid = intval($aset['eid']);
		$aset['pid']=intval($pid);
		$aset['uid']=intval($uid);
		$setsqlarr['pid']=trim($aset['pid']);
		$setsqlarr['uid']=trim($aset['uid']);
		$setsqlarr['start']=trim($aset['start']);
		$setsqlarr['endtime']=trim($aset['endtime']);
		$setsqlarr['agency']=trim($aset['agency']);
		$setsqlarr['course']=trim($aset['course']);
		$setsqlarr['description']=trim($aset['description']);
		if (empty($setsqlarr['start']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('请选择工作开始时间！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['endtime']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('请选择工作结束时间！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['agency']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('培训机构不能为空！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['course']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('培训课程不能为空！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		
		if($eid==0){
			$update_result=inserttable(table('resume_training'),$setsqlarr,1);
		}else{
			$wheresql = "`id`=".$eid;
			$update_result=updatetable(table('resume_training'),$setsqlarr,$wheresql);
		}
		check_resume($uid,$pid);
		//$update_result=$db->query("UPDATE qs_resume_tmp SET fullname = '".$setsqlarr['fullname']."' where id=".$pid);
		//$result_rows = mysql_affected_rows();
		if ($update_result)
		{
			$result['result']=1;
			$result['list']=array('pid'=>$pid);
			$result['errormsg']=android_iconv_utf8('成功保存个人简历培训经历！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}else{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('保存个人简历培训经历失败！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
	}
	if($aset['act']=="delete"){
		$eid = intval($aset['eid']);
		$delete_source = $db->query("delete from ".table('resume_training')." where id=".$eid);
		if($delete_source){
			$result['result']=1;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('删除数据成功');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
	}

	
}
?>