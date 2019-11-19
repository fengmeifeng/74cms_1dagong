<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$id=isset($aset['id'])?trim($aset['id']):"";
	$id=addslashes($id);
	$id=iconv("utf-8",QISHI_DBCHARSET,$id);
	//echo $aset['id'];exit;
	if (empty($id))
	{
	$result['code']=0;
	$result['errormsg']=android_iconv_utf8('没有找到该记录');
	$jsonencode = urldecode(json_encode($result));
	exit($jsonencode);
	}
	$wheresql=" id = ".$id." AND  display=1 LIMIT 1";
	$val = $db->getone("SELECT * FROM ".table('jobfair')."  WHERE ".$wheresql."");
	//echo "<pre>";print_r($val);exit;
	
		$val['addtime']=daterange(time(),$val['addtime'],'Y-m-d',"#FF3300");
		$val['predetermined_start']=date('Y-m-d',$val['predetermined_start']);
		$val['predetermined_end']=date('Y-m-d',$val['predetermined_end']);
		$val['holddates']=date('Y-m-d',$val['holddates']);
		$val['display_time']=date('Y-m-d',$val['display_time']);
	///----------------------------------------------------------------------------------------------------------计算已预定和未预定
	/*--------------------------------------------------------------------------------------------------------------------------*/	
	if(intval($val['subsite_id']!='8')){
		//-------------------------------------------------------------
		/*以预定*/
		$yyd=$db->getone("select count(*) as yiyuding from vip_zhanhui where zid='".$val['id']."'");		//已预订过的展位
		//$smarty->assign("yiyuding",$yyd['yiyuding']);
		$val['yiyuding']=$yyd['yiyuding'];
		/*未预定*/
		$wyd="select count(*) as weiyuding from vip_zw where subsite_id='".intval($val['subsite_id'])."'";
		$wyd=$db->getone($wyd);		//没有预定的展位
		$val['weiyuding']=$wyd['weiyuding']-$yyd['yiyuding'];
		//$smarty->assign("weiyuding",$wyd['weiyuding']-$yyd['yiyuding']);
		//---------------------------------------------------------------
		/*已预订*/
		$sql="select * from vip_zhanhui where zid='".$val['id']."' and subsite_id='".intval($val['subsite_id'])."'";
		$ok=$db->getall($sql);		//已预订过的展位
		//$smarty->assign("ok",$ok);
		
		//-----------------------反应慢--------------------冯美峰------sql累赘
		//echo"<pre>";print_r($ok);exit;
		$html="";
		foreach( $ok  as $k =>$v){
			$html.=$v['number'].",";
			}
			//----------------判断有没有number---是否是第一次订展
			if($html !="")
			{
				$html=substr($html,0,strlen($html)-1);//去掉逗号
				$term=" and number not in(".'"$html"'.") ";
			}
			else
			{
				$term="";	
			}
		/*未预定*/
		//$sql="select number from vip_zw where number not in(select number from vip_zhanhui where zid=".$val['id'].") and subsite_id='".intval($val['subsite_id'])."'";//sql累赘
		$sql="select number from vip_zw where subsite_id='".intval($val['subsite_id'])."'".$term;
		//----------------------------------------------------------------冯美峰改
		$all=$db->getall($sql);		//没有预定的展位
		//$smarty->assign("all",$all);
		
		/*----获取参会企业列表----*/
		/*
		$qy="select * from `vip_zhanhui` where zid='".$val['id']."' and subsite_id='".intval($val['subsite_id'])."'";
		$qydata=$db->getall($qy);
		$val['yudingqiye']=$qydata;
		*/
	}else{
		/*--获取一共展位数--*/
		$num="select number from qs_jobfair where subsite_id='8' and id='".$val['id']."'";
		$gzw=$db->getone($num);
		/*以预定*/
		$yyd=$db->getone("select count(*) as yiyuding from vip_zhanhui where zid='".$val['id']."'");		//已预订过的展位
		//$smarty->assign("yiyuding",$yyd['yiyuding']);
		$val['yiyuding']=$yyd['yiyuding'];
		/*--获取一共展位数--*/
		/*--获取剩余展位数--*/
		$wyd=$gzw['number']-$yyd['yiyuding'];
		//$smarty->assign("weiyuding",$wyd);
		$val['weiyuding']=$wyd;
		
		/*----获取参会企业列表----*/
		$qy="select * from `vip_zhanhui` where zid='".$val['id']."'";
		$qydata=$db->getall($qy);
		$val['yudingqiye']=$qydata;
		//$smarty->assign("qydata",$qydata);
	
	}
	//---fff
	$val=array_map('export_mystrip_tags',$val);
	$result['code']=1;
	$result['errormsg']='';
	$result['data']=android_iconv_utf8_array($val);
	$jsonencode = android_iconv_utf8_array($result);
	//echo "<pre>";print_r($result);exit;
	$jsonencode = urldecode(json_encode($result));
	//exit($jsonencode);
	echo urldecode($jsonencode);
?>