<?php 
header("Content-type: text/html; charset=utf-8");
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$id=$aset['id']?intval($aset['id']):0;
$sql = "select title,deadline,content,addtime,img_path,note from ".table('ad')." WHERE  id=".$id." AND  deadline >".time()." and is_display = 1 LIMIT 1";
//echo $sql."<pre>";echo $id;exit;
$val=$db->getone($sql);
if (empty($val))
{
	echo "信息不存在";
	exit;
}
//$db->query("update ".table('ad')." set click=click+1 WHERE id=".intval($aset['id'])."  LIMIT 1");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo iconv(QISHI_DBCHARSET,"utf-8//IGNORE",$val['note']); ?>-详情</title>
<style type="text/css">
	.zhichang{ margin:25px;}
	.zhichang h1{ font-size:54px; color:#333; text-align:center; margin-top:30px;}
	.zhichang .text{ font-size:42px;}
	.zhichang .date{ display:block; font-size:38px; color:#999; text-align:center; margin:10px auto}
	.zhichang img{ width:100%; height:100%; margin-top:20px;}
	.zhichang p{ text-indent:2em; font-size:40px; color:#666; line-height:64px;}
</style>
</head>

<body>

<div class="zhichang">
    <h1><?php echo iconv(QISHI_DBCHARSET,"utf-8//IGNORE",$val['title']);?></h1>
    
    <!--<div class="date">时间：<?php //echo iconv(QISHI_DBCHARSET,"utf-8//IGNORE",daterange(time(),$val['addtime'],'Y-m-d',"#FF3300"));?></div>-->
	<?php 
		$id=intval($_GET['id']);
		if($id == 450 || $id == 452){
			header("location: http://www.1dagong.com/app/an/");
		}else{ ?>
	<img src="<?php echo $val['img_path']?>" />
	<?php } ?>
    <div class="text">
	<?php echo iconv(QISHI_DBCHARSET,"utf-8//IGNORE",$val['content']);?>
	</div>
    
	</div>

</body>
</html>
