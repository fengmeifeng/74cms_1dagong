<?php
/*********************************************
*骑士职位列表
* *******************************************/
function tpl_function_aqishi_jobs_list($params, &$smarty)
{
// echo '===';exit;
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
	case "职位名长度":
		$aset['jobslen'] = $a[1];
		break;
	case "企业名长度":
		$aset['companynamelen'] = $a[1];
		break;
	case "描述长度":
		$aset['brieflylen'] = $a[1];
		break;
	case "填补字符":
		$aset['dot'] = $a[1];
		break;
	case "职位分类":
		$aset['jobcategory'] = $a[1];
		break;
	case "职位大类":
		$aset['category'] = $a[1];
		break;
	case "职位小类":
		$aset['subclass'] = $a[1];
		break;
	case "地区分类":
		$aset['citycategory'] = $a[1];
		break;
	case "地区大类":
		$aset['district'] = $a[1];
		break;
	case "地区小类":
		$aset['sdistrict'] = $a[1];
		break;
	case "道路":
		$aset['street'] = $a[1];
		break;
	case "写字楼":
		$aset['officebuilding'] = $a[1];
		break;
	case "标签":
		$aset['tag'] = $a[1];
		break;
	case "行业":
		$aset['trade'] = $a[1];
		break;
	case "学历":
		$aset['education'] = $a[1];
		break;
	case "工作经验":
		$aset['experience'] = $a[1];
		break;
	case "工资":
		$aset['wage'] = $a[1];
		break;
	case "职位性质":
		$aset['nature'] = $a[1];
		break;
	case "公司规模":
		$aset['scale'] = $a[1];
		break;
	case "紧急招聘":
		$aset['emergency'] = $a[1];
		break;
	case "推荐":
		$aset['recommend'] = $a[1];
		break;
	case "关键字":
		$aset['key'] = $a[1];
		// echo $a[1] ;exit;
		break;
	case "关键字类型":
		$aset['keytype'] = $a[1];
		break;
	case "日期范围":
		$aset['settr'] = $a[1];
		break;
	case "排序":
		$aset['displayorder'] = $a[1];
		break;
	case "分页显示":
		$aset['page'] = $a[1];
		break;
	case "会员UID":
		$aset['uid'] = $a[1];
		break;
	case "公司页面":
		$aset['companyshow'] = $a[1];
		break;
	case "职位页面":
		$aset['jobsshow'] = $a[1];
		break;
	case "列表页":
		$aset['listpage'] = $a[1];
		break;
	}
	
}
$aset=array_map("get_smarty_request",$aset);
$aset['listname']=isset($aset['listname'])?$aset['listname']:"list";
$aset['listpage']=isset($aset['listpage'])?$aset['listpage']:"QS_jobslist";
$aset['row']=intval($aset['row'])>0?intval($aset['row']):10;
if ($aset['row']>30)$aset['row']=30;
$aset['start']=isset($aset['start'])?intval($aset['start']):0;
$aset['jobslen']=isset($aset['jobslen'])?intval($aset['jobslen']):8;
$aset['companynamelen']=isset($aset['companynamelen'])?intval($aset['companynamelen']):15;
$aset['brieflylen']=isset($aset['brieflylen'])?intval($aset['brieflylen']):0;
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
		$orderbysql=" ORDER BY a.refreshtime {$arr[1]}";
		$jobstable=table('jobs_search_rtime');
		}
		elseif ($arr[0]=="stickrtime")
		{
		$orderbysql=" ORDER BY a.stick {$arr[1]} , a.refreshtime {$arr[1]}";
		$jobstable=table('jobs_search_stickrtime');		
		}
		elseif ($arr[0]=="hot")
		{
		$orderbysql=" ORDER BY a.click {$arr[1]}";
		$jobstable=table('jobs_search_hot');		
		}
		elseif ($arr[0]=="scale")
		{
		$orderbysql=" ORDER BY a.scale {$arr[1]},a.refreshtime {$arr[1]}";
		$jobstable=table('jobs_search_scale');		
		}
		elseif ($arr[0]=="wage")
		{
		$orderbysql=" ORDER BY a.wage {$arr[1]},a.refreshtime {$arr[1]}";
		$jobstable=table('jobs_search_wage');		
		}
		elseif ($arr[0]=="key")
		{
		$jobstable=table('jobs_search_key');
		}
		elseif ($arr[0]=="null")
		{
		$orderbysql="";
		$jobstable=table('jobs_search_rtime');
		}
		else
		{
		$orderbysql=" ORDER BY a.stick {$arr[1]} , a.refreshtime {$arr[1]}";
		$jobstable=table('jobs_search_stickrtime');	
		}
}
else
{
		$orderbysql=" ORDER BY a.stick DESC , a.refreshtime DESC";
		$jobstable=table('jobs_search_stickrtime');
}
$orderbysql.=",a.id desc ";
//分站对数据筛选的影响，修改流程 2015-06-17 By Z
/*if ($_CFG['subsite']=="1" && intval($_CFG['subsite_id'])>0)
{
	// echo 'ok1';exit;
	$wheresql.=" AND a.subsite_id=".intval($_CFG['subsite_id'])." ";
}
//######zzzzzz
if ($_CFG['subsite']=="1" && empty($aset['citycategory']) && empty($aset['district']) && empty($aset['sdistrict']) && $_CFG['subsite_filter_jobs']=="1")
{
// echo 'okd';exit;
	$wheresql.=" AND (a.subsite_id='0' or a.subsite_id=".intval($_CFG['subsite_id']).") ";
}*/
// echo 'ok2';exit;
if (isset($aset['settr']) && $aset['settr']<>'')
{
	$settr=intval($aset['settr']);
	if ($settr>0)
	{
	$settr_val=intval(strtotime("-".$aset['settr']." day"));
	$wheresql.=" AND a.refreshtime>".$settr_val;
	}
}
if (isset($aset['uid'])  && $aset['uid']<>'')
{
	$wheresql.=" AND a.uid=".intval($aset['uid']);
}
if (isset($aset['emergency'])  && $aset['emergency']<>'')
{
	$wheresql.=" AND a.emergency=".intval($aset['emergency']);
}
if (isset($aset['recommend']) && $aset['recommend']<>'')
{
	$wheresql.=" AND a.recommend=".intval($aset['recommend']);
}
//echo $aset['nature'];exit;
if (isset($aset['nature']) && $aset['nature']<>'')
{
	if (strpos($aset['nature'],"-"))
	{
		$or=$orsql="";
		$arr=explode("-",$aset['nature']);
		if (count($arr)>10) exit();
		$sqlin=implode(",",$arr);
		if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
		{
		$wheresql.=" AND a.nature IN  (".$sqlin.") ";
		}
	}
	else
	{
	$wheresql.=" AND a.nature=".intval($aset['nature'])." ";
	}
}
if (isset($aset['scale']) && $aset['scale']<>'')
{
	$wheresql.=" AND a.scale=".intval($aset['scale']);
}
if (isset($aset['education']) && $aset['education']<>'')
{
	$wheresql.=" AND a.education=".intval($aset['education']);
}
if (isset($aset['wage'])  && $aset['wage']<>'')
{
	$wheresql.=" AND a.wage=".intval($aset['wage']);
}
if (isset($aset['experience'])  && $aset['experience']<>'')
{
	$wheresql.=" AND a.experience=".intval($aset['experience']);
}
if (isset($aset['trade']) && $aset['trade']<>'')
{
	if (strpos($aset['trade'],","))
	{
		$or=$orsql="";
		$arr=explode(",",$aset['trade']);
		$arr=array_unique($arr);
		if (count($arr)>10) exit();
		$sqlin=implode(",",$arr);
		if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
		{
		$wheresql.=" AND a.trade IN  ({$sqlin}) ";
		}
	}
	else
	{
	$wheresql.=" AND a.trade=".intval($aset['trade'])." ";
	}
}
if (!empty($aset['citycategory']))
{
		$dsql=$xsql="";
		$arr=explode(",",$aset['citycategory']);
		$arr=array_unique($arr);
		if (count($arr)>10) exit();
		foreach($arr as $sid)
		{
				$cat=explode(".",$sid);
				if (intval($cat[1])===0)
				{
				$dsql.= " OR a.district =".intval($cat[0]);
				}
				else
				{
				$xsql.= " OR a.sdistrict =".intval($cat[1]);
				}
				
				
		}
		$wheresql.=" AND  (".ltrim(ltrim($dsql.$xsql),'OR').") ";
}
else
{
	if (isset($aset['district'])  && $aset['district']<>'')
	{
		if (strpos($aset['district'],"-"))
		{
			$or=$orsql="";
			$arr=explode("-",$aset['district']);
			$arr=array_unique($arr);
			if (count($arr)>20) exit();
			$sqlin=implode(",",$arr);
			if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
			{
				$wheresql.=" AND a.district IN  ({$sqlin}) ";
			}
		}
		else
		{
			$wheresql.=" AND a.district =".intval($aset['district']);
		}
	}
	if (isset($aset['sdistrict'])  && $aset['sdistrict']<>'')
	{
		if (strpos($aset['sdistrict'],"-"))
		{
			$or=$orsql="";
			$arr=explode("-",$aset['sdistrict']);
			$arr=array_unique($arr);
			if (count($arr)>10) exit();
			$sqlin=implode(",",$arr);
			if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
			{
				$wheresql.=" AND a.sdistrict IN  ({$sqlin}) ";
			}
		}
		else
		{
			$wheresql.=" AND a.sdistrict =".intval($aset['sdistrict']);
		}
	}	
}
if (isset($aset['street']) && $aset['street']<>'')
{
	$wheresql.=" AND a.street=".intval($aset['street']);
}
if (isset($aset['officebuilding']) && $aset['officebuilding']<>'')
{
	$wheresql.=" AND a.officebuilding=".intval($aset['officebuilding']);
}
if (!empty($aset['jobcategory']))
{
	$dsql=$xsql="";
	$arr=explode(",",$aset['jobcategory']);
	$arr=array_unique($arr);
	if (count($arr)>10) exit();
	foreach($arr as $sid)
	{
		$cat=explode(".",$sid);
		if (intval($cat[2])===0)
		{
		$dsql.= " OR a.category =".intval($cat[1]);
		}
		else
		{
		$xsql.= " OR a.subclass =".intval($cat[2]);
		}
	}
	$wheresql.=" AND  (".ltrim(ltrim($dsql.$xsql),'OR').") ";
}
else
{
			if (isset($aset['category'])  && $aset['category']<>'')
			{
				if (strpos($aset['category'],"-"))
				{
					$or=$orsql="";
					$arr=explode("-",$aset['category']);
					$arr=array_unique($arr);
					if (count($arr)>10) exit();
					$sqlin=implode(",",$arr);
					if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
					{
					$wheresql.=" AND a.topclass IN  ({$sqlin}) ";
					}
				}
				else
				{
					$wheresql.=" AND a.topclass = ".intval($aset['category']);
				}
			}
			if (isset($aset['subclass'])  && $aset['subclass']<>'')
			{
				if (strpos($aset['subclass'],"-"))
				{
					$or=$orsql="";
					$arr=explode("-",$aset['subclass']);
					$arr=array_unique($arr);
					if (count($arr)>10) exit();
					$sqlin=implode(",",$arr);
					if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
					{
						$wheresql.=" AND a.category IN  ({$sqlin}) ";
					}
				}
				else
				{
					$wheresql.=" AND a.category = ".intval($aset['subclass']);
				}
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
	if ($_CFG['jobsearch_type']=='1')
	{
			$akey=explode(' ',$key);
			if (count($akey)>1)
			{
			$akey=array_filter($akey);
			$akey=array_slice($akey,0,2);
			$akey=array_map("fulltextpad",$akey);
			$key='+'.implode(' +',$akey);
			$mode=' IN BOOLEAN MODE';
			// echo $key;exit;
			}
			else
			{
			$key=fulltextpad($key);
			$mode=' ';
			}
			$wheresql.=" AND  MATCH (`key`) AGAINST ('{$key}'{$mode}) ";
	}
	else
	{
			$wheresql.=" AND a.likekey LIKE '%{$key}%' ";
	}
	if ($_CFG['jobsearch_sort']=='1')
	{
	$orderbysql=" ORDER BY a.refreshtime DESC,a.id desc ";
	}
	else
	{
	$orderbysql=" ORDER BY a.refreshtime DESC,a.id desc ";
	}	
	$jobstable=table('jobs_search_key');
}
if (isset($aset['tag']) && !empty($aset['tag']))
{
	$tag=intval($aset['tag']);
	$wheresql.=" AND  (tag1='{$tag}' OR tag2='{$tag}' OR tag3='{$tag}' OR tag4='{$tag}' OR tag5='{$tag}') ";
	$orderbysql=" order by a.id desc ";
	$jobstable=table('jobs_search_tag');
}
if (!empty($wheresql))
{
$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
//SQL语句加一个条件 职位所属企业必须是审核通过的企业 开始 By Z
$wheresql.=" AND b.audit=1";
//SQL语句加一个条件 职位所属企业必须是审核通过的企业 结束 By Z
//此处涉及的更改还有下面的 “SQL语句更改”
}else{
$wheresql.="where b.audit=1";
}
// echo '1111';exit; 
if (isset($aset['page']))
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$total_sql="SELECT COUNT(*) AS num FROM {$jobstable} a LEFT JOIN qs_company_profile b on a.uid=b.uid {$wheresql}";
	// echo $total_sql;exit;
	$total_count=$db->get_total($total_sql);	
	if ($_CFG['jobs_list_max']>0)
	{
		$total_count>intval($_CFG['jobs_list_max']) && $total_count=intval($_CFG['jobs_list_max']);
	}
	$page = new page(array('total'=>$total_count, 'perpage'=>$aset['row'],'alias'=>$aset['listpage'],'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$aset['start']=abs($currenpage-1)*$aset['row'];
	if ($total_count>$aset['row'])
	{
	$smarty->assign('page',$page->show(3));
	$smarty->assign('pagemin',$page->show(4));
	$smarty->assign('pagenow',$page->show(6));
	}
	$smarty->assign('total',$total_count);
	
}
	
	$limit=" LIMIT {$aset['start']} , {$aset['row']}";
	$list = $id = array();
	$idresult = $db->query("SELECT a.id FROM {$jobstable} a LEFT JOIN qs_company_profile b on a.uid=b.uid ".$wheresql.$orderbysql.$limit);
	// echo "SELECT id FROM {$jobstable} ".$wheresql.$orderbysql.$limit;
	// echo "SELECT a.id FROM {$jobstable} a LEFT JOIN qs_company_profile b on a.uid=b.uid ".$wheresql.$orderbysql.$limit;exit;
	while($row = $db->fetch_array($idresult))
	{
	$id[]=$row['id'];
	}
	if (!empty($id))
	{
	$wheresql=" WHERE a.id IN (".implode(',',$id).") ";
	//SQL语句更改 By Z
	$result = $db->query("SELECT *,a.id,b.audit FROM ".table('jobs')." a LEFT JOIN qs_company_profile b on a.uid=b.uid".$wheresql.$orderbysql);	
	// echo "SELECT * FROM ".table('jobs')." ".$wheresql.$orderbysql;
	// echo "SELECT * FROM ".table('jobs')." a LEFT JOIN qs_company_profile b on a.uid=b.uid".$wheresql.$orderbysql;exit;
		while($row = $db->fetch_array($result))
		{
		// echo $row['audit'];exit;
		$row['jobs_name_']=$row['jobs_name'];
		
		$row['refreshtime_cn']=daterange(time(),$row['refreshtime'],'Y-m-d',"#FF3300");
		$row['jobs_name']=cut_str($row['jobs_name'],$aset['jobslen'],0,$aset['dot']);
			if (!empty($row['highlight']))
			{
			$row['jobs_name']="<span style=\"color:{$row['highlight']}\">{$row['jobs_name']}</span>";
			}
			if ($aset['brieflylen']>0)
			{
				$row['briefly']=cut_str(strip_tags($row['contents']),$aset['brieflylen'],0,$aset['dot']);
			}
			else
			{
				$row['briefly']=strip_tags($row['contents']);
			}
		//----ff
		$row['wage_cn']=$row['wage_cn']=="面议"?'面议':$row['wage_cn'];
		//--ff
		$row['amount']=$row['amount']=="0"?'若干':$row['amount'];
		$row['briefly_']=strip_tags($row['contents']);
		$row['companyname_']=$row['companyname'];
		$row['companyname']=cut_str($row['companyname'],$aset['companynamelen'],0,$aset['dot']);
		// $row['jobs_url']=url_rewrite($aset['jobsshow'],array('id'=>$row['id']),true,$row['subsite_id']);
		$row['jobs_url']=url_rewrite($aset['jobsshow'],array('id'=>$row['id']));
		$row['company_url']=url_rewrite($aset['companyshow'],array('id'=>$row['company_id']));
		if ($row['tag'])
		{
			$tag=explode('|',$row['tag']);
			$taglist=array();
			if (!empty($tag) && is_array($tag))
			{
				foreach($tag as $t)
				{
				$tli=explode(',',$t);
				$taglist[]=array($tli[0],$tli[1]);
				}
			}
			$row['tag']=$taglist;
		}
		else
		{
		$row['tag']=array();
		}
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