<?php
 /*
 * 查看报名
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../../include/common.inc.php');
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : '';
require_once(dirname(__FILE__).'/../../include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
if($act == 'zhuangtai'){
$name=trim($_POST['name']);
$phone1=trim($_POST['phone1']);
$identity_id=trim($_POST['identity_id']);
	if($name && $phone1 && $identity_id)
	{
		$sql="select * from qs_baoming where name='{$name}' and phone1 = '{$phone1}' and identity_id = '{$identity_id}'";
		//echo $sql;exit;
		$res=$db->getone($sql);
		//print_r($res);exit;
		if($res)///-----返回
		{
			
			if($res['status'] == 1){
				//echo "您的报考已经审核通过了";
				include("tongguo.html");exit;
			}elseif($res['status'] == 0){
				//echo "您报名填写的信息还没有审核，请耐心等待。";
				//include("tongguo.html");exit;
				include("weitongguo.html");exit;
			}
			elseif($res['status'] == 2){
				include("weitongguo.html");exit;
				//echo "您报名填写的信息审核没有通过请点击此处修改资料";
			}
			
			
		}else{///---
			echo "<script language=\"JavaScript\">\r\n";echo "alert(\"填写信息错误或者用户不存在！\");\r\n";echo " history.back();\r\n"; echo "</script>";	
		}
		//print_r($res);exit;
	}else
	{
		echo "<script language=\"JavaScript\">\r\n";echo "alert(\"请把信息填写完整后再查询\");\r\n";echo " history.back();\r\n";   echo "</script>";
	}
	
}
if($act == 'gaixinxi')
{
	$id=$_REQUEST['id'];
	if($id)
	{
		$sql="select * from qs_baoming where id='{$id}'";
		//echo $sql;exit;
		$res=$db->getone($sql);
		include("gaixinxi.html");
	}
}
if($act == 'xinxigai'){
$name=trim($_POST['name']);
$phone1=trim($_POST['phone1']);
$identity_id=trim($_POST['identity_id']);
	if($name && $phone1 && $identity_id)
	{
		$sql="select * from qs_baoming where name='{$name}' and phone1 = '{$phone1}' and identity_id = '{$identity_id}'";
		//echo $sql;exit;
		$res=$db->getone($sql);
		//print_r($res);exit;
		if($res)///-----返回
		{
			
			if($res['status'] == 1){
				//echo "您的报考已经审核通过了";
				echo "<script language=\"JavaScript\">\r\n";echo "alert(\"您已经通过审核，不需要修改资料了！\");\r\n";echo " history.back();\r\n";   echo "</script>";exit;
			}
			if($res['status'] == 0 || $res['status'] == 2)
			{
				
				$id=$res['id'];
				if($id)
				{
					$sql="select * from qs_baoming where id='{$id}'";
					//echo $sql;exit;
					$res=$db->getone($sql);
					include("gaixinxi.html");
				}
			}
			
		}else{///---
			echo "<script language=\"JavaScript\">\r\n";echo "alert(\"填写信息错误或者用户不存在！\");\r\n";echo " history.back();\r\n"; echo "</script>";	
		}
		//print_r($res);exit;
	}else
	{
		echo "<script language=\"JavaScript\">\r\n";echo "alert(\"请填写完整信息！\");\r\n";echo " history.back();\r\n";   echo "</script>";
	}
	
}
if($act == 'zhunkaozheng'){
$name=trim($_POST['name']);
$phone1=trim($_POST['phone1']);
$identity_id=trim($_POST['identity_id']);
	if($name && $phone1 && $identity_id)
	{
		$sql="select * from qs_baoming where name='{$name}' and phone1 = '{$phone1}' and identity_id = '{$identity_id}'";
		//echo $sql;exit;
		$res=$db->getone($sql);
		//print_r($res);exit;
		if($res)///-----返回
		{
			
			if($res['status'] == 1){
				if($res['ksbh'] == ''){
					echo "<script language=\"JavaScript\">\r\n";echo "alert(\"您的准考证暂时正在生成中，请稍后再试！\");\r\n";echo " history.back();\r\n"; echo "</script>";	
				}else{
					// echo "<script language=\"JavaScript\">\r\n";echo "alert(\"打印准考证暂时还未开放！\");\r\n";echo " history.back();\r\n"; echo "</script>";					
					include("zhunkaozheng.html");exit;
				}
				//echo "您的报考已经审核通过了";
				// include("zhunkaozheng.html");exit;
			}
			if($res['status'] == 0 || $res['status'] == 2)
			{
				echo "<script language=\"JavaScript\">\r\n";echo "alert(\"您报名资料还没有审核或审核不通过，不能打印准考证！\");\r\n";echo " history.back();\r\n"; echo "</script>";	
			}
			
		}else{///---
			echo "<script language=\"JavaScript\">\r\n";echo "alert(\"填写信息错误或者用户不存在！\");\r\n";echo " history.back();\r\n"; echo "</script>";	
		}
		//print_r($res);exit;
	}else
	{
		echo "<script language=\"JavaScript\">\r\n";echo "alert(\"请填写完整信息！\");\r\n";echo " history.back();\r\n";   echo "</script>";
	}
	
}

if($act == 'chengji')
{
	$name=trim($_POST['name']);
	$phone1=trim($_POST['phone1']);
	$identity_id=trim($_POST['identity_id']);
	if($name && $phone1 && $identity_id)
	{
		$sql="select * from qs_baoming where name='{$name}' and phone1 = '{$phone1}' and identity_id = '{$identity_id}'";
		//echo $sql;exit;
		$res=$db->getone($sql);
		//print_r($res);exit;
		if($res)///-----返回
		{
			
			if($res['status'] == 1){
				if($res['km1'] == '' || $res['km2'] == ''){
					echo "<script language=\"JavaScript\">\r\n";echo "alert(\"您的成绩还没有出来，请稍后再试！\");\r\n";echo " history.back();\r\n"; echo "</script>";	
				}else{
					//echo "<script language=\"JavaScript\">\r\n";echo "alert(\"成绩查询暂时还未开放！\");\r\n";echo " history.back();\r\n"; echo "</script>";					
					include("chegnji.html");exit;
				}
				//echo "您的报考已经审核通过了";
				// include("zhunkaozheng.html");exit;
			}
			if($res['status'] == 0 || $res['status'] == 2)
			{
				echo "<script language=\"JavaScript\">\r\n";echo "alert(\"您报名资料还没有审核或审核不通过，没有成绩信息！\");\r\n";echo " history.back();\r\n"; echo "</script>";	
			}
			
		}else{///---
			echo "<script language=\"JavaScript\">\r\n";echo "alert(\"填写信息错误或者用户不存在！\");\r\n";echo " history.back();\r\n"; echo "</script>";	
		}
		//print_r($res);exit;
	}else
	{
		echo "<script language=\"JavaScript\">\r\n";echo "alert(\"请填写完整信息再查询！\");\r\n";echo " history.back();\r\n";   echo "</script>";
	}
}
?>
