<?php
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC"); 
echo "<font color='red'>Dede:zjobs_archives 和zjobs_addjianli82 ====》》》 QS:qs_resume 和 QS:qs_resume_work 个人发布简历信息的数据转换</font><br/><br/>";
//没有新增字段
// echo date('m',1426152967);exit;
$cfg_dbhost = 'localhost';
$cfg_dbname_1 = '1dagong';
$cfg_dbname_2 = '1jobsupdate_db';
$cfg_dbuser = 'root';
$cfg_dbpwd = '';
$link1  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd );

$db_selected1  =  mysql_select_db ( $cfg_dbname_1 ,  $link1 );

$query1="select a.mid, a.title, b.sex, b.age, b.phone, b.zhiwei, b.zwleixing, b.edu, 
b.pay, b.gzjingyan, b.nativeplace, b.address, b.jingyan, b.gsname, b.gztime, b.lasttime, b.pingjia
 from zjobs_archives a inner join zjobs_addjianli82 b on a.id=b.aid where a.typeid=42";
$result1=mysql_query($query1,$link1);
// echo '===1';exit;
// var_dump($result1);exit;
while ( $row  =  mysql_fetch_assoc ( $result1 )) {
	$s=$row['nativeplace'];
	$query1_1="select diqu_cn from zjobs_diqu_shuzu where diqu_id=$s";
	// echo $query1_1;exit;
	$s1=mysql_fetch_array(mysql_query($query1_1,$link1));
	// echo $s1['diqu_cn'];exit;
	$row['nativeplace']=$s1['diqu_cn'];
	// echo $row['nativeplace'];exit;
	$row1[][]=$row;
}
$num_rows  =  mysql_num_rows ( $result1 );
// var_dump($row1);exit;
echo "原数据表需转换的数据有".$num_rows."条记录<br/><br/>";
$link2  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd ); 
$db_selected2  =  mysql_select_db ( $cfg_dbname_2 ,  $link2 );
$aff_num=0;
$year=intval(date('Y',time()));
$refreshtime=time();
foreach($row1 as $v){
		$s_2=$v[0]['nativeplace'];
		// echo $s_2;exit;
		$query2_2="select id,parentid from qs_category_district where categoryname='".$s_2."'";
		// echo $query2_2;exit;
		$s2=mysql_fetch_array(mysql_query($query2_2,$link2));
		// echo $s2;
		$s_sdistrict=$s2['id'];
		$s_district=$s2['parentid'];
		//这里还可以继续用parentid 去查 省份 ，然后写进district_cn字段里
		//...
		//...
		// echo $s_2.'======'.$s_sdistrict.'==='.$s_district;exit;
		// echo $v[0]['mid'];
		if($v[0]['sex']=='男'){
			$v[0]['sex_num']=1;
		}else{$v[0]['sex_num']=0;}
		$v[0]['age']=$year+1-$v[0]['age'];
		if($v[0]['zwleixing']=='全职'){
			$v[0]['zwleixing_cn']=62;
		}else{$v[0]['zwleixing_cn']=63;}
		switch ( $v[0]['edu'] ) {
			case  '初中' :
				$v[0]['edu_cn']=65;
				break;
			case  '高中' :
				$v[0]['edu_cn']=66;
				break;
			case  '中专' :
				$v[0]['edu_cn']=68;
				break;
			case  '大专' :
				$v[0]['edu_cn']=69;
				break;
			case  '本科' :
				$v[0]['edu_cn']=70;
				break;
			case  '研究生' :
				$v[0]['edu_cn']=71;
				break;
			default:
				$v[0]['edu_cn']=0;
		}
		switch ( $v[0]['pay'] ) {
			case  '1000-2000' :
				$v[0]['pay_cn']=56;
				break;
			case  '2000-3000' :
				$v[0]['pay_cn']=58;
				break;
			case  '3000-5000' :
				$v[0]['pay_cn']=59;
				break;
			case  '5000-10000' :
				$v[0]['pay_cn']=60;
				break;
			default:
				$v[0]['pay_cn']=0;
		}
		switch ( $v[0]['gzjingyan'] ) {
			case  '1年以下' :
				$v[0]['gzjingyan_cn']=75;
				break;
			case  '1-3年' :
				$v[0]['gzjingyan_cn']=76;
				break;
			case  '3-5年' :
				$v[0]['gzjingyan_cn']=77;
				break;
			case  '5-10年' :
				$v[0]['gzjingyan_cn']=78;
				break;
			case  '10年以上' :
				$v[0]['gzjingyan_cn']=79;
				break;
			default :
				$v[0]['gzjingyan_cn']=74;
				break;
		}
		$v[0]['start_year']=intval(date('Y',$v[0]['gztime']));
		$v[0]['start_month']=intval(date('m',$v[0]['gztime']));
		$v[0]['end_year']=intval(date('Y',$v[0]['lasttime']));
		$v[0]['end_month']=intval(date('m',$v[0]['lasttime']));
		$query2="insert into qs_resume(uid,fullname,sex,sex_cn,birthdate,telephone,intention_jobs,
		nature,nature_cn,education,education_cn,wage,wage_cn,experience,experience_cn,district,sdistrict,householdaddress,specialty,refreshtime)
		values(".$v[0]['mid'].",'".$v[0]['title']."',".$v[0]['sex_num'].",'".$v[0]['sex']."',
		".$v[0]['age'].",'".$v[0]['phone']."','".$v[0]['zhiwei']."',".$v[0]['zwleixing_cn'].",'".$v[0]['zwleixing']."',".$v[0]['edu_cn'].",'".$v[0]['edu']."',
		".$v[0]['pay_cn'].",'".$v[0]['pay']."',".$v[0]['gzjingyan_cn'].",'".$v[0]['gzjingyan']."',".$s_district.",".$s_sdistrict.",'".$v[0]['address']."','".$v[0]['pingjia']."',".$refreshtime.")";	
		// echo $query2."<br>";exit;
		$result2=mysql_query($query2,$link2);
		$query3="insert into qs_resume_work (uid,startyear,startmonth,endyear,endmonth,companyname,achievements)
		values(".$v[0]['mid'].",".$v[0]['start_year'].",".$v[0]['start_month'].",".$v[0]['end_year'].",".$v[0]['end_month'].",
		'".$v[0]['gsname']."','".$v[0]['jingyan']."')";
		$result3=mysql_query($query3,$link2);
		 // echo $query3."<br>";
		// echo mysql_affected_rows ();
		$aff_num+=1;
		// echo $v[0]['sex_num'];
		// echo $v[0]['age'];exit;
}
echo "<br>一共有".$aff_num."条记录转换成功";

// var_dump($result1);
// echo mysql_error();exit;
// $num_rows  =  mysql_num_rows ( $result1 );