<?php
/**
 *
 * 文档统计
 *
 * 如果想显示点击次数,请增加view参数,即把下面ＪＳ调用放到文档模板适当位置
 * <script src="{dede:field name='phpurl'/}/count.php?view=yes&companyid={dede:field name='id'/}&mid={dede:field name='mid'/}" language="javascript"></script>
 * 普通计数器为
 * <script src="{dede:field name='phpurl'/}/count.php?companyid={dede:field name='id'/}&mid={dede:field name='mid'/}" language="javascript"></script>
 *
 * @version        $Id: count.php 1 20:43 2010年7月8日Z tianya $
 * @package        DedeCMS.Site
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");

if(isset($companyid)) $arcID = $companyid;

$cid = empty($cid)? 1 : intval(preg_replace("/[^-\d]+[^\d]/",'', $cid));
$arcID = $companyid = empty($arcID)? 0 : intval(preg_replace("/[^\d]/",'', $arcID));

$maintable = '#@__archives';$idtype='id';

if($companyid==0) exit();



$conn = mysql_connect("192.168.3.249","hr.1jobs.com","hr.1jobs.com") or die("数据库联接错误".mysql_error());
mysql_select_db("hr.1jobs.com",$conn)or die("数据库访问错误".mysql_error());

$sql=mysql_query("SELECT job_yibao FROM myhome_jobs WHERE id ='{$companyid}' LIMIT 1",$conn);

$rs=mysql_fetch_array($sql);



if(is_array($rs)){
		echo "document.write('".$rs['job_yibao']."');\r\n";
}


/*
//获得频道模型ID
if($cid < 0)
{
    $row = $dsql->GetOne("SELECT addtable FROM `#@__channeltype` WHERE id='$cid' AND issystem='-1';");
    $maintable = empty($row['addtable'])? '' : $row['addtable'];
    $idtype='companyid';
}
$mid = (isset($mid) && is_numeric($mid)) ? $mid : 0;

//UpdateStat();
if(!empty($maintable))
{
    $dsql->ExecuteNoneQuery(" UPDATE `{$maintable}` SET click=click+1 WHERE {$idtype}='$companyid' ");
}
if(!empty($mid))
{
    $dsql->ExecuteNoneQuery(" UPDATE `#@__member_tj` SET pagecount=pagecount+1 WHERE mid='$mid' ");
}
if(!empty($view))
{
    $row = $dsql->GetOne(" SELECT click FROM `{$maintable}` WHERE {$idtype}='$companyid' ");
    if(is_array($row))
    {
        echo "document.write('".$row['click']."');\r\n";
    }
}
*/
exit();