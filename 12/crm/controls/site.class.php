<?php
	class Site {
		function index(){


		}
		//父类菜单显示
		function flcd(){
			$data=D("menu_crm")->where(array("pid"=>"0"))->select();
			//p($data);
			$this->assign("data",$data);
			$this->display();
			//销售变量
			unset($data);
		}
		//菜单显示
		function menu(){
			$sql = "select * from menu_crm order by concat(path,id)";
			$data=D("menu_crm")->query($sql,"select"); 
            //-----------------------------------
            foreach ($data as $i=>$v){
        		$m=substr_count($v['path'],",")-1;
				$strpad = str_pad("",$m*6*4,"&nbsp;");
				$data[$i]['kg']=$strpad;
			}
			$this->assign("data",$data);
			$this->display();
			//销售变量
			unset($sql,$data);
		}
		//添加父类菜单界面
		function add_fmenu(){
			$this->display();
		}
		//添加子类菜单
		function add_zmenu(){
			if(!empty($_GET['pid'])){
				$data=D("menu_crm")->where(array("id"=>$_GET['pid']))->select();
	            $this->assign("data",$data[0]);
				$this->display();
			}
			//销售变量
			unset($data);
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
				$id=D("menu_crm")->insert();
				if(!empty($id)){
					$this->success("添加成功", 1, "menu"); 
				}else{
					$this->error("添加失败", 1, "add_menu"); 
				}
			}else{
				$this->error("添加失败", 1, "add_menu"); 
			}
			//销售变量
			unset($_POST,$id);
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
				$id=D("menu_crm")->insert();
				if(!empty($id)){
					$this->success("添加成功", 1, "menu"); 
				}else{
					$this->error("添加失败", 1, "add_menu"); 
				}
			}else{
				$this->error("添加失败", 1, "add_menu"); 
			}
			//销售变量
			unset($_POST,$id);
		}
		//修改父类菜单界面
		function modf(){
			if(!empty($_GET["id"])){
				$data=D("menu_crm")->where(array("id"=>$_GET['id']))->select();
	            $this->assign("data",$data[0]);
	            $this->display();
			}
			//销售变量
			unset($data);
		}
		//修改子类菜单界面
		function modz(){
			if(!empty($_GET["id"])){
				$data=D("menu_crm")->where(array("id"=>$_GET['id']))->select();
	            $this->assign("data",$data[0]);
	            $this->display();
			}
			//销售变量
			unset($data);
		}
		//修改代码
		function updata(){
			if($_FILES["pic"]['name']!=""){
				$_POST['ico']=$this->upload();
			}
			if(!empty($_POST)){
				$id=D("menu_crm")->where(array("id"=>$_POST["id"]))->update();
				if(!empty($id)){
					$this->success("修改成功", 1, "menu"); 
				}else{
					$this->error("修改失败", 3, "menu"); 
				}
			}else{
				$this->error("修改失败", 1, "menu"); 
			}
			//销售变量
			unset($_POST,$id);
		}
		//删除代码
		function del(){
			if(!empty($_GET["id"])){
				$id=D("menu_crm")->delete(array("id"=>$_GET["id"]),array("path"=>"%,".$_GET["id"].",%"));
				if(!empty($id)){
					$this->success("成功删除".$id."条记录", 1, "menu"); 
				}else{
					$this->error("删除失败", 1, "menu"); 
				}
			}
			//销售变量
			unset($id);
		}
		//上传图片
		Private function upload(){
			$up = new FileUpload(); //可以通过参数指定上传位置，可通过set()方法
			$up->set("path", "./zhixiao/views/default/resource/ico/")  //设置上传位置
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
			//销售变量
			unset($up);	
		}

	}