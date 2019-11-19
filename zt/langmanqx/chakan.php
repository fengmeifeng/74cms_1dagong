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
    <td colspan="19" align="center" valign="middle">七夕专题报名明细</td>
    </tr>
  <tr>
 <td align="center" valign="middle">编号</td>
    <td align="center" valign="middle">姓名</td>
    <td align="center" valign="middle">性别</td>
    <td align="center" valign="middle">身高</td>
    <td align="center" valign="middle">体重</td>
    <td align="center" valign="middle">工号部门</td>
    <td align="center" valign="middle">联系方式</td>
    <td align="center" valign="middle">出生年月</td> 
    <td align="center" valign="middle">籍贯</td>
    <td align="center" valign="middle">兴趣爱好</td>
    <td align="center" valign="middle">择偶标准</td>
    <td align="center" valign="middle">报名时间</td>
  </tr><?php
$exec="select * from zt_qx_baoming order by id";
$result=mysql_query($exec);
while($rs=mysql_fetch_object($result))
{
echo"<tr>";
 echo" <td align=\"center\" valign=\"middle\">".$rs->id."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->name."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->sex."</td>";
    echo" <td align=\"center\" valign=\"middle\">".$rs->height."</td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->weight."</td>";
  echo" <td align=\"center\" valign=\"middle\">".$rs->depratment."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->phone."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->brithday."</td>";
    echo" <td align=\"center\" valign=\"middle\">".$rs->home."</td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->hobby."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->selected."</td>";
     echo" <td align=\"center\" valign=\"middle\">".date('Y-m-d H:i:s',$rs->addtime)."</td>";
 /*echo"  <td align=\"center\" valign=\"middle\"><a href=\"http://www.1jobs.cn/ycnjl/".$rs->wdurl."\" target=_blank>下载简历</a></br> 
 <a href=\"http://www.1jobs.cn/ycnjl/".$rs->url."\" target=_blank>下载图片</a>
 </td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->time."</td>";*/
 echo" </tr>";
 }
 ?>
</table></div>