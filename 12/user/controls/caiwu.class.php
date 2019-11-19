<?php
class Caiwu{
	//登录页面模版
	function index(){
		
		$this->display();
	}
	
	//申请提现--
	function sqtx(){
		$data=D("tuijian")->where(array("id"=>$_SESSION['id']))->find(); 
		$this->assign("info",$data);
			$this->display();
		//报单中心---
		if($data['pid']<=1){
			$this->error('你不可以提现！ ', 2, "user/info");
		}
		//----------------------
		if($data['jihuo']!='1'){
			$this->error('未激活不可以提现！ ', 2, "user/info");
		}
		
		if($data['pasword2']!='' && $data['bank']!='' && $data['subbranch']!='' && $data['bank_account']!=''){
			$this->assign("info",$data);
			$this->display();
		}else{
			$this->error('你的提现密码未设置! <br/><br/>或提现银行帐号信息未填写！', 5, "user/info");
		}
	}
	
	//提现
	function tixian(){
		if(!empty($_POST)){
			if($_POST['txmoney']==''){
				$this->error('提现金额不能为空！', 1, "sqtx");
			}
			$user=D("tuijian")->field("pasword2,jiangjin")->where(array("bianhao"=>$_POST['userbianhao']))->find();
			if($user['pasword2']!=MD5(USERPASS.$_POST['tixianpass'])){
				$this->error('提现密码错误！', 3, "sqtx");
				exit();
			}else{
			
				if($user['jiangjin'] < 0){
					$this->error('提现申请失败！', 1 , "txjl");
					exit("提现申请失败！");
				}
				
				if($user['jiangjin'] < $_POST['txmoney']){
					$this->error('超出提现奖金！', 3, "sqtx");
					exit();
				}
				
				if(intval($_POST['txmoney']) >= 100){
					$_POST['add_time']=time();
					$_POST['tjmoney']=$user['jiangjin'];
					$_POST['cyjiangjin']=intval($user['jiangjin'])-intval($_POST['txmoney']);
					$id=D("tixian")->insert();
					if($id > 0){
						/*------奖金提现的日志--and------*/
						$data=D("tixian")->where(array("userbianhao"=>$_POST['userbianhao']))->find();
						$recordmoney=array(
							"hyhumber"=>$data['userbianhao'],
							"hyname"=>$data['username'],
							"money"=>-intval($_POST['txmoney']),
							"leftmoney"=>intval($_POST['cyjiangjin']),
							"caozuo"=>"减少",
							"newbianhao"=>'',
							"beizhu"=>"提现".intval($_POST['txmoney'])."元奖金",
							"pid"=>'',
							"path"=>'',
							"addtime"=>date("Y-m-d H:i:s",time())
						);
						$inrecordmoney=D("recordmoney")->insert($recordmoney);
						/*------奖金提现的日志--end------*/
						/*-----提现扣除奖金代码------------*/
						D("tuijian")->where(array("bianhao"=>$_POST['userbianhao'],"id"=>$_POST['tids']))->update("jiangjin=jiangjin-".intval($_POST['txmoney']));
						/*-----提现扣除奖金代码------------*/
						$this->success('提现申请成功！', 1 , "txjl");
					}else{
						$this->error('提现申请失败！', 1 , "txjl");
					}
					
				}else{
					$this->error('提现金额标准最低100元！', 3 ,"sqtx");
				}
			}
		}
	}
	
	//提现记录--
	function txjl(){
		$page=new page(D("tixian")->where(array("userbianhao"=>$_SESSION['bianhao']))->total(),20);
		$data=D("tixian")->where(array("userbianhao"=>$_SESSION['bianhao']))->order("add_time desc")->limit($page->limit)->select();
		$this->assign("data",$data);
		$this->assign('fpage_weihu',$page->fpage());	//分页
		$this->display();
	}
	
}