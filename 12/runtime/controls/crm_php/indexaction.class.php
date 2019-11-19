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
			$this->assign("user",$_SESSION);
			$priv_name=D("crm_priv")->where(array("priv"=>$_SESSION['priv']))->select();
			$this->assign("priv_name",$priv_name[0]['priv_name']);
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
			$data=D("menu_crm")->where(array("pid"=>$id))->order("concat(path,id)")->select();
			foreach ($data as $i=>$v){
				$pid=$v['id'];
				$DEPT_ID = $v['id'];
				$DEPT_NAME = $v['name'];
				$DEPT_PARENT = $v['pid'];
				$ico="icon:'".$GLOBALS['res']."ico/".$v['ico']."'";
					
				if($_SESSION['priv']=='1' && $_SESSION['user']=='admin'){
					//-------------------
						if($DEPT_PARENT==0){
							$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
							$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
						}else{
							$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
							if($DEPT_ID==62){
								$url='';
							}
						}
						print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
						";
						$this->selid($pid);
					//--------------------
				//经理菜单
				}elseif($_SESSION['priv']=='2'){
					//--------------------
						if($DEPT_ID!=4 && $DEPT_ID!=5 && $DEPT_ID!=69){
							if($DEPT_PARENT==0){
								$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
								$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
							}else{
								$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
								if($DEPT_ID==62){
									$url='';
								}
							}
							print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
							";
							$this->selid($pid);
						}
					//--------------------
				//主管菜单	
				}elseif($_SESSION['priv']=='3'){
					//--------------------------
						if($DEPT_ID!=4 && $DEPT_ID!=5 && $DEPT_ID!=70 && $DEPT_ID!=64){
							if($DEPT_PARENT==0){
								$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
								$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
							}else{
								$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
								if($DEPT_ID==62){
									$url='';
								}
							}
							print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
							";
							$this->selid($pid);
						}
					//------------------------
				//职员菜单	
				}elseif($_SESSION['priv']=='4'){
						//--------------------------
						if($DEPT_ID!=4 && $DEPT_ID!=5 && $DEPT_ID!=69 && $DEPT_ID!=70){
							if($DEPT_PARENT==0){
								$icoz=",iconClose:'".$GLOBALS['res']."ico/".$v['ico']."'";
								$ico="iconOpen:'".$GLOBALS['res']."ico/".$v['ico']."'".$icoz;
							}else{
								$url=",url:'".$GLOBALS["app"].$v['operating']."' ,target:'main'";
								if($DEPT_ID==62){
									$url='';
								}
							}
							print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',$ico $url },
							";
							$this->selid($pid);
						}
						//------------------------
				}
			}
			//销毁变量
			unset($data,$pid,$DEPT_ID,$DEPT_NAME,$DEPT_PARENT,$ico,$url);
		}
		//-----------------------------------
		
		//-----------------------------------
		function xiaoxi(){
			$tx=D("crm_lianxijilu")->where(array("lsrid"=>$_SESSION["id"],"nexttime!"=>0,"lianxi"=>0))->order("nexttime asc")->select();
			
			$jttx=array();
			foreach ($tx as $i=>$v){
				if($v['nexttime'] <= time()){
					$jttx[$i]['id']=$v['id'];
					$jttx[$i]['lsrid']=$v['lsrid'];
					$jttx[$i]['lsrname']=$v['lsrname'];
					$jttx[$i]['bianhao']=$v['bianhao'];
					$jttx[$i]['name']=$v['name'];
					$jttx[$i]['sphone']=$v['sphone'];
					$jttx[$i]['nexttime']=$v['nexttime'];
					$jttx[$i]['nextneirong']=$v['nextneirong'];
					$jttx[$i]['lianxi']=$v['lianxi'];
				}
			}
			if(!empty($jttx)){
				$this->assign("jttx",$tx);
				$this->assign("xx",$jttx[0]);
				$this->display();
			}else{
				$this->assign("xx",1);
			}
			$GLOBALS["debug"]=0;
		}
		
		//把消息改为已读
		function gxtx(){
			if(!empty($_POST['id'])){
					$id=D("crm_lianxijilu")->where(array("id"=>$_POST['id'],"lianxi"=>'0'))->update("lianxi='1',lxtime='".time()."' "); 
					if(!empty($id)){
						echo "ok";
					}else{
						echo "no";
					}	
			}
			$GLOBALS["debug"]=1;
			//销毁变量
			unset($data,$id);
		}
	}
		