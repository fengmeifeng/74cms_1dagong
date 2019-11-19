<?php
class IndexAction extends Common {
		function index(){
			$GLOBALS["debug"]=0;
			$this->display();
		}
		//主窗口
		function main(){
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
			$dq=D('adminuser')->field('name')->where(array("user"=>$_SESSION['user']))->find();
			$this->assign("dq",$dq['name']);
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
				$GLOBALS["debug"]=0;
		}
		//隐藏菜单
		function qiehuan(){
			$GLOBALS["debug"]=0;
			$this->display();
		}
		//菜单生成
		function selid($id){
			$data=D("menu_ht")->where(array("pid"=>$id))->order("concat(path,id)")->select();
			foreach ($data as $i=>$v){
				$pid=$v['id'];
				$DEPT_ID = $v['id'];
				$DEPT_NAME = $v['name'];
				$DEPT_PARENT = $v['pid'];
				$ico="icon:'".$GLOBALS['res']."ico/".$v['ico']."'";
				if($_SESSION['priv']=='1' && $_SESSION['user']=='admin'){
					//----------------------------------------
					if($DEPT_PARENT==0){
						$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
						$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
					}else{
						$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
						if($DEPT_ID==42){
							$url='';
						}
					}
					print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
					";
					$this->selid($pid);
					//--------------------------------------------	
				}elseif($_SESSION['priv']=='1' && $_SESSION['user']!='admin'){
					//----------------------------------------
					if($DEPT_ID!='2'){
						if($DEPT_PARENT==0){
							$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
							$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
						}else{
							$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
							if($DEPT_ID==42){
								$url='';
							}
						}
						print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
						";
						$this->selid($pid);
					}
					//--------------------------------------------
				//报单员菜单
				}elseif($_SESSION['priv']=='3'){
					if($_SESSION['user']=='000001'){	//合肥呼叫......
					//--------------------------------------------
						if($DEPT_ID!='2' && $DEPT_ID!='23' && $DEPT_ID!='24' && $DEPT_ID!='26' && $DEPT_ID!='27' && $DEPT_ID!='39' && $DEPT_ID!='28' && $DEPT_ID!='43' && $DEPT_ID!='44' && $DEPT_ID!='46' && $DEPT_ID!='48'){
							if($DEPT_PARENT==0){
								$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
								$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
							}else{
								$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
								if($DEPT_ID==42){
									$url='';
								}
							}
							print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
							";
							$this->selid($pid);
						}
					
					//--------------------------------------------
					}else{			//其他
					//----------------------------------------
						if($DEPT_ID!='2' && $DEPT_ID!='23' && $DEPT_ID!='24' && $DEPT_ID!='26' && $DEPT_ID!='27' && $DEPT_ID!='39' && $DEPT_ID!='28' && $DEPT_ID!='43' && $DEPT_ID!='44' && $DEPT_ID!='46' && $DEPT_ID!='48'){
							if($DEPT_PARENT==0){
								$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
								$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
							}else{
								$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
								if($DEPT_ID==42){
									$url='';
								}
							}
							print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
							";
							$this->selid($pid);
						}
					//--------------------------------------------
					}
					
				//审核员菜单
				}elseif($_SESSION['priv']=='4'){
					//----------------------------------------
					if($_SESSION['user']=='000001'){	//合肥呼叫......
						if($DEPT_ID!='2' && $DEPT_ID!='36' && $DEPT_ID!='37'){
							if($DEPT_PARENT==0){
								$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
								$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
							}else{
								$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
								if($DEPT_ID==42){
									$url='';
								}
							}
							print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
							";
							$this->selid($pid);
						}
					}else{				//其他
						if($DEPT_ID!='2' && $DEPT_ID!='36' && $DEPT_ID!='37'){
							if($DEPT_PARENT==0){
								$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
								$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
							}else{
								$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
								if($DEPT_ID==42){
									$url='';
								}
							}
							print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
							";
							$this->selid($pid);
						}
					}
					//--------------------------------------------
				//财务菜单
				}elseif($_SESSION['priv']=='5'){
					//----------------------------------------
					if($DEPT_ID!='2' && $DEPT_ID!='23'&& $DEPT_ID!='24'&& $DEPT_ID!='25'&& $DEPT_ID!='26'&& $DEPT_ID!='38'&& $DEPT_ID!='39'&& $DEPT_ID!='41'&& $DEPT_ID!='42'&& $DEPT_ID!='29' && $DEPT_ID!='33' && $DEPT_ID!='36' && $DEPT_ID!='47'&&  $DEPT_ID!='48'){
						if($DEPT_PARENT==0){
							$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
							$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
						}else{
							$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
							if($DEPT_ID==42){
								$url='';
							}
						}
						print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
						";
						$this->selid($pid);
					}
					//--------------------------------------------
				}
			}
			//销毁变量
			unset($data,$pid,$DEPT_ID,$DEPT_NAME,$DEPT_PARENT,$ico,$url);
		}
		//-----------------------------------
	}
		