<?php
	class Site {
		function index(){
		
		}
		//父类菜单显示
		function flcd(){
			$data=D("menu")->where(array("pid"=>"0"))->select();
			$this->assign("data",$data);
			$this->display();
		}
		//菜单显示
		function menu(){
			$sql = "select * from bb_menu order by concat(path,id)";
			$data=D("menu")->query($sql,"select"); 
            foreach ($data as $i=>$v){
        		$m=substr_count($v['path'],",")-1;
				$strpad = str_pad("",$m*6*4,"&nbsp;");
				$data[$i]['kg']=$strpad;
			}
			$this->assign("data",$data);
			$this->display();
		}
		//添加父类菜单界面
		function add_fmenu(){
			$this->display();
		}
		//添加子类菜单
		function add_zmenu(){
			if(!empty($_GET['pid'])){
				$data=D("menu")->where(array("id"=>$_GET['pid']))->select();
	            $this->assign("data",$data[0]);
				$this->display();
			}
		}
		//添加父类代码
		function addf(){
			if($_POST['name']==""){
				$this->error("输入父类菜单名", 1, "add_menu"); 
			}
			$_POST['operating']="g";
			if($_FILES["pic"]['name']!=""){
				$_POST['ico']=$this->upload();
			}else{
				$_POST['ico']="gb.png";
			}
			if(!empty($_POST)){
				$id=D("menu")->insert();
				if(!empty($id)){
					$this->success("添加成功", 1, "menu"); 
				}else{
					$this->error("添加失败", 1, "add_menu"); 
				}
			}else{
				$this->error("添加失败", 1, "add_menu"); 
			}
		}
		//添加子类代码
		function addz(){
			if($_POST['name']==""){
				$this->error("输入父类菜单名", 1, "add_menu"); 
			}
			if($_POST['operating']==""){
				$_POST['operating']="z";
			}
			if($_FILES["pic"]['name']!=""){
				$_POST['ico']=$this->upload();
			}else{
				$_POST['ico']="gb.png";
			}
			if(!empty($_POST)){
				$id=D("menu")->insert();
				if(!empty($id)){
					$this->success("添加成功", 1, "menu"); 
				}else{
					$this->error("添加失败", 1, "add_menu"); 
				}
			}else{
				$this->error("添加失败", 1, "add_menu"); 
			}
		}
		//修改父类菜单界面
		function modf(){
			if(!empty($_GET["id"])){
				$data=D("menu")->where(array("id"=>$_GET['id']))->select();
	            $this->assign("data",$data[0]);
	            $this->display();
			}
		}
		//修改子类菜单界面
		function modz(){
			if(!empty($_GET["id"])){
				$data=D("menu")->where(array("id"=>$_GET['id']))->select();
	            $this->assign("data",$data[0]);
	            $this->display();
			}
		}
		//修改代码
		function updata(){
			if($_FILES["pic"]['name']!=""){
				$_POST['ico']=$this->upload();
			}
			if(!empty($_POST)){
				$id=D("menu")->where(array("id"=>$_POST["id"]))->update();
				if(!empty($id)){
					$this->success("修改成功", 1, "menu"); 
				}else{
					$this->error("修改失败", 3, "menu"); 
				}
			}else{
				$this->error("修改失败", 1, "menu"); 
			}
		}
		//删除代码
		function del(){
			if(!empty($_GET["id"])){
				$id=D("menu")->delete(array("id"=>$_GET["id"]),array("path"=>"%,".$_GET["id"].",%"));
				if(!empty($id)){
					$this->success("成功删除".$id."条记录", 1, "menu"); 
				}else{
					$this->error("删除失败", 1, "menu"); 
				}
			}
		}
		/*地区管理---------------------------------------*/
		function dq(){
			$data=D("region")->select();
			$this->assign("data",$data);
			$this->display();
		}
		//修改地区
		function dqmod(){
			$data=D("region")->where(array("id"=>$_GET['id']))->select();
			$this->assign("data",$data[0]);
			$this->display();
		}
		//修改地区代码
		function dq_mod(){
			if(!empty($_POST)){
				$id=D("region")->where(array("id"=>$_POST['id']))->update();
				if(!empty($id)){
					$this->success("添加成功", 1, "dq"); 
				}else{
					$this->error("添加失败", 1, "dq"); 
				}
			}else{
				$this->error("添加失败", 1, "dq"); 
			}
		
		}
		//添加地区
		function dqadd(){
			$this->display();
		}
		//添加地区代码
		function dq_add(){
			if(!empty($_POST)){
				$id=D("region")->insert();
				if(!empty($id)){
					$this->success("添加成功", 1, "dq"); 
				}else{
					$this->error("添加失败", 1, "dq"); 
				}
			}else{
				$this->error("添加失败", 1, "dq"); 
			}
		}
		//删除地区
		function dqdel(){
			if(!empty($_GET['id'])){
				$id=D("region")->delete(array("id"=>$_GET["id"]));
				if(!empty($id)){
					$this->success("成功删除".$id."条记录", 1, "dq"); 
				}else{
					$this->error("删除失败", 1, "dq"); 
				}
			}
		}
		/*----用户管理------------------------*/
		function user(){
			$sql="select user.*,qx.qx_name,dq.name from bb_adminuser as user left join bb_quanxian as qx on user.quanxian=qx.id left join bb_region as dq on dq.id=user.dq_id ORDER BY user.id ASC ";
			$data=D("adminuser")->query($sql,"select");			
			$this->assign("data",$data);
			$this->display();
		}
		//添加用户
		function useradd(){
			$dq=D("region")->select();
			$this->assign("dq",$dq);
			$quanxian=D("quanxian")->select();
			$this->assign("quanxian",$quanxian);
			$this->display();
		}
		//添加用户代码
		function user_add(){
			if(!empty($_POST)){
				$_POST['mima']=md5($_POST['mima']);
				$id=D("adminuser")->insert();
				if(!empty($id)){
					$this->success("添加成功", 1, "user"); 
				}else{
					$this->error("添加失败", 1, "user"); 
				}
			}else{
				$this->error("添加失败", 1, "user"); 
			}
		}
		//修改用户
		function usermod(){
			$dq=D("region")->select();
			$this->assign("dq",$dq);
			$quanxian=D("quanxian")->select();
			$this->assign("quanxian",$quanxian);
			$sql="select user.*,qx.qx_name,dq.name from bb_adminuser as user left join bb_quanxian as qx on user.quanxian=qx.id left join bb_region as dq on dq.id=user.dq_id where user.id='".$_GET['id']."' ORDER BY user.id ASC ";
			$data=D("adminuser")->query($sql,"select");		
			$this->assign("data",$data[0]);
			$this->display();
		}
		//修改用户代码
		function user_mod(){
			if(!empty($_POST)){
				if($_POST['mima']!=""){
					$_POST['mima']=md5($_POST['mima']);
				}
				$id=D("adminuser")->where(array("id"=>$_POST['id']))->update();
				if(!empty($id)){
					$this->success("添加成功", 1, "user"); 
				}else{
					$this->error("添加失败", 1, "user"); 
				}
			}else{
				$this->error("添加失败", 1, "user"); 
			}
		}
		//删除管理员
		function userdel(){
			if(!empty($_GET['id'])){
				$id=D("adminuser")->delete(array("id"=>$_GET["id"]));
				if(!empty($id)){
					$this->success("成功删除".$id."条记录", 1, "user"); 
				}else{
					$this->error("删除失败", 1, "user"); 
				}
			}
		}
		/*地区管理-----------------------------*/
		//上传图片
		Private function upload(){
			$up = new FileUpload(); //可以通过参数指定上传位置，可通过set()方法
			$up->set("path", "./dingzhan/views/default/resource/ico/")  //设置上传位置
			    ->set("maxSize", 1000000)             //设置上传大小，单位字节
			    //设置允许上传的类型
			    ->set("allowType", array("gif", "jpg", "png"))
			    //设置启用上传后随机文件名，true启用（默认）， false使用原文件名
			    ->set("israndname", false);
				if($up->upload("pic")) {  //pic为上传表单的名称
				     return $up->getFileName();  //返回上传后的文件名
				}else{
				//如果上传失败提示出错原因
					$this->error($up->getErrorMsg(), 5, "menu");
				}
			}

	}