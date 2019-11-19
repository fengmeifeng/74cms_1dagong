<?php
class login extends Action{
	//登录页面模版
	function index(){
		$this->display();
	}
	//验证码模块
	function code(){
		$GLOBALS["debug"]=0;
		echo new Vcode(70,20);
	}
	//登录代码
	function denlu(){
		//验证用户和密码是否输入
		if($_POST["user"]=='' || $_POST["pass"]==''){
			$this->error("用户名密码不能为空",3,"index");
		}
		//验证码
		if(strtoupper($_POST["code"]) != $_SESSION["code"]){
			$this->error("验证码错误！",3,"index");
		}
		$sql="select user.*,qx.qx_name,dq.name from bb_adminuser as user left join bb_quanxian as qx on user.quanxian=qx.id left join bb_region as dq on user.dq_id=dq.id where dqname='".$_POST["user"]."' and mima='".md5($_POST["pass"])."'";
		$user=D("adminuser")->query($sql,"select");
		if($user){
			$_SESSION=$user[0];
			$_SESSION["isLogin"]=1;
			$this->success("登录成功",1,"index/index");
		}else{
			$this->error("登录失败！",3,"index");
		}
	}
	//退出登录
	function logout(){
		$username=$_SESSION["dqname"];
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