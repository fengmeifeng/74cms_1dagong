<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
function DeleteHtml($str) 
{ 
$str = trim($str); 
$str = strip_tags($str,""); 
$str = ereg_replace("\t","",$str); 
$str = ereg_replace("\r\n","",$str); 
$str = ereg_replace("\r","",$str); 
$str = ereg_replace("\n","",$str); 
$str = ereg_replace(" "," ",$str); 
return trim($str); 
}
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$id=isset($aset['id'])?trim($aset['id']):"";
	$id=addslashes($id);
	$id=iconv("utf-8",QISHI_DBCHARSET,$id);
	//echo $aset['id'];exit;
	if (empty($id))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该记录');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	$wheresql=" id = ".$id." LIMIT 1";
	$val = $db->getone("SELECT id,companyname,nature_cn,trade_cn,scale_cn,address,district_cn,addtime,refreshtime,company_desc FROM ".table('shenhe_jobs')."  WHERE ".$wheresql."");
	//echo "<pre>";print_r($list);exit;
	
		$val['addtime']=daterange(time(),$val['addtime'],'Y-m-d',"#FF3300");
		$val['refreshtime']=daterange(time(),$val['refreshtime'],'Y-m-d',"#FF3300");
		//$val['company_desc']=strip_tags(str_replace('&nbsp;','',$val['company_desc']));
		$val['company_desc']=DeleteHtml($val['company_desc']);
		//---ffff
		//$val['banner']="http://www.1dagong.com/files/img/ic_enterprise_phtot.png";
		//---fff
		if($val['banner']){
			$banner=explode('|',$val['banner']);
			$bannerlist=array();
				if (!empty($banner) && is_array($banner))
				{
					foreach($banner as $t)
					{
					$tli=explode(',',$t);
					$bannerlist[]=array($tli[0],$tli[1]);
					}
				}
				$val['banner']=$bannerlist;
			}else{
				$bannerlist=array("http://www.1dagong.com/files/img/ic_enterprise_phtot.png");
				$val['banner']=$bannerlist;
				}
			//---fff
		//---ffff
	//---fff
	$val=array_map('export_mystrip_tags',$val);
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=android_iconv_utf8_array($val);
	$jsonencode = android_iconv_utf8_array($result);
	//echo "<pre>";print_r($result);exit;
	$jsonencode = urldecode(json_encode($result));
	//exit($jsonencode);
	echo urldecode($jsonencode);
?>