<?php
	class add_gs_userAction extends Common {
	
		function index(){
		
		}
		
		// 已激活会员列表
		function add_gs_jihuiuser(){
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4:
					$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" jihuo='1' and status!='0' and status!='2' and status!='3' and add_gs='".$_SESSION['user']."' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" jihuo='1' and status!='0' and status!='2' and status!='3' and add_gs='".$_SESSION['user']."' ";
					}
					break;
				case 1:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" jihuo='1' and status!='0' and status!='2' and status!='3' and add_gs!='' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" jihuo='1' and status!='0' and status!='2' and status!='3' and add_gs!='' ";
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			//---时间段搜索-----and------------------------------------------------------------------------------------------------------------------------------------------------
			if(!empty($_GET['shijianduan'])){
				if($_GET['q_time']!='' && $_GET['h_time']!=''){
					$where_sql.=" and to_days(FROM_UNIXTIME(".$_GET['shijianduan'].",'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
				}
			}
			//-------end----------------------------------
			
			//--排序----and-------------------
			if(!empty($_GET['paixu'])){
				if($_GET['fs']=='asc'){
					$paixun=$_GET['paixu']." asc ";
					$this->assign("fs","desc");
				}else{
					$paixun=$_GET['paixu']." desc ";
					$this->assign("fs","asc");
				}
			}else{
				$paixun="jihuo_time asc ";
			}
			//--排序-----end------------------
			
			$page=new page(D("tuijian")->where($where_sql)->total(),20);
			$data=D("tuijian")->where($where_sql)->limit($page->limit)->order($paixun)->select();
			$jibei=D("jibie")->select();
			foreach ($data as $k => $v){
				foreach ($jibei as $i => $s){
					if($s['id']==$v['jibie']){
						$data[$k]['jibie']=$s['jibie'];
					}
				}
				$data[$k]['add_gs']=get_add_gs($v['add_gs']);
			}
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->assign("changshu",$_SERVER['QUERY_STRING']);
			$this->display();
		}
		
/*------------------------------------------------------------------------------------------------------------------------------------------*/	
	
		// 未激活会员列表
		function add_gs_weijihuouser(){
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" jihuo='0' and status='1' and pid!='1' and add_gs='".$_SESSION['user']."'  and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" jihuo='0' and status='1' and pid!='1' and add_gs='".$_SESSION['user']."' ";
					}
					break;
				case 1:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){				
						$where_sql=" jihuo='0' and status='1' and pid!='1' and add_gs!='' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{		
						$where_sql=" jihuo='0' and status='1' and pid!='1' and add_gs!='' ";
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			
			//---时间段搜索-----and------------------------------------------------------------------------------------------------------------------------------------------------
			if(!empty($_GET['shijianduan'])){
				if($_GET['q_time']!='' && $_GET['h_time']!=''){
					$where_sql.=" and to_days(FROM_UNIXTIME(".$_GET['shijianduan'].",'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
				}
			}
			//-------end----------------------------------
			
			$page=new page(D("tuijian")->where($where_sql)->total(),20);
			$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("ruzhi_time asc")->select();
			$jibei=D("jibie")->select();
			foreach ($data as $k => $v){
				$data[$k]['ts']=getdays($v['ruzhi_time']);
				foreach ($jibei as $i => $s){
					if($s['id']==$v['jibie']){
						$data[$k]['jibie']=$s['jibie'];
					}
				}
				$data[$k]['add_gs']=get_add_gs($v['add_gs']);
			}
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->assign("priv",$_SESSION['priv']);
			$this->display();
		}
	
		// 未入职会员列表
		function add_gs_weiruzhi(){
		
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==3 || $_SESSION['priv']==4:
					if(!empty($_GET['search'])){
						$where_sql=" jihuo='0' and hujiaozhongxin!='1' and status='0' and add_gs='".$_SESSION['user']."' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" jihuo='0' and hujiaozhongxin!='1' and status='0' and add_gs='".$_SESSION['user']."'";
					}
					break;
				case 1:
					if(!empty($_GET['search'])){
						$where_sql=" jihuo='0' and status='0' and add_gs!='' and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
					}else{
						$where_sql=" jihuo='0' and status='0' and add_gs!='' ";
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			//-----------------------------------------
			$page=new page(D("tuijian")->where($where_sql)->total(),20);
			$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("add_time asc")->select();
			$jibei=D("jibie")->select();
			foreach ($data as $k => $v){
				foreach ($jibei as $i => $s){
					if($s['id']==$v['jibie']){
						$data[$k]['jibie']=$s['jibie'];
					}
				}
				$data[$k]['add_gs']=get_add_gs($v['add_gs']);
			}
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->display();

		}
		
		// 离职的会员
		function add_gs_lizhi(){
			
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4:
					$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
					if(!empty($_GET['search'])){
						$where_sql=array("jihuo"=>'1',"status"=>'2',"add_gs"=>$_SESSION['user'],$_GET['search']=>'%'.$_GET['findvalue'].'%');
					}else{
						$where_sql=array("jihuo"=>'1',"status"=>'2',"add_gs"=>$_SESSION['user']);
					}
					break;
				case 1:
					if(!empty($_GET['search'])){
						$where_sql=array("jihuo"=>'1',"status"=>'2',$_GET['search']=>'%'.$_GET['findvalue'].'%',"add_gs!"=>'');
					}else{
						$where_sql=array("jihuo"=>'1',"status"=>'2',"add_gs!"=>'' );
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			//-----------------------------------------
			$page=new page(D("tuijian")->where($where_sql)->total(),20);
			$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("lizhi_time asc")->select();
			$jibei=D("jibie")->select();
			foreach ($data as $k => $v){		
				$data[$k]['ts']=getdays($v['lizhi_time']);
				$data[$k]['add_gs']=get_add_gs($v['add_gs']);
				foreach ($jibei as $i => $s){
					if($s['id']==$v['jibie']){
						$data[$k]['jibie']=$s['jibie'];
					}
				}
			}
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->assign("gdd_user",$_SESSION['user']);
			$this->display();
			
		}
		
	}