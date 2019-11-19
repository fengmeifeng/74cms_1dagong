<?php
 /*
 * 查看报名
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../../include/common.inc.php');
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'app';
require_once(dirname(__FILE__).'/../../include/mysql.class.php');

require_once(dirname(__FILE__).'/inc/page.class.php');

$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
//$page=isset($_GET['page'])?intval($_GET['page']):"";
$pagesize=25;
$key=isset($_GET['key'])?trim($_GET['key']):"";

$keysql=isset($_GET['key'])?" where kch = '".$key."'":"";

$satuts=isset($_GET['satuts'])?intval($_GET['satuts']):"";

empty($keysql)?empty($satuts) && $satuts != '0'?$keysql =" ":$keysql =" where status ='".$satuts."' ":"";

$total_sql="select COUNT(*) as num  from ".table('baoming').$keysql." order by addtime,id desc";

$total_count=$db->get_total($total_sql);
$page = new page(array('total'=>$total_count, 'perpage'=>$pagesize,'alias'=>'','getarray'=>$_GET));//QS_jobslist
$currenpage=$page->nowindex;
$offset=abs($currenpage-1)*$pagesize;
?>
<link href="/files/css/common.css" rel="stylesheet" type="text/css" />
<link href="/files/css/jobs.css" rel="stylesheet" type="text/css" />
<link href="../files/css/all.css" rel="stylesheet" type="text/css" />


<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="style/table.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/files/js/jquery.js"></script>
<script>
function shenhe(id,status,phone,baokao_job){
	if(status == 1){var a="通过";}else if(status == 2){var a="不通过";}
	  if(window.confirm('你确定设置审核'+a+'?')) location.href="?id="+id+"&act=shenhe&status="+status+"&phone="+phone+"&baokao_job="+baokao_job;
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
    <td align="center" valign="middle">毕业时间</td>-->
    <td align="center" valign="middle">报考职位</td>
    <td align="center" valign="middle">证件照</td>
    <td align="center" valign="middle">报名时间</td>
    <td align="center" valign="middle">操作</td>
    <td align="center" valign="middle">添加考场(座位)号</td>
  </tr><?php
$limit=" limit ".$offset.",".$pagesize;
//echo $limit;exit;
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
 
   echo"  <td align=\"center\" valign=\"middle\">".$rs->baokao_job."</td>";
 echo"  <td align=\"center\" valign=\"middle\"><a href=\"/zt/hefeizhaomu/".$rs->photo."\" target=_blank>查看</a>
 </td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->addtime."</td>";
  if($rs->status == 1){
	echo"  <td align=\"center\" valign=\"middle\"><font style=\"color:green\">已通过</font></td>";
  }elseif($rs->status == 0){
	echo"  <td align=\"center\" nowrap valign=\"middle\"><a href=\"javascript:shenhe({$rs->id},1,{$rs->phone1},{$rs->baokao_job});\">审核通过</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:;\" onClick=\"statusl({$rs->id},2,{$rs->phone1},'lz')\">审核不通过</a><div class=\"status statusxianshil".$rs->id."\" style=\"display:none;margin: 4px -25px;\">  
			<div class=\"content\"> 
				<form method=\"post\" action=\"\" id=\"formshijian\">
					<input type=\"hidden\" name=\"id\" value=\"".$rs->id."\" />
					<input type=\"hidden\" name=\"status\" value=\"2\" />
					<input type=\"hidden\" name=\"phone\" value=\"".$rs->phone1."\" />
					<input type=\"hidden\" name=\"baokao_job\" value=\"".$rs->baokao_job."\" />
					<span class=\"mz\"></span>：<input type=\"text\"  id=\"yuanyin\" size=\"9\" />
					<input type=\"submit\" value=\"提交\"/>
				</form> </div><s style=\"left: 162px\"><i></i></s> 
</div></td>";
  }elseif($rs->status == 2){
	echo"  <td align=\"center\" valign=\"middle\"><font style=\"color:red\">未通过</font></td>";
  }
//考场号和座位号  
  if($rs->status == 1){ 
	if($rs->ksbh == ''){
		echo"  <td align=\"center\" valign=\"middle\"><form method=\"post\" action=\"?act=add_num\" id=\"form_1\" name=\"form_1\"><input type=\"hidden\" name=\"id\" value=\"".$rs->id."\" />考场号:<input type=\"text\" name=\"kch\" value=\"".$rs->kch."\"  id=\"kch\" size=\"5\" />座位号:<input type=\"text\" name=\"zwh\" value=\"".$rs->zwh."\"  id=\"zwh\" size=\"5\" />准考证号:<input type=\"text\" name=\"ksbh\" value=\"".$rs->ksbh."\"  id=\"ksbh\" size=\"5\" /><input type=\"submit\" value=\"提交\"/></form></td>";
	}else{
		echo '<td align="center" valign="middle">已经添加</td>';
	}	
  }else{
	 echo"  <td align=\"center\" valign=\"middle\"></td>";  
  }
  echo" </tr>";
  echo " ";
 }
 ?>
 <!--<tr>
    <td colspan="19" align="center" valign="middle">
    <form method="get" action="?" name="form1" style="float:right"><input type="text" name="key" id="key" value=""/><input type="submit"  value="搜索"></form><a href="?page=1&key=<?php echo $key;?>">首页</a>  <a href="?page=<?php  if(($page-1) >0){echo $page-1; }else{echo 1;}?>&key=<?php echo $key;?>">上一页</a>  <a href="?page=<?php  if(($page+1)>$maxpage){echo $maxpage;}else{echo $page+1;}?>&key=<?php echo $key;?>">下一页</a>  <a href="?page=<?php echo $maxpage?>&key=<?php echo $key;?>">尾页</a> <a href="?">清除搜索记录</a>
	<br /><br /><a style="color:red;" href="http://www.1dagong.com/vipgn/index.php/excel/bmxx">导出已审核通过的报名人员信息为Excel表格</a>
    </td>
    </tr>-->
    <tr>
    <td colspan="19" align="center" valign="middle">
   <form method="get" action="?" name="form1" style="float:right"> <a href="?key=">返回列表页</a>&nbsp;&nbsp;&nbsp;<input type="text" name="key" id="key" value=""/><input type="submit"  value="搜索"></form>
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="link_bk">
    	    <tr>
              <td align="center" style="border:0px;"><a href="?satuts=1">审核通过</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?satuts=2">审核不通过</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?satuts=0">还未审核</a></td>
          </tr>
          <tr>
            <td style="border:0px;"><div class="page link_bk" style="margin:10px auto;"><?php echo $page->show(3);?></div></td>
            <td style="border:0px;">&nbsp;&nbsp;<span>共<font style="color:#F00;">(<?php echo $total_count;?>)</font>人报名</span></td>
         </tr>
                    
 </table>
 
<br /><a style="color:red;" href="http://www.1dagong.com/vipgn/index.php/excel/bmxx">导出已审核通过的报名人员信息为Excel表格</a>
<br /><a style="color:red;" href="http://www.1dagong.com/vipgn/index.php/excel/bmxx_all">导出所有报名人员信息为Excel表格</a>
    </td>
    </tr>
</table>

</div>
</body>
<?php
if($act == 'shenhe'){
	// echo '2222';exit;
	$id=trim($_REQUEST['id']);
	$status=intval(trim($_REQUEST['status']));
	$phone = $_REQUEST['phone'];
	$baokao_job=intval(substr(trim($_REQUEST['baokao_job']),0,1));
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
		if($baokao_job == 1){
			include_once('../../include/baoming_chenggong_shehuifuwu.php');
		}elseif($baokao_job == 3){
			include_once('../../include/baoming_chenggong_jianxisheng.php');			
		}
	}elseif($status == 2){
		if($baokao_job == 1){
			include_once('../../include/baoming_shibai_shehuifuwu.php');
		}elseif($baokao_job == 3){
			include_once('../../include/baoming_shibai_jianxisheng.php');			
		}
	}
	
}
if($act == 'add_num')
{
	// echo '1111';exit;
	$kch=trim($_REQUEST['kch']);
	$zwh=trim($_REQUEST['zwh']);
	$ksbh=trim($_REQUEST['ksbh']);
	$id=trim($_REQUEST['id']);
	if($kch && $zwh && $ksbh){
	$qsl_id="update qs_baoming set kch = '".$kch."',zwh ='".$zwh."',ksbh ='".$ksbh."' where id =".$id;
	// echo $qsl_id;exit;
	if($db->query($qsl_id))
	{
		echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"添加成功\");\r\n";   echo " history.back();\r\n";   echo "</script>";
	}else{
		echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"添加失败\");\r\n";   echo " history.back();\r\n";   echo "</script>";
	}
	}else{
		echo "<script language=\"JavaScript\">\r\n";echo " alert(\"考场号或座位号或准考证号不能为空！\");\r\n";   echo " history.back();\r\n";   echo "</script>"; exit;
	}
	
}
?>