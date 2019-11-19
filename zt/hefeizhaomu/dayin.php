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
$pagesize=8;
$key=isset($_GET['key'])?trim($_GET['key']):"";
//echo $key;exit;
$keysql=isset($_GET['key'])?" where kch = '".$key."'":"";

$satuts=isset($_GET['satuts'])?intval($_GET['satuts']):1;

empty($keysql)?empty($satuts) && $satuts != '0'?$keysql =" ":$keysql =" where status ='".$satuts."' ":"";


$total_sql="select COUNT(*) as num  from ".table('baoming').$keysql." and kch <>'' order by zwh asc";
$total_count=$db->get_total($total_sql);
$page = new page(array('total'=>$total_count, 'perpage'=>$pagesize,'alias'=>'','getarray'=>$_GET));//QS_jobslist
$currenpage=$page->nowindex;
$offset=abs($currenpage-1)*$pagesize;
$limit=" limit ".$offset.",".$pagesize;
//echo $limit;exit;
$exec="select * from qs_baoming ".$keysql."  and kch <>'' order by zwh asc".$limit;
$rs=$db->getall($exec);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>2015年合肥市社会服务岗位录用考场留验单</title>
<link href="/files/css/common.css" rel="stylesheet" type="text/css" />
<link href="/files/css/jobs.css" rel="stylesheet" type="text/css" />
<link href="../files/css/all.css" rel="stylesheet" type="text/css" />
<style type="text/css">
*{ padding:0; margin:0;}
.zhun_table{ margin:0; width:858px; text-align:center;}
.zhun_print a{ width:210px; height:42px; background-color:#5bc0de; text-align:center; line-height:42px; color:#fff; display:inline-block; text-decoration:none; margin:30px auto 0; font-size:18px;}
.baoming_photo{ width:120px;}
.zhunkao2 ul{ overflow:hidden; padding-left:0;}
.zhunkao2 ul li{ list-style:none; float:left; margin-right:30px; margin-top:35px; width:404px; height:217px;}
.zhunkao2 ul li table tr td{ font-size:14px; height:30px; padding:0;}
.zhunkao2 ul li table tr td p{ margin:0;}
.kaochang{ width:210px; height:32px; font-weight:bold; font-size:14px; margin:30px 0;}
.title{ text-align:center; width:100%; font-size:20px; margin-top:0;}
/*--简历打印样式--*/

@media print{	
	.noprint{display:none;}
}
</style>
<script language="javascript"> 
function preview() 
{ 
bdhtml=window.document.body.innerHTML; 
sprnstr="<!--startprint-->"; 
eprnstr="<!--endprint-->"; 
prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17); 
prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr)); 
window.document.body.innerHTML=prnhtml; 
window.print(); 
} 
</script>

</head>

<body>
<!--startprint-->
<div class="zhun_table zhunkao2">
<h2 class="title">2015年合肥市社会服务岗位录用考场留验单</h2>

  <ul>
  		<?php 
		//echo "<pre>";print_r($rs);exit;
		$i=0;
		foreach($rs as $k=>$v){
		$i++;
		?>
        <li <?php if($i%2 == 0){?>style="margin-right:0;"<?php }?>>
        	<table border="1" cellspacing="0" cellpadding="0" width="404" height="217">      
              <tr>
                <td width="72" height="30"><p align="center">姓名 </p></td>
                <td width="192" colspan="4" height="30"><p align="center"><?php echo $v['name'];?></p></td>
                <td width="130" rowspan="5" height="30"><p align="center"><img src="/zt/hefeizhaomu/<?php echo $v['photo'];?>" class="baoming_photo" /></p></td>
              </tr>
              <tr>
                <td width="72" height="30"><p align="center">性别 </p></td>
                <td width="192" colspan="4" height="30"><p align="center"><?php echo $v['sex'];?></p></td>
              </tr>
              <tr>
                <td width="72" height="30"><p align="center">身份证号 </p></td>
                <td width="192" height="30" colspan="4"><p align="center"><?php echo $v['identity_id'];?></p></td>
              </tr>
              <tr>
                <td width="72" height="30"><p align="center">准考证号 </p></td>
                <td width="192" height="30" colspan="4"><p align="center"><?php echo $v['ksbh'];?></p></td>
              </tr>
              <tr>
                <td width="72" height="30"><p align="center">考场号 </p></td>
                <td width="72" height="30"><p align="center"><?php echo $v['kch'];?></p></td>
                <td width="60" height="30" colspan="2"><p align="center">座位号</p></td>
                <td width="60" height="30"><p align="center"><?php echo $v['zwh'];?></p></td>
              </tr>
              <tr>
                <td width="72" height="30"><p align="center">考生签名 </p></td>
                <td width="192" height="30" colspan="5"><p align="left">&nbsp;&nbsp;第一场&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;第二场</p></td>
              </tr>
            </table>
        </li>
        <?php }?>
	</ul>
    
  	<select class="kaochang noprint" onChange="var jmpURL='?status=1&key=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}" name="key">
    	<option value="">请选择考场号</option>
		<?php
        ///---fff
		$sql_kch="SELECT distinct kch FROM  qs_baoming where kch <> '' order by kch ";
		$result_kch=mysql_query($sql_kch);
		while($rs_kch=mysql_fetch_object($result_kch))
		{
		 echo" <option value=\"".$rs_kch->kch."\">".$rs_kch->kch."</option>";
		}
		?>
    </select> 
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="link_bk noprint">
          <tr>
            <td style="border:0px;"><div class="page link_bk" style="margin:10px auto;"><?php echo $page->show(3);?></div></td>
            <td style="border:0px;">&nbsp;&nbsp;<span>共<font style="color:#F00;">(<?php echo $total_count;?>)</font>人报名</span></td>
         </tr>
                    
 </table>
    <div class="zhun_table zhun_print noprint"><a href="#" onclick="preview()">准考证打印</a><!--javascript:window.print();--></div>
 </div>
 <!--endprint-->
</body>
</html>
