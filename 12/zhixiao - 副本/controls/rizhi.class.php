<?php
	class rizhi {
		//日志----------------------------
		function index(){
		
			if(!empty($_GET['search']) && $_GET['findvalue']!=''){
				$where_sql=array($_GET['search']=>'%'.$_GET['findvalue'].'%');
			}else{
				$where_sql="";
			}
			
			$page=new page(D("caozuolog")->where($where_sql)->total(),20);
			$data=D("caozuolog")->where($where_sql)->limit($page->limit)->order("time desc")->select();
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->display();
		}
	}