<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$id=isset($aset['id'])?trim($aset['id']):"";
	$id=addslashes($id);
	$id=iconv("utf-8",QISHI_DBCHARSET,$id);
	//echo $aset['id'];exit;
	function DeleteHtml($str) 
	{ 
	$str = trim($str); 
	$str = strip_tags($str,""); 
	$str = ereg_replace("\t","",$str); 
	$str = ereg_replace("\r\n","",$str); 
	$str = ereg_replace("\r","",$str); 
	$str = ereg_replace("\n","",$str);
	$str = ereg_replace("&nbsp;","",$str); 
	$str = ereg_replace(" ","",$str); 
	return trim($str); 
	}
	if (empty($id))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该记录');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	$wheresql=" id = ".$id." LIMIT 1";
	$val = $db->getone("SELECT id,companyname,tag,category_cn,wage_cn,zprenshu,age_cn,sex_cn,education_cn,experience_cn,logo,addtime,refreshtime,bmrenshu,contents FROM ".table('shenhe_jobs')."  WHERE ".$wheresql."");
	//echo "<pre>";print_r($list);exit;
	//---fff
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
		$val['addtime']=daterange(time(),$val['addtime'],'Y-m-d',"#FF3300");
		$val['refreshtime']=daterange(time(),$val['refreshtime'],'Y-m-d',"#FF3300");
		$val['contents']=DeleteHtml($val['contents']);
		$val['logo']="http://www.1dagong.com/data/hymq_img/".$val['logo'];
		$val['qq1']='2967555605';
		$val['qq2']='1905131809';
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