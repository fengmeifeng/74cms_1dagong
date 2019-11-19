<?php
header("Content-type:text/html;charset=utf-8");
echo "<font color='red'>Dede:zjobs_member_company ====》》》 QS:qs_company_profile 企业会员信息的数据转换</font><br/><br/>";
//没有新增字段
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


$query1="select a.mid,a.company,a.nativeplace,a.linkman,a.email from zjobs_member_company a";
$result1=mysql_query($query1,$link1);
// echo '===1';exit;
// var_dump($result1);exit;
while ( $row  =  mysql_fetch_assoc ( $result1 )) {
	// var_dump($row['nativeplace']);
	$s=$row['nativeplace'];
	$query1_1="select diqu_cn from zjobs_diqu_shuzu where diqu_id=$s";
	// echo $query1_1;exit;
	$s1=mysql_fetch_array(mysql_query($query1_1,$link1));
	// echo $s1['diqu_cn'];exit;
	$row['nativeplace']=$s1['diqu_cn'];
	$row1[][]=$row;
}
$num_rows  =  mysql_num_rows ( $result1 );
// var_dump($row1);exit;
echo "原数据表需转换的数据有".$num_rows."条记录<br/><br/>";
$link2  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd ); 
$db_selected2  =  mysql_select_db ( $cfg_dbname_2 ,  $link2 );
$aff_num=0;
foreach($row1 as $v){
		$s_2=$v[0]['nativeplace'];
		// echo $s_2;exit;
		$query2_2="select id,parentid from qs_category_district where categoryname='".$s_2."'";
		// echo $query2_2;exit;
		$s2=mysql_fetch_array(mysql_query($query2_2,$link2));
		// echo $s2;
		$s_sdistrict=$s2['id'];
		$s_district=$s2['parentid'];
		// echo $v[0]['mid'];
		// if($v[0]['sex']=='男'){
			// $v[0]['sex']=1;
		// }else{$v[0]['sex']=0;}
		// $v[0]['form']=intval($v[0]['form']);
		$query2="insert into qs_company_profile(id,uid,companyname,district,sdistrict,contact,email) values(".$v[0]['mid'].",".$v[0]['mid'].",'".$v[0]['company']."',".$s_district.",".$s_sdistrict.",'".$v[0]['linkman']."','".$v[0]['email']."')";	
		// echo $query2."<br>";
		$result2=mysql_query($query2,$link2);
		// echo mysql_affected_rows ();
		$aff_num+=1;
}
echo "<br>一共有".$aff_num."条记录转换成功";

// var_dump($result1);
// echo mysql_error();exit;
// $num_rows  =  mysql_num_rows ( $result1 );