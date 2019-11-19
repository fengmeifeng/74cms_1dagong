<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset['id']=$aset['id']?intval($aset['id']):0;
$aset['brieflylen']=isset($aset['brieflylen'])?intval($aset['brieflylen']):200;
$wheresql=" WHERE id={$aset['id']} ";
$sql = "select * from ".table('jobs').$wheresql." LIMIT 1";
$val=$db->getone($sql);
if (empty($val))
	{
		$result['result']=0;
		$result['errormsg']=android_iconv_utf8('信息不存在！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	else
	{
			if ($val['setmeal_deadline']<time() && $val['setmeal_deadline']<>"0" && $val['add_mode']=="2")
			{
			$val['deadline']=$val['setmeal_deadline'];
			}
			$val['amount']=$val['amount']=="0"?'若干':$val['amount'];
			$val['amount']=android_iconv_utf8($val['amount']);
			$val['jobs_name']=android_iconv_utf8($val['jobs_name']);
			$val['companyname']=android_iconv_utf8($val['companyname']);
			$val['company_addtime']=date("Y-m-d",$val['company_addtime']);
			$val['nature_cn']=android_iconv_utf8($val['nature_cn']);
			$val['sex_cn']=android_iconv_utf8($val['sex_cn']);
			$val['category_cn']=android_iconv_utf8($val['category_cn']);
			$val['trade_cn']=android_iconv_utf8($val['trade_cn']);
			$val['district_cn']=android_iconv_utf8($val['district_cn']);
			$val['education_cn']=android_iconv_utf8($val['education_cn']);
			$val['experience_cn']=android_iconv_utf8($val['experience_cn']);
			$val['wage_cn']=android_iconv_utf8($val['wage_cn']);
			$val['contents']=android_iconv_utf8($val['contents']);
			$val['addtime']=date("Y-m-d",$val['addtime']);
			$val['deadline']=date("Y-m-d",$val['deadline']);
			$val['refreshtime']=date("Y-m-d",$val['refreshtime']);
			$val['setmeal_name']=android_iconv_utf8($val['setmeal_name']);
			$sql = "select * from ".table('jobs_contact')." where pid='{$aset['id']}' LIMIT 1";
			$contact=$db->getone($sql);
			$val['contact']=android_iconv_utf8($contact['contact']);
			$val['telephone']=android_iconv_utf8($contact['telephone']);
			$val['email']=android_iconv_utf8($contact['email']);
			$val['address']=android_iconv_utf8($contact['address']);
			$val['qq']=android_iconv_utf8($contact['qq']);
			if ($val['tag'])
			{
				$tag=explode('|',$val['tag']);
				$taglist=array();
				if (!empty($tag) && is_array($tag))
				{
					foreach($tag as $t)
					{
					$tli=explode(',',$t);
					$taglist[]=array($tli[0],android_iconv_utf8($tli[1]));
					}
				}
				$val['tag']=$taglist;
			}
			else
			{
			$val['tag']=array();
			}
	}
	$db->query("update ".table('jobs')." set click=click+1 WHERE id='{$aset['id']}'  LIMIT 1");
	$db->query("update ".table('jobs_search_hot')." set click=click+1 WHERE id='{$aset['id']}'  LIMIT 1");
unset($val['tag'],$val['key']);
$val=array_map('export_mystrip_tags',$val);
$androidresult['result']=1;
$androidresult['errormsg']='';
$androidresult['list']=$val;
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>