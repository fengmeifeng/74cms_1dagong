<?php 
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
unset($dbhost,$dbuser,$dbpass,$dbname);
$aset=$_REQ;
$aset['start']=intval($aset['start']);
$aset['row']=intval($aset['row']);
if ($aset['row']==0)
{
$aset['row']=10;
}
if (!empty($aset['displayorder']))
{
		$arr=explode('>',$aset['displayorder']);
		$arr[1]=preg_match('/asc|desc/',$arr[1])?$arr[1]:"desc";
		if ($arr[0]=="rtime")
		{
		$orderbysql=" ORDER BY refreshtime {$arr[1]}";
		$jobstable=table('jobs_search_rtime');
		}
		elseif ($arr[0]=="stickrtime")
		{
		$orderbysql=" ORDER BY stick {$arr[1]} , refreshtime {$arr[1]}";
		$jobstable=table('jobs_search_stickrtime');		
		}
		elseif ($arr[0]=="hot")
		{
		$orderbysql=" ORDER BY click {$arr[1]}";
		$jobstable=table('jobs_search_hot');		
		}
		elseif ($arr[0]=="scale")
		{
		$orderbysql=" ORDER BY scale {$arr[1]},refreshtime {$arr[1]}";
		$jobstable=table('jobs_search_scale');		
		}
		elseif ($arr[0]=="wage")
		{
		$orderbysql=" ORDER BY wage {$arr[1]},refreshtime {$arr[1]}";
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
		$orderbysql=" ORDER BY stick {$arr[1]} , refreshtime {$arr[1]}";
		$jobstable=table('jobs_search_stickrtime');	
		}
}
else
{
		$orderbysql=" ORDER BY stick DESC , refreshtime DESC";
		$jobstable=table('jobs_search_stickrtime');
}
if (isset($aset['settr']) && $aset['settr']<>'')
{
	$settr=intval($aset['settr']);
	if ($settr>0)
	{
	$settr_val=intval(strtotime("-".$aset['settr']." day"));
	$wheresql.=" AND refreshtime>".$settr_val;
	}
}
if (isset($aset['uid'])  && $aset['uid']<>'')
{
	$wheresql.=" AND uid=".intval($aset['uid']);
}
if (isset($aset['emergency'])  && $aset['emergency']<>'')
{
	$wheresql.=" AND emergency=".intval($aset['emergency']);
}
if (isset($aset['recommend']) && $aset['recommend']<>'')
{
	$wheresql.=" AND recommend=".intval($aset['recommend']);
}
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
		$wheresql.=" AND nature IN  (".$sqlin.") ";
		}
	}
	else
	{
	$wheresql.=" AND nature=".intval($aset['nature'])." ";
	}
}
if (isset($aset['rand'])  && $aset['rand']<>'')
{
	$orderbysql=" ORDER BY RAND() ";
}
if (isset($aset['scale']) && $aset['scale']<>'')
{
	$wheresql.=" AND scale=".intval($aset['scale']);
}
if (isset($aset['education']) && $aset['education']<>'')
{
	$wheresql.=" AND education=".intval($aset['education']);
}
if (isset($aset['wage'])  && $aset['wage']<>'')
{
	$wheresql.=" AND wage=".intval($aset['wage']);
}
if (isset($aset['experience'])  && $aset['experience']<>'')
{
	$wheresql.=" AND experience=".intval($aset['experience']);
}
if (isset($aset['trade']) && $aset['trade']<>'')
{
	if (strpos($aset['trade'],"-"))
	{
		$or=$orsql="";
		$arr=explode("-",$aset['trade']);
		$arr=array_unique($arr);
		if (count($arr)>10) exit();
		$sqlin=implode(",",$arr);
		if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
		{
		$wheresql.=" AND trade IN  ({$sqlin}) ";
		}
	}
	else
	{
	$wheresql.=" AND trade=".intval($aset['trade'])." ";
	}
}
if (!empty($aset['citycategory']))
{
		$dsql=$xsql="";
		$arr=explode("-",$aset['citycategory']);
		$arr=array_unique($arr);
		if (count($arr)>10) exit();
		foreach($arr as $sid)
		{
				$cat=explode(".",$sid);
				if (intval($cat[1])===0)
				{
				$dsql.= " OR district =".intval($cat[0]);
				}
				else
				{
				$xsql.= " OR sdistrict =".intval($cat[1]);
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
				$wheresql.=" AND district IN  ({$sqlin}) ";
			}
		}
		else
		{
			$wheresql.=" AND district =".intval($aset['district']);
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
				$wheresql.=" AND sdistrict IN  ({$sqlin}) ";
			}
		}
		else
		{
			$wheresql.=" AND sdistrict =".intval($aset['sdistrict']);
		}
	}	
}
if (isset($aset['street']) && $aset['street']<>'')
{
	$wheresql.=" AND street=".intval($aset['street']);
}
if (isset($aset['officebuilding']) && $aset['officebuilding']<>'')
{
	$wheresql.=" AND officebuilding=".intval($aset['officebuilding']);
}
if (!empty($aset['jobcategory']))
{
	$dsql=$xsql="";
	$arr=explode("-",$aset['jobcategory']);
	$arr=array_unique($arr);
	if (count($arr)>10) exit();
	foreach($arr as $sid)
	{
		$cat=explode(".",$sid);
		if (intval($cat[1])===0)
		{
		$dsql.= " OR category =".intval($cat[0]);
		}
		else
		{
		$xsql.= " OR subclass =".intval($cat[1]);
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
					$wheresql.=" AND category IN  ({$sqlin}) ";
					}
				}
				else
				{
					$wheresql.=" AND category = ".intval($aset['category']);
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
						$wheresql.=" AND subclass IN  ({$sqlin}) ";
					}
				}
				else
				{
					$wheresql.=" AND subclass = ".intval($aset['subclass']);
				}
			}
}
if (isset($aset['key']) && !empty($aset['key']))
{
	$key=trim($aset['key']);
	$key=iconv("utf-8",QISHI_DBCHARSET,$key);
	$key=addslashes($key);
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
			$wheresql.=" AND likekey LIKE '%{$key}%' ";
	}
	if ($_CFG['jobsearch_sort']=='1')
	{
	$orderbysql="";
	}
	else
	{
	$orderbysql=" ORDER BY refreshtime DESC ";
	}	
	$jobstable=table('jobs_search_key');
}
if (isset($aset['tag']) && !empty($aset['tag']))
{
	$tag=intval($aset['tag']);
	$wheresql.=" AND  (tag1='{$tag}' OR tag2='{$tag}' OR tag3='{$tag}' OR tag4='{$tag}' OR tag5='{$tag}') ";
	$orderbysql="";
	$jobstable=table('jobs_search_tag');
}
if (!empty($wheresql))
{
$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
}
$limit=" LIMIT {$aset['start']} , {$aset['row']}";
	$list = $id = array();
	$idresult = $db->query("SELECT id FROM {$jobstable} ".$wheresql.$orderbysql.$limit);
	//echo "SELECT id FROM {$jobstable} ".$wheresql.$orderbysql.$limit;
	while($row = $db->fetch_array($idresult))
	{
	$id[]=$row['id'];
	}
	if (!empty($id))
	{
	$wheresql=" WHERE id IN (".implode(',',$id).") ";
	$result = $db->query("SELECT * FROM ".table('jobs').$wheresql.$orderbysql);	
		while($row = $db->fetch_array($result))
		{
		unset($row['key'],$row['subsite_id'],$row['robot'],$row['user_status'],$row['display'],$row['tpl'],$row['map_x'],$row['map_y']);
		$row['jobs_name']=android_iconv_utf8($row['jobs_name']);
		$row['companyname']=android_iconv_utf8($row['companyname']);
		$row['company_addtime']=date("Y-m-d",$row['company_addtime']);
		$row['refreshtime_cn']=daterange(time(),$row['refreshtime'],'Y-m-d',"#FF3300");
		$row['nature_cn']=android_iconv_utf8($row['nature_cn']);
		$row['sex_cn']=android_iconv_utf8($row['sex_cn']);
		$row['category_cn']=android_iconv_utf8($row['category_cn']);
		$row['trade_cn']=android_iconv_utf8($row['trade_cn']);
		$row['scale_cn']=android_iconv_utf8($row['scale_cn']);
		$row['district_cn']=android_iconv_utf8($row['district_cn']);
		$row['street_cn']=android_iconv_utf8($row['street_cn']);
		$row['officebuilding_cn']=android_iconv_utf8($row['officebuilding_cn']);
		$row['education_cn']=android_iconv_utf8($row['education_cn']);
		$row['experience_cn']=android_iconv_utf8($row['experience_cn']);
		$row['wage_cn']=android_iconv_utf8($row['wage_cn']);
		$row['contents']=cut_str(strip_tags($row['contents']),50,0,'...');
		$row['contents']=android_iconv_utf8($row['contents']);
		$row['addtime']=date("Y-m-d",$row['addtime']);
		$row['deadline']=date("Y-m-d",$row['deadline']);
		$row['refreshtime']=date("Y-m-d",$row['refreshtime']);
		$row['setmeal_deadline']=date("Y-m-d",$row['setmeal_deadline']);
		$row['setmeal_name']=android_iconv_utf8($row['setmeal_name']);
		$list[] = $row;
		}
	}
	else
	{
	$list=array();
	}
	$list=array_map('export_mystrip_tags',$list);
$androidresult['result']=1;
$androidresult['errormsg']='';
$androidresult['list']=$list;
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>