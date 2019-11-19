<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$orderbysql=" ORDER BY c_order desc";
	$wheresql=" WHERE c_alias = 'HY_wage'";
	//----获取总数
	//echo $wheresql;exit;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('category').$wheresql.$orderbysql;
	$total_val=$db->get_total($total_sql);
	//----获取总数结合苏
	//----fff---分页
	//$page 当前页数
	//$total_val 总条数
	//$pagesize 每页显示条数
	if(!$page) $page = 1;
	if(!$pagesize) $pagesize = 10;
	$maxpage = ceil($total_val / $pagesize);
	if($maxpage>0)
	{
		if($page > $maxpage) $page = $maxpage;
	}
	$offset = ($page - 1) * $pagesize;
	//$offset=$pagesize*($page-1);
	//----fff
	//echo $offset;exit;
	//echo "SELECT * FROM ".table('category').$wheresql.$orderbysql." LIMIT {$offset},{$pagesize}";exit;
	$res = $db->query("SELECT c_id as wage,c_name as wage_cn FROM ".table('category').$wheresql.$orderbysql." LIMIT {$offset},{$pagesize}");
	//echo $row = @mysql_fetch_array($res);exit;
	while($row = $db->fetch_array($res))
		{
			$list[] = $row;
		}
	//echo "<pre>";print_r($list);exit;
		$result['code']=1;
		$result['errormsg']='';
		$result['data']=android_iconv_utf8_array($list);
		$jsonencode = android_iconv_utf8_array($result);
		$jsonencode = urldecode(json_encode($result));
		//exit($jsonencode);
		echo urldecode($jsonencode);
	
?>