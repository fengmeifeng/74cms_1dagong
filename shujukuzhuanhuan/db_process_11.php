<?php
header("Content-type:text/html;charset=utf-8");
// echo date('Y-m-d H:i:s',time());exit;
echo "<font color='red'>QS:qs_jobs数据到qs_jobs_search_wage的克隆(解决按工资搜索不出结果的问题)</font><br/><br/>";
//新增字段 
$cfg_dbhost = 'localhost';
$cfg_dbname_1 = '1dagong';
$cfg_dbname_2 = '1jobsupdate_db';
$cfg_dbuser = 'root';
$cfg_dbpwd = '';
$link1  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd );
// $link2  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd );
// $a=intval('数据');
// var_dump($a);exit;

//测试数据库是否链接成功
 /* if (! $link1 ) {
    die( 'Could not connect: '  .  mysql_error ());
}
echo  'Connected successfully----1' ;  */


$db_selected1  =  mysql_select_db ( $cfg_dbname_2 ,  $link1 );
// $db_selected2  =  mysql_select_db ( $cfg_dbname_2 ,  $link2 );

//测试数据库是否选择成功
/*if (! $db_selected1 ) {
    die ( 'Can\'t use : '  .  mysql_error ());
}
echo 'ok----1';
if (! $db_selected2 ) {
    die ( 'Can\'t use : '  .  mysql_error ());
}
echo 'ok----2';*/


$query1="select a.id,a.uid,a.sex,a.nature,a.topclass,a.category,a.subclass,a.district,a.sdistrict,a.education,a.experience,a.wage,a.refreshtime from qs_jobs a";
$result1=mysql_query($query1,$link1);
// echo '===1';exit;
// var_dump($result1);exit;
while ( $row  =  mysql_fetch_assoc ( $result1 )) {
	$row1[][]=$row;
}
$num_rows  =  mysql_num_rows ( $result1 );
// var_dump($row1);exit;
echo "原数据表需转换的数据有".$num_rows."条记录<br/><br/>";
// $link2  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd ); 
// $db_selected2  =  mysql_select_db ( $cfg_dbname_2 ,  $link2 );
$aff_num=0;
$time=time();
foreach($row1 as $v){
		// echo $v[0]['mid'];
		// if($v[0]['sex']=='男'){
			// $v[0]['sex']=1;
		// }else{$v[0]['sex']=0;}
		// $v[0]['form']=intval($v[0]['form']);
		// $form_field=$v[0]['jobs_name'].','.$v[0]['companyname'];
		// $form_field_2=$v[0]['jobs_name'].$v[0]['companyname'];
		$query2="insert into qs_jobs_search_wage(id,uid,sex,nature,subclass,district,sdistrict,education,experience,wage,refreshtime)
		values(".$v[0]['id'].",".$v[0]['uid'].",".$v[0]['sex'].",".$v[0]['nature'].",".$v[0]['topclass'].",".$v[0]['category'].",".$v[0]['subclass'].",".$v[0]['district']."
		,".$v[0]['sdistrict'].",".$v[0]['education'].",".$v[0]['experience'].",".$v[0]['wage'].",".$v[0]['refreshtime'].")";	
		// echo $query2."<br>";exit;
		$result2=mysql_query($query2,$link1);
		// echo mysql_affected_rows ();
		$aff_num+=1;
}
echo "<br>一共有".$aff_num."条记录转换成功";

// var_dump($result1);
// echo mysql_error();exit;
// $num_rows  =  mysql_num_rows ( $result1 );