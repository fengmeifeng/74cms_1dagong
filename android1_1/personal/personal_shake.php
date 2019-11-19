<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_GET;
$aset=array_map('addslashes',$aset);
//require_once(ANDROID_ROOT_PATH.'include/common.user.inc.php');

	$array = array();
	$lat = $aset['map_y'];//纬度
	$lon = $aset['map_x'];//经度
	$sql='select `id`,`jobs_name`,`companyname`,`wage_cn`,`refreshtime` from '.table("jobs").' where
	`map_y` > '.$lat.'-1 and
	`map_y` < '.$lat.'+1 and
	`map_x` > '.$lon.'-1 and
	`map_x` < '.$lon.'+1 and
	`deadline`>'.$timestamp.'
	order by ACOS(SIN(('.$lat.' * 3.1415) / 180 ) *SIN((`map_y` * 3.1415) / 180 ) +COS(('.$lat.' * 3.1415) / 180 ) * COS((`map_y` * 3.1415) / 180 ) *COS(('.$lon.'* 3.1415) / 180 - (`map_x` * 3.1415) / 180 ) ) * 6380 asc limit 20';
	
	$mysql_result = $db->query($sql);
	while($row = $db->fetch_array($mysql_result)){
		foreach($row as $k=>$v){
			$row[$k] = iconv("gbk","utf-8",$v);
		}
		$array[] = $row;
	}
	if(!empty($array)){
		$result['result']=1;
		$result['list']=$array;
		$result['errormsg']=android_iconv_utf8('获取数据成功！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}else{
		$result['result']=0;
		$result['list']=null;
		$result['errormsg']=android_iconv_utf8('获取数据失败！');
		$jsonencode = urldecode(json_encode($result));
		exit($jsonencode);
	}
	
?>