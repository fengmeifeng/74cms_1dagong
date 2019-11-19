<?php
 /*
 * 74cms 管理中心 广告广利函数
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
 if(!defined('IN_QISHI'))
 {
 	die('Access Denied!');
 }
 //获取广告列表
function get_ad_list($offset,$perpage,$get_sql= '')
{
	global $db;
	$limit=" LIMIT ".$offset.','.$perpage;
	$info = $db->getall("SELECT a.*,c.categoryname FROM ".table('ad')." AS a ".$get_sql." order BY a.show_order DESC,a.id DESC ".$limit);
	return $info;
}
//获取广告(单个)
function get_ad_one($val)
{
	global $db;
	$sql = "select * from ".table('ad')." where id=".intval($val). " LIMIT 1";
	$arr=$db->getone($sql);
	$arr['starttime']=$arr['starttime']=="0"?'':convert_datefm($arr['starttime'],1);
	$arr['deadline']=$arr['deadline']=="0"?'':convert_datefm($arr['deadline'],1);
	return $arr;
}

//获取广告位
function get_ad_category($type=NULL)
{
	global $db;
	if ($type) $wheresql=" where  type_id=".intval($type).""; 
	$sql = "select * from ".table('ad_category').$wheresql." order BY id asc";
	$info = $db->getall($sql);
	return $info;
}
//获取广告位(单个)
function get_ad_category_one($id)
{
	global $db;
	$sql = "select * from ".table('ad_category')." where id=".intval($id);
	$category_one=$db->getone($sql);
	return $category_one;
}
function del_ad($id)
{
	global $db;
	$return=0;
	if (!is_array($id))$id=array($id);
	$sqlin=implode(",",$id);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
	if (!$db->query("Delete from ".table('ad')." WHERE id IN (".$sqlin.") ")) return false;
	$return=$return+$db->affected_rows();
	}
	return $return;
}
function del_ad_category($id)
{
global $db;
if (!$db->query("Delete from ".table('ad_category')." WHERE id  = ".intval($id)." AND admin_set<>'1'")) return false; 
return true;
}
function ck_category_alias($alias,$noid=NULL){
global $db;
	if ($noid)
	{
	$wheresql=" AND id<>'".intval($noid)."'";
	}
$sql = "select id from ".table('ad_category')." WHERE alias='".$alias."'".$wheresql;
$info=$db->getone($sql);
 if ($info)
 {
 return true;
 }
 else
 {
 return false;
 }
}

//广告位订单列表
function get_adv_order_list($offset,$perpage,$get_sql= '')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT ".$offset.','.$perpage;
	$result = $db->query("SELECT o.*,m.username,m.email,c.companyname FROM ".table('adv_order')." as o ".$get_sql.$limit);
	while($row = $db->fetch_array($result))
	{
		if($row['is_points']=="0"){
			$row['payment_name']=get_adv_payment_info($row['payment_name'],true);
		}
		if($row['is_points']=="1"){
			$row['amount']=intval($row['amount']);
		}
	$row_arr[] = $row;
	}
	return $row_arr;
}
//获取订单
function get_adv_order_one($id=0)
{
	global $db;
	$sql = "select * from ".table('adv_order')." where id=".intval($id)." LIMIT 1";
	$val=$db->getone($sql);
	if($val['is_points']=="0"){
		$val['payment_name']=get_adv_payment_info($val['payment_name'],true);
	}
	$val['payment_username']=get_adv_user($val['uid']);
	return $val;
}
//取消订单
function del_adv_order($id)
{
	global $db;
	if (!is_array($id))$id=array($id);
	$sqlin=implode(",",$id);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		if (!$db->query("Delete from ".table('adv_order')." WHERE id IN (".$sqlin.")  AND is_paid=1 ")) return false;		
		return true;
	}
	return false;
}
//获取充值支付方式名称
function get_adv_payment_info($typename,$name=false)
{
	global $db;
	$sql = "select * from ".table('payment')." where typename ='".$typename."'";
	$val=$db->getone($sql);
	if ($name)
	{
	return $val['byname'];
	}
	else
	{
	return $val;
	}
}
function get_adv_user($uid)
{
	global $db;
	$sql = "select * from ".table('members')." where uid=".intval($uid)." LIMIT 1";
	return $db->getone($sql);
}
//付款后开通
function adv_order_paid($v_oid)
{
	global $db,$timestamp,$_CFG;
	$order=$db->getone("select * from ".table('adv_order')." WHERE oid ='{$v_oid}' AND is_paid= '1' LIMIT 1 ");
	if ($order)
	{
		$user=get_adv_user($order['uid']);
		$sql = "UPDATE ".table('adv_order')." SET is_paid= '2',payment_time='{$timestamp}' WHERE oid='{$v_oid}' LIMIT 1 ";
		if (!$db->query($sql)) return false;
			
		//发送邮件
		$mailconfig=get_cache('mailconfig');
		if ($mailconfig['set_payment']=="1" && $user['email_audit']=="1")
		{
		dfopen($_CFG['site_domain'].$_CFG['site_dir']."plus/asyn_mail.php?uid=".$order['uid']."&key=".asyn_userkey($order['uid'])."&act=set_payment");
		}
		//发送邮件完毕
		//sms
		$sms=get_cache('sms_config');
		if ($sms['open']=="1" && $sms['set_payment']=="1"  && $user['mobile_audit']=="1")
		{
		dfopen($_CFG['site_domain'].$_CFG['site_dir']."plus/asyn_sms.php?uid=".$order['uid']."&key=".asyn_userkey($order['uid'])."&act=set_payment");
		}
		//sms
		return true;
	}
return true;
}
?>