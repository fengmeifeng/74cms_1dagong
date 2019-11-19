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
    <td colspan="19" align="center" valign="middle">企业申请查看联系方式明细</td>
    </tr>
  <tr>
 <td align="center" valign="middle">编号</td>
    <td align="center" valign="middle">公司名称</td>
    <td align="center" valign="middle">简历名称</td>
    <td align="center" valign="middle">是否通过</td>
    <td align="center" valign="middle">申请日期</td>
  </tr><?php
$exec="select a.*,c.companyname,r.fullname from ".table('company_apply_ck')." as a left join ".table('company_profile')." as c on a.company_uid=c.uid left join ".table('resume')." as r on a.resume_id=r.id  order by a.interview_addtime desc";
$result=mysql_query($exec);
while($rs=mysql_fetch_object($result))
{
echo"<tr>";
 echo" <td align=\"center\" valign=\"middle\">".$rs->did."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->companyname."</td>";
   if(empty($rs->fullname)){echo" <td align=\"center\" valign=\"middle\"><font style=\"color:#f00;\">该简历可能被删除了</font></td>";}else{echo" <td align=\"center\" valign=\"middle\">".$rs->fullname."</td>";}
    if($rs->company_apply == 1){echo" <td align=\"center\" valign=\"middle\"><font style=\"color:green; font-weight:200px;\">通过</font></td>";}else{echo" <td align=\"center\" valign=\"middle\"><font style=\"color:#f00;font-weight:200px;\">未通过</font></td>";}
     echo" <td align=\"center\" valign=\"middle\">".date('Y-m-d H:i:s',$rs->interview_addtime)."</td>";
 /*echo"  <td align=\"center\" valign=\"middle\"><a href=\"http://www.1jobs.cn/ycnjl/".$rs->wdurl."\" target=_blank>下载简历</a></br> 
 <a href=\"http://www.1jobs.cn/ycnjl/".$rs->url."\" target=_blank>下载图片</a>
 </td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->time."</td>";*/
 echo" </tr>";
 }
 ?>
</table></div>