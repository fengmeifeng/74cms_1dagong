<?php
/*
 * 74cms 企业会员中心
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

define('IN_QISHI', true);
require_once(dirname(__FILE__).'/company_common.php');
$smarty->assign('leftmenu',"jobfair");
if ($act=='jobfair')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$wheresql=" WHERE display=1 ";
	if(intval($_CFG['subsite_id'])==0){
		$wheresql.="and holddates > ".strtotime(date('Y-m-d',strtotime('-1 days'))) ." and subsite_id=0 OR subsite_id=1 and holddates > ".strtotime(date('Y-m-d',strtotime('-1 days')))." ORDER BY holddates asc";	//添加 ORDER BY 按时间排序
	}else{
		$wheresql.="and holddates > ".strtotime(date('Y-m-d',strtotime('-1 days')))." and subsite_id=0 or subsite_id=".intval($_CFG['subsite_id'])." and holddates > ".strtotime(date('Y-m-d',strtotime('-1 days')))."  ORDER BY holddates asc";	//添加 ORDER BY 按时间排序
	}
	$total_sql="SELECT COUNT(*) AS num FROM ".table('jobfair').$wheresql;
	$perpage=5;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$smarty->assign('title','招聘会 - 会员中心 - '.$_CFG['site_name']);
	$jobfair=get_jobfair($offset,$perpage,$wheresql);
	foreach ($jobfair as $i => $v) {
	//----------------------------------------------------------
		/*以预定*/
		$yyd="select count(*) as yiyuding from vip_zhanhui where zid='".$v['id']."'";
		$yyd=$db->getone($yyd);		//已预订过的展位
		$jobfair[$i]['yiyuding']=$yyd['yiyuding'];
		/*未预定*/
		$wyd="select count(*) as weiyuding from vip_zw where number not in(select number from vip_zhanhui where zid=".$v['id'].") and subsite_id='".intval($_CFG['subsite_id'])."'";
		$wyd=$db->getone($wyd);		//没有预定的展位
		$jobfair[$i]['weiyuding']=$wyd['weiyuding'];
	//----------------------------------------------------------
	}	
	$smarty->assign('jobfair',$jobfair);
	if ($total_val>$perpage)$smarty->assign('page',$page->show(3));
	$smarty->display('member_company/company_jobfair_list.htm');
}
elseif ($act=='booth')
{	
	if(!empty($_POST['id'])){$id=intval($_POST['id']);}		//首次预定使用post
	if(!empty($_GET['id'])){$id=intval($_GET['id']);}		//再次预定使用get
	
	if(empty($id)){	exit("ERR"); }		//不存在id 直接终止运行以下代码
		$time=time();
		$sql = "select * from ".table('jobfair')." where id='{$id}' limit 1";
		$jobfair=$db->getone($sql);		// 	$jobfair['holddates']>$time
		if ($jobfair['predetermined_status']=="1" && date("Y-m-d",$jobfair['holddates'])>=date("Y-m-d",$time) && $time>$jobfair['predetermined_start'] && ($jobfair['predetermined_end']=="0" || $jobfair['predetermined_end']>$time || $jobfair['hour']>=date("H")) && $jobfair['predetermined_web']=="1"){
			/*判断是套餐用户，还是积分用户-----------------------------------------------*/
			$sql="select * from vip_user join vip_zt on vip_user.qid = vip_zt.qid where vip_user.qid='".$_SESSION['uid']."'";
			$zt=$db->getall($sql);
			/*套餐次数用户-----------------------展位信息-----------------------------------------*/
			if(!empty($zt)){
					/*过滤免费体验用户*/
					if($zt[0]['huiyuan']==2){
						$day=date("Y-m-d",$jobfair['holddates']);
						$zhou=date('w',strtotime($day));
						echo $zhou;
						if($zhou==6){
							$link[0]['text'] = "会员中心首页";
							$link[0]['href'] = 'company_index.php';
							showmsg("您好,你是免费体验会员用户,不可以预定星期六的展会！",2,$link);
						}
					}
					/*查看用户是否激活，*/
					$sql="select * from vip_zt where qid='".$_SESSION['uid']."' and activation='0'";
					$data=$db->getone($sql);
					if(!empty($data)){
						$link[0]['text'] = "会员中心首页";
						$link[0]['href'] = 'company_index.php';
						showmsg("您好,你的套餐还没有激活,请联系客服！",2,$link);
					}
					/*过滤时间套餐用户*/
					$sql="select * from vip_zt where qid='".$_SESSION['uid']."' and type='1' and activation='1'";
					$data=$db->getone($sql);
					if(!empty($data)){
						$link[0]['text'] = "我预定的展位";
						$link[0]['href'] = '?act=mybooth';
						showmsg("您好,您是时间套餐用户不需要自己预定展位.系统会帮你们预定",3,$link);
					}
					/*过滤用户是否预定过展位*/
					if(empty($_GET['id'])){
						$sql="select * from vip_zhanhui where zid='".$jobfair['id']."' and qid={$_SESSION['uid']} limit 1";
						$data=$db->getall($sql);
						if(!empty($data)){
							$link[0]['text'] = "我预定的展位";
							$link[0]['href'] = '?act=mybooth';
							$link[1]['text'] = "还要预订";
							$link[1]['href'] = '?act=booth&id='.$id;
							showmsg("你已经预定过这期招聘会的展位了，还需要预定吗?",3,$link,true,10);
						}
					}
				//------------------------------------------------------------------------------
				$smarty->assign("zid",$jobfair['id']);
				$smarty->assign("qid",$_SESSION['uid']);
				/*----------------------------展位信息-----------------------------------------*/
				$smarty->assign("type","1");					//套餐用户
				
			/*积分用户------------------------展位信息-----------------------------------------*/	
			}else{
					/*过滤积分是否不足，提示用户充值*/
					$user_points=get_user_points($_SESSION['uid']);
					if ($jobfair['predetermined_point']>$user_points)
					{
						$link[0]['text'] = "立即充值";
						$link[0]['href'] = 'company_service.php?act=order_add';
						$link[1]['text'] = "返回上一页";
						$link[1]['href'] = 'javascript:history.go(-1)';
						$link[2]['text'] = "会员中心首页";
						$link[2]['href'] = 'company_index.php?act=';
						showmsg("你的".$_CFG['points_byname']."不足，请充值后再预定! ",0,$link);
					}
				//-------------------------
				$smarty->assign("zid",$jobfair['id']);
				$smarty->assign("qid",$_SESSION['uid']);
				/*----------------------------展位信息-----------------------------------------*/
				$smarty->assign("type","2");									//积分用户
				$smarty->assign("zhjf",$jobfair['predetermined_point']);		//展会的积分
			}
			
			/*已预订的展位号*/
			$sql="select * from vip_zhanhui where zid='".$jobfair['id']."'";
			$ok=$db->getall($sql);			//已预订过的展位
			$smarty->assign("ok",$ok);		//展位已预订传递到模版
			$smarty->assign("jobfair",$jobfair);		//展会信息传递到模版
			/*-按地区显示不同模版----------------------------------------------------------------------------------------*/
			switch (intval($_CFG['subsite_id'])){
			case 1:
				//echo "合肥";
				/*未预订*/
				$sql="select number from vip_zw where subsite_id=".intval($_CFG['subsite_id'])." and number not in(select number from vip_zhanhui where zid=".$jobfair['id'].")";
				$all=$db->getall($sql);		//没有预定的展位
				$smarty->assign("all",$all);
				$smarty->display('member_company/company_jobfair_yuding.htm');		//地区模版
				break;
			case 2:
				//echo "蚌埠";
				/*未预订*/
				$sql="select number from vip_zw where subsite_id=".intval($_CFG['subsite_id'])." and number not in(select number from vip_zhanhui where zid=".$jobfair['id'].")";
				$all=$db->getall($sql);		//没有预定的展位
				$smarty->assign("all",$all);
				$smarty->display('member_company/company_jobfair_yuding.htm');		//地区模版
				break;
			case 3:
				//echo "芜湖";
				/*未预订*/
				$sql="select number from vip_zw where subsite_id=".intval($_CFG['subsite_id'])." and number not in(select number from vip_zhanhui where zid=".$jobfair['id'].")";
				$all=$db->getall($sql);		//没有预定的展位
				$smarty->assign("all",$all);
				$smarty->display('member_company/company_jobfair_yuding.htm');		//地区模版
				break;
			case 4:
				//echo "江苏";
				/*未预订*/
				$sql="select number from vip_zw where subsite_id=".intval($_CFG['subsite_id'])." and number not in(select number from vip_zhanhui where zid=".$jobfair['id'].")";
				$all=$db->getall($sql);		//没有预定的展位
				$smarty->assign("all",$all);
				$smarty->display('member_company/company_jobfair_yuding.htm');		//地区模版
				break;
			default:
				//全站
				/*未预定*/
				$sql="select number from vip_zw where subsite_id=".intval($_CFG['subsite_id'])." and number not in(select number from vip_zhanhui where zid=".$jobfair['id'].")";
				$all=$db->getall($sql);		//没有预定的展位
				$smarty->assign("all",$all);
				$smarty->display('member_company/company_jobfair_yuding.htm');		//地区模版
			}
		}else{
			$link[0]['text'] = "会员中心首页";
			$link[0]['href'] = 'company_index.php';
			showmsg("不可以预定了！",3,$link);
		}	
}
elseif ($act=='mybooth')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');			//包含分页类
	/*-------------*/
	$smarty->assign('title','我预定的展位 - 招聘会 - 会员中心 - '.$_CFG['site_name']);
	if(empty($_GET['settr'])){
		$sql="select zid from vip_zhanhui where qid='".$_SESSION['uid']."'";
		$jobfair=$db->getall($sql);
		$zid = array();							//定义$zid数组
		for($i=0; $i<sizeof($jobfair); $i++){
			$zid[$i]=$jobfair[$i]['zid'];		//获取展会id,保存到$zid数组里
		}
		array_multisort($zid, SORT_NUMERIC, SORT_ASC);  
		$num = array();		//定义$num数组
		foreach ($zid as $i=>$v){
			$sql="select id,title,holddates from qs_jobfair where id in(".$v.") and holddates > ".strtotime(date('Y-m-d',strtotime('-1 days')));
			$fair=$db->getone($sql);
			if(!empty($fair)){
				$num[$i]['id']=$fair['id'];
				$num[$i]['title']=$fair['title'];
				$num[$i]['holddates']=$fair['holddates'];		//把需要的数据保存到$num数组
			}
		}
		$data=$db->getall("select * from vip_zhanhui where qid='".$_SESSION['uid']."' ORDER BY zid ASC");
		foreach ($data as $k=>$s){
			if($num[$k]['id']==$s['zid']){
				$num[$k]['numid']=$s['id'];
				$num[$k]['number']=$s['number'];
				$num[$k]['online_aoto']=$s['online_aoto'];
				$num[$k]['add_time']=$s['add_time'];
			}	
		}
		
	}elseif($_GET['settr']=="s"){
	/*所有加过期的已近预定的展位---------------------------------------------------*/
		$sql="select zid from vip_zhanhui where qid='".$_SESSION['uid']."'";
		$jobfair=$db->getall($sql);
		$zid = array();							//定义$zid数组
		for($i=0; $i<sizeof($jobfair); $i++){
			$zid[$i]=$jobfair[$i]['zid'];		//获取展会id,保存到$zid数组里
		}
		array_multisort($zid, SORT_NUMERIC, SORT_ASC);  
		$num = array();		//定义$num数组
		foreach ($zid as $i=>$v){
			$sql="select id,title,holddates from qs_jobfair where id in(".$v.")";
			$fair=$db->getone($sql);
			if(!empty($fair)){
				$num[$i]['id']=$fair['id'];
				$num[$i]['title']=$fair['title'];
				$num[$i]['holddates']=$fair['holddates'];		//把需要的数据保存到$num数组
			}
		}
		$data=$db->getall("select * from vip_zhanhui where qid='".$_SESSION['uid']."' ORDER BY zid ASC");
		foreach ($data as $k=>$s){
			if($num[$k]['id']==$s['zid']){
				$num[$k]['numid']=$s['id'];
				$num[$k]['number']=$s['number'];
				$num[$k]['online_aoto']=$s['online_aoto'];
				$num[$k]['add_time']=$s['add_time'];
			}	
		}
	}else{
		/*-------------------------------------------------------------------*/
		$sql="select zid from vip_zhanhui where qid='".$_SESSION['uid']."'";
		$jobfair=$db->getall($sql);
		$zid = array();							//定义$zid数组
		for($i=0; $i<sizeof($jobfair); $i++){
			$zid[$i]=$jobfair[$i]['zid'];		//获取展会id,保存到$zid数组里
		}
		array_multisort($zid, SORT_NUMERIC, SORT_ASC);  
		$num = array();		//定义$num数组
		foreach ($zid as $i=>$v){
			//过期3天后不显示
			$sql="select id,title,holddates from qs_jobfair where id in(".$v.") and holddates < ".strtotime(date('Y-m-d',strtotime($_GET['settr']. 'days')))." and holddates > ".strtotime(date('Y-m-d',strtotime('-1 days')));
			$fair=$db->getone($sql);
			if(!empty($fair)){
				$num[$i]['id']=$fair['id'];
				$num[$i]['title']=$fair['title'];
				$num[$i]['holddates']=$fair['holddates'];		//把需要的数据保存到$num数组
			}
		}
		$data=$db->getall("select * from vip_zhanhui where qid='".$_SESSION['uid']."' ORDER BY zid ASC");
		foreach ($data as $k=>$s){
			if($num[$k]['id']==$s['zid']){
				$num[$k]['numid']=$s['id'];
				$num[$k]['number']=$s['number'];
				$num[$k]['online_aoto']=$s['online_aoto'];
				$num[$k]['add_time']=$s['add_time'];
			}	
		}

	}
	//分页--------------------------------------------------------------------------
		$perpage=15;		//每页数
		$total_val=count($num);		//以预定条数
		$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));		//调用分页类
		$currenpage=$page->nowindex;
		$offset=($currenpage-1)*$perpage;
		$num=array_slice($num,$offset,$perpage);		//数组分页函数
		//排序----------------------------------------------------------------------
		//print_r($num);
		//排序----------------------------------------------------------------------
		$smarty->assign('page',$page->show(3));
		$smarty->assign('list',$num);
		/*-------------------------------------------------------------------*/
	/*-----------------------------------------------------------------------------*/
	$smarty->display('member_company/company_jobfair_exhibitors.htm');
}
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------*/
elseif ($act=='yvding'){	
	//套餐用户---
	if($_POST['yhtype']==1){
		$sql="select * from vip_zt where qid='".$_POST['qid']."' and type='0' and activation='1'";
		$data=$db->getall($sql);		//把这个企业的次数会员信息查出来
		if(!empty($data)){
			$sql="select * from vip_zt where qid='".$_POST['qid']."' and type='0' and activation='1'";
			$data=$db->getone($sql);
			/*-----判断次数套餐是否到期生效---------------*/
			if($data['cs_ks_time']>=time()){
				$link[0]['text'] = "会员中心首页";
				$link[0]['href'] = 'company_index.php';
				showmsg("你办理的次数套餐还没生效! 请等待套餐生效！",3,$link);
			}
			/*-----判断次数套餐是否过期-------------------*/
			if($data['cs_end_time']<=time()){
				$link[0]['text'] = "会员中心首页";
				$link[0]['href'] = 'company_index.php';
				showmsg("亲! 您过期了， 请联系客服！",3,$link);
			}
			/*------------------------------------------*/
			if($data['bout']>0){
				$sql="select * from vip_zhanhui where zid='".$_POST['zid']."' and qid='".$_POST['qid']."'";
				$data=$db->getone($sql);
				//if(empty($data)){
					$sql="UPDATE vip_zt SET bout=bout-1 WHERE qid='".$_POST['qid']."'";
					$id=$db->getone($sql);
					$sql="select * from vip_user where qid='".$_POST['qid']."'";
					$data=$db->getall($sql);	//查询企业信息
					$sql="INSERT INTO vip_zhanhui(subsite_id,zid,qid,username,title,xs_user,huiyuan,phone,email,number,yhtype,online_aoto,add_time) values('".intval($_CFG['subsite_id'])."','".$_POST['zid']."','".$_POST['qid']."','".$data[0]['username']."','".$data[0]['title']."','".$data[0]['xs_user']."','".$data[0]['huiyuan']."','".$data[0]['phone']."','".$data[0]['email']."','".$_POST['number']."','1','2',".time().")";
					$id=$db->query($sql);		//保存到这期展会里
					
					if(!empty($id)){
						/*-------------------------------------------------------*/
						$sql="select * from vip_jf where uid='".$_SESSION['uid']."'";
						$data=$db->getone($sql);
						if(!empty($data)){
							$sqljf="UPDATE vip_jf set jifen=jifen+10 where uid='".$_SESSION['uid']."'";
						}else{
							$sqljf="INSERT INTO vip_jf(uid,jifen) values ('".$_SESSION['uid']."','10')";
						}
						$id=$db->query($sqljf);
						/*--------------------------------------------------------*/
					
						$link[0]['text'] = "我预定的展位";
						$link[0]['href'] = '?act=mybooth';
						$link[1]['text'] = "会员中心首页";
						$link[1]['href'] = 'company_index.php?act=';
						showmsg("预定成功!",2,$link);
					}
				/*}else{
					$link[0]['text'] = "我预定的展位";
					$link[0]['href'] = '?act=mybooth';
					showmsg("你已经预定过此招聘会的展位了，不能重复预定",1,$link);
				}*/
			}else{
				$link[0]['text'] = "会员中心首页";
				$link[0]['href'] = 'company_index.php';
				showmsg("你的参加展会次数已经用完了! 请联系客服",3,$link);
			}
		}else{
			$link[0]['text'] = "会员中心首页";
			$link[0]['href'] = 'company_index.php';
			showmsg("你办理的套餐还没激活! 请联系客服",3,$link);
		}
	}
	//积分用户---
	if($_POST['yhtype']==2){
		$sql="select * from vip_zhanhui where zid='".$_POST['zid']."' and qid='".$_POST['qid']."'";
		$data=$db->getone($sql);
		if(empty($data)){
			$sql='select * from qs_company_profile join qs_members on qs_company_profile.uid = qs_members.uid where qs_members.uid = "'.$_POST['qid'].'"';
			$data=$db->getall($sql);	//查询企业信息
			$sql="INSERT INTO vip_zhanhui(subsite_id,zid,qid,username,title,xs_user,huiyuan,phone,email,number,yhtype,online_aoto,add_time) values('".intval($_CFG['subsite_id'])."','".$_POST['zid']."','".$_POST['qid']."','".$data[0]['username']."','".$data[0]['companyname']."','".$data[0]['xs_user']."','".null."','".$data[0]['telephone']."','".$data[0]['email']."','".$_POST['number']."','2','2',".time().")";
			$id=$db->query($sql);
			
			if(!empty($id)){
				$sql="UPDATE qs_members_points SET points=points-".$_POST['zhjf']." WHERE uid='".$_POST['qid']."'";
				$id=$db->getall($sql);
				/*-------------------------------------------------------*/
				$sql="select * from vip_jf where uid='".$_SESSION['uid']."'";
				$data=$db->getone($sql);
				if(!empty($data)){
					$sqljf="UPDATE vip_jf set jifen=jifen+10 where uid='".$_SESSION['uid']."'";
				}else{
					$sqljf="INSERT INTO vip_jf(uid,jifen) values ('".$_SESSION['uid']."','10')";
				}
				$id=$db->query($sqljf);
				/*--------------------------------------------------------*/
				$link[0]['text'] = "我预定的展位";
				$link[0]['href'] = '?act=mybooth';
				$link[1]['text'] = "会员中心首页";
				$link[1]['href'] = 'company_index.php?act=';
				showmsg("预定成功!",2,$link);
			}
		}else{
			$link[0]['text'] = "我预定的展位";
			$link[0]['href'] = '?act=mybooth';
			$link[1]['text'] = "返回上一页";
			$link[1]['href'] = 'javascript:history.go(-1)';
			showmsg("你已经预定过此招聘会的展位了，不能重复预定",1,$link);
		}
	}
/*------------------------------------------------------------------------------------------------------*/	
}
elseif ($act=='tuiding'){
	if(!empty($_GET['id'])){
		$id=$_GET['id'];
		$sql="select predetermined_point,predetermined_end from qs_jobfair where id=".$_GET['zid'];
		$data=$db->getone($sql);
		if(!empty($data)){
			
			if($data['predetermined_end'] > time()){
				$sql="DELETE  FROM  vip_zhanhui WHERE  id='".$id."' and qid='".$_SESSION['uid']."'";
				$res=mysql_query($sql);
				if(mysql_affected_rows()){
					$sql="select * from vip_zt where type='0' and qid='".$_SESSION['uid']."'";
					$dat=$db->getone($sql);
					//是次数会员
					if(!empty($dat)){
						$sql="UPDATE vip_zt SET bout = bout+1 WHERE qid='".$_SESSION['uid']."'";
						$res=mysql_query($sql);
						if(mysql_affected_rows()){
							$link[0]['text'] = "我预定的展位";
							$link[0]['href'] = '?act=mybooth';
							$link[1]['text'] = "会员中心首页";
							$link[1]['href'] = 'company_index.php?act=';
							showmsg("退订成功!",2,$link);
						}
					}else{
					//是积分会员
						$sql="UPDATE qs_members_points SET points = points+".$data['predetermined_point']." WHERE uid='".$_SESSION['uid']."'";
						$res=mysql_query($sql);
						if(mysql_affected_rows()){
							$link[0]['text'] = "我预定的展位";
							$link[0]['href'] = '?act=mybooth';
							$link[1]['text'] = "会员中心首页";
							$link[1]['href'] = 'company_index.php?act=';
							showmsg("退订成功!",2,$link);
						}
					}
				}else{
					$link[0]['text'] = "我预定的展位";
					$link[0]['href'] = '?act=mybooth';
					$link[1]['text'] = "会员中心首页";
					$link[1]['href'] = 'company_index.php?act=';
					showmsg("退订失败!",2,$link);
				}
				echo "可以退订";
			}else{
				//echo "不可以退订了";
				$link[0]['text'] = "我预定的展位";
				$link[0]['href'] = '?act=mybooth';
				$link[1]['text'] = "会员中心首页";
				$link[1]['href'] = 'company_index.php?act=';
				showmsg("已经不可以退订了!",2,$link);
			}
		}
	}
}
/*更改展位--------------------------------------*/
elseif ($act=='gaizw'){
	if(!empty($_GET['zid'])){
		$id=$_GET['zid'];
		/*已预订*/
		$sql="select * from vip_zhanhui where zid='".$id."'";
		$ok=$db->getall($sql);		//已预订过的展位
		$smarty->assign("ok",$ok);
		/*未预定*/
		$sql="select number from vip_zw where number not in(select number from vip_zhanhui where zid=".$id.")";
		$all=$db->getall($sql);		//没有预定的展位
		$smarty->assign("all",$all);
		/*-----------------------------------------------*/
		$smarty->assign("zid",$id);
		$smarty->assign("qid",$_SESSION['uid']);
		$smarty->assign("zwh",$_GET['zwh']);
		$smarty->assign("id",$_GET['id']);
	}
	$smarty->display('member_company/ydzw.htm');
}
elseif ($act=='gaizwdm'){
	if(!empty($_POST)){
		$sq="SELECT id,holddates,hour FROM  qs_jobfair where id=".$_POST['zid'];
		$data=$db->getone($sq);
		if($data['holddates']>time()){
			$sql="UPDATE vip_zhanhui SET number='".$_POST['number']."' WHERE  qid='".$_POST['qid']."' and zid='".$_POST['zid']."' and id='".$_POST['id']."' LIMIT 1;";
			$res=mysql_query($sql);
			if(mysql_affected_rows()){
				$link[0]['text'] = "我预定的展位";
				$link[0]['href'] = '?act=mybooth';
				$link[1]['text'] = "会员中心首页";
				$link[1]['href'] = 'company_index.php?act=';
				showmsg("更改展位成功!",2,$link);
			}else{
				$link[0]['text'] = "我预定的展位";
				$link[0]['href'] = '?act=mybooth';
				$link[1]['text'] = "会员中心首页";
				$link[1]['href'] = 'company_index.php?act=';
				showmsg("更改展位失败!",2,$link);
			}
		}else{
				$link[0]['text'] = "我预定的展位";
				$link[0]['href'] = '?act=mybooth';
				$link[1]['text'] = "会员中心首页";
				$link[1]['href'] = 'company_index.php?act=';
				showmsg("额！,已经不可以更改展位号了,好像展会已经开始或过期了！",1,$link);
		}
	}
}
unset($smarty);
?>