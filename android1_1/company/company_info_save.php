<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset=array_map('addslashes',$aset);
require_once(ANDROID_ROOT_PATH.'include/common.user.inc.php');
if ($_SESSION['utype']<>'1')
{
	$result['result']=0;
	$result['list']=null;
	$result['errormsg']=android_iconv_utf8("请登录企业会员中心！");
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
}
else
{
	$uid=intval($_SESSION['uid']);
	$setsqlarr['uid']=intval($_SESSION['uid']);
	$company=get_company_info($_SESSION['uid']);
	if(!empty($aset['companyname'])){
		$setsqlarr['companyname']=trim($aset['companyname']);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('您没有输入企业名称！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	if(intval($aset['nature'])>0){
		$setsqlarr['nature']=intval($aset['nature']);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('您选择企业性质！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	$setsqlarr['nature_cn']=trim($aset['nature_cn']);
	if(intval($aset['trade'])>0){
		$setsqlarr['trade']=intval($aset['trade']);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('您选择所属行业！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	$setsqlarr['trade_cn']=trim($aset['trade_cn']);
	if(intval($aset['district'])>0){
		$setsqlarr['district']=intval($aset['district']);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('您选择所属地区！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	$setsqlarr['sdistrict']=intval($aset['sdistrict']);
	$setsqlarr['district_cn']=trim($aset['district_cn']);
	if (intval($aset['street'])>0)
	{
	$setsqlarr['street']=intval($aset['street']);
	$setsqlarr['street_cn']=trim($aset['street_cn']);
	}
	if (intval($aset['officebuilding'])>0)
	{
	$setsqlarr['officebuilding']=intval($aset['officebuilding']);
	$setsqlarr['officebuilding_cn']=trim($aset['officebuilding_cn']);
	}
	if(!empty($aset['scale'])){
		$setsqlarr['scale']=trim($aset['scale']);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('您选择公司规模！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	$setsqlarr['scale_cn']=trim($aset['scale_cn']);
	$setsqlarr['registered']=trim($aset['registered']);
	$setsqlarr['currency']=trim($aset['currency']);
	if(!empty($aset['address'])){
		$setsqlarr['address']=trim($aset['address']);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('请填写通讯地址！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	if(!empty($aset['contact'])){
		$setsqlarr['contact']=trim($aset['contact']);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('请填写联系人！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	if(!empty($aset['telephone'])){
		$setsqlarr['telephone']=trim($aset['telephone']);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('请填写联系电话！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	if(!empty($aset['email'])){
		$setsqlarr['email']=trim($aset['email']);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('请填写联系邮箱！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	$setsqlarr['website']=trim($aset['website']);
	if(!empty($aset['contents'])){
		$setsqlarr['contents']=trim($aset['contents']);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('请填写公司简介！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	$setsqlarr['yellowpages']=intval($aset['yellowpages']);
	if ($_CFG['company_repeat']=="0")
	{
		$info=$db->getone("SELECT uid FROM ".table('company_profile')." WHERE companyname ='{$setsqlarr['companyname']}' AND uid<>'{$_SESSION['uid']}' LIMIT 1");
		if(!empty($info))
		{
			$result['result']=0;
			$result['list']=null;
			$result['errormsg']=android_iconv_utf8("{$setsqlarr['companyname']}已经存在，同公司信息不能重复注册");
			$jsonencode = urldecode(json_encode($result));
			exit($jsonencode);
		}
	}
	if ($company)
	{
			$_CFG['audit_edit_com']<>"-1"?$setsqlarr['audit']=intval($_CFG['audit_edit_com']):'';
			if (updatetable(table('company_profile'), $setsqlarr," uid='{$uid}'"))
			{
				$jobarr['companyname']=$setsqlarr['companyname'];
				$jobarr['trade']=$setsqlarr['trade'];
				$jobarr['trade_cn']=$setsqlarr['trade_cn'];
				$jobarr['scale']=$setsqlarr['scale'];
				$jobarr['scale_cn']=$setsqlarr['scale_cn'];
				$jobarr['street']=$setsqlarr['street'];
				$jobarr['street_cn']=$setsqlarr['street_cn'];
				$jobarr['officebuilding']=$setsqlarr['officebuilding'];
				$jobarr['officebuilding_cn']=$setsqlarr['officebuilding_cn'];				
				if (!updatetable(table('jobs'),$jobarr," uid=".$setsqlarr['uid']."")) {
					$result['result']=0;
					$result['list']=null;
					$result['errormsg']=android_iconv_utf8('修改公司名称出错！');
					$jsonencode = urldecode(json_encode($result));
					exit($jsonencode);
				}
				if (!updatetable(table('jobs_tmp'),$jobarr," uid=".$setsqlarr['uid']."")){
					$result['result']=0;
					$result['list']=null;
					$result['errormsg']=android_iconv_utf8('修改公司名称出错！');
					$jsonencode = urldecode(json_encode($result));
					exit($jsonencode);
				} 
				if (!updatetable(table('jobfair_exhibitors'),array('companyname'=>$setsqlarr['companyname'])," uid=".$setsqlarr['uid']."")) {
					$result['result']=0;
					$result['list']=null;
					$result['errormsg']=android_iconv_utf8('修改公司名称出错！');
					$jsonencode = urldecode(json_encode($result));
					exit($jsonencode);
				}
				$soarray['trade']=$jobarr['trade'];
				$soarray['scale']=$jobarr['scale'];
				$soarray['street']=$setsqlarr['street'];
				$soarray['officebuilding']=$setsqlarr['officebuilding'];
				updatetable(table('jobs_search_scale'),$soarray," uid=".$setsqlarr['uid']."");
				updatetable(table('jobs_search_wage'),$soarray," uid=".$setsqlarr['uid']."");
				updatetable(table('jobs_search_rtime'),$soarray," uid=".$setsqlarr['uid']."");
				updatetable(table('jobs_search_stickrtime'),$soarray," uid=".$setsqlarr['uid']."");
				updatetable(table('jobs_search_hot'),$soarray," uid=".$setsqlarr['uid']."");
				updatetable(table('jobs_search_key'),$soarray," uid=".$setsqlarr['uid']."");
				write_memberslog($_SESSION['uid'],$_SESSION['utype'],8001,$aset['username'],"通过手机客户端修改企业资料");
				$result['result']=1;
				$result['list']=null;
				$result['errormsg']=android_iconv_utf8('保存成功！');
				$jsonencode = urldecode(json_encode($result));
				exit($jsonencode);
			}
			else
			{
				$result['result']=0;
				$result['list']=null;
				$result['errormsg']=android_iconv_utf8('保存失败！');
				$jsonencode = urldecode(json_encode($result));
				exit($jsonencode);
			}
	}
	else
	{
			$setsqlarr['audit']=intval($_CFG['audit_add_com']);
			$setsqlarr['addtime']=$timestamp;
			$setsqlarr['refreshtime']=$timestamp;
			if (inserttable(table('company_profile'),$setsqlarr))
			{
				write_memberslog($_SESSION['uid'],$_SESSION['utype'],8001,$aset['username'],"通过手机客户端完善企业资料");
				$result['result']=1;
				$result['list']=null;
				$result['errormsg']=android_iconv_utf8('保存成功！');
				$jsonencode = urldecode(json_encode($result));
				exit($jsonencode);
			}
			else
			{
				$result['result']=0;
				$result['list']=null;
				$result['errormsg']=android_iconv_utf8('保存失败！');
				$jsonencode = urldecode(json_encode($result));
				exit($jsonencode);
			}
	}
}
?>