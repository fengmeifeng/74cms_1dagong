<?php
/*********************************************
*导航栏目
* *******************************************/
function tpl_function_qishi_get_salary_data_all_salary($params, &$smarty)
{
	global $db,$_CFG;
	$arr=explode(',',$params['set']);
	foreach($arr as $str)
	{
	$a=explode(':',$str);
		switch ($a[0])
		{
		case "调用名称":
			$aset['alias'] = $a[1];
			break;
		case "列表名":
			$aset['listname'] = $a[1];
			break;
		case "地区":
			$aset['district'] = $a[1];
			break;
		case "职位":
			$aset['category'] = $a[1];
			break;
		}
	}
	$result = dfopen("http://www.74cms.com/salary/get_salary_data_all_salary.php?district=".$aset['district']."&category=".$aset['category']);
	// var_dump($result);die;
	if($result!="-1"){
		$result = json_decode($result,true);
	}else{
		$result="error";
	}
	
	$smarty->assign($aset['listname'],$result);
}

?>