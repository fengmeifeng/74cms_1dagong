<?php
// header("Content-type:text/html;charset=utf-8");
// echo "<font color='red'>企业会员信息的删除</font><br/><br/>";
//没有新增字段
$cfg_dbhost = '192.168.3.246';
$cfg_dbname_1 = 'demo';
// $cfg_dbname_1 = '1jobsupdate_db';
// $cfg_dbname_2 = '1jobsupdate_db';
$cfg_dbuser = '1jobstest';
// $cfg_dbuser = 'root';
$cfg_dbpwd = 'shenbo@123';
// $cfg_dbpwd = '123456';
$link1  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd );
// $link2  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd );
// $a=intval('数据');
// var_dump($a);exit;

//测试数据库是否链接成功
 /* if (! $link1 ) {
    die( 'Could not connect: '  .  mysql_error ());
}
echo  'Connected successfully----1' ;  */


$db_selected1  =  mysql_select_db ( $cfg_dbname_1 ,  $link1 );
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
// include('arr.php');
// $arr=array('合肥宝成物流有限责任公司');
// var_dump($arr);exit;
$query1="select mid,zhizhao from zjobs_diyzhizhao";
$result1=mysql_query($query1,$link1);
while ( $row  =  mysql_fetch_assoc ( $result1 )) {
	$row['zhizhao']=substr($row['zhizhao'],19);
	$row1[][]=$row;
}
// var_dump($row1);exit;
$aff_num=0;
foreach($row1 as $v){
		// echo $k.'=>'.$v;
		$query2="update qs_company_profile set
					certificate_img = '".$v[0]['zhizhao']."',
					license = '".$v[0]['zhizhao']."'
					where uid = '".$v[0]['mid']."'";
		$res=mysql_query($query2);
		$aff_num+=1;
		// echo $query1;exit;
		/*$res1=mysql_sfetch_array(mysql_query($query1,$link1));
		$query2="delete from qs_members where uid=".$res1['uid'];
		$res2=mysql_query($query2);
		$query3="delete from qs_company_profile where uid=".$res1['uid'];
		// echo $query3;exit;
		$res3=mysql_query($query3);
		$query4="delete from qs_jobs_search_stickrtime where uid=".$res1['uid'];
		$res4=mysql_query($query4);
		$query5="delete from qs_jobs where uid=".$res1['uid'];
		$res5=mysql_query($query5);*/
}
echo $aff_num;

// var_dump($result1);
// echo mysql_error();exit;
// $num_rows  =  mysql_num_rows ( $result1 );