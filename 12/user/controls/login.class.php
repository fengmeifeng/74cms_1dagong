<?php
class login extends Action{
	//登录页面模版
	function index(){
		
		$this->display();
	}
	//登录代码
	function denlu(){
		if($_POST["user"]=='' || $_POST["pass"]==''){
			$this->error("用户名密码不能为空",3,"index");
		}
		$user=D("tuijian")->field("id,bianhao,name,sex,sphone,id_number,qq,jiangjin,tj_num,add_time,jihuo,jihuo_time,status,ruzhi_time,lizhi_time,guanxi,f_bianghao,pid,jibie,path")->where(array("bianhao"=>$_POST["user"],"pasword"=>MD5(USERPASS.$_POST["pass"]),"status!"=>0),array("bianhao"=>$_POST["user"],"pasword"=>MD5(USERPASS.$_POST["pass"]),"status!"=>2))->select();
		if(!empty($user)){
			$_SESSION=$user[0];
			$_SESSION["isLoginus"]=1;		//普通用户登录
			$this->success("登录成功",1,"index/index");
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