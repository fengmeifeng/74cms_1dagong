<?php
class Zhanghu{
	//登录页面模版
	function index(){
		
		$this->display();
	}
	
	//我的账户图
	function wotu(){
		//数据--
		$data=D("tuijian")->where(array("jihuo"=>'1',"path"=>"%,".$_SESSION['id'].",%"))->order("id asc,concat(path,id)")->select();
		if(empty($data)){
			$this->assign("dat",'1');
		}
		//模版--
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
		foreach ($data as $i=>$v){
			$DEPT_ID = $v['id'];
			$DEPT_NAME = $v['bianhao']."[".$v['name']."]";
			$DEPT_PARENT = $v['pid'];
			$open="false";
			if($DEPT_PARENT==='0' || $DEPT_PARENT==='1'){
				$open="true";
			}
			print "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME',open:'$open' },
			";
		}
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
	}
	//我的账户表
	function wobiao(){
		$where_sql=array("jihuo"=>'1',"path"=>"%,".$_SESSION['id'].",%");
		$page=new page(D("tuijian")->where($where_sql)->total(),20);
		$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("concat(path,id)")->select();
		if($_SESSION['pid']=='1' && $_SESSION['jibie']=='1'){
			//---------------------------------
			foreach($data as $k => $v){
				$v['path']=strstr($v['path'],$_SESSION['id'].",");
				$m=substr_count($v['path'],",");
				$strpad = str_pad("",$m*6*4,"&nbsp;");
				$data[$k]['kg']=$strpad.$m."┨";			
				$data[$k]['m']=$m;
				if($m >= 1 and $m <= 3){
					$data[$k]['q']=100;
				}elseif($m >= 4 and $m <= 7){
					$data[$k]['q']=30;
				}elseif($m >= 8 and $m <= 10){
					$data[$k]['q']=25;
				}elseif($m >= 11 and $m <= 12){
					$data[$k]['q']=20;
				}else{
					$data[$k]['q']=0;
				}
			}
			
		}else{
			//---------------------------------
			foreach($data as $k => $v){
				$v['path']=strstr($v['path'],$_SESSION['id'].",");
				$m=substr_count($v['path'],",");
				$strpad = str_pad("",$m*6*4,"&nbsp;");
				$data[$k]['kg']=$strpad.$m."┨";			
				$data[$k]['m']=$m;
				if($m >= 1 and $m <= 3){
					$data[$k]['q']=100;
				}elseif($m >= 4 and $m <= 7){
					$data[$k]['q']=30;
				}elseif($m >= 8 and $m <= 10){
					$data[$k]['q']=25;
				}elseif($m >= 11 and $m <= 12){
					$data[$k]['q']=20;
				}else{
					$data[$k]['q']=0;
				}
			}
			
			//---------------------------------
		}
		$user=D("tuijian")->field("id,bianhao,name,jiangjin,tj_num")->where(array("id"=>$_SESSION['id']))->find();
		$this->assign("user",$user);
		$this->assign('fpage_weihu',$page->fpage());	//分页
		$this->assign("data",$data);
		$this->display();
			
	}
	
	//获得的奖金记录
	function jiangjinjilu(){
		$where_sql=array("hyhumber"=>$_SESSION['bianhao']);
		$page=new page(D("recordmoney")->where($where_sql)->total(),20);
		$data=D("recordmoney")->where($where_sql)->limit($page->limit)->order("addtime desc")->select();
		$this->assign("data",$data);
		$this->assign('fpage_weihu',$page->fpage());	//分页
		$this->display();
	}
	
	//推荐未激活
	function weijihuo(){
		$where_sql=array("jihuo"=>'0',"path"=>"%,".$_SESSION['id'].",%");
		$page=new page(D("tuijian")->where($where_sql)->total(),20);
		$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("add_time desc")->select();
		$jibei=D("jibie")->select();
		foreach ($data as $k => $v){
			foreach ($jibei as $i => $s){
				if($s['id']==$v['jibie']){
					$data[$k]['jibie']=$s['jibie'];
				}
			}
		}
		$this->assign('fpage_weihu',$page->fpage());	//分页
		$this->assign("data",$data);
		$this->display();
	}
	
	//删除自己推荐的用户
	function deluser(){
		if(!empty($_GET['id'])){
			$id=D('tuijian')->delete(array("id"=>$_GET['id']));  
			if($id > 0){
				$this->success("删除成功", 1, "weijihuo");        
			}else{
				$this->error("删除失败！", 1, "weijihuo");
			}
		}
	}
}