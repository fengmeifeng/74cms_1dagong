<?php
 /*
 * 74cms 共用配置文件（手机客户端）
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('ANDROID_CHARSET', 'utf-8');
define('ANDROID_KEY', 'S7T5M5V0L61f5Xsu');
if(!defined('IN_QISHI')) exit('Access Denied!');
define('QISHI_ROOT_PATH',dirname(dirname(dirname(__FILE__))).'/');
define('ANDROID_ROOT_PATH',dirname(dirname(__FILE__)).'/');
error_reporting(E_ERROR);
ini_set('session.save_handler', 'files');
session_save_path(QISHI_ROOT_PATH.'data/sessions/');
session_start();
require_once(QISHI_ROOT_PATH.'data/config.php');
require_once(ANDROID_ROOT_PATH.'include/common.fun.php');
header("Content-Type:text/html;charset=".ANDROID_CHARSET);
date_default_timezone_set("PRC");
$_CFG=get_cache('config');//var_dump($_GET);die;
$getarr = addslashes_deep(clear_addslashes_deep($_GET));
// var_dump($getarr);exit;
//$j = json_encode($get_info );
foreach($getarr as $k=>$v){
	$_REQ[$k]=iconv("utf-8",QISHI_DBCHARSET,$v);
}
// var_dump($_REQ);exit;
$androidkey = $_REQ['androidkey'];
$username = $_REQ['username'];
$userpwd = $_REQ['userpwd'];
//$_REQ=clear_addslashes_deep($_GET['user_info']);
//$_REQ=json_decode($_REQ,true);
//$_REQ=addslashes_deep($_REQ);
$timestamp=time();
//$a=var_export($_POST, true);
//@file_put_contents('1.txt', '1'.$a, LOCK_EX);
// $result['result']=0;
// $result['errormsg']=android_iconv_utf8('key错误，服务器拒绝了您的请求！');
// $jsonencode = urldecode(json_encode($result));
// exit($jsonencode);
if ($androidkey<>ANDROID_KEY)
{
// echo 'zwlnook';exit;
$result['result']=0;
$result['errormsg']=android_iconv_utf8('key错误，服务器拒绝了您的请求！');
$jsonencode = urldecode(json_encode($result));
exit($jsonencode);
}
?>