<?php
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC"); 
echo "<font color='red'>Dede:zjobs_archives 和zjobs_addgongzuo81 ====》》》 QS:qs_jobs 和 QS:qs_jobs_contact 企业发布职位信息的数据转换</font><br/><br/>";
//没有新增字段
// echo date('m',1426152967);exit;
$cfg_dbhost = 'localhost';
$cfg_dbname_1 = '1dagong';
$cfg_dbname_2 = '1jobsupdate_db';
$cfg_dbuser = 'root';
$cfg_dbpwd = '';
$link1  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd );

$db_selected1  =  mysql_select_db ( $cfg_dbname_1 ,  $link1 );

$query1="select a.mid, a.pubdate, a.title, b.gzname, b.typeid, b.lasttime, b.zwleibie, b.sex, b.gongzi, b.edu, 
b.gongzuojy, b.nativeplace, b.zprenshu, b.zwmiaoshu, c.linkman, c.mobile, c.email, c.address, d.qs_firstid, d.qs_secondid, d.qs_thirdid
 from zjobs_addgongzuo81 b inner join zjobs_archives  a on a.id=b.aid inner join zjobs_member_company c 
on a.mid=c.mid inner join sheet1 d on b.typeid=d.second_id";
$result1=mysql_query($query1,$link1);
// echo $query1;exit;
// echo mysql_error();exit;
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
	// var_dump($row['mid']);
}
// exit;
$num_rows  =  mysql_num_rows ( $result1 );
// echo $num_rows;exit;
// var_dump($row1);exit;
echo "原数据表需转换的数据有".$num_rows."条记录<br/><br/>";
// exit;
$link2  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd ); 
$db_selected2  =  mysql_select_db ( $cfg_dbname_2 ,  $link2 );
$aff_num=0;
$year=intval(date('Y',time()));
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
		// $v[0]['age']=$year+1-$v[0]['age'];
		if($v[0]['zwleibie']=='全职'){
			$v[0]['zwleibie_cn']=62;
		}else{$v[0]['zwleibie_cn']=63;}
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
		switch ( $v[0]['gongzi'] ) {
			case '面议' :
				$v[0]['gongzi_cn']=55;
				break;
			case  '1000-2000' :
				$v[0]['gongzi_cn']=56;
				break;
			case  '2000-3000' :
				$v[0]['gongzi_cn']=58;
				break;
			case  '3000-5000' :
				$v[0]['gongzi_cn']=59;
				break;
			case  '5000-8000' :
				$v[0]['gongzi_cn']=60;
				break;
			default:
				$v[0]['gongzi_cn']=0;
		}
		switch ( $v[0]['gongzuojy'] ) {
			case  '1年以下' :
				$v[0]['gongzuojy_cn']=75;
				break;
			case  '1-3年' :
				$v[0]['gongzuojy_cn']=76;
				break;
			case  '3-5年' :
				$v[0]['gongzuojy_cn']=77;
				break;
			case  '5-10年' :
				$v[0]['gongzuojy_cn']=78;
				break;
			case  '10年以上' :
				$v[0]['gongzuojy_cn']=79;
				break;
			default :
				$v[0]['gongzuojy_cn']=74;
				break;
		}
		$query2="insert into qs_jobs(uid,company_id,refreshtime,display,jobs_name,sex,sex_cn,companyname,topclass,category,subclass,deadline,nature,nature_cn,
		education,education_cn,wage,wage_cn,experience,experience_cn,district_cn,district,sdistrict,amount)
		values(".$v[0]['mid'].",".$v[0]['mid'].",".$v[0]['pubdate'].",1,'".$v[0]['title']."',".$v[0]['sex_num'].",'".$v[0]['sex']."','".$v[0]['gzname']."',".$v[0]['qs_firstid'].",".$v[0]['qs_secondid'].",".$v[0]['qs_thirdid'].",
		'".$v[0]['lasttime']."',".$v[0]['zwleibie_cn'].",'".$v[0]['zwleibie']."',".$v[0]['edu_cn'].",'".$v[0]['edu']."',
		".$v[0]['gongzi_cn'].",'".$v[0]['gongzi']."',".$v[0]['gongzuojy_cn'].",'".$v[0]['gongzuojy']."','".$v[0]['nativeplace']."',".$s_district.",".$s_sdistrict.",".$v[0]['zprenshu'].")";	
		// var_dump($query2);exit;
		$result2=mysql_query($query2,$link2);
		$query4="select id from qs_jobs where uid=".$v[0]['mid']."";
		$result4=mysql_query($query4,$link2);
		// var_dump($result4);echo mysql_error();exit;
		$row4  =  mysql_fetch_assoc ( $result4 );
		// var_dump($row4);exit;
		$query3="insert into qs_jobs_contact (pid,contact,telephone,email,address)
		values(".$row4['id'].",'".$v[0]['linkman']."','".$v[0]['mobile']."','".$v[0]['email']."','".$v[0]['address']."')";
		$result3=mysql_query($query3,$link2);
		 // echo $query3."<br>";
		// echo mysql_affected_rows ();
		$aff_num+=1;
		// echo $v[0]['sex_num'];
		// echo $v[0]['age'];exit;
		mysql_free_result($result4);
		$row4=array();
}
echo "<br>一共有".$aff_num."条记录转换成功";

// var_dump($result1);
// echo mysql_error();exit;
// $num_rows  =  mysql_num_rows ( $result1 );