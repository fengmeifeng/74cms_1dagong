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
$resumetable=table('resume_search_rtime');
if (!empty($aset['displayorder']))
{
	$arr=explode('>',$aset['displayorder']);
	$arr[1]=preg_match('/asc|desc/',$arr[1])?$arr[1]:"desc";
	if ($arr[0]=="rtime")
	{
		$orderbysql=" ORDER BY r.refreshtime {$arr[1]}";
	}
}
if (!empty($aset['category']) || !empty($aset['subclass']) || !empty($aset['jobcategory']))
{
	if (!empty($aset['jobcategory']))
	{
					$dsql=$xsql="";
					$arr=explode("-",$aset['jobcategory']);
					$arr=array_unique($arr);
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
					$joinwheresql.=" WHERE ".ltrim(ltrim($dsql.$xsql),'OR');
	}
	else
	{
					if (!empty($aset['category']))
					{
						if (strpos($aset['category'],"-"))
						{
							$or=$orsql="";
							$arr=explode("-",$aset['category']);
							$sqlin=implode(",",$arr);
							if (count($arr)>10) exit();
							$sqlin=implode(",",$arr);
							if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
							{
								$joinwheresql.=" AND category IN  ({$sqlin}) ";
							}
						}
						else
						{
							$joinwheresql.=" AND  category=".intval($aset['category']);
						}
					}
					if (!empty($aset['subclass']))
					{
						if (strpos($aset['subclass'],"-"))
						{
							$or=$orsql="";
							$arr=explode("-",$aset['subclass']);
							if (count($arr)>10) exit();
							$sqlin=implode(",",$arr);
							if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
							{
								$joinwheresql.=" AND subclass IN  ({$sqlin}) ";
							}
						}
						else
						{
						$joinwheresql.=" AND subclass=".intval($aset['subclass']);
						}
					}
					if (!empty($joinwheresql))
					{
					$joinwheresql=" WHERE ".ltrim(ltrim($joinwheresql),'AND');
					}
					
	}
	$joinsql="  INNER  JOIN  ( SELECT DISTINCT pid FROM ".table('resume_jobs')." {$joinwheresql} )AS j ON  r.id=j.pid ";
}
if (!empty($aset['citycategory']))
{
		if (strpos($aset['citycategory'],"-"))
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
						$dsql.= " OR r.district =".intval($cat[0]);
						}
						else
						{
						$xsql.= " OR r.sdistrict =".intval($cat[1]);
						}
					}
					$wheresql.=" AND  (".ltrim(ltrim($dsql.$xsql),'OR').") ";
		}
		else
		{
				$cat=explode(".",$aset['citycategory']);
				if (intval($cat[1])>0)
				{
				$wheresql.=" AND r.sdistrict =".intval($cat[1]);
				}
				else
				{
				$wheresql.=" AND r.district=".intval($cat[0])." ";
				}
		}
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
					if (count($arr)>10) exit();
					$sqlin=implode(",",$arr);
					if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
					{
						$wheresql.=" AND r.district IN  ({$sqlin}) ";
					}
				}
				else
				{
				$wheresql.=" AND r.district=".intval($aset['district'])." ";
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
						$wheresql.=" AND r.sdistrict IN  ({$sqlin}) ";
					}
				}
				else
				{
					$wheresql.=" AND r.sdistrict=".intval($aset['sdistrict'])." ";
				}
			}	
}
if (isset($aset['settr']) && !empty($aset['settr']))
{
	$settr_val=intval(strtotime("-".intval($aset['settr'])." day"));
	$wheresql.=" AND r.refreshtime > ".$settr_val;
}
if (isset($aset['experience']) && !empty($aset['experience']))
{
	$wheresql.=" AND r.experience=".intval($aset['experience'])." ";
}
if (isset($aset['education']) && !empty($aset['education']))
{
	$wheresql.=" AND r.education=".intval($aset['education'])." ";
}
if (isset($aset['talent']) && !empty($aset['talent']))
{
	$wheresql.=" AND r.talent=".intval($aset['talent'])." ";
}
if (isset($aset['photo']) && !empty($aset['photo']))
{
	$wheresql.=" AND r.photo='".intval($aset['photo'])."' ";
}
if (isset($aset['sex'])  && !empty($aset['sex']))
{
	$wheresql.=" AND r.sex=".intval($aset['sex'])."";
}
if (isset($aset['key']) && !empty($aset['key']))
{
	$key=trim($aset['key']);
	$key=iconv("utf-8",QISHI_DBCHARSET,$key);
	$key=addslashes($key);
	if ($_CFG['resumesearch_type']=='1')
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
		$wheresql.=" AND  MATCH (r.`key`) AGAINST ('{$key}'{$mode}) ";
	}
	else
	{
		$wheresql.=" AND r.likekey LIKE '%{$key}%' ";
	}
		if ($_CFG['resumesearch_sort']=='1')
		{
		$orderbysql="";
		}
		else
		{
		$orderbysql=" ORDER BY r.refreshtime DESC ";
		}
	$resumetable=table('resume_search_key');
}
$wheresql.=" AND r.display='1' ";
if (!empty($wheresql))
{
$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
}
$limit=" LIMIT {$aset['start']} , {$aset['row']}";
$list = $id = array();
//@file_put_contents('2.txt', "SELECT id FROM {$resumetable}  AS r".$joinsql.$wheresql.$orderbysql.$limit, LOCK_EX);
$idresult = $db->query("SELECT id FROM {$resumetable}  AS r".$joinsql.$wheresql.$orderbysql.$limit);
	//echo "SELECT id FROM {$resumetable}  AS r".$joinsql.$wheresql.$orderbysql.$limit;
	while($row = $db->fetch_array($idresult))
	{
	$id[]=$row['id'];
	}
	if (!empty($id))
	{
	$wheresql=" WHERE id IN (".implode(',',$id).") ";
	$result = $db->query("SELECT * FROM ".table('resume')."  AS r ".$wheresql.$orderbysql);
		while($row = $db->fetch_array($result))
		{
				if ($row['display_name']=="2")
				{
					$row['fullname']="N".str_pad($row['id'],7,"0",STR_PAD_LEFT);
				}
				elseif($row['display_name']=="3")
				{
					$row['fullname']=cut_str($row['fullname'],1,0,"**");
				}
				else
				{
					$row['fullname']=$row['fullname'];
				}
			$row['specialty']=strip_tags($row['specialty']);
			$row['specialty']=cut_str(strip_tags($row['specialty']),80,0,'');
			$row['age']=date("Y")-$row['birthdate'];
			$row['addtime']=date("Y-m-d",$row['addtime']);
			$row['refreshtime']=date("Y-m-d",$row['refreshtime']);
			unset($row['tag'],$row['key'],$row['subsite_id'],$row['display'],$row['display_name'],$row['audit'],$row['title'],$row['email_notify'],$row['photo'],$row['photo_img'],$row['photo_display'],$row['complete'],$row['user_status'],$row['tpl'],$row['tpl']);
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
$androidresult['list']=android_iconv_utf8_array($list);
$jsonencode = json_encode($androidresult);
echo urldecode($jsonencode);
?>