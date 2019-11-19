<?php
 /*
 * 查看报名
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../../include/common.inc.php');
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'app';
require_once(dirname(__FILE__).'/../../include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
?>
<div align="center">
<table width="80%" border="1" cellspacing="1" style="border-collapse: collapse" bordercolorlight="#000000" bordercolordark="#000000">
  <tr>
    <td colspan="19" align="center" valign="middle">七夕专题爱情宣言明细</td>
    </tr>
  <tr>
 <td align="center" valign="middle">编号</td>
    <td align="center" valign="middle">姓名</td>
    <td align="center" valign="middle">工号</td>
    <td align="center" valign="middle">手机号码</td>
    <td align="center" valign="middle">宣言内容</td>
    <td align="center" valign="middle">填写时间</td>
  </tr><?php
$exec="select * from zt_qx_xuanyan order by id";
$result=mysql_query($exec);
while($rs=mysql_fetch_object($result))
{
echo"<tr>";
 echo" <td align=\"center\" valign=\"middle\">".$rs->id."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->name."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->gonghao."</td>";
    echo" <td align=\"center\" valign=\"middle\">".$rs->phone."</td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->contents."</td>";
  echo" <td align=\"center\" valign=\"middle\">".date('Y-m-d H:i:s',$rs->addtime)."</td>";
 echo" </tr>";
 }
 ?>
</table></div>