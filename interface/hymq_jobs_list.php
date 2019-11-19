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
	$district_cn=isset($aset['district_cn'])?trim($aset['district_cn']):"";
	$district_cn=iconv(QISHI_DBCHARSET,"utf-8//IGNORE",$district_cn);
	$district_cn=iconv("utf-8",QISHI_DBCHARSET,$district_cn);
	//echo $district_cn;exit;
	$orderbysql=" ORDER BY refreshtime desc";
	$wheresql=" WHERE audit=1 and display=1 and deadline > ".time();
	isset($aset['district_cn'])?$wheresql.=" AND district_cn like '%".$district_cn."%'":'';//地区条件
	isset($aset['wage'])?$wheresql.=" AND wage=".intval($aset['wage'])." ":'';//工资条件
	
	//-------fffffff
	$category_cn=isset($aset['category_cn'])?trim($aset['category_cn']):"";
	$category_cn=iconv(QISHI_DBCHARSET,"utf-8//IGNORE",$category_cn);
	$category_cn=iconv("utf-8",QISHI_DBCHARSET,$category_cn);
	isset($aset['category_cn'])?$wheresql.=" AND category_cn='".$category_cn."' ":'';//职位分类
	isset($aset['category'])?$wheresql.=" AND category=".intval($aset['category'])." ":'';//
	isset($aset['subclass'])?$wheresql.=" AND subclass=".intval($aset['subclass'])." ":'';//
	
	//----获取总数
	//echo $wheresql;exit;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('shenhe_jobs').$wheresql.$orderbysql;
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
	//echo "SELECT id,companyname,wage_cn,logo,bmrenshu,addtime,refreshtime,category_cn,tag FROM ".table('shenhe_jobs').$wheresql.$orderbysql." LIMIT {$offset},{$pagesize}";exit;
	$res = $db->query("SELECT id,companyname,wage_cn,logo,bmrenshu,addtime,refreshtime,category_cn,tag,district_cn FROM ".table('shenhe_jobs').$wheresql.$orderbysql." LIMIT {$offset},{$pagesize}");
	//echo $row = @mysql_fetch_array($res);exit;
	$list= array();
	while($row = $db->fetch_array($res))
		{
			//---fff
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
			//---fff
			$row['logo']="http://www.1dagong.com/data/hymq_img/".$row['logo'];
			$row['addtime']=daterange(time(),$row['addtime'],'Y-m-d',"#FF3300");
			$row['refreshtime']=daterange(time(),$row['refreshtime'],'Y-m-d',"#FF3300");
			$row['bmrenshu']=$row['bmrenshu'];
			if($row['wage_cn'] !='面议'){$row['wage_cn']=$row['wage_cn']."/月";}
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