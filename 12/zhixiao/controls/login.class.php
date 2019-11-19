<?php
class login extends Action{
	//登录页面模版
	function index(){
		$data=D("region")->select();
		$this->assign("dq",$data);
		$this->display();
		//销毁变量
		unset($data);
	}
	//登录代码
	function denlu(){
		if($_POST["user"]=='' || $_POST["pass"]==''){
			$this->error("用户名密码不能为空",3,"index");
		}
		//echo MD5(USERPASS.$_POST["pass"]);exit;
		$user=D("adminuser")->where(array("username"=>$_POST["user"],"pass"=>MD5(USERPASS.$_POST["pass"])))->select();
		
		if(!empty($user)){
			if($user[0]['priv']!=2){
				$_SESSION=$user[0];
				$_SESSION["isLogin"]=1;
				$this->success("登录成功",1,"index/index");
			}else{
				$this->error("不允许登录",3,"index");
			}
		}else{
			$this->error("登录失败！",3,"index");
		}
		//销毁变量
		unset($user);
	}
	//退出登录
	function logout(){
		$username=$_SESSION["name"];
		$_SESSION=array();
		if(isset($_COOKIE[session_name()])){
			setCookie(session_name(),'',time()-3600,'/');
		}
		session_destroy();
		$this->success("再见 $username  要想使用请重新登录!",3,"index");
		//销毁变量
		unset($username);
	}
}