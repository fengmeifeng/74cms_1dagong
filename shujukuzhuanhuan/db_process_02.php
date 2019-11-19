<?php
// include_once("array01.php");
// var_dump($qs_city_parent);exit;
header("Content-type:text/html;charset=utf-8");
// $a="安徽省合肥市";
// echo substr($a,9,18);exit;
echo "<font color='red'>Dede:zjobs_member||zjobs_member_person ====》》》 QS:qs_members_info 个人会员信息的数据转换</font><br/><br/>";
//在qs_members_info表里新建 phone2--备用手机，form--标志注册来源（已入职员工注册|1+2平台注册|微信注册）
// echo '11111123';exit;
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


$query1="select a.userid,a.mid,a.sphone2,a.form,b.sex,b.uname,b.syear,b.address from zjobs_member_person b inner join zjobs_member a on b.mid=a.mid where a.mtype='个人'";
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
		if($v[0]['sex']=='男'){
			$v[0]['sex']=1;
		}else{$v[0]['sex']=0;}
		$v[0]['form']=intval($v[0]['form']);
		// $sheng_name=substr($v[0]['address'],0,9);
		// $shi_name=substr($v[0]['address'],9,18);
		// foreach($qs_city_parent as $k1 =>$v1){
			// if ($v1==$sheng_name){
				// $s1=$k1;
			// }
		// }
		// foreach($qs_city[$s1] as $k2 => $v2){
			// if($v2==$shi_name){
				// $s2=$k2;
			// }
		// }
		// echo $s1.'===='.$s2;exit;
		$query2="insert into qs_members_info(uid,realname,sex,birthday,phone,residence,residence_cn,form,phone2) values(".$v[0]['mid'].",'".$v[0]['uname']."',".$v[0]['sex'].",'".$v[0]['syear']."','".$v[0]['userid']."','".$v[0]['address']."','".$v[0]['address']."',".$v[0]['form'].",'".$v[0]['sphone2']."')";	
		// echo $query2."<br>";
		$result2=mysql_query($query2,$link2);
		// echo mysql_affected_rows ();
		$aff_num+=1;
}
echo "<br>一共有".$aff_num."条记录转换成功";

// var_dump($result1);
// echo mysql_error();exit;
// $num_rows  =  mysql_num_rows ( $result1 );