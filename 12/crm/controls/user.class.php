<?php
class User{
	//登录页面模版
	function index(){
		
		echo "欢迎来到1+2事业平台";
	}
	
	
	//个人信息维护界面
	function info(){
		if(!empty($_SESSION)){
			//用户信息
			$this->assign("info",$_SESSION);
			$priv_name=D("crm_priv")->where(array("priv"=>$_SESSION['priv']))->select();
			$this->assign("priv_name",$priv_name[0]['priv_name']);
			$this->display();
		}
	}
	//修改密码界面
	function pass(){
		$info=D("crm_user")->where(array("id"=>$_SESSION['id']))->find();
		$this->assign("info",$info);
		$this->display();
	}
	//修改登录密码
	function passdenglu(){
		if(!empty($_POST)){
			if($_POST['dlmima']!=''){
				$data=D("crm_user")->where(array("id"=>$_POST['id'],"pass"=>MD5(USERPASS.$_POST['dlmima'])))->select();
				if(!empty($data)){
					
					if($_POST["dlmima1"]==$_POST["dlmima2"]){
						$_POST['pass']=MD5(USERPASS.$_POST["dlmima1"]);
						$id=D('crm_user')->where(array('id'=>$_POST['id']))->update();
						if(!empty($id)){
							$this->success("修改登录密码成功", 1);
						}else{
							$this->error("修改登录密码失败",3);
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
}