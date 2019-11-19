<?php
class M_huodong{
	//----------------------
	function index(){
		if(!empty($_SESSION['username'])){
			$this->assign("user",$_SESSION);
		}
		$this->display();
	}

	//领取页--------
	function lq(){
		if($_SESSION['uid'] && $_SESSION['username'] && $_SESSION['utype']){
			if($_SESSION['utype']==1){
				$data=D("qs_gifts")->where(array("be"=>"0"))->find();
				$_POST["lp_id"]=$data["id"];
				$_POST["username"]=$_SESSION['username'];
				$_POST["uid"]=$_SESSION['uid'];
				$_POST["addtime"]=time();
				$datalp=D("vip_lpk")->where(array("uid"=>$_SESSION['uid']))->select();
				if(empty($datalp)){
					$id=D("vip_lpk")->insert();
				}else{
					$this->assign("dat","你已经领取过了！这是你的礼品卡号");
					$this->dayin();
				}
				if(!empty($id)){
					$_POST["be"]=1;
					$id=D("qs_gifts")->where($data["id"])->update();
					if(!empty($id)){
						$this->assign("dat","领取成功，这是你的礼品卡号");
						$this->dayin();
					}
				}
			}
                              else{
				$this->error("你不是企业用户！",3,"login");
			}


		}else{
			$this->login();
		}
	}
	//登录页面--------------------------------
	function login(){
		if(!empty($_SESSION['username'])){
			$this->assign("user",$_SESSION);
		}
		$this->display(dl);
	}
	
	//登录处理------------
	function dl(){
	  if(!empty($_POST)){
		$pwdhash = "3GbKpqoWDiBSK6Wg";
		$user=$_POST['user'];
		$pass=$_POST['pass'];
		$data=D("qs_members")->field("uid,utype,username,email,password,pwd_hash")->where(array("username"=>$user))->select();
		$pwd_hash=$data[0]['pwd_hash'];
		$usname=$data[0]['username'];
		$pwd=md5(md5($pass).$pwd_hash.$pwdhash);
		if($data[0]['password']==$pwd){
			$_SESSION['utype']=$data[0]['utype'];
			$_SESSION['uid']=$data[0]['uid'];
			$_SESSION['username']=$data[0]['username'];
			$this->lq();
		}else{
			$this->error("登录失败! （＞﹏＜）",3,"login");
		}
	  }else{
			$this->error("请输入用户名和密码！",3,"login");
		}
	}

	//退出页面
	function tologin(){
		$username=$_SESSION["username"];
		$_SESSION=array();
		if(isset($_COOKIE[session_name()])){
			setCookie(session_name(),'',time()-3600,'/');
		}
		session_destroy();
		$this->success("再见 $username . 重新登录!",3,"index");

	}

	//打印页面
	function dayin(){
		$sql="select * from qs_gifts where id in(select lp_id from vip_lpk where uid='".$_SESSION['uid']."')";
		$data=D("qs_gifts")->query($sql,"select");
		if(!empty($data)){
			$this->assign("data",$data[0]);
		}
		if(!empty($_SESSION['username'])){
			$this->assign("user",$_SESSION);
		}
		$this->display(dayin);
	}
}