<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	$aset=$_REQ;
	$page=isset($aset['page'])?trim($aset['page']):"";
	$page=addslashes($page);
	$page=iconv("utf-8",QISHI_DBCHARSET,$page);
	//echo $aset['page'];exit;
	$pagesize=isset($aset['pagesize'])?trim($aset['pagesize']):"";
	$pagesize=addslashes($pagesize);
	$pagesize=iconv("utf-8",QISHI_DBCHARSET,$pagesize);
	//echo $aset['pagesize'];exit;
	/*
	$district_cn=isset($aset['district_cn'])?trim($aset['district_cn']):"";
	$district_cn=iconv(QISHI_DBCHARSET,"utf-8//IGNORE",$district_cn);
	$district_cn=iconv("utf-8",QISHI_DBCHARSET,$district_cn);
	//echo $district_cn;exit;*/
	$diquid=isset($aset['areaId'])?intval($aset['areaId']):"";

	
	$orderbysql=" order BY `holddates` ASC";
	$wheresql=" WHERE display=1 AND holddates > ".strtotime(date('Y-m-d',strtotime('-1 days')));
	if(intval($aset['subsite_id'])!="0" || intval($aset['subsite_id'])!="")
	{
		$wheresql.=empty($wheresql)?" WHERE ":" AND ";
		$wheresql.=" subsite_id=".intval($aset['subsite_id']);
	}
	if(!empty($diquid))
	{
		$wheresql.=empty($wheresql)?" WHERE ":" AND ";
		$wheresql.=" subsite_id=".intval($aset['areaId']);
	}
	
	//-------fffffff----活动结束搜索
	//----." and  hour < ".date('H',time())
	isset($aset['status'])?$status=intval($aset['status']):'';//
	
	if($status == 1){$wheresql.=" AND predetermined_end <= ".time()." and  hour <= ".date('H',time());}//echo $status;exit;
	//----获取总数
	//echo $wheresql;exit;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('jobfair').$wheresql.$orderbysql;
	$total_val=$db->get_total($total_sql);
	//----获取总数结合苏
	//----fff---分页
	//$page 当前页数
	//$total_val 总条数
	//$pagesize 每页显示条数
	if(!$page) $page = 1;
	if(!$pagesize) $pagesize = 10;
	$maxpage = ceil($total_val / $pagesize);
	/*if($maxpage>0)
	{
		if($page > $maxpage) $page = $maxpage;
	}*/
	$offset = ($page - 1) * $pagesize;
	//$offset=$pagesize*($page-1);
	//----fff
	//echo $offset;exit;
	$list= array();
	$week=array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
	$time=time();
	//echo "SELECT * FROM ".table('jobfair').$wheresql.$orderbysql." LIMIT {$offset},{$pagesize}";exit;
	$res = $db->query("SELECT id,title,address,phone,holddates,predetermined_status,predetermined_web,predetermined_start,predetermined_tel,predetermined_end,hour,subsite_id FROM ".table('jobfair').$wheresql.$orderbysql." LIMIT {$offset},{$pagesize}");
	//echo $row = @mysql_fetch_array($res);exit;
	while($row = $db->fetch_array($res))
		{
			/*---------------*/
			/*以预定*/
			$yyd=$db->getone("select count(*) as yiyuding from vip_zhanhui where zid='".$row['id']."'");		//已预订过的展位
			$row['yiyuding']=$yyd['yiyuding'];
			/*未预定*/
			$wyd="select count(*) as weiyuding from vip_zw where subsite_id='".intval($row['subsite_id'])."'";
			$wyd=$db->getone($wyd);		//没有预定的展位
			$row['weiyuding']=$wyd['weiyuding']-$yyd['yiyuding'];
			/*---------------*/
			$row['title']=$row['title'];
			//$color=$row['color']?"color:".$row['color'].";":'';///----颜色
			//$weight=$row['weight']=="1"?"font-weight:bold;":'';//-----粗体
			if ($color || $weight)$row['title']="<span style=".$color.$weight.">".$row['title']."</span>";
			$row['holddates_week']=$week[date("w",$row['holddates'])];
			//$row['url'] = url_rewrite($aset['showname'],array('id'=>$row['id']));
			//$row['exhibitorsurl'] = url_rewrite($aset['exhibitorspage'],array('id'=>$row['id']));
			if ($row['predetermined_status']=="1" && ($row['predetermined_web']=="1" || $row['predetermined_tel']=="1") && date("Y-m-d",$row['holddates'])>=date("Y-m-d",$time) && $time>$row['predetermined_start'])
			{
				if($row['predetermined_end']=="0" || date("Y-m-d",$row['predetermined_end'])>date("Y-m-d",$time)){
					$row['predetermined_ok']=1;
				}elseif(date("Y-m-d",$row['predetermined_end'])==date("Y-m-d",$time)){
					if($row['hour']>date("H")){$row['predetermined_ok']=1;}
				}
				//---ffff----自己填写
				else{$row['predetermined_ok']=0;}
				//---ffff
			}
			else
			{
				$row['predetermined_ok']=0;
			}
			$row['holddates']=date("Y-m-d",$row['holddates']);
			$row['predetermined_start']=date('Y-m-d',$row['predetermined_start']);
			$row['predetermined_end']=date('Y-m-d',$row['predetermined_end']);
			$list[] = $row;
		}
	//echo "<pre>";print_r($list);exit;
		$result['code']=1;
		$result['errormsg']='';
		$result['data']=android_iconv_utf8_array($list);
		$jsonencode = android_iconv_utf8_array($result);
		$jsonencode = urldecode(json_encode($result));
		//exit($jsonencode);
		echo urldecode($jsonencode);
	
?>