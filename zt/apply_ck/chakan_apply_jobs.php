<?php
 /*
 * 查看报名
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../../include/common.inc.php');
require_once(dirname(__FILE__).'/../../include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$page=isset($_GET['page'])?intval($_GET['page']):"";

$key=isset($_GET['key'])?trim($_GET['key']):"";

$keysql=isset($_GET['key'])?" where resume_name like '%".$key."%' or jobs_name like '%".$key."%' or company_name like '%".$key."%'":"";

$total_sql="select COUNT(*) as num  from ".table('personal_jobs_apply').$keysql." order by apply_addtime,did desc";
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
<div align="center">
<table width="80%" border="1" cellspacing="1" style="border-collapse: collapse" bordercolorlight="#000000" bordercolordark="#000000">
  <tr>
    <td colspan="19" align="center" valign="middle">个人会员投递职位明细</td>
    </tr>
  <tr>
 <td align="center" valign="middle">编号</td>
    <td align="center" valign="middle">简历姓名</td>
    <td align="center" valign="middle">职位名称</td>
    <td align="center" valign="middle">公司名称</td>
    <td align="center" valign="middle">投递日期</td>
  </tr>
  <?php
  $limit=" limit ".$offset.",".$pagesize;
$exec="select * from ".table('personal_jobs_apply').$keysql." order by apply_addtime desc".$limit;
//echo $exec;exit;
$result=mysql_query($exec);
while($rs=mysql_fetch_object($result))
{
echo"<tr>";
 echo" <td align=\"center\" valign=\"middle\">".$rs->did."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->resume_name."</td>";
   if(empty($rs->jobs_name)){echo" <td align=\"center\" valign=\"middle\"><font style=\"color:#f00;\">该职位可能被删除了</font></td>";}else{echo" <td align=\"center\" valign=\"middle\">".$rs->jobs_name."</td>";}
    if(empty($rs->company_name)){echo" <td align=\"center\" valign=\"middle\"><font style=\"color:#f00; font-weight:200px;\">该职位可能被删除了</font></td>";}else{echo" <td align=\"center\" valign=\"middle\">".$rs->company_name."</td>";}
     echo" <td align=\"center\" valign=\"middle\">".date('Y-m-d H:i:s',$rs->apply_addtime)."</td>";
 /*echo"  <td align=\"center\" valign=\"middle\"><a href=\"http://www.1jobs.cn/ycnjl/".$rs->wdurl."\" target=_blank>下载简历</a></br> 
 <a href=\"http://www.1jobs.cn/ycnjl/".$rs->url."\" target=_blank>下载图片</a>
 </td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->time."</td>";*/
 echo" </tr>";
 }
 ?>
 <tr>
    <td colspan="19" align="center" valign="middle"><form method="get" action="?" name="form1" style="float:right"><input type="text" name="key" id="key" value=""/><input type="submit"  value="搜索"></form><a href="?page=1&key=<?php echo $key;?>">首页</a>  <a href="?page=<?php  if(($page-1) >0){echo $page-1; }else{echo 1;}?>&key=<?php echo $key;?>">上一页</a>  <a href="?page=<?php  if(($page+1)>$maxpage){echo $maxpage;}else{echo $page+1;}?>&key=<?php echo $key;?>">下一页</a>  <a href="?page=<?php echo $maxpage?>&key=<?php echo $key;?>">尾页</a> <a href="?">清除搜索记录</a></td>
    </tr>
  <tr>
</table></div>