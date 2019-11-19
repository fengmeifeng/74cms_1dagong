<?php
 /*
 * 查看报名
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'app';
require_once(dirname(__FILE__).'/../include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$id=trim($_REQUEST['id']);
$res=$db->getone("select * from qs_baoming where id={$id}");
?>
<style>
*{
	 font-family:Arial,Helvetica,sans-serif;
       font-size:1em;
       vertical-align:middle;
       font-weight:normal;
	}
.tabhead {
font-weight: bold;
color: #476074;
line-height: 23px;
padding: 0px;
background: #EFF7FF;
}
table {
border-collapse: collapse;
border-spacing: 0;
display: table;
border-color: gray;
}
td, th {
display: table-cell;
vertical-align: inherit;
}
td {
border: 1px #b8d1e2 solid;
}

</style>
<script>
function shenhe(id,status){
	if(status == 1){var a="通过";}else if(status == 2){var a="不通过";}
	  if(window.confirm('你确定设置审核'+a+'?')) location.href="?id="+id+"&act=shenhe&status="+status;
  }
</script>
<table class="tabhead" align="center" width="80%">
	<tr>
		<td class="biaoti" align="left" colspan="4">&nbsp;查看个人报名信息</td>
	</tr>
	<tr>
		<td class="tabhead" nowrap="" align="right" colspan="6"><?php if($res['status'] == 0){?><a href="javascript:shenhe(<?php echo $res['id'];?>,1);">审核通过</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:shenhe(<?php echo $res['id'];?>,2);">审核不通过</a><?php }elseif($res['status'] == 1){?><font style="color:#030;">已通过</font><?php }elseif($res['status'] == 2){?><font style=" color:#F00;">未通过</font><?php }?><!--<a href="/kaoshi/chakan.php">返回列表页</a>--></td>
	</tr>
	<tr>
		<td width="25%" style="background: #F0F0F0;">姓名:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['name'];?></td>
		<td width="25%" style="background: #F0F0F0;">身份证号:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['identity_id'];?></td>
	</tr>
	<tr>
		<td width="25%" style="background: #F0F0F0;">出生日期:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['birthday'];?></td>
		<td width="25%" style="background: #F0F0F0;">入党(团)时间:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['join_time'];?> &nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td width="25%" style="background: #F0F0F0;">政治面貌:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['politics'];?></td>
		<td width="25%" style="background: #F0F0F0;">性别:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['sex'];?></td>
	</tr>
	<tr>
		<td width="25%" style="background: #F0F0F0;">现户籍所在地:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['address'];?></td>
		<td width="25%" style="background: #F0F0F0;">档案所在地:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['profile_add'];?></td>
	</tr>
	<tr>
		<td width="25%" style="background: #F0F0F0;">学历:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['education'];?></td>
		<td width="25%" style="background: #F0F0F0;">学历性质:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['edu_sta'];?></td>
	</tr>
	<tr>
		<td width="25%" style="background: #F0F0F0;">毕业学院:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['graduate_school'];?></td>
		<td width="25%" style="background: #F0F0F0;">所学专业:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['specialty'];?></td>

	</tr>
	<tr>
		<td width="25%" style="background: #F0F0F0;">毕业时间:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['graduate_time'];?></td>
		<td width="25%" style="background: #F0F0F0;">手机号:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['phone1'];?></td>
	</tr>
	<tr>
		<td width="25%" style="background: #F0F0F0;">固定电话:</td>
		<td width="25%" style="background: #fff;"> <?php echo $res['phone2'];?> </td>
		<td width="25%" style="background: #F0F0F0;">职位编码:</td>
		<td width="25%" style="background: #fff;">
		<?php echo $res['baokao_job'];?>
		</td>

	</tr>
	<tr>
		<!--<td width="25%" style="background: #F0F0F0;">报到时间:</td>
		<td width="25%" style="background: #fff;"><{$data.register_time|date_format:"%Y-%m-%d %H:%M:%S"}></td>-->
	</tr>
	<tr>
		<td width="25%" style="background: #F0F0F0;">报考专业:</td>
		<td width="25%" style="background: #fff;"><?php echo $res['baokao_specialty'];?></td>
		<td width="25%" style="background: #F0F0F0;">&nbsp;</td>
		<td width="25%" style="background: #fff;">&nbsp;</td>
	</tr>
	<tr>
		<td width="25%" style="background: #F0F0F0;">身份证正(反)面:</td>
		<td width="75%" style="background: #fff;" colspan="3"><img src="<?php echo $res['identity_up'];?>" width="200" height="200"/><img src="<?php echo $res['identity_down'];?>" width="200" height="200"/></td>
	</tr>
    <tr>
		<td width="25%" style="background: #F0F0F0;">证件照:</td>
		<td width="75%" style="background: #fff;" colspan="3"><img src="<?php echo $res['photo'];?>" width="200" height="200"/></td>
	</tr>
	<tr>
		<td width="100%" style="background: #fff; padding-bottom: 5px;" colspan="4">&nbsp;</td>
</table>
<?php
if($act == 'shenhe'){
	$id=trim($_REQUEST['id']);
	$status=intval(trim($_REQUEST['status']));
	$qsl_id=" update qs_baoming set status = ".$status." where id =".$id;
	if($db->query($qsl_id))
	{
		echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"审核成功\");\r\n";   echo " history.back();\r\n";   echo "</script>";
	}else{
		echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"审核失败\");\r\n";   echo " history.back();\r\n";   echo "</script>";
		}
	
	}
?>