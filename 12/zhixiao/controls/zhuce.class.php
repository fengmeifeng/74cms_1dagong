<?php
	class zhuce {
		function index(){
			
		}
		
		//注册用户---
		function zc(){
			if($_SESSION['priv']=='1'){
				$this->error("可以在报单中心注册会员", 1, "jichu/baodan");
			}
			$bianhao="s".rand(100000,999999);
			//使用死循环防止纯在重复的随机数
			$i=1;
			while($i){
				$data=D("tuijian")->where(array("bianhao"=>$bianhao))->select();
				if(!empty($data)){
					$bianhao="s".rand(100000,999999);
					$i=1;
				}else{
					break;
				}
			}
			$this->assign('bianhao',$bianhao);
			$gx=D('guanxi')->select();	//关系
			$this->assign('guanxi',$gx);
			$this->display();
		}
		//报单中心注册界面
		function bdzc(){
			//是否接收到这些值
			if($_GET['bianhao']!="" && $_GET['id']!=""){
				/*-------*/
				$bianhao="s".rand(100000,999999);
				//使用死循环防止纯在重复的随机数
				$i=1;
				while($i){
					$data=D("tuijian")->where(array("bianhao"=>$bianhao))->select();
					if(!empty($data)){
						$bianhao="s".rand(100000,999999);
						$i=1;
					}else{
						break;
					}
				}
				$this->assign('bianhao',$bianhao);
				$this->assign('bh',$_GET['bianhao']);
				$this->assign('id',$_GET['id']);
				$gx=D('guanxi')->select();	//关系
				$this->assign('guanxi',$gx);
				$this->display();
			}
		}
		//注册用户代码
		function zhucedaima(){
			//---------------------------
			if($_SESSION['user']!=''){
			//---------------------------
			if(!empty($_POST)){
				
				if($_POST['guanxi']==''){
					//$this->error('推荐关系未选择！', 1);
				}
				
				if($_POST['name']!='' && $_POST['sphone']!='' && $_POST['id_number']){
					$data=D("tuijian")->where(array("sphone"=>$_POST['sphone']),array("id_number"=>$_POST['id_number']))->find();
				}else{
					$this->error('姓名，手机号和身份证号必须填写！', 1);
				}
				
				if(empty($data)){
					if($_POST['tuijianbiaohao']!=''){
						//存在
						$user=D("tuijian")->where(array("bianhao"=>$_POST['tuijianbiaohao']))->find();
						$m=substr_count($user['path'],",");
						if($m <= 2){	$_POST['jibie']="2"; }else{	$_POST['jibie']="3"; 	$_POST['add_gs']=$_SESSION['user'];	}		//大于2级就 添加上录入地区
						$_POST['add_time']=time();
						$_POST['f_bianghao']=$user['bianhao'];
						$_POST['f_name']=$user['name'];
						$_POST['pid']=$user['id'];
						$_POST['path']=$user['path'].$user['id'].',';
						
						if($_SESSION['name']!=''){
						
							$id=D("tuijian")->insert();
							
							if($id > 0){
								if(DUANXIN){
									$content="您好".$_POST['name']."，".$user['name']."已经将您推荐到1+2事业平台，请登陆www.1dagong.com查看。账号为您的手机号，密码为手机号后四位。【壹打工网】";
									$dx=new bb_duanxin($_POST['sphone'],$content);
									$dx->fs();
								}
							}
							
						}
						$userbh=$_POST['tuijianbiaohao'];	//推荐编号
					}else{
						//不纯在 
						if($_POST['bh']!='' && $_POST['sid']!=''){		//总站报单中心不纯在插入该地区的报单
							$user=D("tuijian")->where(array("bianhao"=>$_POST['bh']))->find();					
							$_POST['add_time']=time();
							$_POST['f_bianghao']=$user['bianhao'];
							$_POST['f_name']=$user['name'];
							$_POST['pid']=$user['id'];
							$_POST['jibie']="2";
							$_POST['path']=$user['path'].$user['id'].',';
							
							if($_SESSION['name']!=''){
								$id=D("tuijian")->insert();
								if($id > 0){
									if(DUANXIN){
										$content="您好".$_POST['name']."，您已成功加入到1+2事业平台，请登陆www.1dagong.com查看。账号为您的手机号，密码为手机号后四位。【壹打工网】";
										$dx=new bb_duanxin($_POST['sphone'],$content);
										$dx->fs();
									}
								}
							}
							$userbh=$_POST['bh'];		//报单选择编号
						}else{		//个报单中心
							$user=D("tuijian")->where(array("bianhao"=>$_SESSION['user']))->find();						
							$_POST['add_time']=time();
							$_POST['f_bianghao']=$user['bianhao'];
							$_POST['f_name']=$user['name'];
							$_POST['pid']=$user['id'];
							$_POST['jibie']="2";
							$_POST['path']=$user['path'].$user['id'].',';
							if($_SESSION['name']!=''){
								$id=D("tuijian")->insert();
								if($id > 0){
									if(DUANXIN){
										$content="您好".$_POST['name']."，您已成功加入到1+2事业平台，请登陆www.1dagong.com查看。账号为您的手机号，密码为手机号后四位。【壹打工网】";
										$dx=new bb_duanxin($_POST['sphone'],$content);
										$dx->fs();
									}
								}
							}
							$userbh=$_SESSION['user'];		//操作编号
						}
					}
				}else{
					$this->error('这个人已经被推荐了', 1);
				}
				if($id > 0){
					//--记录日志---and--------------------------------
					if($_SESSION['name']!=''){
						$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'添加会员  编号：'.$_POST['bianhao'].'， 姓名：'.$_POST['name']);
						D("caozuolog")->insert($caozuo);
					}
					//--记录日志---end----------------------------
					//--注册1打工会员--and------------------------------------------
					$url='http://www.1dagong.com/home/12tuijian/getzuce.php?dopost=curl&sj='.$_POST['sphone'].'&us='.$_POST['bianhao'];
					scurl($url);
					//---注册1打工会员--end-----------------------------------------
					
					$this->success("注册用户成功！", 1, "zc");        
				}else{
					$this->error("注册用户失败！", 5);
				}
			}
			//-----------------------------------
			}else{
				
				$this->error("出错了！请重新登录，重试！", 3);
			}
			//---------------------------------
		}
		
/*------ajax调用---------------------------------*/
		function getbianhao(){
			if(!empty($_POST)){
				$user=D("tuijian")->where(array("bianhao"=>$_POST['bh']))->find();
				if(!empty($user)){
					echo '<font color="green">ok  推荐人：'.$user['name']."</font>";
				}else{
					echo '<font color="red">推荐人编号不存在！</font>';
				}
			}
		}
		
		function getshouji(){
			if(!empty($_POST)){
				$user=D("tuijian")->where(array("sphone"=>$_POST['sphone']))->find();
				if(empty($user)){
					echo '<font color="green">ok</font>';
				}else{
					echo '<font color="red">存在</font>';
				}
			}
		}
		
		function getid_number(){
			if(!empty($_POST)){
				$user=D("tuijian")->where(array("id_number"=>$_POST['id_number']))->find();
				if(empty($user)){
					echo '<font color="green">ok</font>';
				}else{
					echo '<font color="red">存在</font>';
				}
			}
		}
	}