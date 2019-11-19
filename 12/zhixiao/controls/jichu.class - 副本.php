<?php
	class jichu {
		//----------------------------
		function index(){
			
		}
		
		//地区管理--
		function diqu(){
			$data=D("region")->select();
			$this->assign("data",$data);
			$this->display();
		}
		
		//新建地区
		function add_region(){
			$this->display();
		}
		//新建地区
		function add_qidu(){
			if(!empty($_POST)){
				$id=D("region")->insert();
				if($id > 0){
					$this->success("添加成功", 1, "diqu");        
				}else{
					$this->error("添加失败！", 1, "diqu");
				}
			}
		}
		//修改地区
		function mod_region(){
			if(!empty($_GET['id'])){
				$data=D("region")->where(array("id"=>$_GET['id']))->select();
				$this->assign("data",$data[0]);
				$this->display();
			}
		}
		//修改地区
		function mod_qidu(){
			if(!empty($_POST)){
				$id=D("region")->where(array($_POST['id']))->update();
				if($id > 0){
					$this->success("修改成功", 1, "diqu");        
				}else{
					$this->error("修改失败！", 1, "diqu");
				}
			}
		}
		//删除地区
		function del_region(){
			if(!empty($_GET['id'])){
			
				$id=D("region")->delete($_GET['id']);  
				if($id > 0){
					$this->success("删除成功", 1, "diqu");        
				}else{
					$this->error("删除失败！", 1, "diqu");
				}
			}
		}
		
		/*------------------------------------------*/
		//报单用户
		function baodan(){
			$data=D("tuijian")->where(array("pid"=>"1"))->select();
			$jibei=D("jibie")->select();
			foreach ($data as $k => $v){
				foreach ($jibei as $i => $s){
					if($s['id']==$v['jibie']){
						$data[$k]['jibie']=$s['jibie'];
					}
				}
			}
			$this->assign("data",$data);
			$this->display();
		}
		
		//----------------
		function adduser(){
			$bianhao="b".rand(100000,999999);
			//使用死循环防止纯在重复的随机数
			$i=1;
			while($i){
				$data=D("tuijian")->where(array("bianhao"=>$bianhao))->select();
				if(!empty($data)){
					$bianhao="b".rand(100000,999999);
					$i=1;
				}else{
					break;
				}
			}
			$this->assign('bianhao',$bianhao);
			$this->assign("region",D("region")->select());
			$this->display();
		}
		
		function useradd(){
			if(!empty($_POST)){
				if($_POST['pass1']!=$_POST['pass2']){
					$this->error('二次密码输入不正确！', 1);
				}
				$_POST['user']=$_POST['bianhao'];
				$_POST['pass']=MD5(USERPASS.$_POST['pass1']);
				$id=D("adminuser")->insert();
				if($id){
					$_POST['pasword']=MD5(USERPASS.$_POST['pass1']);
					$_POST['add_time']=time();
					$_POST['f_bianghao']="1dagong";
					$_POST['jihuo']="0";
					$_POST['jihuo_time']="0";
					$_POST['pid']="1";
					$_POST['jibie']="1";
					$_POST['status']="0";
					$_POST['path']="0,1,";
					$id=D("tuijian")->insert();
					if($id > 0){
						$this->success("添加成功", 1, "baodan");        
					}else{
						$this->error("添加失败！", 1, "baodan");
					}
				}
			}
		}
		//修改--
		function moduser(){
			if(!empty($_GET['id'])){
				$data=D("tuijian")->field("bianhao,name")->where(array("id"=>$_GET['id']))->find();
				$this->assign('data',$data);
				$this->display();
			}
		}
		//修改代码--
		function usermod(){
			if(!empty($_POST)){
				if($_POST['pass1']!=$_POST['pass2']){
					$this->error('二次密码输入不正确！', 1);
				}
				if($_POST['pass1']!=''){
					$_POST['pasword']=MD5(USERPASS.$_POST['pass1']);
					$_POST['pass']=MD5(USERPASS.$_POST['pass1']);
				}
				$a=D("tuijian")->where(array("bianhao"=>$_POST['bianhao']))->update();
				$id=D("adminuser")->where(array("user"=>$_POST['bianhao']))->update();
				if($id > 0){
					$this->success("修改成功", 1, "baodan");        
				}else{
					$this->error("修改失败！", 1, "baodan");
				}
			}
		}
		//删除--
		function deluser(){
			if(!empty($_GET['id'])){
				
				$id=D("tuijian")->field("bianhao")->where(array("id"=>$_GET['id']))->find();
				$a=D('adminuser')->delete(array("user"=>$id['bianhao']));  
				if($a){
					$id=D('tuijian')->delete(array("id"=>$_GET['id']));  
					if($id > 0){
						$this->success("删除成功", 1, "baodan");        
					}else{
						$this->error("删除失败！", 1, "baodan");
					}
				}
				
			}
		}
		
		//激活报单中心会员
		function jihuo(){
			if(!empty($_GET['id'])){
		
				$user=D("tuijian")->field("id,bianhao,name,sphone,jihuo,f_bianghao,pid,path")->where(array("id"=>$_GET['id']))->find();
				if($user['jihuo']!='1'){						//如果激活过了就不执行激活
					$path=explode(",",$user['path']);
					$jzmax=array_search(max($path), $path);
					foreach ($path as $k => $v){
						if($v!='' && strval($v)!='0'){
							$pth=strstr($user['path'],$v.",");	//获取当前路径
							$m=substr_count($pth,",");
							if($m < 13){
								if($m >= 1 and $m <= 3){			//1,2,3	  下线每人给100元
									$q = 100;
								}elseif($m >= 4 and $m <= 7){		//4,5,6,7 下线每人给30元
									$q = 30;
								}elseif($m >= 8 and $m <= 10){		//8,9,10  下线每人给25元
									$q = 25;
								}elseif($m >= 11 and $m <= 12){		//11,12   下线每人该20元
									$q = 20;
								}else{								//超过12层   就不给钱
									$q = 0;
								}
								//---奖金增加的日志--and------------------------
								$urdat=D("tuijian")->field("id,bianhao,name,sphone,jiangjin,f_bianghao,pid,path")->where(array("id"=>$v))->find();
								$recordmoney=array("hyhumber"=>$urdat['bianhao'],"hyname"=>$urdat['name'],"money"=>$q,"leftmoney"=>$urdat['jiangjin']+$q,"caozuo"=>"增加","newbianhao"=>$user['bianhao'],"beizhu"=>"激活".$user['bianhao']."结算奖金","pid"=>$user['pid'],"path"=>$user['path'],"addtime"=>date("Y-m-d H:i:s",time()));	
								$inrecordmoney=D("recordmoney")->insert($recordmoney);
								//---奖金增加的日志--end------------------------
								$upa=D("tuijian")->where(array("id"=>$v))->update("jiangjin=jiangjin+".$q);
								if(intval($v)===intval($path[$jzmax])){
									$upb=D("tuijian")->where(array("id"=>$v))->update("tj_num=tj_num+1");
									break;
								}
							}
						}
					}
				}
				
				$id=D("tuijian")->where(array("id"=>$_GET['id']))->update(array("jihuo"=>'1',"jihuo_time"=>time(),"status"=>'3'));
				if($id > 0){
					$this->success("激活成功！", 1);
				}else{
					$this->error("激活失败！", 1);
				}
			}
		}
		
		/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
		//查看管理人员
		function guanli(){
			if(!empty($_GET['bianhao'])){
				$data=D("adminuser")->where(array("user"=>$_GET['bianhao']))->select();	
				$this->assign("bianhao",$_GET['bianhao']);
				$this->assign("data",$data);
				$this->display();				
			}
		}
		
		//添加管理人员
		function addguanli(){
			if(!empty($_GET['bianhao'])){
				$this->assign("bianhao",$_GET['bianhao']);
				$this->display();
			}
		}
		//添加管理人员代码
		function guanliadd(){
			if(!empty($_POST)){
				if($_POST['quanxian']==''){
					$this->error("权限为选择！", 1);
				}
				if($_POST['pass1']!=$_POST['pass2']){
					$this->error('二次密码输入不正确！', 1);
				}
				
				if($_POST['quanxian']=='3'){
					$_POST['priv_name']="报单员";
				}
				if($_POST['quanxian']=='4'){
					$_POST['priv_name']="审核员";
				}
				if($_POST['quanxian']=='5'){
					$_POST['priv_name']="财务";
				}
				
				$_POST['priv']=$_POST['quanxian'];
				$_POST['user']=$_POST['bianhao'];
				$_POST['pass']=MD5(USERPASS.$_POST['pass1']);
				
				$id=D("adminuser")->insert();
				if($id > 0){
					$this->success("添加管理人员成功", 1);        
				}else{
					$this->error("添加管理人员失败！", 1);
				}
			}
		}
		
		//修改管理人员
		function modguanli(){
			if(!empty($_GET['id'])){
				$data=D("adminuser")->where(array("id"=>$_GET['id']))->find();	
				$this->assign("data",$data);
				$this->display();
			}
		}
		//管理人员代码修改
		function guanlimod(){
			if(!empty($_POST)){
				if($_POST['quanxian']==''){
					$this->error("权限为选择！", 1);
				}
				if($_POST['pass1']!=$_POST['pass2']){
					$this->error('二次密码输入不正确！', 1);
				}
				
				if($_POST['quanxian']=='3'){
					$_POST['priv_name']="报单员";
				}
				if($_POST['quanxian']=='4'){
					$_POST['priv_name']="审核员";
				}
				if($_POST['quanxian']=='5'){
					$_POST['priv_name']="财务";
				}
				
				$_POST['priv']=$_POST['quanxian'];
				
				if($_POST['pass1']!=''){
					$_POST['pass']=MD5(USERPASS.$_POST['pass1']);
				}
				
				$id=D("adminuser")->where($_POST['id'])->update();
				if($id > 0){
					$this->success("修改管理人员成功", 1, "jichu/guanli/bianhao/".$_GET['bianhao']);        
				}else{
					$this->error("修改管理人员失败！", 1, "jichu/guanli/bianhao/".$_GET['bianhao']);
				}
			}
		}
		
		//删除管理人员
		function guanlidel(){
			if(!empty($_GET['id'])){
				$id=D('adminuser')->delete(array("id"=>$_GET['id']));  
				if($id > 0){
					$this->success("删除成功", 1);        
				}else{
					$this->error("删除失败！", 1);
				}
			}
		}
		
	}