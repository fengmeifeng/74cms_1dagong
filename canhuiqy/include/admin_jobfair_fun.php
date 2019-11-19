<?php
 /*
 * 74cms 招聘会
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
function get_jobfair($offset, $perpage, $sql='')
{
	global $db;
	$row_arr = array();
	if(empty($offset) || empty($perpage)){$limit=='';}else{	$limit=" LIMIT ".$offset.','.$perpage;}
	//echo "SELECT * FROM ".table('jobfair')." ".$sql." ".$limit;exit;
	$result = $db->query("SELECT * FROM ".table('jobfair')." ".$sql." ".$limit);
	while($row = $db->fetch_array($result))
	{
	$color = $row['color'] ? "color:".$row['color'].";" : '';
	$weight = $row['weight']>0 ? "font-weight:bold;" : '';
	if  ($color || $weight)
	{
	$row['title']="<span style=\"{$color}{$weight}\">{$row['title']}</span>";
	}
	$row_arr[] = $row;
	}	
	//echo "<pre>";print_r($row_arr);exit;
	return $row_arr;
}
function get_jobfair_display()
{
	global $db;
	$info = $db->getall("SELECT * FROM ".table('jobfair')." WHERE display=1  order BY `order` DESC,id DESC");
	return $info;
}
function get_jobfair_audit()
{
	global $db;
	$info = $db->getall("SELECT * FROM ".table('jobfair')." WHERE display=1 AND predetermined_status=1 AND holddates>".time()." order BY `order` DESC,id DESC");
	return $info;
}
function del_jobfair($id)
{
	global $db;
	if(!is_array($id)) $id=array($id);
	$return=0;
	$sqlin=implode(",",$id);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		if (!$db->query("Delete from ".table('jobfair')." WHERE id IN (".$sqlin.")")) return false;
		$return=$return+$db->affected_rows();
	}
	return $return;
}
function get_jobfair_exhibitors($offset, $perpage, $sql= '')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT ".$offset.','.$perpage;
	$result = $db->query("SELECT j.*,c.telephone,c.address,c.contact FROM ".table('jobfair_exhibitors')." as j left join ".table('company_profile')." as c on c.uid=j.uid ".$sql." ".$limit);
	while($row = $db->fetch_array($result))
	{
	if ($row['uid']>0 && $row['company_id']>0)
	{
	$row['company_url']=url_rewrite('QS_companyshow',array('id'=>$row['company_id']));
	}
	else
	{
	$row['company_url']="";
	}	
	$row['jobfair_url']=url_rewrite('QS_jobfairshow',array('id'=>$row['jobfairid']));
	$row_arr[] = $row;
	}
	return $row_arr;
}
/*//------备份
function get_jobfair_exhibitors($offset, $perpage, $sql= '')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT ".$offset.','.$perpage;
	$result = $db->query("SELECT * FROM ".table('jobfair_exhibitors')." ".$sql." ".$limit);
	while($row = $db->fetch_array($result))
	{
	if ($row['uid']>0 && $row['company_id']>0)
	{
	$row['company_url']=url_rewrite('QS_companyshow',array('id'=>$row['company_id']));
	}
	else
	{
	$row['company_url']="";
	}	
	$row['jobfair_url']=url_rewrite('QS_jobfairshow',array('id'=>$row['jobfairid']));
	$row_arr[] = $row;
	}
	return $row_arr;
}*/
function del_exhibitors($id)
{
	global $db;
	if(!is_array($id)) $id=array($id);
	$return=0;
	$sqlin=implode(",",$id);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		if (!$db->query("Delete from ".table('jobfair_exhibitors')." WHERE id IN (".$sqlin.")")) return false;
		$return=$return+$db->affected_rows();
	}
	return $return;
}
function edit_exhibitors_audit($id,$audit)
{
	global $db;
	if (!is_array($id))$id=array($id);
	$return=0;
	$sqlin=implode(",",$id);	
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		if (!$db->query("update  ".table('jobfair_exhibitors')." SET audit='".intval($audit)."'  WHERE id IN (".$sqlin.")")) return false;
		$return=$return+$db->affected_rows();
	}
	return $return;
}
?>