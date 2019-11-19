<?php
class dzshuju{

	function index(){
		
		if(!empty($_GET['id'])==0){
				//根据地区显示数据
				if(empty($_GET['dqid'])){
					$_GET['dqid']=1;
				}
				if(!empty($_POST['name'])){
					$sq="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_POST['dqid']."' and title LIKE '%".$_POST['name']."%' and username!='无' group by title";
					$total=D("vip_zhanhui")->query($sq,"select");
					$total=count($total);
					$page=new Page($total, 10, '/name/'.$_POST['name']);
					$sql="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_GET['dqid']."' and title LIKE '%".$_POST['name']."%' and username!='无' group by title ORDER BY add_time DESC limit ".$page->limit;
					$data=D("vip_zhanhui")->query($sql,"select");	
				}elseif(!empty($_GET['name'])){
					$_GET['name']=iconv("utf-8","gbk",trim($_GET['name']));
					$sq="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_GET['dqid']."' and title LIKE '%".$_GET['name']."%' and username!='无' group by title";
					$total=D("vip_zhanhui")->query($sq,"select");
					$total=count($total);
					$page=new Page($total, 10, '/name/'.$_GET['name']);
					$sql="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_GET['dqid']."' and title LIKE '%".$_GET['name']."%' and username!='无' group by title ORDER BY add_time DESC limit ".$page->limit;
					$data=D("vip_zhanhui")->query($sql,"select");	
				}else{
					$sq="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_GET['dqid']."' and  username!='无' group by title";
					$total=D("vip_zhanhui")->query($sq,"select");
					$total=count($total);
					$page=new Page($total, 10, '/id/0/dqid/'.$_GET['dqid']);
					$sql="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_GET['dqid']."' and username!='无' group by title ORDER BY add_time DESC limit ".$page->limit;
					$data=D("vip_zhanhui")->query($sql,"select");
				}
			$this->assign("dqid",$_GET['dqid']);
			$this->assign("fpage", $page->fpage());
			$site=D("qs_subsite")->field("s_id,s_districtname")->select();
			$this->assign("dq",$site);
			
		}else{
			//每个地区的数据
			if(!empty($_GET['id'])){
				$this->assign("dqid",$_GET['id']);
			}
			if(!empty($_POST['name'])){
				$sq="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_POST['dqid']."' and title LIKE '%".$_POST['name']."%' and username!='无' group by title";
				$total=D("vip_zhanhui")->query($sq,"select");
				$total=count($total);
				$page=new Page($total, 10, '/name/'.$_POST['name'].'/id/'.$_POST['dqid']);
				$sql="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_GET['id']."' and title LIKE '%".$_POST['name']."%' and username!='无' group by title ORDER BY add_time DESC limit ".$page->limit;
				$data=D("vip_zhanhui")->query($sql,"select");	
			}elseif(!empty($_GET['name'])){
				$_GET['name']=iconv("utf-8","gbk",trim($_GET['name']));
				$sq="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_GET['id']."' and title LIKE '%".$_GET['name']."%' and username!='无' group by title";
				$total=D("vip_zhanhui")->query($sq,"select");
				$total=count($total);
				$page=new Page($total, 10, '/name/'.$_GET['name'].'/id/'.$_GET['id']);
				$sql="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_GET['id']."' and title LIKE '%".$_GET['name']."%' and username!='无' group by title ORDER BY add_time DESC limit ".$page->limit;
				$data=D("vip_zhanhui")->query($sql,"select");	
			}else{
				$sq="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_GET['id']."' and username!='无' group by title";
				$total=D("vip_zhanhui")->query($sq,"select");
				$total=count($total);
				$page=new Page($total, 10,'/id/'.$_GET['id']);
				$sql="select *, count(distinct title) from vip_zhanhui where subsite_id='".$_GET['id']."' and username!='无' group by title ORDER BY add_time DESC limit ".$page->limit;
				$data=D("vip_zhanhui")->query($sql,"select");
			}
			$site=D("qs_subsite")->field("s_id,s_districtname")->select();
			$this->assign("fpage", $page->fpage());
		}
		foreach ($data as $i=>$v){
			$data[$i]['dq']="全站";
			foreach ($site as $k=>$s){
				if($s['s_id']==$data[$i]['subsite_id']){
					$data[$i]['dq']=$s['s_districtname'];
				}
			}
		}
		$this->assign("data",$data);
		$this->display();
	}
	//---------------------------
	function ckdz(){
		if(!empty($_GET['id'])){
			$zd="select zid from vip_zhanhui where vip_zhanhui.qid='".$_GET['id']."'";
			$com="select count(a.title) as num from vip_zhanhui as a left join qs_jobfair as b on a.zid=b.id where b.id in(".$zd.") and a.qid='".$_GET['id']."'";
			$num=D("qs_jobfair")->query($com,"select");
			$page=new Page($num[0]['num'], 20,"id/".$_GET['id']);
			$zid="select zid from vip_zhanhui where vip_zhanhui.qid=".$_GET['id'];
			$sql="select b.id,a.zid,a.qid,a.username,a.title,b.title as qytitle,a.xs_user,a.number,a.add_time,b.holddates,a.online_aoto,a.yhtype,a.subsite_id from vip_zhanhui as a left join qs_jobfair as b on a.zid=b.id where b.id in(".$zid.") and a.qid='".$_GET['id']."'";
			$data=D("qs_jobfair")->query($sql,"select");
			$site=D("qs_subsite")->field("s_id,s_districtname")->select();
			foreach ($data as $i=>$v){
				$data[$i]['dq']="全站";
				foreach ($site as $k=>$s){
					if($s['s_id']==$data[$i]['subsite_id']){
						$data[$i]['dq']=$s['s_districtname'];
					}
				}
			}
			$this->assign("data",$data);
			$this->assign("fpage", $page->fpage());
			$this->assign("qid",$_GET['id']);
			$this->display();
		}
	}
	//---------------------
	function sells(){
		//----------------------------------
		if(!empty($_POST['name'])){
			$zd="select zid from vip_zhanhui where vip_zhanhui.title LIKE '%".$_POST['name']."%' ";
			$com="select count(a.title) as num from vip_zhanhui as a left join qs_jobfair as b on a.zid=b.id where b.id in(".$zd.") and qid='0' and a.title LIKE '%".$_POST['name']."%'";
			$num=D("qs_jobfair")->query($com,"select");
			$page=new Page($num[0]['num'], 20,"key/".$_POST['name']);
			$zid="select zid from vip_zhanhui where vip_zhanhui.title LIKE '%".$_POST['name']."%' ";
			$sql="select b.id,a.zid,a.qid,a.username,a.title,b.title as qytitle,a.xs_user,a.number,a.add_time,b.holddates,a.online_aoto,a.yhtype,a.subsite_id from vip_zhanhui as a left join qs_jobfair as b on a.zid=b.id where b.id in(".$zid.") and qid='0' and a.title LIKE '%".$_POST['name']."%' LIMIT ".$page->limit;
			$data=D("qs_jobfair")->query($sql,"select");
			$site=D("qs_subsite")->field("s_id,s_districtname")->select();
			foreach ($data as $i=>$v){
				$data[$i]['dq']="全站";
				foreach ($site as $k=>$s){
					if($s['s_id']==$data[$i]['subsite_id']){
						$data[$i]['dq']=$s['s_districtname'];
					}
				}
			}
			echo $num[0]['num'];
			$this->assign("fpage", $page->fpage());
		}
		//------------------------------
		if(!empty($_GET['key'])){
			$key= iconv("utf-8","gbk",trim($_GET['key']));
			$zd="select zid from vip_zhanhui where vip_zhanhui.title LIKE '%".$key."%' ";
			$com="select count(a.title) as num from vip_zhanhui as a left join qs_jobfair as b on a.zid=b.id where b.id in(".$zd.") and qid='0' and a.title LIKE '%".$key."%'";
			$num=D("qs_jobfair")->query($com,"select");
			$page=new Page($num[0]['num'], 20,"key/".$key);
			$zid="select zid from vip_zhanhui where vip_zhanhui.title LIKE '%".$key."%' ";
			$sql="select b.id,a.zid,a.qid,a.username,a.title,b.title as qytitle,a.xs_user,a.number,a.add_time,b.holddates,a.online_aoto,a.yhtype,a.subsite_id from vip_zhanhui as a left join qs_jobfair as b on a.zid=b.id where b.id in(".$zid.") and qid='0' and a.title LIKE '%".$key."%' LIMIT ".$page->limit;
			$data=D("qs_jobfair")->query($sql,"select");
			$site=D("qs_subsite")->field("s_id,s_districtname")->select();
			foreach ($data as $i=>$v){
				$data[$i]['dq']="全站";
				foreach ($site as $k=>$s){
					if($s['s_id']==$data[$i]['subsite_id']){
						$data[$i]['dq']=$s['s_districtname'];
					}
				}
			}
			$this->assign("fpage", $page->fpage());
		}
		$this->assign("data",$data);
		$this->display();
	}
	
}