<?php
	class DanweiAction extends Common {

		function index(){

		}
		function addcy(){
			if($_GET['partment_id']!=""){
				
			
				
				$this->display();
			}
		}
		//部门管理
		function dwgl(){
			if(!empty($_POST)){
				$data=D("crm_department")->where(array($_POST['searchfield']=>$_POST['searchvalue']))->order("concat(path,dept_id)")->select();
			}elseif(!empty($_GET['dept_parent_id'])){
				$data=D("crm_department")->where(array("dept_parent_id"=>$_GET['dept_parent_id']))->order("concat(path,dept_id)")->select();
			}else{
				$data=D("crm_department")->order("concat(path,dept_id)")->select();
			}
			
			$dat=D("crm_department")->order("concat(path,dept_id)")->select();
			$arr=array();
			foreach ($dat as $i=>$v){
				$arr[$v['dept_id']]=$v['dept_name'];
			}
			foreach ($data as $k => $v) {
				foreach ($arr as $i => $s) {
					if($v['dept_parent_id']==$i){
						$data[$k]['dept']=$s;
					}
				}
				$m=substr_count($v['path'],",")-1;
				$strpad = str_pad("",$m*6*4,"&nbsp;");
				$data[$k]['kg']=$strpad;
			}
			$this->assign("data",$data);
			$this->display();
		}
		//添加部门界面
		function add(){
				$data=D("crm_department")->where(array("dept_id"=>$_GET['dept_parent_id']))->select();
	            $this->assign("data",$data[0]);
				$this->display();
		}
		//添加部门代码
		function indata(){
			if(!empty($_POST)){
				if($_POST['dept_name']=="" || $_POST['tel_no']==""){
					$this->error("请输入必填项！", 1, "add"); 
				}
				$id=D("crm_department")->insert();
				if(!empty($id)){
					$this->success("添加成功", 1, "dwgl"); 
				}else{
					$this->error("添加失败", 1, "dwgl"); 
				}
			}
		}
		//修改部门参数界面
		function mod(){
			if(!empty($_GET['id'])){
				$data=D("crm_department")->where(array("dept_id"=>$_GET['id']))->find();
				$f=D("crm_department")->where(array("dept_id"=>$data['dept_parent_id']))->find();
				$this->assign("data",$data);
				$this->assign("f",$f);
				$this->display();
			}
		}
		//修改部门参数代码
		function updata(){
			if(!empty($_POST)){
				if($_POST['dept_name']==""){
					$this->error("请输入部门名称！", 1, "dwgl"); 
				}
				
				$id=D("crm_department")->where(array("dept_id"=>$_POST['dept_id']))->update();
				
				if(!empty($id)){
					$this->success("修改成功", 1, "dwgl"); 
				}else{
					$this->error("修改失败", 1, "dwgl"); 
				}
			}
		}
		//删除部门
		function del(){
			if(!empty($_GET['id'])){
				$id=D("crm_department")->delete($_GET["id"]);
				if(!empty($id)){
					$this->success("删除成功", 1, "dwgl"); 
				}else{
					$this->error("删除失败", 1, "dwgl"); 
				}
			}
			//---------------------------------------------
			if(!empty($_POST)){
				$id=D("crm_department")->delete($_POST["selectid"]);
				if(!empty($id)){
					$this->success("删除成功", 1, "dwgl"); 
				}else{
					$this->error("删除失败", 1, "dwgl"); 
				}
			}else{
				$this->error("请选择要删除的内容", 1, "dwgl"); 
			}
		}
		/*用户权限---------------------------------------------------------*/
		function yhqx(){
			$this->display();
		}
		//------------------------
		function cd($a){
				$this->display();
				print "<SCRIPT type='text/javascript'>";
				print "
					var setting = {
						data: {
							simpleData: {
								enable: true
							}
						}
					};
				";
				print "var zNodes =[";

				$this->selid(0);

				print "];
				
					function onClick(e,treeId, treeNode) {
						var zTree = $.fn.zTree.getZTreeObj('treeDemo');
						zTree.expandNode(treeNode);
					}

					$(document).ready(function(){
						$.fn.zTree.init($('#treeDemo'), setting, zNodes);
					});
				";

				print "</SCRIPT>";
				$GLOBALS["debug"]=0;
		}
		
		function selid($id){
			if($_SESSION['priv']=='3'){
				
				$data=D("crm_department")->where(array("dept_id"=>$_SESSION['dept']))->order("concat(path,dept_id)")->select();
				foreach ($data as $i=>$v){
					$pid=$v['dept_id'];
					$DEPT_ID = $v['dept_id'];
					$DEPT_NAME = $v['dept_name'];
					$DEPT_PARENT = $v['dept_parent_id'];
					$open="false";
					if($DEPT_PARENT==0 || $DEPT_PARENT==1){
						$open="true";
						$url=",url:'".$GLOBALS["url"]."nr/',target:'edu_main'";
						if($DEPT_PARENT==1){
							$url=",url:'".$GLOBALS["url"]."nr/dept_id/".$v['dept_id']."',target:'edu_main'";
						}
					}else{
						$url=",url:'".$GLOBALS["url"]."nr/dept_id/".$v['dept_id']."',target:'edu_main'";
					}
					print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',open:'$open' $url},
					";
				}
				
			}else{
			
				$data=D("crm_department")->where(array("dept_parent_id"=>$id))->order("concat(path,dept_id)")->select();
			
				foreach ($data as $i=>$v){
					$pid=$v['dept_id'];
					$DEPT_ID = $v['dept_id'];
					$DEPT_NAME = $v['dept_name'];
					$DEPT_PARENT = $v['dept_parent_id'];
					$open="false";
					if($DEPT_PARENT==0 || $DEPT_PARENT==1){
						$open="true";
						$url=",url:'".$GLOBALS["url"]."nr/',target:'edu_main'";
						if($DEPT_PARENT==1){
							$url=",url:'".$GLOBALS["url"]."nr/dept_id/".$v['dept_id']."',target:'edu_main'";
						}
					}else{
						$url=",url:'".$GLOBALS["url"]."nr/dept_id/".$v['dept_id']."',target:'edu_main'";
					}
					print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',open:'$open' $url},
					";

					$this->selid($pid);
				}
			}
		}
 
/*****************************-用户管理--********************************************/
		//用户管理
		function nr(){
			//------------------------------
			$bm=D("crm_department")->field("dept_id,dept_name")->select();
			$this->assign("bm",$bm);
			
			$qx=D("crm_priv")->select();
			$this->assign("qx",$qx);
			//------------------------------
			if(!empty($_GET['user_priv'])){
				if($_SESSION['priv']=='3'){
					$page=new Page(D("crm_user")->where(array("dept"=>$_SESSION['dept']))->total(), 20, "dept_id/".$_GET['dept_id']);
					$data=D("crm_user")->where(array("dept"=>$_SESSION['dept']))->limit($page->limit)->select();
				}else{
					$page=new Page(D("crm_user")->where(array("priv"=>$_GET['user_priv']))->total(), 20, "user_priv/".$_GET['user_priv']);
					$data=D("crm_user")->where(array("priv"=>$_GET['user_priv']))->limit($page->limit)->select();
				}
			}elseif(!empty($_GET['dept_id'])){
				if($_SESSION['priv']=='3'){
					$page=new Page(D("crm_user")->where(array("dept"=>$_SESSION['dept']))->total(), 20, "dept_id/".$_GET['dept_id']);
					$data=D("crm_user")->where(array("dept"=>$_SESSION['dept']))->limit($page->limit)->select();
				}else{
					$page=new Page(D("crm_user")->where(array("dept"=>$_GET['dept_id']))->total(), 20, "dept_id/".$_GET['dept_id']);
					$data=D("crm_user")->where(array("dept"=>$_GET['dept_id']))->limit($page->limit)->select();
				}	
			}elseif(!empty($_POST)){
				if($_SESSION['priv']=='3'){
					$page=new Page(D("crm_user")->where(array("dept"=>$_SESSION['dept'],$_POST['searchfield']=>$_POST['searchvalue']))->total(), 20);
					$data=D("crm_user")->where(array("dept"=>$_SESSION['dept'],$_POST['searchfield']=>$_POST['searchvalue']))->limit($page->limit)->select();
				}else{
					$page=new Page(D("crm_user")->where(array($_POST['searchfield']=>$_POST['searchvalue']))->total(), 20);
					$data=D("crm_user")->where(array($_POST['searchfield']=>$_POST['searchvalue']))->limit($page->limit)->select();
				}
			}else{
				if($_SESSION['priv']=='3'){
					$page=new Page(D("crm_user")->where(array("dept"=>$_SESSION['dept']))->total(), 100);
					$data=D("crm_user")->where(array("dept"=>$_SESSION['dept']))->limit($page->limit)->select();
				}else{
					$page=new Page(D("crm_user")->total(), 100);
					$data=D("crm_user")->limit($page->limit)->select();
				}
			}
			//---------------------------------
			foreach ($data as $i => $v) {
				//遍历出......
				foreach ($bm as $a => $b) {
					if($v['dept']==$b['dept_id']){
						$data[$i]['depts']=$b['dept_name'];
					}
				}
				foreach ($qx as $x => $y) {
					if($v['priv']==$y['priv']){
						$data[$i]['privs']=$y['priv_name'];
					}
				}
				//-----------------------------------------
			}
			$this->assign("data",$data);
			$this->assign("fpage", $page->fpage());
			$this->display();
		}
		//添加用户界面
		function add_user(){
			if($_SESSION['priv']==3){
				$bm=D("crm_department")->where(array('dept_id'=>$_SESSION['dept']))->select();
				
			}else{
				$bm=D("crm_department")->field("dept_id,dept_name,path")->order("concat(path,dept_id)")->select();
				foreach ($bm as $k => $v) {
					$m=substr_count($v['path'],",")-1;
					$strpad = str_pad("",$m*6*4,"&nbsp;");
					$bm[$k]['kg']=$strpad;
				}
			}
			
			$this->assign("bm",$bm);
			
			if($_SESSION['priv']==3){
				$qx=D("crm_priv")->where(array('priv'=>4))->select();
			}else{
				$qx=D("crm_priv")->select();
			}
			
			$this->assign("qx",$qx);
			//--------------------------
			$this->display();
			$GLOBALS["debug"]=0; 
		}
		//添加用户代码
		function ad_user(){
			if(!empty($_POST)){
				if($_POST['user']=="" || $_POST['name']==""){
					$this->error("请输入必填项！", 1, "add_user"); 
				}
				$_POST['pass']=MD5(USERPASS.$_POST["pass"]);
				
				$id=D("crm_user")->insert();
				if(!empty($id)){
					if($_SESSION['priv']==4){
						$this->success("添加成功", 1, "user/zu"); 
					}else{
						$this->success("添加成功", 1, "nr"); 
					}
				}else{
					if($_SESSION['priv']==4){
						$this->error("添加失败", 1,  "user/zu"); 
					}else{
						$this->error("添加失败", 1, "nr"); 
					}
				}
			}
		}
		//修改用户界面
		function mod_user(){
			//-----------------------
			$zw=D("crm_priv")->select();
			$this->assign("zw",$zw);
			//------------------------
			$bm=D("crm_department")->field("dept_id,dept_name,path")->order("concat(path,dept_id)")->select();
			foreach ($bm as $k => $v){
				$m=substr_count($v['path'],",")-1;
				$strpad = str_pad("",$m*6*4,"&nbsp;");
				$bm[$k]['kg']=$strpad;
			}
			$this->assign("bm",$bm);
			//--------------------------
			if(!empty($_GET['id'])){
				$data=D("crm_user")->where(array("id"=>$_GET['id']))->select();
				foreach ($data as $i => $v) {
					//遍历出......
					foreach ($bm as $a => $b) {
						if($v['dept']==$b['dept_id']){
							$data[$i]['dept']=$b['dept_name'];
						}
					}
					foreach ($zw as $x => $y) {
						if($v['priv']==$y['priv']){
							$data[$i]['priv']=$y['priv_name'];
						}
					}
				//-----------------------------------------
				}
				$this->assign("data",$data[0]);
				$this->display();
				$GLOBALS["debug"]=0; 
			}
		}
		//修改用户数据代码
		function up_user(){
			if(!empty($_POST)){
				if($_POST['user']=="" || $_POST['name']==""){
					$this->error("请不要删除必填项！", 1, "nr"); 
				}
				if($_POST['pass']!=""){
					$_POST['pass']=MD5($_POST["pass"].MY);
				}
				$id=D("crm_user")->update();
				
				if(!empty($id)){
					$this->success("修改成功", 1, "nr"); 
				}else{
					//$this->error("修改失败", 1, "nr");
				}
			}
		}
		//删除用户数据
		function del_user(){
			if(!empty($_GET['id'])){
				$id=D("crm_user")->where(array("id"=>$_GET['id']))->delete();
				if(!empty($id)){
					$this->success("删除成功", 1, "nr");
				}else{
					$this->error("删除失败", 1, "nr"); 
				}
			}
		}

	}