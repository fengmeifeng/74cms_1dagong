<?php 
header("Content-type: text/html; charset=utf-8");
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db_1 = new mysql($dbhost,$dbuser,$dbpass,'zhichang');
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$id=$aset['id']?intval($aset['id']):0;
$sql = "select c.title,c.typeid,c.pubdate,c.senddate,c.writer,a.body from jplat_archives as c left join jplat_addonarticle as a on c.id=a.aid  WHERE  c.id=".$id." AND  c.arcrank >= 0 LIMIT 1";
//echo $sql."<pre>";echo $id;exit;
$val=$db_1->getone($sql);
if (empty($val))
{
	echo "信息不存在！";
	exit;
}
$db_1->query("update jplat_archives set click=click+1 WHERE id=".intval($aset['id'])."  LIMIT 1");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>职场咨询——详情</title>
<style type="text/css">
	.zhichang{ margin:25px;}
	.zhichang h1{ font-size:54px; color:#333; text-align:center; margin-top:30px;}
	.zhichang span{ display:block; font-size:38px; color:#999; text-align:center; margin:10px auto}
	.zhichang .imgde{ margin:40px auto; width:100%; height:100%;}
	.zhichang img{ width:100%; height:100%; }
	.zhichang div{ text-indent:2em; font-size:46px; color:#666; line-height:70px;}
</style>
</head>

<body>

<div class="zhichang">
    <h1><?php echo iconv(QISHI_DBCHARSET,"utf-8//IGNORE",$val['title']);?></h1>
    
    <span>时间：<?php echo daterange(time(),$val['senddate'],'Y-m-d',"#FF3300");?></span>
	<img src="" />
    <div class="imgde">
	<?php echo iconv(QISHI_DBCHARSET,"utf-8//IGNORE",$val['body']);?>
	</div>
    
	</div>

</body>
</html>
