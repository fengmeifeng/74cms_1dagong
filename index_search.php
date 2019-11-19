<?php
//处理首页的搜索
	$key=urlencode($_POST['key']);
	// echo $key;
	$citycategory=trim($_POST['citycategory']);
	$types=intval($_POST['types']);
	//echo $key."<br>";echo $types;exit;
	if($types =='2'){
		//echo "....".$key;exit;
	header("Location:company/comapny-search.php?key=$key&citycategory=$citycategory");	
	}else{
	header("Location:jobs/jobs-list.php?key=$key&citycategory=$citycategory");	
	}
?>