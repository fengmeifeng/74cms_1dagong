<?php
 /*
 * 查看报名
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../../include/common.inc.php');
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'app';
require_once(dirname(__FILE__).'/../../include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$page=isset($_GET['page'])?intval($_GET['page']):"";

$key=isset($_GET['key'])?trim($_GET['key']):"";

$keysql=isset($_GET['key'])?" where name like '%".$key."%' or phone1 like '%".$key."%' or identity_id like '%".$key."%'":"";
$total_sql="select COUNT(*) as num  from ".table('baoming').$keysql." order by addtime,id desc";
//echo $total_sql;exit;
$total=mysql_query($total_sql);
$rows=array();
while($row = mysql_fetch_array($total)){
    		$rows[] = $row;
}
if (!empty($rows) && is_array($rows))
		{			
			foreach($rows as $n)
			{
			$v=$v+$n['num'];
			}			
		}
$total_val=$v;
//echo $total_val;exit;
if(!$page) $page = 1;
if(!$pagesize) $pagesize = 30;
$maxpage = ceil($total_val / $pagesize);
if($maxpage>0)
{
	if($page > $maxpage) $page = $maxpage;
}
$offset = ($page - 1) * $pagesize;
?>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="style/table.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/files/js/jquery.js"></script>
<script>
function shenhe(id,status,phone){
	if(status == 1){var a="通过";}else if(status == 2){var a="不通过";}
	  if(window.confirm('你确定设置审核'+a+'?')) location.href="?id="+id+"&act=shenhe&status="+status+"&phone="+phone;
  }
  //离职----
	function statusl(id,status,phone,act){
		//alert(id);
		if(act=='lz'){
			$(".mz").html("不通过原因");
			$("input[id='yuanyin']").attr("name","yuanyin");
			$("#formshijian").attr("action","chakan.php?act=shenhe");
		}
		$(".statusxianshil"+id).css("display","");
		$("body").append("<div class='zhezhao' onclick='gb()'> </div>");
	}
	//关闭弹出框---
	function gb(){
		$(".status").css("display","none");
		$(".zhezhao").remove();
	}
</script>
<body>
<div align="center">
<table width="80%" border="1" cellspacing="1" style="border-collapse: collapse" bordercolorlight="#000000" bordercolordark="#000000">
  <tr>
    <td colspan="20" align="center" valign="middle">报名明细</td>
    </tr>
  <tr>
 <td align="center" valign="middle">编号</td>
    <td align="center" valign="middle">姓名</td>
    <td align="center" valign="middle">身份证号</td>
    <td align="center" valign="middle">联系电话1</td>
   <!-- <td align="center" valign="middle">政治面貌</td>
    <td align="center" valign="middle">入党(团)时间</td>
    <td align="center" valign="middle">户籍所在地</td>
    <td align="center" valign="middle">档案所在地</td>  
    <td align="center" valign="middle">学历</td>  
    <td align="center" valign="middle">学历性质</td>
    <td align="center" valign="middle">毕业院校</td>
    <td align="center" valign="middle">所学专业</td>
    <td align="center" valign="middle">毕业时间</td>
    <td align="center" valign="middle">报考专业</td> -->
    <td align="center" valign="middle">报考职位</td>
    <td align="center" valign="middle">证件照</td>
    <td align="center" valign="middle">报名时间</td>
    <td align="center" valign="middle">操作</td>
  </tr><?php
$limit=" limit ".$offset.",".$pagesize;
$exec="select * from qs_baoming ".$keysql." order by id desc".$limit;
$result=mysql_query($exec);
while($rs=mysql_fetch_object($result))
{
echo"<tr>";
 echo" <td align=\"center\" valign=\"middle\">".$rs->id."</td>";//exam_num
   echo" <td align=\"center\" valign=\"middle\"><a href=\"display.php?id={$rs->id}\" target=\"_blank\">".$rs->name."</a></td>";
    echo" <td align=\"center\" valign=\"middle\">".$rs->identity_id."</td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->phone1."</td>";
   //echo" <td align=\"center\" valign=\"middle\">".$rs->politics."</td>";
  // echo" <td align=\"center\" valign=\"middle\">".$rs->join_time."</td>";
   // echo" <td align=\"center\" valign=\"middle\">".$rs->address."</td>";
 // echo"  <td align=\"center\" valign=\"middle\">".$rs->profile_add."</td>";
  // echo" <td align=\"center\" valign=\"middle\">".$rs->education."</td>";
     //echo" <td align=\"center\" valign=\"middle\">".$rs->edu_sta."</td>";
   //echo" <td align=\"center\" valign=\"middle\">".$rs->graduate_school."</td>";
   // echo" <td align=\"center\" valign=\"middle\">".$rs->specialty."</td>";
  //echo"  <td align=\"center\" valign=\"middle\">".$rs->graduate_time."</td>";
  //echo"  <td align=\"center\" valign=\"middle\">".$rs->baokao_specialty."</td>";
   echo"  <td align=\"center\" valign=\"middle\">".$rs->baokao_job."</td>";
 echo"  <td align=\"center\" valign=\"middle\"><a href=\"/zt/hefeizhaomu/".$rs->photo."\" target=_blank>查看</a>
 </td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->addtime."</td>";
  if($rs->status == 1){
	echo"  <td align=\"center\" valign=\"middle\"><font style=\"color:green\">已通过</font></td>";
  }elseif($rs->status == 0){
	echo"  <td align=\"center\" nowrap valign=\"middle\"><a href=\"javascript:shenhe({$rs->id},1,{$rs->phone1});\">审核通过</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:;\" onClick=\"statusl({$rs->id},2,{$rs->phone1},'lz')\">审核不通过</a><div class=\"status statusxianshil".$rs->id."\" style=\"display:none;margin: 4px -25px;\">  
			<div class=\"content\"> 
				<form method=\"post\" action=\"\" id=\"formshijian\">
					<input type=\"hidden\" name=\"id\" value=\"".$rs->id."\" />
					<input type=\"hidden\" name=\"status\" value=\"2\" />
					<input type=\"hidden\" name=\"phone\" value=\"".$rs->phone1."\" />
					<span class=\"mz\"></span>：<input type=\"text\"  id=\"yuanyin\" size=\"9\" />
					<input type=\"submit\" value=\"提交\"/>
				</form> </div><s style=\"left: 162px\"><i></i></s> 
</div></td>";
  }elseif($rs->status == 2){
	echo"  <td align=\"center\" valign=\"middle\"><font style=\"color:red\">未通过</font></td>";
  } echo" </tr>";
  echo " ";
 }
 ?>
 <tr>
    <td colspan="19" align="center" valign="middle"><form method="get" action="?" name="form1" style="float:right"><input type="text" name="key" id="key" value=""/><input type="submit"  value="搜索"></form><a href="?page=1&key=<?php echo $key;?>">首页</a>  <a href="?page=<?php  if(($page-1) >0){echo $page-1; }else{echo 1;}?>&key=<?php echo $key;?>">上一页</a>  <a href="?page=<?php  if(($page+1)>$maxpage){echo $maxpage;}else{echo $page+1;}?>&key=<?php echo $key;?>">下一页</a>  <a href="?page=<?php echo $maxpage?>&key=<?php echo $key;?>">尾页</a> <a href="?">清除搜索记录</a>
	<br /><br /><a style="color:red;" href="http://www.1dagong.com/vipgn/index.php/excel/bmxx">导出已审核通过的报名人员信息为Excel表格</a></td>
    </tr>
</table>

</div>
</body>
<?php
if($act == 'shenhe'){
	$id=trim($_REQUEST['id']);
	$status=intval(trim($_REQUEST['status']));
	$phone = $_REQUEST['phone'];
	$yuanyin=trim($_REQUEST['yuanyin']);
	if(empty($yuanyin) && $status == 2){echo "<script language=\"JavaScript\">\r\n";echo " alert(\"请填写不通过原因\");\r\n";   echo " history.back();\r\n";   echo "</script>"; exit;}
	//echo $id."<br>";echo $status."<br>";echo $phone."<br>";echo $yuanyin;exit;
	// var_dump($username);exit;
	$qsl_id=" update qs_baoming set status = ".$status.",yuanyin ='".$yuanyin."' where id =".$id;
	// echo $qsl_id;exit;
	if($db->query($qsl_id))
	{
		echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"审核成功\");\r\n";   echo " history.back();\r\n";   echo "</script>";
	}else{
		echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"审核失败\");\r\n";   echo " history.back();\r\n";   echo "</script>";
	}
	if($status == 1){
		include_once('../../include/baoming_chenggong.php');
	}else{
		include_once('../../include/baoming_shibai.php');
	}
	
}
?>