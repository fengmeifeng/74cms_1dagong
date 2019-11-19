<?php
 /*
 * 74cms 招聘会
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);

require_once(dirname(dirname(__FILE__)).'/include/common.inc.php');

require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);


$t1=strtotime("2014-2-1");
$t2=strtotime("2014-2-28");

$sql="SELECT * FROM qs_jobfair WHERE holddates >= '".$t1."' AND holddates <= '".$t2."' and subsite_id='1' ORDER BY `holddates` asc";

$data=$db->getall($sql);

foreach ($data as $k => $v) {
		//----------------------------------------------------------
		/*以预定*/
		$yyd="select count(*) as yiyuding from vip_zhanhui where zid='".$v['id']."'";
		$yyd=$db->getone($yyd);		//已预订过的展位
		$data[$k]['yiyuding']=$yyd['yiyuding'];
		/*未预定*/
		$wyd="select count(*) as weiyuding from vip_zw where number not in(select number from vip_zhanhui where zid=".$v['id'].") and subsite_id='".intval($_CFG['subsite_id'])."'";
		$wyd=$db->getone($wyd);		//没有预定的展位
		$data[$k]['weiyuding']=$wyd['weiyuding'];
		//----------------------------------------------------------
		if(date("Y-m-d",$data[$k]['holddates']) > date("Y-m-d",$time)){
			$data[$k]['predetermined_ok']=1;
		}else{
			$data[$k]['predetermined_ok']=0;
		}
}

//print_r($data);

$smarty->assign("jobfair",$data);

$smarty->display('./../templates/1jobscnthf/jobfair-newyear.htm');

unset($smarty);
?>