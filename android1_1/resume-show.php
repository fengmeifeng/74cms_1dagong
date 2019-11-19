<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
	$username=isset($aset['username'])?trim($aset['username']):"";
	$password=isset($aset['userpwd'])?trim($aset['userpwd']):"";
	$username=addslashes($username);
	$password=addslashes($password);
	$username=iconv("utf-8",QISHI_DBCHARSET,$username);
	$password=iconv("utf-8",QISHI_DBCHARSET,$password);
	$account_type=1;
	if (preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$username))
	{
	$account_type=2;
	}
	elseif (preg_match("/^(13|15|18)\d{9}$/",$username))
	{
	$account_type=3;
	}
if ($username && $password)
{
user_login($username,$password);
}
$aset['id']=$aset['id']?intval($aset['id']):0;
//$aset['id']=138;
$wheresql=" WHERE  id='{$aset['id']}' ";
$tb1=$db->getone("select * from ".table('resume').$wheresql." LIMIT  1");
if (!empty($tb1))
{
$val=$tb1;
}
else
{
$val=$db->getone("select * from ".table('resume_tmp').$wheresql." LIMIT  1");
}
if (empty($val))
	{
		$result['result']=0;
		$result['errormsg']=android_iconv_utf8('信息不存在！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	else
	{
		if ($val['display_name']=="2")
		{
			$val['fullname']="N".str_pad($val['id'],7,"0",STR_PAD_LEFT);	
		}
		elseif($val['display_name']=="3")
		{
			$val['fullname']=cut_str($val['fullname'],1,0,"**");
		}
		else
		{
			$val['fullname']=$val['fullname'];
		}
		$val['age']=date("Y")-$val['birthdate'];
		$val['tagcn']=preg_replace("/\d+/", '',$val['tag']);
		$val['tagcn']=preg_replace('/\,/','',$val['tagcn']);
		$val['tagcn']=preg_replace('/\|/','&nbsp;&nbsp;&nbsp;',$val['tagcn']);
		$val['addtime']=date("Y-m-d",$val['addtime']);
		$val['refreshtime']=date("Y-m-d",$val['refreshtime']);
		unset($val['key'],$val['subsite_id'],$val['display'],$val['display_name'],$val['title'],$val['title']);
	}
$androidresult['result']=1;
$androidresult['errormsg']='';
$androidresult['list']=android_iconv_utf8_array($val);
$androidresult['education_list']=android_iconv_utf8_array(get_this_education($val['uid'],$val['id']));
$androidresult['work_list']=android_iconv_utf8_array(get_this_work($val['uid'],$val['id']));
$androidresult['training_list']=android_iconv_utf8_array(get_this_training($val['uid'],$val['id']));
$androidresult['resume_contact']=android_iconv_utf8_array(resume_contact($val['id']));
$db->query("update ".table('resume')." set click=click+1 WHERE id='{$aset['id']}'  LIMIT 1");
$db->query("update ".table('resume_tmp')." set click=click+1 WHERE id='{$aset['id']}'  LIMIT 1");
$androidresult=array_map('export_mystrip_tags',$androidresult);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
function get_this_education($uid,$pid)
{
	global $db;
	$sql = "SELECT * FROM ".table('resume_education')." WHERE uid='".intval($uid)."' AND pid='".intval($pid)."' ";
	return $db->getall($sql);
}
function get_this_work($uid,$pid)
{
	global $db;
	$sql = "select * from ".table('resume_work')." where uid=".intval($uid)." AND pid='".$pid."' " ;
	return $db->getall($sql);
}
function get_this_training($uid,$pid)
{
	global $db;
	$sql = "select * from ".table('resume_training')." where uid='".intval($uid)."' AND pid='".intval($pid)."'";
	return $db->getall($sql);
}
function resume_contact($id)
{
	global $db,$_CFG;
 		$id=intval($id);
		$show=false;
		if($_CFG['showresumecontact']=='0')
		{
		$show=true;
		}
		elseif($_CFG['showresumecontact']=='1')
		{
			if ($_SESSION['uid'] && $_SESSION['username'] && $_SESSION['utype']=='1')
			{
			$show=true;
			}
			else
			{
			$show=false;
			}
		}
		elseif($_CFG['showresumecontact']=='2')
		{
			if ($_SESSION['username'] && $_SESSION['utype']=='1')
			{
				$sql = "select did from ".table('company_down_resume')." WHERE company_uid = {$_SESSION['uid']} AND resume_id='{$id}' LIMIT 1";
				$info=$db->getone($sql);
			 	if (!empty($info))
				{
				$show=true;
				}
				else
				{
				$show=false;
				}
			}
			else
			{
			$show=false;
			}
		}
		if ($show)
		{
			$tb1=$db->getone("select fullname,telephone,email,qq,address,website from ".table('resume')." WHERE  id='{$id}'  LIMIT 1");
			$tb2=$db->getone("select fullname,telephone,email,qq,address,website from ".table('resume_tmp')." WHERE  id='{$id}'  LIMIT 1");		
			$val=!empty($tb1)?$tb1:$tb2;
			return array('fullname'=>$val['fullname'],'telephone'=>$val['telephone'],'email'=>$val['email'],'qq'=>$val['qq'],'address'=>$val['address'],'website'=>$val['website']);
		}
		else
		{
		return 'null';
		}
}
?>