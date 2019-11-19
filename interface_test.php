
<?php

// By Z
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);

$key=$_GET['key'];
$key=iconv('utf-8',QISHI_DBCHARSET,$_GET['key']);
$query='select * from qs_jobs where jobs_name like "%'.$key.'%"';
$res=$db->getone($query);
// var_dump($res);
// if(mysql_error()){
	// echo mysql_error();
// }else{
	// echo 'no error';
// }
$jsonres=json_encode($res);
echo $jsonres;
// echo $query;exit;

?>
