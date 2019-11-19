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
	
	$uid = intval($_SESSION['uid']);
	if($aset['act']=="add"){
		$pid = intval($aset['pid']);
		$resume_search = $db->query("select `title`,`fullname`,`sex`,`sex_cn`,`education`,`education_cn`,`marriage`,`marriage_cn`,`birthdate`,`householdaddress`,`experience`,`experience_cn`,`address`,`email`,`telephone`,`complete_percent` from ".table('resume')." where `id`=".$pid);
		$return_data_arr = $db->fetch_array($resume_search);
		if(!$return_data_arr){
			$resume_search = $db->query("select `title`,`fullname`,`sex`,`sex_cn`,`education`,`education_cn`,`marriage`,`marriage_cn`,`birthdate`,`householdaddress`,`experience`,`experience_cn`,`address`,`email`,`telephone`,`complete_percent` from ".table('resume_tmp')." where `id`=".$pid);
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
	elseif($aset['act']=="save"){
		$setsqlarr['title']=trim($aset['title']);
		$aset['birthdate']=date('Y',strtotime($aset['birthdate']));
		$setsqlarr['fullname']=trim($aset['fullname']);
		$setsqlarr['sex_cn']=trim($aset['sex_cn']);
		$setsqlarr['sex']=$setsqlarr['sex_cn']=="男"?1:2;
		$setsqlarr['education']=trim($aset['education']);
		$setsqlarr['education_cn']=trim($aset['education_cn']);
		$setsqlarr['marriage_cn']=trim($aset['marriage_cn']);
		$setsqlarr['marriage']=$setsqlarr['marriage_cn']=="未婚"?1:($setsqlarr['marriage_cn']=="已婚"?2:3);
		$setsqlarr['birthdate']=trim($aset['birthdate']);
		$setsqlarr['householdaddress']=trim($aset['householdaddress']);
		$setsqlarr['experience']=trim($aset['experience']);
		$setsqlarr['experience_cn']=trim($aset['experience_cn']);
		$setsqlarr['address']=trim($aset['address']);
		$setsqlarr['telephone']=trim($aset['telephone']);
		if (empty($setsqlarr['title']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('简历名称不能为空！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['fullname']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('姓名不能为空！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['birthdate']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('请选择出生日期！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['householdaddress']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('户籍地址不能为空！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['experience']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('请选择工作经验！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		
		if (empty($setsqlarr['address']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('通讯地址不能为空！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if (empty($setsqlarr['telephone']))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8('联系电话不能为空！');
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
		if(isset($aset['pid'])){
			$pid = intval($aset['pid']);
			$wheresql = "`id`=".$pid;
			$setsqlarr['audit']=intval($_CFG['audit_edit_resume']);
			$update_result1=updatetable(table('resume'),$setsqlarr,$wheresql);
			$update_result2=updatetable(table('resume_tmp'),$setsqlarr,$wheresql);
			check_resume($uid,$pid);
			//$update_result=$db->query("UPDATE qs_resume_tmp SET fullname = '".$setsqlarr['fullname']."' where id=".$pid);
			//$result_rows = mysql_affected_rows();
			if ($update_result1||$update_result2)
			{
				$result['result']=1;
				$result['list']=array('pid'=>$pid);
				$result['errormsg']=android_iconv_utf8('成功保存个人简历基本信息！');
				$jsonencode = urldecode(json_encode($result));
				exit($jsonencode);
			}else{
				$result['result']=0;
				$result['list']=null;
				$result['errormsg']=android_iconv_utf8('保存个人简历基本信息失败！');
				$jsonencode = urldecode(json_encode($result));
				exit($jsonencode);
			}
		}else{
			$setsqlarr['audit']=intval($_CFG['audit_resume']);
			$setsqlarr['uid']=intval($uid);
			$pid=inserttable(table('resume_tmp'),$setsqlarr,1);
			check_resume($uid,$pid);
			//$update_result=$db->query("UPDATE qs_resume_tmp SET fullname = '".$setsqlarr['fullname']."' where id=".$pid);
			//$result_rows = mysql_affected_rows();
			if ($pid>0)
			{
				$result['result']=1;
				$result['list']=array('pid'=>$pid);
				$result['errormsg']=android_iconv_utf8('成功创建简历！');
				$jsonencode = urldecode(json_encode($result));
				exit($jsonencode);
			}else{
				$result['result']=0;
				$result['list']=null;
				$result['errormsg']=android_iconv_utf8('创建简历失败！');
				$jsonencode = urldecode(json_encode($result));
				exit($jsonencode);
			}
		}
		
		
	}

	
	

	
}
?>