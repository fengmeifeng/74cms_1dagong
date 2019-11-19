<?php
 /*
 * 74cms 个人会员函数
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
function get_tiyan_type($wheresql)
{
	global $db;
	$result = $db->query("{$wheresql} LIMIT 30");
	$i=0;
	while($row = $db->fetch_array($result))
		{
			$i=$i+1;
			$row['i']=$i;
			$row_arr[] = $row;
		}
		return $row_arr;
}
function get_user_info($uid)
{
	global $db;
	$sql = "select * from ".table('members')." where uid = ".intval($uid)." LIMIT 1";
	return $db->getone($sql);
}

?>