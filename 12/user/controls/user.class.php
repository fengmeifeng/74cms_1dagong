<?php
class User{
	//登录页面模版
	function index(){
		
		echo "欢迎来到1+2事业平台";
	}
	//添加我推荐的用户
	function adduser(){
		if($_SESSION['bianhao']=='1dagong'){
			$this->error('财务中心帐号不允许注册会员！', 1);
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
		$this->assign('pid',$_SESSION['pid']);
		$this->display();
	}
	//------------
	function zhucedaima(){
		if(!empty($_POST)){
			
			if($_POST['guanxi']==''){
				$this->error('推荐关系未选择！', 1);
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
					if($m <= 2){ $_POST['jibie']="2"; }else{ $_POST['jibie']="3"; }
					$_POST['add_time']=time();
					$_POST['f_bianghao']=$user['bianhao'];
					$_POST['pid']=$user['id'];
					$_POST['path']=$user['path'].$user['id'].',';
					$id=D("tuijian")->insert();
				}else{
					//不存在
					$user=D("tuijian")->where(array("bianhao"=>$_SESSION['bianhao']))->find();						
					$m=substr_count($user['path'],",");
					if($m <= 2){ $_POST['jibie']="2"; }else{ $_POST['jibie']="3"; }
					$_POST['add_time']=time();
					$_POST['f_bianghao']=$user['bianhao'];
					$_POST['pid']=$user['id'];
					$_POST['path']=$user['path'].$user['id'].',';
					$id=D("tuijian")->insert();
				}
			}else{
				$this->error('这个人已经被推荐了', 1);
			}
			
			if($id > 0){
				$this->success("注册用户成功！", 1);        
			}else{
				$this->error("注册用户失败！", 1);
			}
			
		}
	}
	//个人信息维护界面
	function info(){
		if(!empty($_SESSION['id'])){
			//用户信息
			$info=D("tuijian")->where(array("id"=>$_SESSION['id']))->select();
			$this->assign("info",$info[0]);
			$this->assign("tjurl",base64_encode($info[0]['bianhao']));
			$this->assign('guanxi',D('guanxi')->select());		//关系
			$this->display();
		}
	}
	//个人信息维护代码
	function modinfo(){
		if(!empty($_POST)){
			$_POST['birthday']=strtotime($_POST['birthday']);
			$id=D("tuijian")->where(array("id"=>$_POST['id']))->update();
			if($id > 0){
				$this->success('用户资料修改成功！', 1 , "info");
			}else{
				$this->error('用户资料修改失败！', 1);
			}
		}
	}
	//修改密码界面
	function pass(){
		$info=D("tuijian")->where(array("id"=>$_SESSION['id']))->find();
		if($info['pasword2']!=''){
			$bd='<li><label>原提现密码：</label><input class="ipt" type="password" name="yztxmima" size="30" > <span class="red">*</span></li>';
		}else{
			$bd='<li><label><b>登录密码</b>：</label><input class="ipt" type="password" name="yzdlmima" size="30" > <span class="red">*</span></li>';
		}
		$this->assign("bd",$bd);
		$this->assign("info",$info);
		$this->display();
	}
	//修改登录密码
	function passdenglu(){
		if(!empty($_POST)){
			if($_POST['dlmima']!=''){
				$data=D("tuijian")->where(array("id"=>$_POST['id'],"pasword"=>MD5(USERPASS.$_POST['dlmima'])))->select();
				if(!empty($data)){
					
					if($_POST["dlmima1"]==$_POST["dlmima2"]){
						$_POST['pasword']=MD5(USERPASS.$_POST["dlmima1"]);
						$id=D('tuijian')->where(array('id'=>$_POST['id']))->update();
						if(!empty($id)){
							$this->success("修改登录密码成功", 1, "index");
						}else{
							$this->error("修改登录密码失败",3,"pass");
						}
					}else{
						$this->error("两次输入的密码不一致！",1);
					}
				
				}else{
					$this->error('登录密码输入错误！', 1);
				}
			}else{
				$this->error('登录密码没有被修改！', 1);
			}
		}
	}
	
	//设置于修改提现密码
	function passtixian(){
		if(!empty($_POST)){
			//设置提现密码--and--------------------
			if($_POST['yzdlmima']!=''){
				$data=D("tuijian")->where(array("id"=>$_POST['id'],"pasword"=>MD5(USERPASS.$_POST['yzdlmima'])))->select();
				if(!empty($data)){
					//---------------------------
					if($_POST["txmima1"]!=''){
						if($_POST["txmima1"]==$_POST["txmima1"]){
							$_POST['pasword2']=MD5(USERPASS.$_POST["txmima1"]);
							$id=D('tuijian')->where(array('id'=>$_POST['id']))->update();
							if(!empty($id)){
								$this->success("设置提现密码成功", 1, "index");
							}else{
								$this->error("设置提现密码失败",3,"pass");
							}
						}else{
							$this->error("两次输入的密码不一致！",1);
						}
					}else{
						$this->error('提现密码不能为空！', 1);
					}
					//---------------------------
				}else{
					$this->error('登录密码错误！', 1);
				}
			}else
			//设置提现密码--end--------------------
	/*---------------------------------------------------------*/
			//修改提现密码--and--------------------
			if($_POST['yztxmima']!=''){				
				$data=D("tuijian")->where(array("id"=>$_POST['id'],"pasword2"=>MD5(USERPASS.$_POST['yztxmima'])))->select();
				if(!empty($data)){
					//---------------------------
					if($_POST["txmima1"]!=''){
						if($_POST["txmima1"]==$_POST["txmima1"]){
							$_POST['pasword2']=MD5(USERPASS.$_POST["txmima1"]);
							$id=D('tuijian')->where(array('id'=>$_POST['id']))->update();
							if(!empty($id)){
								$this->success("修改提现密码成功", 1, "index");
							}else{
								$this->error("修改提现密码失败",3,"pass");
							}
						}else{
							$this->error("两次输入的密码不一致！",1);
						}
					}else{
						$this->error('提现密码不能为空！', 1);
					}
					//---------------------------
				}else{
					$this->error('提现密码错误！', 1);
				}
			}else{
				$this->error('提现密码没有被修改！', 1);
			}
			//修改提现密码--end--------------------
		}
	}
	
}