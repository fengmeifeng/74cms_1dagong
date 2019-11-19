<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_GET;
$aset=array_map('addslashes',$aset);
//require_once(ANDROID_ROOT_PATH.'include/common.user.inc.php');
//$lt_x $lt_y 左边经度,纬度  rb_x rb_y右边经度,纬度
	$array = array();
	$lt_x = $aset['lt_x'];//左上角经度
	$lt_y = $aset['lt_y'];//左上角纬度
	$rb_x = $aset['rb_x'];//右下角经度
	$rb_y = $aset['rb_y'];//右下角纬度
	//$lat = $aset['map_y'];//纬度
	//$lon = $aset['map_x'];//经度
	$sql='select `id`,`jobs_name`,`companyname`,`company_id`,`wage_cn`,`refreshtime`,`map_x`,`map_y` from '.table("jobs").' where
	`map_y`>'.$lt_y.' and 
	`map_y`<'.$rb_y.' and
	`map_x`>'.$lt_x.' and
	`map_x`<'.$rb_x;
	
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