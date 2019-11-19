<?php
class Index {
		function index(){
			$GLOBALS["debug"]=0;
			$this->display();
		}
		function fsa(){
			$a=new duanxin();
			$a=$a->fs();
			echo $a;
		}
		//主窗口
		function main(){
			//p($_SESSION);
			$this->display();
		}
		//头部
		function top(){
			$GLOBALS["debug"]=0;
			$this->display();
		}
		//head
		function head(){
			$GLOBALS["debug"]=0;
			$this->assign("user",$_SESSION);
			$this->display();
		}
		//菜单
		function menu(){
			$GLOBALS["debug"]=0;
			$this->display();
		}
		function leftmenu(){
			$GLOBALS["debug"]=0;
			$this->display();
		}
		function rightmenu(){
			$GLOBALS["debug"]=0;
			$this->display();
		}
		function nenu_t(){
			$GLOBALS["debug"]=0;
			$this->display();
		}
		function nenu_d(){
			$GLOBALS["debug"]=0;
			$this->display();
		}
		function menu_z(){
			$this->display();
				print "<SCRIPT type='text/javascript'>";
				print "
					var setting = {
						data: {
							simpleData: {
								enable: true
							}
						},
						callback: {
							onClick: onClick
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
				$GLOBALS["debug"]=1;
		}
		//隐藏菜单
		function qiehuan(){
			$GLOBALS["debug"]=0;
			$this->display();
		}
		//菜单生成
		function selid($id){
			$data=D("menu")->where(array("pid"=>$id))->order("concat(path,id)")->order("id asc")->select();

			foreach ($data as $i=>$v){
				$pid=$v['id'];
				$DEPT_ID = $v['id'];
				$DEPT_NAME = $v['name'];
				$DEPT_PARENT = $v['pid'];
				$ico="icon:'".$GLOBALS['res']."ico/".$v['ico']."'";
				//管理员------------------------------------------------------------
				if($_SESSION['quanxian']==2){
					if($DEPT_ID!=1){
						if($DEPT_PARENT==0){
							$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
							$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
						}else{
							$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
							if($DEPT_ID==6){
								$url='';
							}
						}
						print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
						";
						$this->selid($pid);
					}
				//路费报销--------------------------------------------------------------
				}elseif($_SESSION['quanxian']==3 || $_SESSION['quanxian']==4){
					if($DEPT_ID!=1){
						if($DEPT_PARENT==0){
							$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
							$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
						}else{
							$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
							if($DEPT_ID==6){
								$url='';
							}
						}
						print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
						";
						$this->selid($pid);
					}
				//地区管理---------------------------------------------------------------
				}else{
					if($DEPT_PARENT==0){
						$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
						$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
					}else{
						$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
					}
					print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
					";
					$this->selid($pid);
				}
			}
		}
	}
		