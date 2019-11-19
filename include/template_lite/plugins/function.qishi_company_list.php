<?php
function tpl_function_qishi_company_list($params, &$smarty)
{
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
	case "企业名长度":
		$aset['companynamelen'] = $a[1];
		break;
	case "描述长度":
		$aset['brieflylen'] = $a[1];
		break;
	case "填补字符":
		$aset['dot'] = $a[1];
		break;
	case "行业":
		$aset['trade'] = $a[1];
		break;
	case "黄页":
		$aset['yellowpages'] = $a[1];
		break;
	case "排序":
		$aset['displayorder'] = $a[1];
		break;
	case "分页显示":
		$aset['paged'] = $a[1];
		break;
	case "公司页面":
		$aset['companyshow'] = $a[1];
		break;
	case "列表页":
		$aset['listpage'] = $a[1];
		break;
	case "行业名企":
		$aset['hymq'] = $a[1];
		break;
	}
}
//echo $aset['hymq'];exit;
if (is_array($aset)) $aset=array_map("get_smarty_request",$aset);
$aset['listname']=isset($aset['listname'])?$aset['listname']:"list";
$aset['row']=!empty($aset['row'])?intval($aset['row']):10;
$aset['start']=isset($aset['start'])?intval($aset['start']):0;
$aset['companynamelen']=isset($aset['companynamelen'])?intval($aset['companynamelen']):16;
$aset['dot']=isset($aset['dot'])?$aset['dot']:'';
$aset['companyshow']=isset($aset['companyshow'])?$aset['companyshow']:'QS_companyshow';
$aset['listpage']=!empty($aset['listpage'])?$aset['listpage']:'QS_companylist';
if ($aset['displayorder'])
{
	if (strpos($aset['displayorder'],'>'))
	{
	$arr=explode('>',$aset['displayorder']);
	$arr[0]=preg_match('/click|id/',$arr[0])?$arr[0]:"";
	$arr[1]=preg_match('/asc|desc/',$arr[1])?$arr[1]:"";
		if ($arr[0] && $arr[1])
		{
		$orderbysql=" ORDER BY `".$arr[0]."` ".$arr[1];
		}
	}
}
if (isset($aset['yellowpages']) && $aset['yellowpages']=='1' )
{
	$wheresql.=" AND yellowpages='1' ";
}
if (isset($aset['trade']) && intval($aset['trade'])>0)
{
	$wheresql.=" AND trade=".intval($aset['trade']);
}
if (!empty($wheresql))
{
$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
}
if (isset($aset['paged']))
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$total_sql="SELECT COUNT(*) AS num FROM ".table('company_profile').$wheresql;
	$total_count=$db->get_total($total_sql);
	$pagelist = new page(array('total'=>$total_count, 'perpage'=>$aset['row'],'alias'=>$aset['listpage'],'getarray'=>$_GET));
	$currenpage=$pagelist->nowindex;
	$aset['start']=($currenpage-1)*$aset['row'];
		if ($total_count>$aset['row'])
		{
		$smarty->assign('page',$pagelist->show(3));
		}
		$smarty->assign('total',$total_count);
}
$limit=" LIMIT ".abs($aset['start']).','.$aset['row'];
$result = $db->query("SELECT * FROM ".table('company_profile')." ".$wheresql.$orderbysql.$limit);
$list= array();
while($row = $db->fetch_array($result))
{
	$row['companyname_']=$row['companyname'];
	$row['companyname']=cut_str($row['companyname'],$aset['companynamelen'],0,$aset['dot']);
	$row['url'] = url_rewrite($aset['companyshow'],array('id'=>$row['id']));
	$row['contents']=str_replace('&nbsp;','',$row['contents']);
	$row['briefly_']=strip_tags($row['contents']);
	$row['briefly']=strip_tags($row['briefly_']);
		if ($aset['brieflylen']>0)
		{
		$row['briefly']=cut_str(strip_tags($row['contents']),$aset['brieflylen'],0,$aset['dot']);
		}
		if ($row['logo'])
		{
			$row['logo']=$_CFG['main_domain']."data/logo/".$row['logo'];
		}
		else
		{
			$row['logo']=$_CFG['main_domain']."data/logo/no_logo.gif";
		}
	$row['jobs_num'] = $db->get_total("select count(*) as num from ".table('jobs')." where company_id=".$row['id']);
	$row['comment_num'] = $db->get_total("select count(*) as num from ".table('comment')." where company_id=".$row['id']." and audit=1");
	$list[] = $row;
}

if($aset['hymq']){
	//echo "行业名企列表";exit;
	
	
	}
//echo "23233";exit;
$smarty->assign($aset['listname'],$list);
}
?>