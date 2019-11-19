<?php
 /*
 * 74cms 会员注册
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
$alias="QS_login";
require_once(dirname(__FILE__).'/../../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/fun_zt.php');
//require_once(dirname(__FILE__) . '/zt_common.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$smarty->cache = false;
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'tiyanyuan';
if ($act=='tiyanyuan')
{
	//echo "体验员模块";exit;
	$sql_company='';
	///------fffff
	$sql="select * from zt_tiyan_type order by id desc";
	$tiyan_type=get_tiyan_type($sql);
	//echo "<pre>";print_r($tiyan_type);exit;
	$smarty->assign('tiyan_type',$tiyan_type);
	$smarty->assign('tiyan_type1',$tiyan_type);
	//echo $sql;exit;
	$smarty->display('zt/tiyanyuan.htm');
}
elseif($act == 'shangchuan')
{
	//echo "这里是上传文件";exit;
	$uptypes1=array(
	'application/msword',
	'application/vnd.ms-powerpoint',
	'application/vnd.ms-excel',
	'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
	'application/vnd.openxmlformats-officedocument.presentationml.presentation'
	);
	
	$max_file_size=20000000;   //上传文件大小限制, 单位BYTE
	$path_parts=pathinfo($_SERVER['PHP_SELF']); //取得当前路径
	$time=time();
	$destination_folder=date("Y",$time).'/'; //上传文件路径
	$destination_folder .=date("m",$time).'/'; //上传文件路径
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if (!is_uploaded_file($_FILES["upfile"][tmp_name][0]))
		//是否存在文件
		{
		echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"视频文件没有上传\");\r\n";   echo " history.back();\r\n";   echo "</script>";
							exit;  
		}
		$file = $_FILES["upfile"];
		if($max_file_size < $file["size"][0])
		 //检查文件大小
		{
			echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"视频文件太大！\");\r\n";   echo " history.back();\r\n";   echo "</script>";
			exit;  
		}
		if(!in_array($file["type"][0], $uptypes1))  
		//检查文件类型  
		{  
			echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"视频文件类型不符！\");\r\n";   echo " history.back();\r\n";   echo "</script>";
						exit;  
		}
		if(!file_exists($destination_folder))
		if(!mkdir($destination_folder,0777,true)){
			echo "<font color='red'>您创建目录失败,请手动创建！</a>";
		}
		$filename1=$file["tmp_name"][0];
		$pinfo1=pathinfo($file["name"][0]);
		$ftype1=$pinfo1[extension];
		$firstname='体验报告';
		$destination1 = $destination_folder.$firstname."doc".date('Y-m-d',time()).".".$ftype1;
		if (file_exists($destination1) && $overwrite != true)
		{
			 echo "<font color='red'>相同文件已经存在了！</a>";
			 exit;
		}
		if(!move_uploaded_file ($filename1, $destination1))
		{
			echo "<font color='red'>移动文件出错！</a>";
			exit;
		}
		echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"上传成功！稍后等我们会联系您！\");\r\n";   echo " history.back();\r\n";   echo "</script>";
		
	}
	//$smarty->assign('contents',$val['contents']);
}
elseif($act == 'chakan')
{
	$id=intval($_GET['id']);
	$sql = "select * from zt_qx where id = ".$id." LIMIT 1";
	$val=$db->getone($sql);
	$smarty->assign('time',date('Y-m-d',$val['addtime']));
	$smarty->assign('to',$val['to']);
	$smarty->assign('from',$val['from']);
	$smarty->assign('bg',$val['bg']);
	$smarty->assign('contents',$val['contents']);
	$smarty->display('zt/qixi.htm');
}
unset($smarty);
?>