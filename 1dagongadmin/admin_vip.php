<?php
 /*
 * bingbing 套餐会员查找
 * ============================================================================
 * 版权所有: bingbing，并保留所有权利。
 * 网站地址: http://weibo.com/1d501；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
// echo '1==';exit;
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../data/config.php');
require_once(dirname(__FILE__).'/include/admin_common.inc.php');
require_once(dirname(__FILE__).'/include/page.class.php');

$act = !empty($_GET['act']) ? trim($_GET['act']) : 'vip';

$smarty->assign('pageheader',"套餐操作");

if($act == 'vip')
{	
	header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"'); 
	setcookie("name", $_SESSION['admin_name'],time()+3600, "/", ".1jobs.com"); 
setcookie("name", $_SESSION['admin_name'],time()+3600, "/", ".1jobs.cn"); 
	$smarty->display('vip/admin_vip.htm');
	
}
elseif($act == 'selecttcvip'){
	//查看套餐会员
	$dqid=intval($_CFG['subsite_id']);
	$pnum=10;							//设置每页显示数量
	if($dqid==0){
		//显示全站所有用户信息
		if(!empty($_GET['username'])){
			$where_sql=" and title like '%".$_GET['username']."%' ";
			$sqln='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="1" '.$where_sql;
			$count=$db->getone($sqln);
			$url="admin_vip.php?act=selecttcvip&username=".$_GET['username']."&";				//分页地址
		}else if(!empty($_GET['jh'])){
			$url="admin_vip.php?act=selecttcvip&jh=1&";			//分页地址
			if($_GET['jh']==2){
				$_GET['jh']=0;
				$url="admin_vip.php?act=selecttcvip&jh=2&";		//分页地址
			}
			$where_sql=" and activation='".$_GET['jh']."'";
			$sql='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="1" '.$where_sql;
			$count=$db->getone($sql);
		
		}elseif(!empty($_GET['qdid'])){			
			$url="admin_vip.php?act=selecttcvip&qdid=".$_GET['qdid']."&";			//分页地址
			$where_sql=" and vip_zt.subsite_id='".$_GET['qdid']."'";
			$sql='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="1" '.$where_sql;
			$count=$db->getone($sql);
			
		}else{
			$url="admin_vip.php?act=selecttcvip&";			//分页地址
			$sql='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="1" ';
			$count=$db->getone($sql);
		}
		$page=new Page($count['num'], $pnum, $url);
		$sql='select vip_zt.id,vip_zt.uid,vip_user.qid,vip_zt.subsite_id,username,title,xs_user,activation,type,duration,bout,number,add_time,end_time from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="1" '.$where_sql.' ORDER BY vip_zt.id desc limit '.$page->limit;
		$data=$db->getall($sql);
		$smarty->assign("fpage", $page->fpage());
		//把过期的时间套餐设为过期
		foreach ($data as $k => $v) {
			//查看是否有过期的
			if($v['activation']=='1'){
				if(date('Y-m-d',time()) >= date('Y-m-d',$v['end_time'])){
					$up="UPDATE vip_zt SET activation='3' WHERE uid='".$v['uid']."'";
					$id=$db->query($up);
				}
			}
		}
		$dq_sql="select s_id,s_districtname from qs_subsite";
		$site=$db->getall($dq_sql);
		foreach ($data as $i=>$v){
			$data[$i]['dq']="全站";
			foreach ($site as $k=>$s){
				if($s['s_id']==$data[$i]['subsite_id']){
					$data[$i]['dq']=$s['s_districtname'];
				}
			}
		}
		$smarty->assign("data",$data);
		$smarty->assign("dq",$site);		//地区
	
	}else{
		//在各地区显示不同地区的信息
		if(!empty($_GET['username'])){
			$where_sql=" and title like '%".$_GET['username']."%' and vip_zt.subsite_id='".$dqid."'";
			$sqln='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="1" '.$where_sql;
			$count=$db->getone($sqln);
			$url="admin_vip.php?act=selecttcvip&username=".$_GET['username']."&";				//分页地址
		}else if(!empty($_GET['jh'])){
			$url="admin_vip.php?act=selecttcvip&jh=1&";			//分页地址
			if($_GET['jh']==2){
				$_GET['jh']=0;
				$url="admin_vip.php?act=selecttcvip&jh=2&";		//分页地址
			}
			$where_sql=" and activation='".$_GET['jh']."' and vip_zt.subsite_id='".$dqid."'";
			$sql='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="1" '.$where_sql;
			$count=$db->getone($sql);
		
		}else{
			$where_sql="and vip_zt.subsite_id='".$dqid."'";
			$url="admin_vip.php?act=selecttcvip&";			//分页地址
			$sql='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="1" ';
			$count=$db->getone($sql);
		}
		
		$page=new Page($count['num'], $pnum, $url);
		$sql='select vip_zt.id,vip_zt.uid,vip_user.qid,vip_zt.subsite_id,username,title,xs_user,activation,type,duration,bout,number,add_time,end_time from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="1" '.$where_sql.' ORDER BY vip_zt.id desc limit '.$page->limit;
		$data=$db->getall($sql);
		$smarty->assign("fpage", $page->fpage());
		
		//把过期的时间套餐设为过期
		foreach ($data as $k => $v) {
			//查看是否有过期的
			if($v['activation']=='1'){
				if(date('Y-m-d',time()) >= date('Y-m-d',$v['end_time'])){
					$up="UPDATE vip_zt SET activation='3' WHERE uid='".$v['uid']."'";
					echo $up;
					$id=$db->query($up);
				}
			}
		}
		
		$dq_sql="select s_id,s_districtname from qs_subsite";
		$site=$db->getall($dq_sql);
		foreach ($data as $i=>$v){
			$data[$i]['dq']="全站";
			foreach ($site as $k=>$s){
				if($s['s_id']==$data[$i]['subsite_id']){
					$data[$i]['dq']=$s['s_districtname'];
				}
			}
		}
		$smarty->assign("data",$data);
	}
	$smarty->assign("dqid",$dqid);
	$smarty->display('vip/selecttcvip.htm');
	
}
elseif($act == 'selectcsvip'){
	//查看次数会员
	$dqid=intval($_CFG['subsite_id']);
	$pnum=10;							//设置每页显示数量
	if($dqid==0){
		//显示全站所有用户信息
		if(!empty($_GET['username'])){
			$where_sql=" and title like '%".$_GET['username']."%' ";
			$sqln='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="0" '.$where_sql;
			$count=$db->getone($sqln);
			$url="admin_vip.php?act=selectcsvip&username=".$_GET['username']."&";				//分页地址
		}else if(!empty($_GET['jh'])){
			$url="admin_vip.php?act=selectcsvip&jh=1&";			//分页地址
			if($_GET['jh']==2){
				$_GET['jh']=0;
				$url="admin_vip.php?act=selectcsvip&jh=2&";		//分页地址
			}
			$where_sql=" and activation='".$_GET['jh']."'";
			$sql='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="0" '.$where_sql;
			$count=$db->getone($sql);
		
		}elseif(!empty($_GET['qdid'])){
			
			$url="admin_vip.php?act=selectcsvip&qdid=".$_GET['qdid']."&";			//分页地址
			$where_sql=" and vip_zt.subsite_id='".$_GET['qdid']."'";
			$sql='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="0" '.$where_sql;
			$count=$db->getone($sql);
			
		}else{
			$url="admin_vip.php?act=selectcsvip&";			//分页地址
			$sql='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="0" ';
			$count=$db->getone($sql);
		}
		
		$page=new Page($count['num'], $pnum, $url);
		$sql='select vip_zt.id,vip_zt.bout_6,vip_zt.uid,vip_user.qid,vip_user.huiyuan,vip_zt.subsite_id,username,title,xs_user,activation,type,duration,bout,cs_ks_time,cs_end_time,add_time from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="0" '.$where_sql.' ORDER BY vip_zt.id desc limit '.$page->limit;
		$data=$db->getall($sql);
		$smarty->assign("fpage", $page->fpage());
		
		$dq_sql="select s_id,s_districtname from qs_subsite";
		$site=$db->getall($dq_sql);
		foreach ($data as $i=>$v){
			$data[$i]['dq']="全站";
			foreach ($site as $k=>$s){
				if($s['s_id']==$data[$i]['subsite_id']){
					$data[$i]['dq']=$s['s_districtname'];
				}
			}
		}
		$smarty->assign("data",$data);
		$site=$db->getall("select s_id,s_districtname from qs_subsite");
		$smarty->assign("dq",$site);		//地区
	}else{
		//在各地区显示不同地区的信息
		if(!empty($_GET['username'])){
			$where_sql=" and title like '%".$_GET['username']."%' and vip_zt.subsite_id='".$dqid."'";
			$sqln='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="0" '.$where_sql;
			$count=$db->getone($sqln);
			$url="admin_vip.php?act=selectcsvip&username=".$_GET['username']."&";				//分页地址
		}else if(!empty($_GET['jh'])){
			$url="admin_vip.php?act=selectcsvip&jh=1&";			//分页地址
			if($_GET['jh']==2){
				$_GET['jh']=0;
				$url="admin_vip.php?act=selectcsvip&jh=2&";		//分页地址
			}
			$where_sql=" and activation='".$_GET['jh']."' and vip_zt.subsite_id='".$dqid."'";
			$sql='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="0" '.$where_sql;
			$count=$db->getone($sql);
		
		}else{
			$where_sql="and vip_zt.subsite_id='".$dqid."'";
			$url="admin_vip.php?act=selectcsvip&";			//分页地址
			$sql='select COUNT(*) as num from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="0" '.$where_sql;
			$count=$db->getone($sql);
		}
		$page=new Page($count['num'], $pnum, $url);
		$sql='select vip_zt.id,vip_zt.bout_6,vip_zt.uid,vip_user.qid,vip_user.huiyuan,vip_zt.subsite_id,username,title,xs_user,activation,type,duration,bout,cs_ks_time,cs_end_time,add_time from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="0" '.$where_sql.' ORDER BY vip_zt.id desc limit '.$page->limit;
		$data=$db->getall($sql);
		$smarty->assign("fpage", $page->fpage());
		
		$dq_sql="select s_id,s_districtname from qs_subsite";
		$site=$db->getall($dq_sql);
		foreach ($data as $i=>$v){
			$data[$i]['dq']="全站";
			foreach ($site as $k=>$s){
				if($s['s_id']==$data[$i]['subsite_id']){
					$data[$i]['dq']=$s['s_districtname'];
				}
			}
		}
		$smarty->assign("data",$data);
	}
	$smarty->assign("dqid",$dqid);
	$smarty->display('vip/selectcsvip.htm');
}
elseif($act == 'ckvip'){
	$dqid=intval($_CFG['subsite_id']);
	$pnum=10;							//设置每页显示数量
	if($dqid==0){
	
		if(!empty($_GET['name'])){
	
			$where_sql=" where title like '%".$_GET['name']."%'";
			$sqln='select COUNT(*) as num FROM vip_user '.$where_sql;
			$count=$db->getone($sqln);
			$url="admin_vip.php?act=ckvip&name=".$_GET['name']."&";				//分页地址
			
		}else if(!empty($_GET['bl'])){
		
			$url="admin_vip.php?act=ckvip&bl=1&";			//分页地址
			if($_GET['bl']==2){
				$_GET['bl']=0;
				$url="admin_vip.php?act=ckvip&bl=2&";		//分页地址
			}
			$where_sql=" WHERE bl='".$_GET['bl']."'";
			$sqln='select COUNT(*) as num FROM vip_user '.$where_sql;
			$count=$db->getone($sqln);
		
		}elseif(!empty($_GET['qdid'])){
		
			$where_sql=" WHERE subsite_id='".$_GET['qdid']."'";
			$sqln='select COUNT(*) as num FROM vip_user '.$where_sql;
			$count=$db->getone($sqln);
			
		}else{
		
			$sqln="SELECT COUNT(*) as num FROM vip_user ORDER BY addtime desc";
			$count=$db->getone($sqln);
			$url="admin_vip.php?act=ckvip&";				//分页地址
		}
		
		
		$page=new Page($count['num'], $pnum, $url);
		$sql="SELECT id,subsite_id,qid,username,title,xs_user,pic,contents,huiyuan,phone,email,addtime,bl FROM vip_user ".$where_sql." ORDER BY addtime desc limit ".$page->limit;
		$data=$db->getall($sql);
		$smarty->assign("fpage", $page->fpage());
		
		$site=$db->getall("select s_id,s_districtname from qs_subsite");
		$smarty->assign("dq",$site);		//地区
		
	}else{
	
		if(!empty($_GET['name'])){
	
			$where_sql=" where title like '%".$_GET['name']."%' and subsite_id='".$dqid."'";
			$sqln='select COUNT(*) as num FROM vip_user '.$where_sql;
			$count=$db->getone($sqln);
			$url="admin_vip.php?act=ckvip&name=".$_GET['name']."&";				//分页地址
			
		}else if(!empty($_GET['bl'])){
		
			$url="admin_vip.php?act=ckvip&bl=1&";			//分页地址
			if($_GET['bl']==2){
				$_GET['bl']=0;
				$url="admin_vip.php?act=ckvip&bl=2&";		//分页地址
			}
			$where_sql=" WHERE bl='".$_GET['bl']."' and subsite_id='".$dqid."'";
			$sqln='select COUNT(*) as num FROM vip_user '.$where_sql;
			$count=$db->getone($sqln);
		
		}else{
			$where_sql="WHERE subsite_id='".$dqid."'";
			$sqln="SELECT COUNT(*) as num FROM vip_user ".$where_sql;
			$count=$db->getone($sqln);
			$url="admin_vip.php?act=ckvip&";				//分页地址
		}
		
		
		$page=new Page($count['num'], $pnum, $url);
		$sql="SELECT id,subsite_id,qid,username,title,xs_user,pic,contents,huiyuan,phone,email,addtime,bl FROM vip_user ".$where_sql." ORDER BY addtime desc limit ".$page->limit;
		$data=$db->getall($sql);
		$smarty->assign("fpage", $page->fpage());
	}
	//-----------------------------------
	$dq_sql="select s_id,s_districtname from qs_subsite";
	$site=$db->getall($dq_sql);
	foreach ($data as $i=>$v){
		$data[$i]['dq']="全站";
		foreach ($site as $k=>$s){
			if($s['s_id']==$data[$i]['subsite_id']){
				$data[$i]['dq']=$s['s_districtname'];
			}
		}
	}
	$smarty->assign("data",$data);
	$smarty->display('vip/ckvip.htm');
}

?>