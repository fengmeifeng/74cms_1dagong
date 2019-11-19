<?php
header("Content-type:text/html;charset=utf-8");
// echo md5('123456');exit;
echo "<font color='red'>Dede:zjobs_member ====》》》 QS:qs_members 会员信息的数据转换</font><br/><br/>";
//数据库初始化
$cfg_dbhost = 'localhost';
$cfg_dbname_1 = '1dagong';
$cfg_dbname_2 = '1jobsupdate_db';
$cfg_dbuser = 'root';
$cfg_dbpwd = '';
$link1  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd );
// $link2  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd );

//测试数据库是否链接成功
/* if (! $link1 ) {
    die( 'Could not connect: '  .  mysql_error ());
}
echo  'Connected successfully----1' ; 
 if (! $link2 ) {
    die( 'Could not connect: '  .  mysql_error ());
}
echo  'Connected successfully----2' ; */

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
//此处去掉mid的限制即可
$query1="select mid, mtype, email, xiaoshou, userid, pwd, jointime, joinip, logintime, loginip from zjobs_member";
$result1=mysql_query($query1,$link1);
// $tem_arr=array('mid','mtype','email','xiaoshou','pwd','jointime','joinip','logintime','loginip');
// var_dump($tem_arr);exit;
while ( $row  =  mysql_fetch_assoc ( $result1 )) {
    // for($i=0;$i<9;$i++){
    	// $tem=$tem_arr[$i];
    	// $row1[][$tem]=$row[$tem];
	// }
	$row1[][]=$row;
}
$num_rows  =  mysql_num_rows ( $result1 );
echo "原数据表zjobs_member有".$num_rows."条记录<br/><br/>";

// $row1=mysql_fetch_assoc($result1);
// var_dump($row1);exit;
$link2  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd ); 
$db_selected2  =  mysql_select_db ( $cfg_dbname_2 ,  $link2 );
/*if (! $db_selected2 ) {
    die ( 'Can\'t use : '  .  mysql_error ());
}
echo 'ok----2';*/

$aff_num=0;
foreach($row1 as $v){
		// echo $v[0]['mid'];
		if($v[0]['mtype']=='个人'){
			$v[0]['mtype']=2;
		}else{$v[0]['mtype']=1;}
		$query2="insert into qs_members(uid,utype,username,email,xs_user,mobile,password,reg_time,reg_ip,last_login_time,last_login_ip)
		values(".$v[0]['mid'].",".$v[0]['mtype'].",'".$v[0]['userid']."','".$v[0]['email']."','".$v[0]['xiaoshou']."','".$v[0]['userid']."','".$v[0]['pwd']."',".$v[0]['jointime'].",'".$v[0]['joinip']."',".$v[0]['logintime'].",'".$v[0]['loginip']."')";	
		// echo $query2."<br>";
		$result2=mysql_query($query2,$link2);
		$aff_num+=1;
}
echo "<br>一共有".$aff_num."条记录转换成功";
// mysql_free_result ( $result1 );
// mysql_free_result ( $result2 );  
// var_dump($query2);exit;

//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------

//Dede:zjobs_member||zjobs_member_person ====》》》 QS:qs_members_info 的数据转换
//在qs_members_info表里新建 phone2--备用手机，
// $query1="select a.sphone2,a.form,b.sex,b.uname,b.syear,b.address from zjobs_member_person b left join zjobs_member a on a.mid=b.mid where a.mtype='个人'";
// $result1=mysql_query($query1,$link1);
// $num_rows  =  mysql_num_rows ( $result1 );