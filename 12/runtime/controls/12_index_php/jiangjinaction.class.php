<?php
	class jiangjinAction extends Common {
		//提现成功的记录----------------------------
		function index(){
		
		}

		function fafang(){
			
			$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
			
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql="path like '%,".$user['id'].",%' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql="path like '%,".$user['id'].",%' ";
					}
					break;
				case 1:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql="";
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			
			//---时间段搜索-----and------------------------------------------------------------------------------------------------------------------------------------------------
			if($_GET['q_time']!='' && $_GET['h_time']!=''){
				if($where_sql!=''){ $s=' and'; }else{ $s=''; }
				$where_sql.=$s." to_days(FROM_UNIXTIME(UNIX_TIMESTAMP(addtime),'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
			}
			//-------end----------------------------------
			
			$page=new page(D("recordmoney")->where($where_sql)->total(),18);
			$data=D("recordmoney")->where($where_sql)->limit($page->limit)->order("addtime desc")->select();
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->display();
		}
	
		
	}