<?php
class HuiyuanAction extends Common {
	//登录页面模版
	function index(){
		$this->display();
	}
	
	//在职
	function zaizhi(){
		switch($_SESSION['priv']){
			//主管
			case $_SESSION['priv']==3:
				
				$deptid=get_user_id($_SESSION['dept']);
				
				if(!empty($_GET['search'])){
					$where_sql=" lsr in(".$deptid.") and status='1' and lsr!='0' and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
				}else{
					$where_sql=" lsr in(".$deptid.") and status='1' and lsr!='0' ";
				}
				break;
			//职员	
			case $_SESSION['priv']==4:
				if(!empty($_GET['search'])){
					$where_sql=" lsr='".$_SESSION['id']."' and status='1' and lsr!='0' and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
				}else{
					$where_sql=" lsr='".$_SESSION['id']."' and status='1' and lsr!='0' ";
				}
				break;
			//管理员
			case $_SESSION['priv']==1 || $_SESSION['priv']==2:
				if(!empty($_GET['search'])){
					$where_sql=" status=1 and lsr!=0 and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
				}else{
					$where_sql=" status=1 and lsr!=0 ";
				}
				break;
			//默认无
			default:	
				exit('没权访问！');
		}
		//隶属人
		if(!empty($_GET['lsr'])){
			$where_sql.=" and lsr=".$_GET['lsr'];
		}
		//时间段
		if(!empty($_GET['shijianduan'])){
			if($_GET['q_time']!='' && $_GET['h_time']!=''){
				$where_sql.=" and to_days(FROM_UNIXTIME(".$_GET['shijianduan'].",'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
			}
		}
		
		$page=new page(D("tuijian")->where($where_sql)->total(),20);
		$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("add_time desc")->select();
		//查找隶属人---
		if($_SESSION['priv']==3){
			$user=D("crm_user")->where(array("dept"=>$_SESSION['dept']))->field("id,name")->select();
		}elseif($_SESSION['priv']==4){
			$user=D("crm_user")->where(array("id"=>$_SESSION['id']))->field("id,name")->select();
		}else{
			$user=D("crm_user")->field("id,name")->select();
		}
		foreach ($data as $i=>$v){	
			foreach ($user as $ui=>$uv){	
				if($uv['id']==$v['lsr']){	
					$data[$i]['lsr']=$uv['name'];	
				}	
			}
			
			if($v['gz_time']!='0'){
				$days=time();
				$date1= date('Y-m-d H:i:s', $v['gz_time']); 
				$date2= date('Y-m-d H:i:s', time()); 
				$days=(int)abs((strtotime($date1)-strtotime($date2))/86400);
				$data[$i]['lxts']=$days."天";
			}else{
				$data[$i]['lxts']="从未";
			}
		}
		//查找隶属人---
		$this->assign('fpage_weihu',$page->fpage());		//分页
		$this->assign("data",$data);
		$this->assign("user",$user);
		$this->display();
	}
	//离职
	function lizhi(){
		switch($_SESSION['priv']){
			//主管
			case $_SESSION['priv']==3:
				
				$deptid=get_user_id($_SESSION['dept']);
				
				if(!empty($_GET['search'])){
					$where_sql=" lsr in(".$deptid.") and status='2' and lsr!='0' and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
				}else{
					$where_sql=" lsr in(".$deptid.") and status='2' and lsr!='0' ";
				}
				break;
			//职员	
			case $_SESSION['priv']==4:
				if(!empty($_GET['search'])){
					$where_sql=" lsr='".$_SESSION['id']."' and status='2' and lsr!='0' and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
				}else{
					$where_sql=" lsr='".$_SESSION['id']."' and status='2' and lsr!='0' ";
				}
				break;
			//管理员
			case $_SESSION['priv']==1 || $_SESSION['priv']==2:
				if(!empty($_GET['search'])){
					$where_sql=" status=2 and lsr!=0 and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
				}else{
					$where_sql=" status=2 and lsr!=0 ";
				}
				break;
			//默认无
			default:	
				exit('没权访问！');
		}
		//隶属人
		if(!empty($_GET['lsr'])){
			$where_sql.=" and lsr=".$_GET['lsr'];
		}
		//时间段
		if(!empty($_GET['shijianduan'])){
			if($_GET['q_time']!='' && $_GET['h_time']!=''){
				$where_sql.=" and to_days(FROM_UNIXTIME(".$_GET['shijianduan'].",'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
			}
		}
		
		$page=new page(D("tuijian")->where($where_sql)->total(),20);
		$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("add_time desc")->select();
		//查找隶属人---
		if($_SESSION['priv']==3){
			$user=D("crm_user")->where(array("dept"=>$_SESSION['dept']))->field("id,name")->select();
		}elseif($_SESSION['priv']==4){
			$user=D("crm_user")->where(array("id"=>$_SESSION['id']))->field("id,name")->select();
		}else{
			$user=D("crm_user")->field("id,name")->select();
		}
		foreach ($data as $i=>$v){	
			foreach ($user as $ui=>$uv){	
				if($uv['id']==$v['lsr']){	
					$data[$i]['lsr']=$uv['name'];	
				}	
			}
			
			if($v['gz_time']!='0'){
				$days=time();
				$date1= date('Y-m-d H:i:s', $v['gz_time']); 
				$date2= date('Y-m-d H:i:s', time()); 
				$days=(int)abs((strtotime($date1)-strtotime($date2))/86400);
				$data[$i]['lxts']=$days."天";
			}else{
				$data[$i]['lxts']="从未";
			}
		}
		$this->assign('fpage_weihu',$page->fpage());		//分页
		$this->assign("user",$user);
		$this->assign("data",$data);
		$this->display();
		
	}
	//未入职
	function weiruzhi(){
	
		switch($_SESSION['priv']){
			//主管
			case $_SESSION['priv']==3:
				
				$deptid=get_user_id($_SESSION['dept']);
				
				if(!empty($_GET['search'])){
					$where_sql=" lsr in(".$deptid.") and status='0' and jihuo='0' and lsr!='0' and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
				}else{
					$where_sql=" lsr in(".$deptid.") and status='0' and jihuo='0' and lsr!='0' ";
				}
				break;
			//职员	
			case $_SESSION['priv']==4:
				if(!empty($_GET['search'])){
					$where_sql=" lsr='".$_SESSION['id']."' and status='0' and jihuo='0' and lsr!='0' and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
				}else{
					$where_sql=" lsr='".$_SESSION['id']."' and status='0' and jihuo='0' and lsr!='0' ";
				}
				break;
			//管理员
			case $_SESSION['priv']==1 || $_SESSION['priv']==2:
				if(!empty($_GET['search'])){
					$where_sql=" status=0 and jihuo='0' and lsr!=0 and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
				}else{
					$where_sql=" status=0 and jihuo='0' and lsr!=0 ";
				}
				break;
			//默认无
			default:	
				exit('没权访问！');
		}
		//隶属人
		if(!empty($_GET['lsr'])){
			$where_sql.=" and lsr=".$_GET['lsr'];
		}
		//时间段
		if(!empty($_GET['shijianduan'])){
			if($_GET['q_time']!='' && $_GET['h_time']!=''){
				$where_sql.=" and to_days(FROM_UNIXTIME(".$_GET['shijianduan'].",'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
			}
		}
		
		$page=new page(D("tuijian")->where($where_sql)->total(),20);
		$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("add_time desc")->select();
		//查找隶属人---
		if($_SESSION['priv']==3){
			$user=D("crm_user")->where(array("dept"=>$_SESSION['dept']))->field("id,name")->select();
		}elseif($_SESSION['priv']==4){
			$user=D("crm_user")->where(array("id"=>$_SESSION['id']))->field("id,name")->select();
		}else{
			$user=D("crm_user")->field("id,name")->select();
		}
		foreach ($data as $i=>$v){	
			foreach ($user as $ui=>$uv){	
				if($uv['id']==$v['lsr']){	
					$data[$i]['lsr']=$uv['name'];	
				}	
			}
			
			if($v['gz_time']!='0'){
				$days=time();
				$date1= date('Y-m-d H:i:s', $v['gz_time']); 
				$date2= date('Y-m-d H:i:s', time()); 
				$days=(int)abs((strtotime($date1)-strtotime($date2))/86400);
				$data[$i]['lxts']=$days."天";
			}else{
				$data[$i]['lxts']="从未";
			}
		}
		$this->assign('fpage_weihu',$page->fpage());		//分页
		$this->assign("user",$user);
		$this->assign("data",$data);
		$this->display();
	
	}
	
	//未分配
	function weifenpei(){
		
		switch($_SESSION['priv']){
			case 2:
				if(!empty($_GET['search'])){
					$where_sql=" lsr=0 and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
				}else{
					$where_sql=" lsr=0 ";
				}
				break;
			//管理员
			case 1:
				if(!empty($_GET['search'])){
					$where_sql=" lsr=0 and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
				}else{
					$where_sql=" lsr=0 ";
				}
				break;
			//默认无
			default:	
				exit('没权访问！');
		}
		
		//时间段
		if(!empty($_GET['shijianduan'])){
			if($_GET['q_time']!='' && $_GET['h_time']!=''){
				$where_sql.=" and to_days(FROM_UNIXTIME(".$_GET['shijianduan'].",'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
			}
		}
		
		//在职状态
		if(!empty($_GET['status'])){
			if($_GET['status']==5){ $_GET['status']=0; }
			
			$where_sql.=" and status='".$_GET['status']."' ";
		}
		
		//激活状态
		if(!empty($_GET['jihuo'])){
			if($_GET['jihuo']==5){ $_GET['jihuo']=0; }
			
			$where_sql.=" and jihuo='".$_GET['jihuo']."' ";
		}
		
		$page=new page(D("tuijian")->where($where_sql)->total(),60);
		$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("add_time desc")->select();
		$this->assign('fpage_weihu',$page->fpage());		//分页
		$this->assign("data",$data);
		$this->display();
	}
	
//---------------------------------------------------------------------------------------------------------------------------------------	
	//要分配
	function yaofenpei(){
	
		if($_SESSION['priv']==3 || $_SESSION['priv']==1 || $_SESSION['priv']==2){
			//--------------------------------------
			if(!empty($_GET['search'])){
				$where_sql="lsr='".$_SESSION['id']."' and ".$_GET['search']." like '%".$_GET['findvalue']."%'";
			}else{
				$where_sql="lsr='".$_SESSION['id']."' ";
			}
			
			//时间段
			if(!empty($_GET['shijianduan'])){
				if($_GET['q_time']!='' && $_GET['h_time']!=''){
					$where_sql.=" and to_days(FROM_UNIXTIME(".$_GET['shijianduan'].",'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
				}
			}
			
			//在职状态
			if(!empty($_GET['status'])){
				if($_GET['status']==5){ $_GET['status']=0; }
				
				$where_sql.=" and status='".$_GET['status']."' ";
			}
			
			//激活状态
			if(!empty($_GET['jihuo'])){
				if($_GET['jihuo']==5){ $_GET['jihuo']=0; }
				
				$where_sql.=" and jihuo='".$_GET['jihuo']."' ";
			}
			
			$page=new page(D("tuijian")->where($where_sql)->total(),20);
			$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("add_time desc")->select();
			$this->assign('fpage_weihu',$page->fpage());		//分页
			$this->assign("data",$data);
			$this->display();
			
		}else{
			exit('没权访问！');
		}
	}
	
	
	
	
	
/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	//要移交分配界面
	function yaofenpeiuser(){
		if(!empty($_GET['id']) && !empty($_GET['name'])){
			$this->assign('uid',$_GET['id']);
			$this->assign('name',urldecode($_GET['name']));
			$user=D("crm_user")->field("id,name")->where(array("priv"=>'4',"dept"=>$_SESSION['dept']))->select();
			$this->assign('crm_user',$user);
			$this->display();
		}
		
		if(!empty($_POST)){
			if($_POST['id']!=''){
				$str = explode(",", rtrim($_POST['id'],","));
				$uid="";
				$name="";
				foreach($str as $v){
					$str = explode("|", $v);
					$uid.=$str[0].",";
					$name.=$str[1].",";
				}
				
				$this->assign('uid',rtrim($uid, ","));
				$this->assign('name',rtrim($name, ","));
				$user=D("crm_user")->field("id,name")->where(array("priv"=>'4',"dept"=>$_SESSION['dept']))->select();
				$this->assign('crm_user',$user);
				
				$this->display();
				
			}else{
				$this->error("请选择要分配的会员！", 1); 
			}
		}
	}
//------------------------------------------------------------------------------------------------------------------------------	
	//跟踪记录
	function genzhong(){
		
		if($_SESSION['priv']=='1' || $_SESSION['priv']=='2'){
			$where_sql='';
		}elseif($_SESSION['priv']=='3'){
			$deptid=get_user_id($_SESSION['dept']);
			$where_sql='lsrid in ('.$deptid.')';
		}else{
			$where_sql=array("lsrid"=>$_SESSION['id']);
		}
		
		$page=new page(D("crm_lianxijilu")->where($where_sql)->total(),20);
		$data=D("crm_lianxijilu")->where($where_sql)->limit($page->limit)->order("lianxitime desc")->select();
		$this->assign('fpage_weihu',$page->fpage());		//分页
		$this->assign("data",$data);
		$this->display();
	}
	
	//添加跟踪记录界面
	function gzuser(){
		if(!empty($_GET['id'])){
			$user=D("tuijian")->field("id,bianhao,name,sphone")->where(array("id"=>$_GET['id']))->find();
			$this->assign("user",$_SESSION);
			$this->assign("data",$user);
			$this->display();
		}
	}
	//添加跟踪记录代码
	function addgzjl(){
		if(!empty($_POST)){
			$_POST['lianxitime']=strtotime($_POST['lianxitime']);
			if($_POST['nexttime']!=''){
				$_POST['nexttime']=strtotime($_POST['nexttime']);;
			}
			$id=D('crm_lianxijilu')->insert();
			if($id > 0){
				D('tuijian')->where(array("id"=>$_POST['kuhuid']))->update(array("gz_time"=>$_POST['lianxitime']));
				$this->success("添加跟踪记录成功！", 1); 
			}else{
				$this->error("添加跟踪记录失败！", 1); 
			}
		}
	}
	//移交分配界面
	function fenpeiuser(){
		if(!empty($_GET['id']) && !empty($_GET['name'])){
			$this->assign('uid',$_GET['id']);
			$this->assign('name',urldecode($_GET['name']));
			$user=D("crm_user")->field("id,name")->where(array("priv"=>'3'))->select();
			$this->assign('crm_user',$user);
			$this->display();
		}
		
		if(!empty($_POST)){
			if($_POST['id']!=''){
				$str = explode(",", rtrim($_POST['id'],","));
				$uid="";
				$name="";
				foreach($str as $v){
					$str = explode("|", $v);
					$uid.=$str[0].",";
					$name.=$str[1].",";
				}
				$this->assign('uid',rtrim($uid, ","));
				$this->assign('name',rtrim($name, ","));
				$user=D("crm_user")->field("id,name")->where(array("priv"=>'3'))->select();
				$this->assign('crm_user',$user);
				$this->display();
				
			}else{
				$this->error("请选择要分配的会员！", 1); 
			}
		}
	}
	//移交分配代码
	function yjdaima(){
		if(!empty($_POST)){
			$id=D('tuijian')->where("id in(".$_POST['id'].")")->update(array("lsr"=>$_POST['lsrid']));
			if(!empty($id)){
				$this->success2("分配成功！", 1); 
			}else{
				$this->error2("分配失败！", 1); 
			}
		}
	}
	//修改
	function upuser(){
		if(!empty($_GET['id'])){
			$user=D("tuijian")->where(array("id"=>$_GET['id']))->find();
			$this->assign("info",$user);
			$this->assign('guanxi',D('guanxi')->select());		//关系
			$this->display(huiyuaninfo);
		}
	}
	//修改代码
	function useradd(){
		if(!empty($_POST)){
			$id=D("tuijian")->where(array("id"=>$_POST['id']))->update();
			if($id > 0){
				$this->success2('修改成功！', 1);
			}else{
				$this->error('修改失败！', 1);
			}
		}
	}
}