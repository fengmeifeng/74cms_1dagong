<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(ANDROID_ROOT_PATH.'include/fun_user.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$userid=isset($aset['userid'])?trim($aset['userid']):"";
	$userid=addslashes($userid);
	$userid=iconv("utf-8",QISHI_DBCHARSET,$userid);
	//echo $aset['userid'];exit;
	$page=isset($aset['page'])?trim($aset['page']):"";
	$page=addslashes($page);
	$page=iconv("utf-8",QISHI_DBCHARSET,$page);
	//echo $aset['page'];exit;
	$pagesize=isset($aset['pagesize'])?trim($aset['pagesize']):"";
	$pagesize=addslashes($pagesize);
	$pagesize=iconv("utf-8",QISHI_DBCHARSET,$pagesize);
	//echo $aset['pagesize'];exit;
	
	if (empty($userid))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该用户');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	//----获取总数
	$total_sql="SELECT COUNT(*) AS num FROM ".table('personal_favorites')." where personal_uid={$userid}";
	$total_val=$db->get_total($total_sql);
	//----获取总数结合苏
	//----fff---分页
	//$page 当前页数
	//$total_val 总条数
	//$pagesize 每页显示条数
	if(!$page) $page = 1;
	if(!$pagesize) $pagesize = 10;
	$maxpage = ceil($total_val / $pagesize);
	if($page > $maxpage) $page = $maxpage;
	$offset = ($page - 1) * $pagesize;	
	//$offset=$pagesize*($page-1);
	//----fff
	//echo $offset;exit;
	
	$res = $db->query("SELECT * FROM ".table('personal_favorites')." WHERE personal_uid='{$userid}' LIMIT {$offset},{$pagesize}");
	while($row = $db->fetch_array($res))
		{
			$list[] = $row;
		}
	if(empty($list)){
	$result['code']=-1;
	$result['errormsg']=android_iconv_utf8('收藏夹为空！');
	$jsonencode = json_encode($result);
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}else{
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=android_iconv_utf8_array($list);
	$jsonencode = android_iconv_utf8_array($result);
	$jsonencode = urldecode(json_encode($result));
	//exit($jsonencode);
	echo urldecode($jsonencode);
	}
?>