<?php
	class Adminuser {
		//权限用户列表
		function index(){
			$adminuser=D("vip_adminpassword");
			$data=$adminuser->select();
			$this->assign("data",$data);
			$this->display();
		}

		//添加管理人员权限界面
		function adminuseradd(){
			$dq=D("qs_subsite")->field("s_id,s_districtname")->select();
			$this->assign("dq",$dq);
			$this->display(add);
		}

		//添加数据
		function add(){
			if(!empty($_POST)){
				if($_POST['mima']==$_POST['cfmima']){
					$_POST['mima']=MD5($_POST['mima']);
					$_POST['quanxian']="1";
					$id=D("vip_adminpassword")->insert();		
					if(!empty($id)){
						$this->success("成功!", 2, "adminuser/index");
					}else{
						$this->error("失败!",2,"adminuser/adminuseradd");
					}
				}else{
					$this->error("权限密码两次输入不相等,请重新输入",2,"adminuser/adminuseradd");
				}
			}
		}

		//修改界面
		function mod(){
			if(!empty($_GET['id'])){
				$data=D("vip_adminpassword")->where($_GET['id'])->select();
				$this->assign("data",$data[0]);
				$this->display(mod);
			}
		}

		//修改数据
		function updata(){
			if(!empty($_POST)){
				if($_POST['mima']==$_POST['cfmima']){
				$_POST['mima']=MD5($_POST['mima']);
				$id=D("vip_adminpassword")->update(); 
				if(!empty($id)){
						$this->success("成功!", 2, "adminuser/index");
					}else{
						$this->error("失败!",2,"adminuser/adminuseradd");
					}

				}else{
					$this->error("权限密码两次输入不相等,请重新输入",2,"adminuser/adminuseradd");
				}
			}
		}

		//删除数据
		function del(){
			if(!empty($_GET['id'])){
				$id=$_GET['id'];
				$id=D("vip_adminpassword")->delete($id);
				if(!empty($id)){
					$this->success("删除成功!", 1, "adminuser/index");
				}else{
					$this->error("删除失败!", 1, "adminuser/index");
				}
			}
			

		}
		
		//查看日志
		function rz(){
			if(!empty($_POST['key'])){
				$page=new Page(D("rizhi")->total(array('sqlx'=>"%".$_POST['key']."%")), 20);
				$sql="select * from rizhi where sqlx like '%".$_POST['key']."%' ORDER BY `time` DESC LIMIT ".$page->limit;
				$data=D("rizhi")->query($sql,"select");		
			}else{
				$page=new Page(D("rizhi")->total(), 20);
				$sql="select * from rizhi ORDER BY `time` DESC LIMIT ".$page->limit;
				$data=D("rizhi")->query($sql,"select");
			}
			$this->assign("data",$data);
			$this->assign("fpage", $page->fpage());
			$this->display(rizhi);
		}
}
	