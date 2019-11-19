<?php
header("Content-type:text/html;charset=utf-8");
echo "<font color='red'>Dede:zjobs_member_stow ====》》》 QS:qs_personal_jobs_apply 简历投递记录信息的数据转换</font><br/><br/>";
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


$query1="select a.aid,a.mid,a.company_id,a.title,a.person,a.company,a.addtime,a.type,a.p_aid from zjobs_member_stow a";
$result1=mysql_query($query1,$link1);
// echo '===1';exit;
// var_dump($result1);exit;
while ( $row  =  mysql_fetch_assoc ( $result1 )) {
	$row1[][]=$row;
}
$num_rows  =  mysql_num_rows ( $result1 );
// var_dump($row1);exit;
echo "原数据表需转换的数据有".$num_rows."条记录<br/><br/>";
$link2  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd ); 
$db_selected2  =  mysql_select_db ( $cfg_dbname_2 ,  $link2 );
$aff_num=0;
foreach($row1 as $v){
		// echo $v[0]['mid'];
		// if($v[0]['sex']=='男'){
			// $v[0]['sex']=1;
		// }else{$v[0]['sex']=0;}
		// $v[0]['form']=intval($v[0]['form']);
		$query2="insert into qs_personal_jobs_apply(jobs_id,personal_uid,company_uid,jobs_name,resume_name,company_name,apply_addtime,type,resume_id)
		values(".$v[0]['aid'].",".$v[0]['mid'].",".$v[0]['company_id'].",'".$v[0]['title']."','".$v[0]['person']."',
		'".$v[0]['company']."','".$v[0]['addtime']."','".$v[0]['type']."','".$v[0]['p_aid']."')";	
		// echo $query2."<br>";exit;
		$result2=mysql_query($query2,$link2);
		// echo mysql_affected_rows ();
		$aff_num+=1;
}
echo "<br>一共有".$aff_num."条记录转换成功";

// var_dump($result1);
// echo mysql_error();exit;
// $num_rows  =  mysql_num_rows ( $result1 );