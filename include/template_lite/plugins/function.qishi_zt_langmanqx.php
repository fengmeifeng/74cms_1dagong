<?php
/*********************************************
*骑士职位列表
* *******************************************/
function tpl_function_qishi_zt_langmanqx($params, &$smarty)
{
 //echo '===';exit;
global $db,$_CFG;
$arrset=explode(',',$params['set']);
foreach($arrset as $str)
{
$a=explode(':',$str);
	switch ($a[0])
	{
	case "列表名":
		$aset['listname'] = $a[1];
		break;
	case "显示数目":
		$aset['row'] = $a[1];
		break;
	case "开始位置":
		$aset['start'] = $a[1];
		break;
	case "排序":
		$aset['displayorder'] = $a[1];
		break;
	case "分页显示":
		$aset['page'] = $a[1];
		break;
	case "列表页":
		$aset['listpage'] = $a[1];
		break;
	}
	
}
$aset=array_map("get_smarty_request",$aset);
$aset['listname']=isset($aset['listname'])?$aset['listname']:"list";
$aset['listpage']=isset($aset['listpage'])?$aset['listpage']:"zt_langmanqx";
$aset['row']=intval($aset['row'])>0?intval($aset['row']):10;
if ($aset['row']>30)$aset['row']=1000;
$aset['start']=isset($aset['start'])?intval($aset['start']):0;
$aset['companyshow']=isset($aset['companyshow'])?$aset['companyshow']:'QS_companyshow';
$aset['jobsshow']=isset($aset['jobsshow'])?$aset['jobsshow']:'QS_jobsshow';
$openorderby=false;
if (isset($aset['displayorder']))
{
		$arr=explode('>',$aset['displayorder']);
		// 排序方式
		if($arr[1]=='desc'){
			$arr[1]="desc";
		}
		elseif($arr[1]=="asc")
		{
			$arr[1]="asc";
		}
		else
		{
			$arr[1]="desc";
		}
		if ($arr[0]=="rtime")
		{
		$orderbysql=" ORDER BY addtime {$arr[1]}";
		$jobstable='zt_qx_xuanyan';
		}
		elseif ($arr[0]=="stickrtime")
		{
		$orderbysql=" ORDER BY stick {$arr[1]} , addtime {$arr[1]}";
		$jobstable='zt_qx_xuanyan';		
		}
		elseif ($arr[0]=="hot")
		{
		$orderbysql=" ORDER BY click {$arr[1]}";
		$jobstable='zt_qx_xuanyan';		
		}
		
		elseif ($arr[0]=="key")
		{
		$orderbysql=" ORDER BY addtime {$arr[1]}";
		$jobstable='zt_qx_xuanyan';
		}
		elseif ($arr[0]=="null")
		{
		$orderbysql="";
		$jobstable='zt_qx_xuanyan';
		}
		else
		{
		$orderbysql=" ORDER BY  addtime {$arr[1]}";
		$jobstable='zt_qx_xuanyan';	
		}
}
else
{
		$orderbysql=" ORDER BY  addtime DESC";
		$jobstable='zt_qx_xuanyan';
}
$orderbysql.=",id desc ";

if (isset($aset['settr']) && $aset['settr']<>'')
{
	$settr=intval($aset['settr']);
	if ($settr>0)
	{
	$settr_val=intval(strtotime("-".$aset['settr']." day"));
	$wheresql.=" AND addtime>".$settr_val;
	}
}


if (isset($aset['key']) && !empty($aset['key']))
{
	if ($_CFG['jobsearch_purview']=='2')
	{
		if ($_SESSION['username']=='')
		{
		header("Location: ".url_rewrite('QS_login')."?url=".urlencode($_SERVER["REQUEST_URI"]));
		}
	}
	$key=trim($aset['key']);
	// echo $key;exit;
	$wheresql.=" AND companyname LIKE '%{$key}%' ";	
	$jobstable='zt_qx_xuanyan';
}

if (!empty($wheresql))
{
$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
//SQL语句加一个条件 职位所属企业必须是审核通过的企业 开始 By Z
$wheresql.=" AND audit=0";
//SQL语句加一个条件 职位所属企业必须是审核通过的企业 结束 By Z
//此处涉及的更改还有下面的 “SQL语句更改”
}else{
$wheresql.="where audit=0";
}
// echo '1111';exit; 
if (isset($aset['page']))
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$total_sql="SELECT COUNT(*) AS num FROM {$jobstable} {$wheresql}";
	//echo $total_sql;exit;
	$total_count=$db->get_total($total_sql);	
	/*if ($_CFG['jobs_list_max']>0)
	{
		$total_count>intval($_CFG['jobs_list_max']) && $total_count=intval($_CFG['jobs_list_max']);
	}*/
	$page = new page(array('total'=>$total_count, 'perpage'=>$aset['row'],'alias'=>$aset['listpage'],'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$aset['start']=abs($currenpage-1)*$aset['row'];
	if ($total_count>$aset['row'])
	{
	$smarty->assign('page',$page->show(3));
	$smarty->assign('pagemin',$page->show(4));
	$smarty->assign('pagenow',$page->show(6));
	}
	//echo $total_count;exit;
	$smarty->assign('total',$total_count);
	
}
	
	$limit=" LIMIT {$aset['start']} , {$aset['row']}";
	$list = $id = array();
	//echo "SELECT id FROM {$jobstable}  ".$wheresql.$orderbysql.$limit;exit;
	$idresult = $db->query("SELECT id FROM {$jobstable}  ".$wheresql.$orderbysql.$limit);
	// echo "SELECT id FROM {$jobstable} ".$wheresql.$orderbysql.$limit;
	// echo "SELECT a.id FROM {$jobstable} a LEFT JOIN qs_company_profile b on a.uid=b.uid ".$wheresql.$orderbysql.$limit;exit;
	while($row = $db->fetch_array($idresult))
	{
	$id[]=$row['id'];
	}
	if (!empty($id))
	{
	$wheresql=" WHERE id IN (".implode(',',$id).") ";
	//SQL语句更改 By Z  ----fff添加addtime
	//echo "SELECT * FROM zt_qx_xuanyan ".$wheresql.$orderbysql;exit;
	$result = $db->query("SELECT * FROM zt_qx_xuanyan ".$wheresql.$orderbysql);	
	// echo "SELECT * FROM ".table('jobs')." ".$wheresql.$orderbysql;
	// echo "SELECT * FROM ".table('jobs')." a LEFT JOIN qs_company_profile b on a.uid=b.uid".$wheresql.$orderbysql;exit;
		$i=1000;
		while($row = $db->fetch_array($result))
		{
		$i=$i+rand(5,500);
		$row['i']=$i;
		$row['l']=rand(0,800);
		$row['t']=rand(0,600);
		//---ffff
		$row['addtime']=daterange(time(),$row['addtime'],'Y-m-d',"#FF3300");
		//---fff
		
		$row['contents']=cut_str($row['contents'],32,0,'...');
		$row['name']=$row['name'];
		$list[] = $row;
		}
	}
	else
	{
	$list=array();
	}
	//echo $key;exit;
	$smarty->assign($aset['listname'],$list);
}
?>