<?php

define("ROOT", str_replace("\\", "/", dirname(__FILE__)).'/');  //类的目录


	class userAction extends Common {
	
		function index(){
			
		}
		
/*------------------------------------------------------------------------------------------------------------------------------------------*/
		
		//用户状态------------------
		function us(){			
			$this->assign("user",$_SESSION);
			$this->display();
		}
		//用户密码修改-------------
		function pass(){
			$this->display();			
		}
		//修改密码代码-------------
		function passdm(){
			if(!empty($_POST)){
				$user=D("adminuser")->where(array("id"=>$_SESSION['id'],"pass"=>MD5(USERPASS.$_POST["pass1"])))->find();
				if(!empty($user)){
					if($_POST["pass2"]==$_POST["pass3"]){
						$_POST['pass']=MD5(USERPASS.$_POST["pass3"]);
						$id=D('adminuser')->where(array('id'=>$user['id']))->update();
						if(!empty($id)){
							$this->success("修改密码成功", 1, "index/main");
						}else{
							$this->error("修改密码失败",3,"user/pass");
						}
					}else{
						$this->error("两次输入的密码不一致！",3,"user/pass");
					}
				}else{
					$this->error("原密码不正确",3,"user/pass");
				}
			}
		}
		
/*------------------------------------------------------------------------------------------------------------------------------------------*/
		
		// 已激活会员列表
		function jihuiuser(){
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4:
					$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" jihuo='1' and status!='0' and status!='2' and status!='3' and path like '%,".$user['id'].",%' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" jihuo='1' and status!='0' and status!='2' and status!='3' and path like '%,".$user['id'].",%' ";
					}
					break;
				case 1:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" jihuo='1' and status!='0' and status!='2' and status!='3' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" jihuo='1' and status!='0' and status!='2' and status!='3' ";
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
			}
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->assign("changshu",$_SERVER['QUERY_STRING']);
			$this->assign("gdd_user",$_SESSION['user']);
			$this->display();
		}
		
/*------------------------------------------------------------------------------------------------------------------------------------------*/	
	
		// 未激活会员列表
		function weijihuouser(){
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4:
					$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" jihuo='0' and status='1' and pid!='1' and path like '%,".$user['id'].",%' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" jihuo='0' and status='1' and pid!='1' and path like '%,".$user['id'].",%' ";
					}
					break;
				case 1:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){				
						$where_sql=" jihuo='0' and status='1' and pid!='1' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{		
						$where_sql=" jihuo='0' and status='1' and pid!='1' ";
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
			}
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->assign("priv",$_SESSION['priv']);
			$this->assign("gdd_user",$_SESSION['user']);
			$this->display();
		}
		
	
/*------------------------------------------------------------------------------------------------------------------------------------------*/

		// 今日新增会员列表
		function jinrenuser(){
		
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==3 || $_SESSION['priv']==4:
					$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
					if(!empty($_GET['search'])){
						$where_sql=" hujiaozhongxin!='1' and path like '%,".$user['id'].",%' and to_days(FROM_UNIXTIME(add_time,'%Y-%m-%d'))=to_days(now()) and ".$_GET['search']." like '%".$_GET['findvalue']."%'"; 
					}else{
						$where_sql=" hujiaozhongxin!='1' and path like '%,".$user['id'].",%' and to_days(FROM_UNIXTIME(add_time,'%Y-%m-%d'))=to_days(now())"; 
					}
					break;
				case 1:
					if(!empty($_GET['search'])){
						$where_sql=" to_days(FROM_UNIXTIME(add_time,'%Y-%m-%d'))=to_days(now()) and ".$_GET['search']." like '%".$_GET['findvalue']."%'"; 
					}else{
						$where_sql=" to_days(FROM_UNIXTIME(add_time,'%Y-%m-%d'))=to_days(now())"; 
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			$page=new page(D("tuijian")->where($where_sql)->total(),20);
			$data=D("tuijian")->where($where_sql)->order("add_time asc")->limit($page->limit)->select();
			$jibei=D("jibie")->select();
			foreach ($data as $k => $v){
				foreach ($jibei as $i => $s){
					if($s['id']==$v['jibie']){
						$data[$k]['jibie']=$s['jibie'];
					}
				}
			}
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->display();
			
		}

	
/*------------------------------------------------------------------------------------------------------------------------------------------*/

		// 推荐关系图 会员列表
		function guanxitu(){
			$this->display();		//模版
			$abc=false;				//变量
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4:
					$user=D("tuijian")->field("id,bianhao,name,pid")->where(array("bianhao"=>$_SESSION['user']))->find();
					if(!empty($_GET['search'])){
						$id=D("tuijian")->field('id')->where(array("jihuo"=>'1',$_GET['search']=>'%'.$_GET['findvalue'].'%',"path"=>'%,'.$user['id'].',%'))->find();
						$data=D("tuijian")->where(array("jihuo"=>'1',"status!"=>'0',"path"=>"%,".$id['id'].",%"))->order("id ASC,concat(path,id)")->select();
					}else{
						$data=D("tuijian")->where(array("jihuo"=>'1',"status!"=>'0',"path"=>"%,".$user['id'].",%"))->order("id ASC,concat(path,id)")->select();
						$abc=true;
					}
					break;
				case 1:
					if(!empty($_GET['search'])){
						$id=D("tuijian")->field('id')->where(array("jihuo"=>'1',$_GET['search']=>'%'.$_GET['findvalue'].'%'))->find();
						$data=D("tuijian")->where(array("jihuo"=>'1',"status!"=>'0',"path"=>"%,".$id['id'].",%"))->order("id ASC,concat(path,id)")->select();
					}else{
						$data=D("tuijian")->where(array("jihuo"=>'1',"status!"=>'0'))->order("id ASC,concat(path,id)")->select();
					}				
					break;
				default:	//默认无
					exit('没权访问！');
			}
			print "<SCRIPT type='text/javascript'>";
			print "
				var setting = {
					data: {
						simpleData: {
							enable: true
						}
					},
					callback: {
						onClick: onClick
					}
				};
			";
			print "var zNodes =[";
			
			// $abc这个变量等于true 才执行这个
			if($abc){
				$DEPT_ID = $user['id'];	$DEPT_NAME = $user['bianhao']."[".$user['name']."]"; $DEPT_PARENT = $user['pid'];
				print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',open:'true' },
					";
			}
			// 输出推荐图内容
			foreach ($data as $i=>$v){
				$DEPT_ID = $v['id'];
				$DEPT_NAME = $v['bianhao']."【".$v['name']."】";
				$DEPT_PARENT = $v['pid'];
				$open="false";
				if($DEPT_PARENT==='0' || $DEPT_PARENT==='1'){
					$open="true";
				}
				print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',open:'$open' },
				";
			}
			print "];
				function onClick(e,treeId, treeNode) {
					var zTree = $.fn.zTree.getZTreeObj('treeDemo');
					zTree.expandNode(treeNode);
				}
				$(document).ready(function(){
					$.fn.zTree.init($('#treeDemo'), setting, zNodes);
				});
			";
			print "</SCRIPT>";
			$GLOBALS["debug"]=1;
		}
		

/*------------------------------------------------------------------------------------------------------------------------------------------*/
		
		// 推荐关系表 会员列表
		function guanxibiao(){
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4 || $_SESSION['priv']==5:
					$user=D("tuijian")->field("id,bianhao,name,f_bianghao,guanxi,jiangjin,tj_num,jibie,jihuo_time,add_time,status")->where(array("bianhao"=>$_SESSION['user']))->find();
					if(!empty($_GET['search'])){
						$user=D("tuijian")->field('id,path')->where(array("jihuo"=>'1',$_GET['search']=>'%'.$_GET['findvalue'].'%',"path"=>'%,'.$user['id'].',%'))->find();
						$where_sql=array("jihuo"=>'1',"status!"=>'0',"path"=>"%,".$user['id'].",%");
					}else{
						$where_sql=array("jihuo"=>'1',"status!"=>'0',"path"=>"%,".$user['id'].",%");
						//当前用户----------------------
						$jibei=D("jibie")->select();
						foreach($user as $k => $v){
							$user['kg']="0┨";
							foreach ($jibei as $i => $s){
								if($s['id']==$v['jibie']){	$user['jibie']=$s['jibie'];	}
							}
						}
						$this->assign("user",$user);
						//当前用户----------------------
					}
					$page=new page(D("tuijian")->where($where_sql)->total(),20);
					$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("concat(path,id)")->select();
					$jibei=D("jibie")->select();
					foreach ($data as $k => $v){
						$v['path']=strstr($v['path'],$user['id'].",");	//当前的下线
						$m=substr_count($v['path'],",");
						$strpad = str_pad("",$m*6*4,"&nbsp;");
						$data[$k]['kg']=$strpad.$m."┨";
						foreach ($jibei as $i => $s){
							if($s['id']==$v['jibie']){	$data[$k]['jibie']=$s['jibie'];	}
						}
					}
					break;
				case 1:
					if(!empty($_GET['search'])){
							$id=D("tuijian")->field('id')->where(array("jihuo"=>'1',$_GET['search']=>'%'.$_GET['findvalue'].'%'))->find();
							$where_sql=array("jihuo"=>'1',"status!"=>'0',"path"=>"%,".$id['id'].",%");
							$page=new page(D("tuijian")->where($where_sql)->total(),20);
							$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("concat(path,id)")->select();
							$jibei=D("jibie")->select();
							foreach ($data as $k => $v){				
								$v['path']=strstr($v['path'],$id['id'].",");	//当前的下线
								$m=substr_count($v['path'],",");
								$strpad = str_pad("",$m*6*4,"&nbsp;");
								$data[$k]['kg']=$strpad.$m."┨";
								foreach ($jibei as $i => $s){
									if($s['id']==$v['jibie']){	$data[$k]['jibie']=$s['jibie']; }
								}
							}
							
					}else{
						$where_sql=array("jihuo"=>'1',"status!"=>'0');
						$page=new page(D("tuijian")->where($where_sql)->total(),20);
						$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("concat(path,id)")->select();
						$jibei=D("jibie")->select();
						foreach ($data as $k => $v){
							$m=substr_count($v['path'],",")-1;
							$strpad = str_pad("",$m*6*4,"&nbsp;");
							$data[$k]['kg']=$strpad.$m."┨";
							foreach ($jibei as $i => $s){
								if($s['id']==$v['jibie']){	$data[$k]['jibie']=$s['jibie']; }
							}
						}
					}
					break;
					
				default:	//默认无
					exit('没权访问！');
			}
			
			
			//----------------------------------------
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->assign("gdd_user",$_SESSION['user']);
			$this->display();
		}
		
	
/*------------------------------------------------------------------------------------------------------------------------------------------*/	
	
		//未入职会员列表
		function weiruzhi(){
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==3 || $_SESSION['priv']==4:
					$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
					if(!empty($_GET['search'])){
						$where_sql=array("jihuo"=>'0',"hujiaozhongxin!"=>'1',"status"=>'0',"path"=>"%,".$user['id'].",%",$_GET['search']=>'%'.$_GET['findvalue'].'%');
					}else{
						$where_sql=array("jihuo"=>'0',"hujiaozhongxin!"=>'1',"status"=>'0',"path"=>"%,".$user['id'].",%");
					}
					break;
				case 1:
					if(!empty($_GET['search'])){
						$where_sql=array("jihuo"=>'0',"status"=>'0',$_GET['search']=>'%'.$_GET['findvalue'].'%');
					}else{
						$where_sql=array("jihuo"=>'0',"status"=>'0');
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
			}
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->assign("gdd_user",$_SESSION['user']);
			$this->display();
		}
		
		//网络未入职的
		function wlhuiyuantuijian(){	
			switch($_SESSION['priv']){
				case $_SESSION['priv']==3 || $_SESSION['priv']==4:
					$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
					if(!empty($_GET['search'])){
						$where_sql=array("jihuo"=>'0',"status"=>'0',"hujiaozhongxin"=>'1',$_GET['search']=>'%'.$_GET['findvalue'].'%',"path"=>"%,".$user['id'].",%");
					}else{
						$where_sql=array("jihuo"=>'0',"status"=>'0',"hujiaozhongxin"=>'1',"path"=>"%,".$user['id'].",%");
					}
					break;
				case 1:
					if(!empty($_GET['search'])){
						$where_sql=array("jihuo"=>'0',"status"=>'0',"hujiaozhongxin"=>'1',$_GET['search']=>'%'.$_GET['findvalue'].'%');
					}else{
						$where_sql=array("jihuo"=>'0',"status"=>'0',"hujiaozhongxin"=>'1');
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			$page=new page(D("tuijian")->where($where_sql)->total(),20);
			$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("add_time asc")->select();
			$jibei=D("jibie")->select();
			foreach ($data as $k => $v){
				foreach ($jibei as $i => $s){
					if($s['id']==$v['jibie']){
						$data[$k]['jibie']=$s['jibie'];
					}
				}
			}
			
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->display();		
		}
		
		//已离职60的会员
		function guo60day(){
			
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4:
					$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
					if(!empty($_GET['search'])){
						$where_sql=array("status"=>'2',"path"=>"%,".$user['id'].",%",$_GET['search']=>'%'.$_GET['findvalue'].'%');
					}else{
						$where_sql=array("status"=>'2',"path"=>"%,".$user['id'].",%");
					}
					break;
				case 1:
					if(!empty($_GET['search'])){
						$where_sql=array("status"=>'2',$_GET['search']=>'%'.$_GET['findvalue'].'%');
					}else{
						$where_sql=array("status"=>'2' );
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
		
/*------下面都在操作------and------------------------------------------------------------------------------------------------------------------------------*/

		//会员入职	有短信发送通知
		function ruzhihuiyuan(){
			if(!empty($_POST)){
				//--------------------------
				if($_SESSION['priv']==1 || $_SESSION['priv']==3 || $_SESSION['priv']==4){
				//--------------------------
				if($_SESSION['name']!=''){
					if($_POST['ruzhi_time']!='' && $_POST['ruzhi_name']!=''){
						$data=D("tuijian")->field("bianhao,name,sphone,pid,f_bianghao,path,add_gs")->where(array("id"=>$_POST['id']))->find();	//查询要入职人员信息
						if($data['pid'] <=1){
							$this->error('该用户不能入职！', 1);		//报单中心 人员不可以入职
						}
						//----------------------------------------------
						if($data['add_gs']!=''){
							if($data['add_gs']!=$_SESSION['user']){
								$add_gs=get_add_gs($data['add_gs']);
								$this->error($add_gs."添加的, 您没有权限激活！", 5);
								exit("没有权限！");
							}
						}
						//--------------------------------------------------
						$_POST['status']='1';										//入职状态为1 -> "入职"
						$_POST['ruzhi_time']=strtotime($_POST['ruzhi_time']);		//入职时间
						$_POST['lizhi_time']=0;										//离职时间设为空
						$id=D("tuijian")->where(array("id"=>$_POST['id']))->update();	//执行入职写入数据库
						if($id > 0){		//执行成功！
							//--发短信通知用户--入职成功！---
							if(DUANXIN){
								$content="您好".$data['name']."，您的1+2事业平台入职成功！【壹打工网】";
								$dx=new bb_duanxin($data['sphone'],$content);
								$dx->fs();
							}else{
								//写log日志
								$content="您好".$data['name']."，您的1+2事业平台入职成功！ 账户编号：".$data['bianhao'];
								$str=date("Y-m-d H:i:s",time())."   内容：".$content."	 \r\n";
								error_log($str,3,PROJECT_PATH.'/log/errors_dxnr.log');
							}
							//--记录日志---and--------------------------------
							$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'会员入职  编号：'.$data['bianhao'].'， 姓名：'.$data['name'].'， 入职企业：'.$_POST['ruzhi_name'].'， 入职时间：'.date("Y-m-d",$_POST['ruzhi_time']));
							D("caozuolog")->insert($caozuo);
							//--记录日志---end----------------------------
							$this->success('入职成功！', 1, 'weiruzhi');
						}else{
							$this->error('入职失败！', 1);
						}
					}else{
						$this->error('入职企业或入职时间未填写！', 1);
					}
				}
				//-------------------
				}else{
					exit("没有权限！");
				}
				//-------------------
			}
		}
		

/*------------------------------------------------------------------------------------------------------------------------------------------*/

		//激活会员   有短信发送通知
		function jihuohuiyuan(){
			if($_SESSION['name']!=''){
			//-------------------------------
			if($_SESSION['priv']==1 || $_SESSION['priv']==4){
			//-------------------------------
				if(!empty($_GET['id'])){
					$user=D("tuijian")->field("id,bianhao,name,sphone,jihuo,status,ruzhi_time,f_bianghao,pid,path,jibie,add_gs")->where(array("id"=>$_GET['id']))->find();
					//未入职不可以激活
					if($user['status']!=1){
						$this->error("未入职不允许激活！", 1);
						exit('错误！');
					}
					//----------------------------------------------
					if($user['add_gs']!='' and $_SESSION['user'] !='admin' ){
						if($user['add_gs']!=$_SESSION['user'] and $_SESSION['user'] !='admin'){
							$add_gs=get_add_gs($user['add_gs']);
							$this->error($add_gs."添加的, 没有权限操作！", 5);
							exit("没有权限！");
						}
					}
					//--------------------------------------------------
					//如果级别为2就是1级  所以只要入职就可以激活会员
					if($user['jibie']!='2'){
						//判断多少天才可以激活
						if(getdays($user['ruzhi_time']) < JIHUODAYS){
							$this->error("入职未满".JIHUODAYS."天，不可以激活！", 1);
							exit('错误！');
						}
					}
					//上层会员必须激活
					if(!empty($_GET['id'])){
					$user=D("tuijian")->field("id,bianhao,name,sphone,jihuo,status,ruzhi_time,f_bianghao,pid,path,jibie,add_gs")->where(array("id"=>$_GET['id']))->find();
					$user1=D("tuijian")->field("id,bianhao,name,sphone,jihuo,status,ruzhi_time,f_bianghao,pid,path,jibie,add_gs")->where(array("bianhao"=>$user['f_bianghao']))->find();
					 if ($user['f_bianghao']==$user1['bianhao'] and $user1['jihuo']=='0' and $user1['status']=='1'){
					 $this->error("该会员还有上级会员".$user1['name']."未激活，不可以激活！", 1);
									exit('错误！');
					 }
					 }
					
					
					//--记录日志---and--------------------------------
					$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'会员激活  编号：'.$user['bianhao'].'， 姓名：'.$user['name']);
					D("caozuolog")->insert($caozuo);
					//--记录日志---end----------------------------
					//---------------------------------------------
					if($user['jihuo']!='1'){						//如果激活过了就不执行激活
						$path=explode(",",$user['path']);
						$jzmax=array_search(max($path), $path);
						foreach ($path as $k => $v){
							if($v!='' && strval($v)!='0'){
								$pth=strstr($user['path'],$v.",");	//获取当前路径
								$m=substr_count($pth,",");			//获取当前等级
								if($m < 13){						//超过12层就执行
									if($m >= 1 and $m <= 3){			//1,2,3	  下线每人给100元
										$q = 100;
									}elseif($m >= 4 and $m <= 7){		//4,5,6,7 下线每人给30元
										$q = 30;
									}elseif($m >= 8 and $m <= 10){		//8,9,10  下线每人给25元
										$q = 25;
									}elseif($m >= 11 and $m <= 12){		//11,12   下线每人给20元
										$q = 20;
									}else{								//超过12层   就不给钱
										$q = 0;
									}
									//---奖金增加的日志--and------------------------
									$urdat=D("tuijian")->field("id,bianhao,name,sphone,status,jihuo,jiangjin,f_bianghao,pid,path")->where(array("id"=>$v))->find();
									if($urdat['status']=='1' and $urdat['jihuo']=='1'){		//当前用户在职才能拿到推荐奖金到日志!
										$recordmoney=array("hyhumber"=>$urdat['bianhao'],"hyname"=>$urdat['name'],"money"=>$q,"leftmoney"=>$urdat['jiangjin']+$q,"caozuo"=>"增加","newbianhao"=>$user['bianhao'],"newname"=>$user['name'],"beizhuxinming"=>"激活".$user['name']."结算奖金","beizhu"=>"激活".$user['bianhao']."结算奖金","pid"=>$user['pid'],"path"=>$user['path'],"addtime"=>date("Y-m-d H:i:s",time()));	
										$inrecordmoney=D("recordmoney")->insert($recordmoney);
									}
									elseif($urdat['status']=='1' and $urdat['jihuo']=='0'){ //上级会员必须激活才可以激活当前会员
									$recordmoney=array("hyhumber"=>$urdat['bianhao'],"hyname"=>$urdat['name'],"money"=>'0',"leftmoney"=>$urdat['jiangjin'],"caozuo"=>"失败","newbianhao"=>$user['bianhao'],"newname"=>$user['name'],"beizhuxinming"=>$urdat['name']."未激活，无法激活当前会员","beizhu"=>$urdat['name']."未激活，无法激活当前会员","pid"=>$user['pid'],"path"=>$user['path'],"addtime"=>date("Y-m-d H:i:s",time()));	
										$inrecordmoney=D("recordmoney")->insert($recordmoney);
										}
									else{
										$recordmoney=array("hyhumber"=>$urdat['bianhao'],"hyname"=>$urdat['name'],"money"=>'0',"leftmoney"=>$urdat['jiangjin'],"caozuo"=>"失败","newbianhao"=>$user['bianhao'],"newname"=>$user['name'],"beizhuxinming"=>$urdat['name']."不在职，无法获得奖金","beizhu"=>$urdat['name']."不在职，无法获得奖金","pid"=>$user['pid'],"path"=>$user['path'],"addtime"=>date("Y-m-d H:i:s",time()));	
										$inrecordmoney=D("recordmoney")->insert($recordmoney);
									}
									//---奖金增加的日志--end------------------------
									//当前用户在职才能拿到推荐奖金!
																					
									$upa=D("tuijian")->where(array("id"=>$v,"status"=>'1',"jihuo"=>'1'))->update("jiangjin=jiangjin+".$q);
									if(intval($v)===intval($path[$jzmax])){
										$upb=D("tuijian")->where(array("id"=>$v,"status"=>'1',"jihuo"=>'1'))->update("tj_num=tj_num+1");
										break;
										
							
										
									}
								}
							}
						}
					}
					//--------------------------------------------

					$id=D("tuijian")->where(array("id"=>$_GET['id']))->update(array("jihuo"=>'1',"jihuo_time"=>time()));
					if($id > 0){
						//--发短信通知用户--账户已激活---
						if(DUANXIN){
							$content="您好".$user['name']."，您的1+2事业平台已经激活！【壹打工网】";
							$dx=new bb_duanxin($user['sphone'],$content);
							$dx->fs();
						}else{
							$content="您好".$user['name']."，您的1+2事业平台已经激活！";
							$str=date("Y-m-d H:i:s",time())."   内容：".$content."	 \r\n";
							error_log($str,3,PROJECT_PATH.'/log/errors_dxnr.log');
						}
						//-------------------------------------
						$this->success("激活成功！", 1);
					}else{
						$this->error("激活失败！", 1);
					}
				}
				//--------------------------
				}else{
					exit("没有权限！");
				}
				//--------------------------
			}
		}
		
		//会员详细信息
		function huiyuaninfo(){
			if(!empty($_GET['id'])){
				$data=D("tuijian")->where(array("id"=>$_GET['id']))->select();
				$this->assign("info",$data[0]);											//会员数据
				$this->assign("tjurl",base64_encode($data[0]['bianhao']));				//使用base64_encode加密编号
				$this->assign('guanxi',D('guanxi')->select());		//关系
				$this->assign('user',$_SESSION['user']);			//权限
				$this->assign('dqurl',$_GET['dqurl']);				//要跳转的url
				$this->display();
			}
		}
		
		//会员详细信息修改
		function modinfo(){
			if(!empty($_POST)){
				//-----------------------------
				if($_SESSION['priv']==1 || $_SESSION['priv']==3 || $_SESSION['priv']==4){
				//-----------------------------
				if($_SESSION['name']!=''){
					$_POST['ruzhi_time']=strtotime($_POST['ruzhi_time']);
					$id=D("tuijian")->where(array("id"=>$_POST['id']))->update();
					if($id > 0){
						//--记录日志---and--------------------------------
						$user=D("tuijian")->field("bianhao,name,sphone")->where(array("id"=>$_POST['id']))->find();
						$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'会员详细信息修改  被修改人的编号：'.$user['bianhao'].'， 姓名：'.$user['name']);
						D("caozuolog")->insert($caozuo);
						//--记录日志---end----------------------------
						$this->success2('用户资料修改成功！', 1);
					}else{
						$this->error2('用户资料修改失败！', 1);
					}
				}
				//---------------------
				}else{
					exit("没有权限！");
				}
				//--------------------
			}
		}
		
		//会员推荐的列表	
		function huiyuantuijian(){
			if(!empty($_GET['id'])){
				$where_sql=array("jihuo"=>'1',"status!"=>'0',"path"=>"%,".$_GET['id'].",%");
				$page=new page(D("tuijian")->where($where_sql)->total(),20);
				$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("concat(path,id)")->select();
				foreach($data as $k => $v){
					$v['path']=strstr($v['path'],$_GET['id'].",");
					$m=substr_count($v['path'],",");
					$strpad = str_pad("",$m*6*4,"&nbsp;");
					$data[$k]['kg']=$strpad.$m."┨";
					$data[$k]['m']=$m;
					if($m >= 1 and $m <= 3){
						$data[$k]['q']=100;
					}elseif($m >= 4 and $m <= 7){
						$data[$k]['q']=30;
					}elseif($m >= 8 and $m <= 10){
						$data[$k]['q']=25;
					}elseif($m >= 11 and $m <= 12){
						$data[$k]['q']=20;
					}else{
						$data[$k]['q']=0;
					}
				}
				$user=D("tuijian")->field("id,bianhao,name,jiangjin,tj_num")->where(array("id"=>$_GET['id']))->find();
				$this->assign("user",$user);
				$this->assign('fpage_weihu',$page->fpage());	//分页
				$this->assign("gdd_user",$_SESSION['user']);
				$this->assign("data",$data);
				$this->display();
			}
		}
		
		//删除未激活的账户
	/*	function delhuiyuan(){
			if(!empty($_GET['id'])){
				//------------------------------------------
				if($_SESSION['priv']==1 || $_SESSION['priv']==3 || $_SESSION['priv']==4){
				//------------------------------------------
				if($_SESSION['name']!=''){
				
					//查询用户信息
					$user=D("tuijian")->field("id,bianhao,name,sex,address,sphone,id_number,qq,jiangjin,tj_num,add_time,f_bianghao,f_name,pid,jibie,path,add_gs")->where(array("id"=>$_GET['id']))->find();
					//----------------------------------------------
					if($user['add_gs']!=''){
						if($user['add_gs']!=$_SESSION['user']){
							$add_gs=get_add_gs($user['add_gs']);
							$this->error($add_gs."添加的, 没有权限操作！", 5);
							exit("没有权限！");
						}
					}
					//--------------------------------------------------
					
					$user['deltime']=time();
					//写入删除记录
					$delid=D('tuijiandel')->insert($user);
					if($delid > 0){
						//--记录日志---and--------------------------------
						$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'删除会员  编号：'.$user['bianhao'].'， 姓名：'.$user['name']);
						D("caozuolog")->insert($caozuo);
						//--记录日志---end----------------------------
						$id=D('tuijian')->delete(array("id"=>$_GET['id']));  
						if($id > 0){
							$this->success("删除成功", 1);  
						}else{
							D('tuijiandel')->delete(array("id"=>$delid));
							$this->error("删除失败！", 1);
						}
					}
				}
				//-----------------------------------
				}else{
					exit("没有权限！");
				}
				//--------------------------
			}
		}
		
		//删除已激活的账户
		function deluser(){
			if(!empty($_GET['id'])){
				//------------------------------------------
				if($_SESSION['priv']==1 || $_SESSION['priv']==3 || $_SESSION['priv']==4){
				//------------------------------------------
				if($_SESSION['name']!=''){
					//查询用户信息
					$user=D("tuijian")->field("id,bianhao,name,sex,address,sphone,id_number,qq,jiangjin,tj_num,add_time,f_bianghao,f_name,pid,jibie,path,add_gs")->where(array("id"=>$_GET['id']))->find();
					//----------------------------------------------
					if($user['add_gs']!=''){
						if($user['add_gs']!=$_SESSION['user']){
							$add_gs=get_add_gs($user['add_gs']);
							$this->error($add_gs."添加的, 没有权限操作！", 5);
							exit("没有权限！");
						}
					}
					//--------------------------------------------------
					$user['deltime']=time();
					//写入删除记录
					$delid=D('tuijiandel')->insert($user);
					if($delid > 0){
						//--记录日志---and--------------------------------
						$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'删除会员  编号：'.$user['bianhao'].'， 姓名：'.$user['name']);
						D("caozuolog")->insert($caozuo);
						//--记录日志---end----------------------------
						$id=D('tuijian')->delete(array("id"=>$_GET['id']));  
						if($id > 0){
							//因为这个会员激活过了，所以要减去被推荐人的推荐数量
							$del=D("tuijian")->where(array("bianhao"=>$user['f_bianghao']))->update("tj_num=tj_num-1");
							$this->success("删除成功", 1);  
						}else{
							D('tuijiandel')->delete(array("id"=>$delid));
							$this->error("删除失败！", 1);
						}
					}
				}
				//-----------------------------------
				}else{
					exit("没有权限！");
				}
				//--------------------------
			}
		}*/
		
	/*	
		function dellizhi(){
			if(!empty($_GET['id'])){
				//------------------------------------------
				if($_SESSION['priv']==1 || $_SESSION['priv']==3 || $_SESSION['priv']==4){
				//------------------------------------------
				if($_SESSION['name']!=''){
					//查询用户信息
					$user=D("tuijian")->field("id,bianhao,name,sex,address,sphone,id_number,qq,jiangjin,tj_num,add_time,f_bianghao,f_name,pid,jibie,path,add_gs")->where(array("id"=>$_GET['id']))->find();
					//----------------------------------------------
					if($user['add_gs']!=''){
						if($user['add_gs']!=$_SESSION['user']){
							$add_gs=get_add_gs($user['add_gs']);
							$this->error($add_gs."添加的, 没有权限操作！", 5);
							exit("没有权限！");
						}
					}
					//--------------------------------------------------
					$user['deltime']=time();
					//写入删除记录
					$delid=D('tuijiandel')->insert($user);
					if($delid > 0){
						//--记录日志---and--------------------------------
						$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'删除会员  编号：'.$user['bianhao'].'， 姓名：'.$user['name']);
						D("caozuolog")->insert($caozuo);
						//--记录日志---end----------------------------
						$id=D('tuijian')->delete(array("id"=>$_GET['id']));  
						if($id > 0){
							//因为这个会员激活过了，所以要减去被推荐人的推荐数量
							$del=D("tuijian")->where(array("bianhao"=>$user['f_bianghao']))->update("tj_num=tj_num-1");
							$this->success("删除成功", 1);  
						}else{
							D('tuijiandel')->delete(array("id"=>$delid));
							$this->error("删除失败！", 1);
						}
					}
				}
				//-----------------------------------
				}else{
					exit("没有权限！");
				}
				//--------------------------
			}
		}*/
/*------------------------------------------------------------------------------------------------------------------------------------------*/

		//离职调用
		function lizhi(){
			//---------------------------------
			if($_SESSION['priv']==1 || $_SESSION['priv']==4){
			//----------------------------------
			if(!empty($_POST)){
				if($_POST['lizhi_time']!=''){
					$data=D("tuijian")->field("bianhao,name,pid,f_bianghao,path,ruzhi_time,add_gs")->where(array("id"=>$_POST['id']))->find();		//查询要入职人员信息
					if($data['pid'] <=1){
						$this->error('该用户不能离职！', 1);		//报单中心 人员不可以离职
					}
					//----------------------------------------------
					if($data['add_gs']!=''){
						if($data['add_gs']!=$_SESSION['user']){
							$add_gs=get_add_gs($data['add_gs']);
							$this->error($add_gs."添加的, 您没有权限激活！", 5);
							exit("没有权限！");
						}
					}
					//--------------------------------------------------
					if($_SESSION['name']!=''){
					$_POST['jihuo']='0';
						$_POST['status']='2';									//入职状态为2 -> "离职"
						$_POST['lizhi_time']=strtotime($_POST['lizhi_time']);	//离职时间
						$id=D("tuijian")->where(array("id"=>$_POST['id']))->update();		//执行更新
						if($id > 0){		//执行成功！
							//--记录日志---and--------------------------------
							$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'离职会员  编号：'.$data['bianhao'].'， 姓名：'.$data['name'].', 离职时间：'.date("Y-m-d",$_POST['lizhi_time']));
							D("caozuolog")->insert($caozuo);
							//--记录日志---end----------------------------
							$this->success('用户离职成功！', 1);
						}else{
							$this->error('用户离职失败！', 1);
						}
					}
				}else{
					$this->error('离职时间不能为空！', 1);
				}	
			}
			//--------------------------------
			}else{
				exit("没有权限！");
			}
			//-------------------------------
		}
		/*----导出excel-----------------------------------------------------------------------------------------------------*/
		function daochuexcel(){
		
			switch($_SESSION['priv']){
				case 4:
					$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" jihuo='1' and status!='0' and path like '%,".$user['id'].",%' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" jihuo='1' and status!='0' and path like '%,".$user['id'].",%' ";
					}
					break;
				case 1:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" jihuo='1' and status!='0' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" jihuo='1' and status!='0' ";
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
			$data=D("tuijian")->where($where_sql)->order("jihuo_time asc")->select();
			$jibei=D("jibie")->select();
			foreach ($data as $k => $v){
				foreach ($jibei as $i => $s){
					if($s['id']==$v['jibie']){
						$data[$k]['jibie']=$s['jibie'];
					}
				}
			}
			
			$name="已激活会员，导出时间-".date('Y-m-d',time());
			
			$title=array("A"=>"编号",
						 "B"=>"姓名",
						 "C"=>"推荐人编号",
						 "D"=>"关系",
						 "E"=>"奖金",
						 "F"=>"推荐人数",
						 "G"=>"报单中心",
						 "H"=>"入职时间",
						 "I"=>"入职企业",
						 "J"=>"激活时间",
						 "K"=>"添加时间",
						 "L"=>"状态",
						);	
				
			$this->excel($name,$title,$data);
			
		}
		
		
		function excel($name,$title,$data){
			include 'PHPExcel.php';
			include 'PHPExcel/Writer/Excel5.php'; 		//用于输出.xls的
			//创建一个excel
			$objPHPExcel = new PHPExcel();			
			//设置excel的属性：
			$objPHPExcel->getProperties()->setCreator("1dagong.com");					//创建人
			$objPHPExcel->getProperties()->setLastModifiedBy("1dagong.com");			//最后修改人
			$objPHPExcel->getProperties()->setTitle("Office 2003 XLSX Test Document");		//标题			
			$objPHPExcel->getProperties()->setSubject("Office 2003 XLSX Test Document");	//题目			
			$objPHPExcel->getProperties()->setDescription("Test document for Office 2003 XLSX.");	//描述			
			$objPHPExcel->getProperties()->setKeywords("office 2003 openxml php");		//关键字			
			$objPHPExcel->getProperties()->setCategory("Test result file");				//种类
			$objPHPExcel->setActiveSheetIndex(0);	
			//设置excel的文件名
			//设置sheet的name
			$objPHPExcel->getActiveSheet()->setTitle($name);
			//设置列宽为自动
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); 
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
			//标题-------------------------------------------------------------------------------
			foreach ($title as $k=>$v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k."1", $v);
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->getStartColor()->setARGB('FFDFEDF7');
			}
			//内容-------------------------------------------------------------------------------
			foreach ($data as $k=>$v) {
			
				$k=$k+2;
				$objPHPExcel->getActiveSheet()->setCellValue("A".$k, strval($v['bianhao']));
				$objPHPExcel->getActiveSheet()->setCellValue("B".$k, $v['name']);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$k, strval(' '.$v['f_bianghao']));
				$objPHPExcel->getActiveSheet()->setCellValue("D".$k, $v['guanxi']);
				$objPHPExcel->getActiveSheet()->setCellValue("E".$k, strval($v['jiangjin']).'元');
				$objPHPExcel->getActiveSheet()->setCellValue("F".$k, strval($v['tj_num']).'人');
				$objPHPExcel->getActiveSheet()->setCellValue("G".$k, $v['jibie']);
				$objPHPExcel->getActiveSheet()->setCellValue("H".$k, date('Y-m-d',$v['ruzhi_time']));
				$objPHPExcel->getActiveSheet()->setCellValue("I".$k, $v['ruzhi_name']);
				$objPHPExcel->getActiveSheet()->setCellValue("J".$k, date('Y-m-d H:i:s',$v['jihuo_time']));
				$objPHPExcel->getActiveSheet()->setCellValue("K".$k, date('Y-m-d H:i:s',$v['add_time']));
				if($v['status']==1){	$status='在职';	}elseif($v['status']==2){	$status='已离职';	}else{	$status='无';	}
				$objPHPExcel->getActiveSheet()->setCellValue("L".$k, $status);
			
			}
			//直接输出到浏览器
			$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
			header("Content-Type:application/force-download");
			header("Content-Type:application/vnd.ms-execl");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");
			header('Content-Disposition:attachment;filename="'.$name.'.xls"');
			header("Content-Transfer-Encoding:binary");
			$objWriter->save('php://output');
		}
		
		
	}
	

	
	
	//离职 减钱代码
	//--------------------------------------------------------------------
	/*	if($data['status']!='2'){							//如果入职状态不等于离职， 才可以执行离职扣钱操作
			$path=explode(",",$data['path']);
			$jzmax=array_search(max($path), $path);
			foreach ($path as $k => $v){
				if($v!='' && strval($v)!='0'){
					$pth=strstr($data['path'],$v.",");	//获取当前路径
					$m=substr_count($pth,",");
					
					if($m < 13){				//超过12层就不操作奖金
						if($m >= 1 and $m <= 3){			//1,2,3	  下线每人给100元
							$q = 100;
						}elseif($m >= 4 and $m <= 7){		//4,5,6,7 下线每人给30元
							$q = 30;
						}elseif($m >= 8 and $m <= 10){		//8,9,10  下线每人给25元
							$q = 25;
						}elseif($m >= 11 and $m <= 12){		//11,12   下线每人该20元
							$q = 20;
						}else{								//超过12层   就不给钱
							$q = 0;
						}
						
						//离职只要不大于规定的天数奖金退还
						if(intval(getdays($data['ruzhi_time'])) < intval(TIANDAYS)){
							//---写入日志---and----------------------------
							$urdat=D("tuijian")->field("id,bianhao,name,sphone,jiangjin,f_bianghao,pid,path")->where(array("id"=>$v))->find();
							$recordmoney=array("hyhumber"=>$urdat['bianhao'],"hyname"=>$urdat['name'],"money"=>$q,"leftmoney"=>$urdat['jiangjin']-$q,"caozuo"=>"减少","newbianhao"=>$data['bianhao'],"beizhu"=>$data['bianhao']."离职扣除的奖金","pid"=>$data['pid'],"path"=>$data['path'],"addtime"=>date("Y-m-d H:i:s",time()));
							$inrecordmoney=D("recordmoney")->insert($recordmoney);	
							//---写入日志--end----------------------------
							//---奖金退还--and------------------------
							$upa=D("tuijian")->where(array("id"=>$v))->update("jiangjin=jiangjin-".$q);
							if(intval($v)===intval($path[$jzmax])){
								$upb=D("tuijian")->where(array("id"=>$v))->update("tj_num=tj_num-1");
								break;
							}
							//---奖金退还--end------------------------
						}
					}
				}
			}
			//离职只要不大于规定的天数奖金退还
			if(intval(getdays($data['ruzhi_time'])) < intval(TIANDAYS)){
				//记录下这个人以后入职在把这个人奖金返回
				$lizhi_renyuan=array("bianhao"=>$data['bianhao'],"name"=>$data['name'],"pid"=>$data['pid'],"f_bianghao"=>$data['f_bianghao'],"path"=>$data['path'],"add_time"=>time());
				$add=D("lizhi_snap")->insert($lizhi_renyuan);
			}
		}
		*/
		//--------------------------------------------------------------------
	
	
	//入职 加钱代码
	
	//-----------------------------------------------------------
	/*
	if($data['status']!='1'){							//如果入职状态不等于已入职的， 才可以执行入职加钱操作。
		$lzuser=D("lizhi_snap")->where(array("bianhao"=>$data['bianhao']))->find();		//查询未满规定天数的离职人员，“存在”就退还奖金，“不存在” 直接入职不进行任何操作。
		if(!empty($lzuser)){
			D("lizhi_snap")->delete(array("bianhao"=>$data['bianhao']));	//删除这个离职人员的记录
			$path=explode(",",$data['path']);
			$jzmax=array_search(max($path), $path);
			foreach ($path as $k => $v){
				if($v!='' && strval($v)!='0'){
					$pth=strstr($data['path'],$v.",");	//获取当前路径
					$m=substr_count($pth,",");
					if($m < 13){				//超过12层就不操作奖金
						if($m >= 1 and $m <= 3){			//1,2,3	  下线每人给100元
							$q = 100;
						}elseif($m >= 4 and $m <= 7){		//4,5,6,7 下线每人给30元
							$q = 30;
						}elseif($m >= 8 and $m <= 10){		//8,9,10  下线每人给25元
							$q = 25;
						}elseif($m >= 11 and $m <= 12){		//11,12   下线每人该20元
							$q = 20;
						}else{								//超过12层   就不给钱
							$q = 0;
						}
						//---写入日志---and----------------------------
						$urdat=D("tuijian")->field("id,bianhao,name,sphone,jiangjin,f_bianghao,pid,path")->where(array("id"=>$v))->find();
						$recordmoney=array("hyhumber"=>$urdat['bianhao'],"hyname"=>$urdat['name'],"money"=>$q,"leftmoney"=>$urdat['jiangjin']+$q,"caozuo"=>"增加","newbianhao"=>$data['bianhao'],"beizhu"=>$data['bianhao']."离职后又入职返还的奖金","pid"=>$data['pid'],"path"=>$data['path'],"addtime"=>date("Y-m-d H:i:s",time()));
						$inrecordmoney=D("recordmoney")->insert($recordmoney);	
						//---写入日志---end---------------------------
						//---奖金退还---and---------------------------
						$upa=D("tuijian")->where(array("id"=>$v))->update("jiangjin=jiangjin+".$q);
						if(intval($v)===intval($path[$jzmax])){
							$upb=D("tuijian")->where(array("id"=>$v))->update("tj_num=tj_num+1");
							break;
						}
						//---奖金退还---end---------------------------
					}
				}
			}
		}
	}
	*/
	//----------------------------------------------------------