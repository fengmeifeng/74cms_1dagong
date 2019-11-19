<?php
	class LufeiAction extends Common {
		//待审核报销会员
		function index(){

			if(!empty($_GET['name'])){
				$page=new Page(D("lufei")->where(array("audit"=>0,"text"=>"","xingming"=>'%'.$_GET['name'].'%'))->total(), 20);
				$data=D("lufei")->where(array("audit"=>0,"text"=>"","xingming"=>'%'.$_GET['name'].'%'))->limit($page->limit)->select();
			}else{
				$page=new Page(D("lufei")->where(array("audit"=>0,"text"=>""))->total(), 20);
				$data=D("lufei")->where(array("audit"=>0,"text"=>""))->limit($page->limit)->select();
			}
			$this->assign("data",$data);
			$this->assign("fpage", $page->fpage());
			$this->display();
		}
		//---------------
		function wxiao(){
			if(!empty($_GET['id'])){
				$id=D("lufei")->where(array("id"=>$_GET['id']))->update("lz=0,text='无效'");
				if(!empty($id)){
					$this->success("设置无效用户成功", 1, "index");
				}else{
					$this->error("设置无效用户失败", 1, "index");
				}
			}
		}
		//审核数据是否正确
		function sh(){
			if(!empty($_POST)){
				
				if($_POST['sh']==1){
					$id=D("lufei")->where(array("id"=>$_POST['id']))->update("audit=1,shenheren='".$_SESSION['user']."'");
				}
				if($_POST['sh']==0){
					$id=D("lufei")->where(array("id"=>$_POST['id']))->update("audit=0,shenheren='".$_SESSION['user']."',text='审核失败！ </br>".$_POST['nr1'].$_POST['nr2'].$_POST['nr3'].$_POST['nr4'].$_POST['nr5'].$_POST['nr6']."'");
				}
				if(!empty($id)){
					$this->success("审核路费报销成功", 1, "index");
				}else{
					$this->error("审核路费报销失败", 1, "index");
				}
			}
		}
		//审核成功未满15天
		function shcg(){
			if(!empty($_GET['name'])){
				$num="SELECT * FROM bb_lufei where DATE_SUB(CURDATE(), INTERVAL 15 DAY) < date(from_unixtime(rztime)) and audit=1 and xingming like '%".$_GET['name']."%' ";
				$num=D('lufei')->query($num,"total");
				$page=new Page($num, 20);
				$sql="SELECT * FROM bb_lufei where DATE_SUB(CURDATE(), INTERVAL 15 DAY) < date(from_unixtime(rztime)) and audit=1 and xingming like '%".$_GET['name']."%' ORDER BY `rztime` ASC LIMIT ".$page->limit;
				$data=D('lufei')->query($sql,"select");

			}else{
				$num="SELECT * FROM bb_lufei where DATE_SUB(CURDATE(), INTERVAL 15 DAY) < date(from_unixtime(rztime)) and audit=1 ";
				$num=D('lufei')->query($num,"total");
				$page=new Page($num, 20);
				$sql="SELECT * FROM bb_lufei where DATE_SUB(CURDATE(), INTERVAL 15 DAY) < date(from_unixtime(rztime)) and audit=1 ORDER BY `rztime` ASC LIMIT ".$page->limit;
				$data=D('lufei')->query($sql,"select");
			}

			foreach ($data as $k => $v){
				$date1= date('Y-m-d H:i:s',$v['rztime']);
				$date2= date('Y-m-d H:i:s', time()); 
				$days=(int)abs((strtotime($date1)-strtotime($date2))/86400);
				$data[$k]['rzt']=$days."天";
			}
			$this->assign("data",$data);
			$this->assign("fpage", $page->fpage());
			$this->display();

		}
		//是否在职
		function ylz(){
			if(!empty($_GET['id']) && !empty($_GET['zaizi'])){

				if($_GET['zaizi']==1){
					$id=D("lufei")->where(array("id"=>$_GET['id']))->update("lz=0");
				}
				if($_GET['zaizi']==2){
					$id=D("lufei")->where(array("id"=>$_GET['id']))->update("lz=1");
				}
				if(!empty($id)){
					$this->success("修改是否在职状态成功", 1, "shcg");
				}else{
					$this->error("修改是否在职状态失败", 1, "shcg");
				}
			}
		}
		//审核成功满15天
		function bxff(){
			if(!empty($_GET['name'])){
				$num="SELECT * FROM bb_lufei where DATE_SUB(CURDATE(), INTERVAL 15 DAY) >= date(from_unixtime(rztime)) and audit=1 and dff=0 and xingming like '%".$_GET['name']."%' ORDER BY `rztime` ASC ";
				$num=D('lufei')->query($num,"total");
				$page=new Page($num, 20);
				$sql="SELECT * FROM bb_lufei where DATE_SUB(CURDATE(), INTERVAL 15 DAY) >= date(from_unixtime(rztime)) and audit=1 and dff=0 and xingming like '%".$_GET['name']."%' ORDER BY `rztime` ASC LIMIT ".$page->limit;
				$data=D('lufei')->query($sql,"select");
			}else{
				$num="SELECT * FROM bb_lufei where DATE_SUB(CURDATE(), INTERVAL 15 DAY) >= date(from_unixtime(rztime)) and audit=1 and dff=0 ORDER BY `rztime` ASC ";
				$num=D('lufei')->query($num,"total");
				$page=new Page($num, 20);
				$sql="SELECT * FROM bb_lufei where DATE_SUB(CURDATE(), INTERVAL 15 DAY) >= date(from_unixtime(rztime)) and audit=1 and dff=0 ORDER BY `rztime` ASC LIMIT ".$page->limit;
				$data=D('lufei')->query($sql,"select");
			}
			foreach ($data as $k => $v){
				$date1= date('Y-m-d H:i:s',$v['rztime']);
				$date2= date('Y-m-d H:i:s', time()); 
				$days=(int)abs((strtotime($date1)-strtotime($date2))/86400);
				$data[$k]['rzt']=$days."天";
			}

			$this->assign("data",$data);
			$this->assign("fpage", $page->fpage());
			$this->display();
		}
		
		//是否合格路费申请
		function sf(){
				
			if(!empty($_POST)){
				if($_POST['sh']==1){
					$id=D("lufei")->where(array("id"=>$_POST['id']))->update("dff=1");
				}
				if($_POST['sh']==0){
					$id=D("lufei")->where(array("id"=>$_POST['id']))->update("dff=0,text='已经离职' ");
				}
				if(!empty($id)){
					$this->success("以合格路费报销", 1, "bxff");
				}else{
					$this->error("以失败路费报销", 1, "bxff");
				}
			}
			
		}
		//待报销路费会员
		function dbxlf(){
			if(!empty($_GET['name'])){
				$page=new Page(D('lufei')->where(array("audit"=>1,"dff"=>1,"xingming"=>"%".$_GET['name']."%"))->total(), 20);
				$data=D('lufei')->where(array("audit"=>1,"dff"=>1,"xingming"=>"%".$_GET['name']."%"))->order("`dff` ASC")->limit($page->limit)->select();
			}else{
				$page=new Page(D('lufei')->where(array("audit"=>1,"dff"=>1))->total(), 20);
				$data=D('lufei')->where(array("audit"=>1,"dff"=>1))->order("`dff` ASC")->limit($page->limit)->select();
			}
			foreach ($data as $k => $v){
				$date1= date('Y-m-d H:i:s',$v['rztime']);
				$date2= date('Y-m-d H:i:s', time()); 
				$days=(int)abs((strtotime($date1)-strtotime($date2))/86400);
				$data[$k]['rzt']=$days."天";
			}
			$this->assign("data",$data);
			$this->assign("fpage", $page->fpage());
			$this->display();
		}
		//是否发放成功路费
		function faf(){
			if($_SESSION['quanxian']!=3){
				if(!empty($_GET['id'])){
					$data=D("lufei")->where(array("id"=>$_GET['id']))->select();
					$this->assign("data",$data['0']);
					$this->display(lufeiadd);
				}
			}else{
				$this->error("没有权限！", 1, "index");
			}
		}
		//-----------------------
		function fafang(){
			if($_SESSION['quanxian']!=3){
				if(!empty($_POST)){
					$updata=array("grants"=>'1',"jine"=>$_POST['jine'],"fafangren"=>$_SESSION['user']);
					$id=D("lufei")->where(array("id"=>$_POST['id']))->update($updata);
					if(!empty($id)){
						$this->success("报销路费成功", 1, "dbxlf");
					}else{
						$this->error("报销路费失败!", 1, "dbxlf");
					}
				}
			}else{
				$this->error("没有权限！", 1, "index");
			}
		}
		//路费报销成功
		function cg(){
			if(!empty($_GET['name'])){
				$page=new Page(D('lufei')->where(array("audit"=>1,"dff"=>1,"grants"=>1,"xingming"=>"%".$_GET['name']."%"))->total(), 20);
				$data=D('lufei')->where(array("audit"=>1,"dff"=>1,"grants"=>1,"xingming"=>"%".$_GET['name']."%"))->limit($page->limit)->select();
			}else{
				$page=new Page(D('lufei')->where(array("audit"=>1,"dff"=>1,"grants"=>1))->total(), 20);
				$data=D('lufei')->where(array("audit"=>1,"dff"=>1,"grants"=>1))->limit($page->limit)->select();
			}
			foreach ($data as $k => $v){
				$date1= date('Y-m-d H:i:s',$v['rztime']);
				$date2= date('Y-m-d H:i:s', time()); 
				$days=(int)abs((strtotime($date1)-strtotime($date2))/86400);
				$data[$k]['rzt']=$days."天";
			}
			$this->assign("data",$data);
			$this->assign("fpage", $page->fpage());
			$this->display();
		}
		
}
	