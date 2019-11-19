<?php
	class IndexAction extends Common {
		//查看展位信息。。。.
		function index(){			
			header("Content-type: text/html; charset=gb2312");
			$jobfair=D("qs_jobfair");
			if(!empty($_GET['id'])){$id=$_GET['id'];}
			if($id==0){
				//全站数据
				if(empty($_GET['dqid'])){$dqid=1;}else{$dqid=$_GET['dqid'];}
				
				$page=new Page($jobfair->where(array("subsite_id"=>$dqid,"holddates >"=>strtotime(date('Y-m-d',strtotime('-1 days')))))->total(), 10, "/id/0/dqid/".$dqid);
				$data=$jobfair->field("id,subsite_id,title,holddates,predetermined_start,predetermined_end,addtime")->where(array("subsite_id"=>$dqid,"holddates >"=>strtotime(date('Y-m-d',strtotime('-1 days')))))->order("id asc")->limit($page->limit)->select();
				$site=D("qs_subsite")->field("s_id,s_districtname")->select();
				foreach ($data as $i=>$v){
					$data[$i]['dq']="全站";
					foreach ($site as $k=>$s){
						if($s['s_id']==$data[$i]['subsite_id']){
							$data[$i]['dq']=$s['s_districtname'];
						}
					}
				}
				$this->assign("dqid","0");
				$this->assign("data",$data);
				$this->assign("dq",$site);
			}else{
			
				$page=new Page($jobfair->where(array("subsite_id"=>$id,"holddates >"=>strtotime(date('Y-m-d',strtotime('-1 days')))))->total(), 10, "/id/".$_GET['id']);
				$data=$jobfair->field("id,subsite_id,title,holddates,predetermined_start,predetermined_end,addtime")->where(array("subsite_id"=>$id,"holddates >"=>strtotime(date('Y-m-d',strtotime('-1 days')))))->order("id asc")->limit($page->limit)->select();
				$site=D("qs_subsite")->field("s_id,s_districtname")->select();
				foreach ($data as $i=>$v){
					$data[$i]['dq']="全站";
					foreach ($site as $k=>$s){
						if($s['s_id']==$data[$i]['subsite_id']){
							$data[$i]['dq']=$s['s_districtname'];
						}
					}
				}
				$this->assign("dqid",$id);
				$this->assign("data",$data);
			}
			$this->assign("fpage", $page->fpage());
			$this->display();	
		}
		/*----------------------------------------------------------------*/
		//查看全部
		function indexckqb(){
			header("Content-type: text/html; charset=gb2312");
			$jobfair=D("qs_jobfair");
			if(!empty($_GET['id'])){$id=$_GET['id'];}
			if($id==0){
				if(empty($_GET['dqid'])){$dqid=1;}else{$dqid=$_GET['dqid'];}
				$page=new Page($jobfair->where(array("subsite_id"=>$dqid,"holddates <="=>strtotime(date('Y-m-d',strtotime('-1 days')))))->total(), 10, "/id/0/dqid/".$dqid);
				$data=$jobfair->field("id,subsite_id,title,holddates,predetermined_start,predetermined_end,addtime")->where(array("subsite_id"=>$dqid,"holddates <="=>strtotime(date('Y-m-d',strtotime('-1 days')))))->order("holddates desc")->limit($page->limit)->select();
				$site=D("qs_subsite")->field("s_id,s_districtname")->select();
				foreach ($data as $i=>$v){
					$data[$i]['dq']="全站";
					foreach ($site as $k=>$s){
						if($s['s_id']==$data[$i]['subsite_id']){
							$data[$i]['dq']=$s['s_districtname'];
						}
					}
				}
				$this->assign("dqid","0");
				$this->assign("data",$data);
				$this->assign("dq",$site);
			}else{
				$page=new Page($jobfair->where(array("subsite_id"=>$id,"holddates <="=>strtotime(date('Y-m-d',strtotime('-1 days')))))->total(), 10);
				$data=$jobfair->field("id,subsite_id,title,holddates,predetermined_start,predetermined_end,addtime")->where(array("subsite_id"=>$id,"holddates <="=>strtotime(date('Y-m-d',strtotime('-1 days')))))->order("holddates desc")->limit($page->limit)->select();
				$site=D("qs_subsite")->field("s_id,s_districtname")->select();
				foreach ($data as $i=>$v){
					$data[$i]['dq']="全站";
					foreach ($site as $k=>$s){
						if($s['s_id']==$data[$i]['subsite_id']){
							$data[$i]['dq']=$s['s_districtname'];
						}
					}
				}
				$this->assign("dqid",$id);
				$this->assign("data",$data);
			}
			$this->assign("fpage", $page->fpage());
			$this->display(indexckqb);	
		}
		/*----------------------------------------------------------------*/
		//自动把vip套餐里的会员保存到这期展会里。。。
		function addzw(){
			header("Content-type: text/html; charset=gb2312"); 
			if(!empty($_GET['id'])){
				$id=$_GET['id'];
					//自动定展位
					$user=D("vip_user");
					$zt=D("vip_zt");
					$Zhanhui=D("vip_zhanhui");
					$sql='select vip_user.id,vip_zt.uid,vip_user.qid,username,vip_zt.subsite_id,title,Pic,contents,huiyuan,phone,email,type,bout,number,add_time,end_time from vip_user left join vip_zt on vip_zt.uid = vip_user.id where activation=1 and type=1 ';
					$data=$user->query($sql,"select");															//查询用户时间套餐的数据
					//------------------------------------------------------------
					$jobfair=D("qs_jobfair")->field("id,subsite_id,holddates")->where(array("id"=>$id))->select();		//查询展会所在地区
					if(!empty($data)){
						$arrayLen = sizeof($data);
						for($i=0; $i<$arrayLen; $i++){
							if($data[$i]['subsite_id']==$jobfair[0]['subsite_id']){			//用户和地区在一起的用户时间套餐的数据提取出来
								if(date('Y-m-d',$jobfair[0]['holddates']) <= date('Y-m-d',$data[$i]['end_time'])){
									$hh=$Zhanhui->where(array("zid"=>$id,"qid"=>$data[$i]['qid'],"subsite_id"=>$data[$i]['subsite_id']))->select();  //过滤以参加的用户
									if(empty($hh)){
										$_POST['subsite_id']=$data[$i]['subsite_id'];
										$_POST['zid']=$id;
										$_POST['qid']=$data[$i]['qid'];
										$_POST['username']=$data[$i]['username'];
										$_POST['title']=$data[$i]['title'];
										$_POST['huiyuan']=$data[$i]['huiyuan'];
										$_POST['phone']=$data[$i]['phone'];
										$_POST['email']=$data[$i]['email'];
										$_POST['number']=$data[$i]['number'];
										$_POST['yhtype']="1";
										$_POST['online_aoto']="1";
										$_POST['add_time']=time();
										$Zhanhui->insert();					//保存到数据库
										echo $data[$i]['title']."已经报名参加了 !<br />";
									}else{
										echo $data[$i]['title']."已经参加了,不需要重复参加 !<br />";
									}
								}else{
									    echo $data[$i]['title']."套餐已过期,不可以参加 !<br />";
								}
							}
						}
						$this->success("套餐用户参加展会成功!", 15, "index/selqy/id/".$id);
				  }else{

				  		$this->error("没找到企业用户,或有企业用户未激活",3,"index/index");
				  }
			}
		}
		//查找企业名单
		function selssqy(){
			if(!empty($_POST['id'])){
				$this->assign("zid",$_POST['id']);		//展会id
				$Zhanhui=D("vip_zhanhui");
				$page=new Page($Zhanhui->where(array("zid"=>$_POST['id'],"title"=>"%".$_POST['name']."%"))->total(), 20 ,"id/".$_POST['id']);
				$data=$Zhanhui->where(array("zid"=>$_POST['id'],"title"=>"%".$_POST['name']."%"))->limit($page->limit)->select();
			}
			if(!empty($_GET['id'])){
				$this->assign("zid",$_GET['id']);		//展会id
				$Zhanhui=D("vip_zhanhui");
				$page=new Page($Zhanhui->where(array("zid"=>$_GET['id'],"title"=>"%".$_POST['name']."%"))->total(), 20 ,"id/".$_GET['id']);
				$data=$Zhanhui->where(array("zid"=>$_GET['id'],"title"=>"%".$_POST['name']."%"))->limit($page->limit)->select();
			}
			
				$site=D("qs_subsite")->field("s_id,s_districtname")->select();
				foreach($data as $i=>$v){
					$data[$i]['dq']="全站";
					foreach ($site as $k=>$s){
						if($s['s_id']==$data[$i]['subsite_id']){
							$data[$i]['dq']=$s['s_districtname'];
						}
					}
				}
				$this->assign("data",$data);	//预定企业信息
				$this->assign("fpage", $page->fpage());

			$this->display(zhqy);			//模版
		}
		//查看这期的企业名单
		function selqy(){
			header("Content-type: text/html; charset=gb2312"); 
			if(!empty($_GET['id'])){
				$id=$_GET['id'];	
			}else{
				$id=$_POST['id'];
			}
			//--------------------------------------------------
			$this->assign("zid",$id);		//展会id
			//------------------------------------------
			$Zhanhui=D("vip_zhanhui");
			$page=new Page($Zhanhui->where(array("zid"=>$id))->total(), 20 ,"id/".$id);
			$data=$Zhanhui->where(array("zid"=>$id))->limit($page->limit)->select();
			$site=D("qs_subsite")->field("s_id,s_districtname")->select();
			/*foreach($data as $i=>$v){
				$data[$i]['dq']="全站";
				foreach ($site as $k=>$s){
					if($s['s_id']==$data[$i]['subsite_id']){
						$data[$i]['dq']=$s['s_districtname'];
					}
				}
			}*/
			$this->assign("data",$data);	//预定企业信息
			$this->assign("fpage", $page->fpage());
			/*--------------------------------------------------------------------------------*/
			//传递地区------------------------------------------------
			$dqid=D("qs_jobfair")->field('subsite_id,title')->where(array(id=>$id))->select();
			// var_dump($dqid);exit;
			foreach ($site as $i=>$s){
				if($s['s_id']==$dqid[0]['subsite_id']){
					$qid=$s['s_id'];
					$dq=$s['s_districtname'];
				}
			}
			// echo $qid;exit;
			$this->assign("dqid",$qid);		//地区id
			$this->assign("dq",$dq);		//地区名字
			$this->assign("jobfair_text",$dqid[0]['title']);		//地区名字
			
			//展位显示-----------------------------------------
			$zhanhui=D("vip_zhanhui");
			$ok=$zhanhui->where(array("zid"=>$id))->select();
			$this->assign("ok",$ok);		//已预订的展位
			$zw=D("vip_zw");
			$un_ding=D("vip_zhanhui")->where(array('zid'=>$id))->field("number")->select();
			// var_dump($un_ding);exit;
			foreach($un_ding as $i=>$v){
				if($i==0){
					$str="'".$v['number']."'";
				}else{
					$str.=",'".$v['number']."'";
				}
			}
			// var_dump($str);exit;
			// $sql="select number from vip_zw where subsite_id='".$qid."' and number not in(select number from vip_zhanhui where zid=".$id.")";
			$sql="select number from vip_zw where subsite_id='".$qid."' and number not in(".$str.")";
			// echo $sql;exit;
			// $sql="select number from vip_zw where number not in(select number from vip_zhanhui where zid=".$id.")";
			// echo mysql_error();exit;
			$all=$zw->query($sql,"select");
			// var_dump($all);exit;
			$this->assign("all",$all);		//未预定的展位
			//-----------------------------------------------------------------
			$this->display(zhqy);			//模版
		}
		//添加预定紧急展位
		function jinji(){
			header('Content-Type:text/html;charset=GB2312');
			if(!empty($_POST)){
				$_POST['subsite_id']= iconv("utf-8","gbk",trim($_POST['subsite_id'])); 
				$_POST['zid']= iconv("utf-8","gbk",trim($_POST['zid'])); 
				$_POST['username']= "无";
				$_POST['title']= iconv("utf-8","gbk",trim($_POST['title']));
				$_POST['huiyuan']= iconv("utf-8","gbk",trim($_POST['huiyuan']));
				$_POST['phone']= iconv("utf-8","gbk",trim($_POST['phone']));
				$_POST['email']= iconv("utf-8","gbk",trim($_POST['email']));
				$_POST['xs_user']= iconv("utf-8","gbk",trim($_POST['xs_user']));
				$_POST['text']= iconv("utf-8","gbk",trim($_POST['text']));
				$_POST['number']= iconv("utf-8","gbk",trim($_POST['number']));
				$_POST['yhtype']= iconv("utf-8","gbk",trim($_POST['yhtype']));
				$_POST['online_aoto']= iconv("utf-8","gbk",trim($_POST['online_aoto']));
				$_POST['add_time']=time();
				$Zhanhui=D("vip_zhanhui");
				$id=$Zhanhui->insert();		
				if(!empty($id)){
					echo "预定展会成功！";
				}else{
					echo "预定展会失败！";
				}
			}
			$GLOBALS["debug"]=0;
		}
		//查看参会企业
		function ckchqy(){
			header("Content-type: text/html; charset=gb2312");
			$jobfair=D("qs_jobfair");
			if(!empty($_GET['id'])){$id=$_GET['id'];}
			if($id==0){
				$data=$jobfair->field("id,subsite_id,title,holddates,addtime")->where(array())->order("holddates asc")->select();
				$this->assign("data",$data);
			}else{
				$data=$jobfair->field("id,subsite_id,title,holddates,addtime")->where(array("subsite_id"=>$id))->order("holddates asc")->select();
				$this->assign("data",$data);
			}
			$this->display(sszhqy);
		}
		//预定过展会更改展位号界面
		function gzw(){
			if(!empty($_GET['id'])){$id=$_GET['id'];}
			$zh=D("vip_zhanhui")->where(array("id"=>$id))->select();
			$this->assign("data",$zh[0]);
			$this->display(zhggzw);
		}
		//预定过展会更改展位号
		function gmod(){
			if(!empty($_POST)){
				$a=D("vip_zhanhui")->where(array("number"=>$_POST['number'],"zid"=>$_POST['zid']))->select();
				if(empty($a)){
					$id=D("vip_zhanhui")->where($_POST['id'])->update("number='".strval($_POST['number'])."'");
					if(!empty($id)){
						$this->success("更改展位成功!", 1, "index/selqy/id/".$_POST['zid']);
					}else{
						$this->error("更改展位失败!",1,"index/selqy/id/".$_POST['zid']);
					}
				}else{
					$this->error("这个展位已被别的用户预定过了，请更换!",2,"index");
				}
			}
		}
		//删除预定过的企业
		function gdel(){
			if(!empty($_GET['id'])){
				$id=$_GET['id'];
				$user=D("vip_zhanhui");
				$id=$user->delete($id);
				if(!empty($id)){
					$this->success("删除成功!", 1, "index/selqy/id/".$_GET['zhid']);
				}else{
					$this->error("删除失败!", 1, "index/selqy/id/".$_GET['zhid']);
				}
			}
		}
		//-----------------------------------------------------------------------------------------------------
		
		//查询数据库的企业
		function selsecqy(){
			header("Content-type: text/html; charset=gb2312"); 
			if(!empty($_POST['qname'])){
				$name=$_POST['qname'];
				$a=D("qs_company_profile");
				$b=D("qs_members");
				$sql='select * from qs_company_profile join qs_members on qs_company_profile.uid = qs_members.uid where username = "'.$name.'"';
				$data=$b->query($sql,"select");
				if(empty($data)){
					$this->error("没有找到这个企业!", 1);
				}
				$this->assign("data",$data[0]);
				$dq=D("qs_subsite")->field("s_id,s_districtname")->select();
				$this->assign("dq",$dq);
				if(!empty($_POST['dq_id'])){
					$this->assign("dq_dq",$_POST['dq_id']);
				}
				$this->display(addvip);
			}
			$GLOBALS["debug"]=0;
		}
		/*------------------------------------------------------操作------------------------------------------------------*/
		//操作
		function Operating(){
			header("Content-type: text/html; charset=gb2312"); 
			$zt=D("vip_zt");
			if(!empty($_GET['id'])){
				$id=$_GET['id'];
				$data=$zt->where(array("id"=>$id))->select();
				if(!empty($data)){
					if($data[0]['type']==1){
						//echo "你好这是套餐用户，可以更改展位号";
						$this->assign("data",$data[0]);
						$this->assign("dqid",$_GET['dqid']);
						$this->display(cztaocan);
					}else{
						//echo "你好这是次数用户，可以增加次数";
						//p($data[0]);exit;
						$this->assign("data",$data[0]);
						$this->display(czvip);
					}
				}else{
					$this->error("亲你先办套餐，谢谢!",1,"index/bl/id/".$id);
				}
			}
		}
		//修改次数时间
		function updatasj(){
				header("Content-type: text/html; charset=gb2312"); 
				$zt=D("vip_zt");
				$sql="UPDATE {$zt->tabName} set cs_ks_time=".strtotime($_POST['cs_ks_time']).",cs_end_time=".strtotime($_POST['cs_end_time'])."  WHERE id=".$_POST['id'];
				$id=$zt->query($sql,"update");
				if(!empty($id)){
					//$this->success("增加次数成功!", 1, "index");
					$this->ok("操作成功!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
				}else{
					//$this->error("增加次数失败!",1,"index");
					$this->xw("操作失败!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
				}
		}
		//修改展位与次数
		function updata(){
			header("Content-type: text/html; charset=gb2312"); 
			$zt=D("vip_zt");
			/*-------------------------------------------------------------------------------------*/
			if($_POST['cs']=='1'){
					if($_POST['subsite_id'] == 5)///----上海区
					{
						if($_POST['cz']==1){$bout=intval($_POST['bout1'])+intval($_POST['bout']);}		//增加
						if($_POST['cz']==2){$bout=intval($_POST['bout1'])-intval($_POST['bout']);}	//减少
						if($bout<-1){
							$this->ok("次数小于0啦!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
						}
						if($_POST['cz_6']==1){$bout_6=intval($_POST['bout1_6'])+intval($_POST['bout_6']);}	//增加
						if($_POST['cz_6']==2){$bout_6=intval($_POST['bout1_6'])-intval($_POST['bout_6']);}		//减少
						if($bout_6<-1){
						$this->ok("周六次数小于0啦!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
						}
						$sql="UPDATE {$zt->tabName} set bout=".$bout.",bout_6=".$bout_6." WHERE id=".$_POST['id'];
						//echo $sql;exit;
					}else{//-----其他地区
						if($_POST['cz']==1)
						{
							$bout=intval($_POST['bout1'])+intval($_POST['bout']);		//增加
						}
						if($_POST['cz']==2)
						{
							$bout=intval($_POST['bout1'])-intval($_POST['bout']);		//减少
						}
						if($bout<-1)
						{
							$this->ok("次数小于0啦!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
						}
						$sql="UPDATE {$zt->tabName} set bout=".$bout." WHERE id=".$_POST['id'];
					}
					
					$id=$zt->query($sql,"update");
					if(!empty($id)){
						//$this->success("增加次数成功!", 1, "index");
						$this->ok("操作次数成功!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
					}else{
						//$this->error("增加次数失败!",1,"index");
						$this->xw("操作次数失败!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
					}
			}
			/*-------------------------------------------------------------------------------------*/
			if($_POST['nf']=='1'){
				//改展位
				$a=$zt->where(array("number"=>$_POST['number'],"subsite_id"=>$_POST['subsite_id']))->select();
				if(empty($a)){
					$id=$zt->where($_POST['id'])->update("number='".strval($_POST['number'])."'");
					if(!empty($id)){
						//$this->success("更改展位成功!", 1, "index");
						$this->ok("更改展位成功!",1,"/../kunkunhaobang/admin_vip.php?act=selecttcvip");
					}else{
						$this->xw("更改展位失败!",1,"/../kunkunhaobang/admin_vip.php?act=selecttcvip");
					}
				}else{
					//$this->error("这个展位已被别的用户预定过了，请更换!",1,"index");
					$this->xw("这个展位已被别的用户预定过了，请更换!!",1,"/../kunkunhaobang/admin_vip.php?act=selecttcvip");
				}
			}
			/*-------------------------------------------------------------------------------------*/
		}
		//增加减少套餐用户天数
		function zjshijian(){
			if(!empty($_POST)){
				if($_POST['sj']==1){
					$date=date('Y-m-d',$_POST['end_time']);
					$sj=date('Y-m-d',strtotime($date . '+'.$_POST['tianshu'].' day'));
				}
				if($_POST['sj']==2){
					$date=date('Y-m-d',$_POST['end_time']);
					$sj=date('Y-m-d',strtotime($date . '-'.$_POST['tianshu'].' day'));
				}
				//echo strtotime($sj)."<br>";echo time();exit;
				$zt=D("vip_zt");
				$id=$zt->where($_POST['id'])->update("end_time='".strtotime($sj)."'");
				if(!empty($id)){
					//$this->success("更改展位成功!", 1, "index");
					$this->ok("增减时间成功!",1,"/../kunkunhaobang/admin_vip.php?act=selecttcvip");
				}else{
					$this->xw("增减时间失败!",1,"/../kunkunhaobang/admin_vip.php?act=selecttcvip");
				}
			}
		}
		/*-----------------------------------------------套餐操作-------------------------------------------------*/
		//时间套餐的激活
		function tjh(){
			header("Content-type: text/html; charset=gb2312"); 
			if(!empty($_GET['id'])){
				$id=D("vip_zt")->where(array("id"=>$_GET['id']))->update("activation=1");  
				if(!empty($id)){
					//$this->success("激活成功!", 1, "index");
					$this->ok("激活成功!",1,"/../kunkunhaobang/admin_vip.php?act=selecttcvip");
				}else{
					//$this->error("已激活,或激活失败!",1,"index");
					$this->xw("激活失败, 或者已激活!",1,"/../kunkunhaobang/admin_vip.php?act=selecttcvip");
				}
			}
		}
		//次数套餐的激活
		function cjh(){
			header("Content-type: text/html; charset=gb2312"); 
			if(!empty($_GET['id'])){
				$id=D("vip_zt")->where(array("id"=>$_GET['id']))->update("activation=1");  
				if(!empty($id)){
					//$this->success("激活成功!", 1, "index");
					$this->ok("激活成功!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
				}else{
					//$this->error("已激活,或激活失败!",1,"index");
					$this->xw("激活失败, 或者已激活!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
				}
			}
		}
		//查看套餐会员
		/*
			已在源程序添加
		*/
		//办理vip界面
		function blvip(){
			header("Content-type: text/html; charset=gb2312"); 
			$user=D("vip_user");
			if(!empty($_GET['id'])){
				$id=$_GET['id'];
				$data=$user->where(array("id"=>$id))->select();
				$site=D("qs_subsite")->field("s_id,s_districtname")->select();
				foreach ($data as $i=>$v){
					$data[$i]['dq']="全站";
					foreach ($site as $k=>$s){
						if($s['s_id']==$data[$i]['subsite_id']){
							$data[$i]['dq']=$s['s_districtname'];
						}
					}
				}
			$this->assign("data",$data[0]);
			$this->display(blvip);
			}
		}
		//办理搜索用户办理套餐
		function ssbl(){
			header("Content-type: text/html; charset=gb2312");
			$user=D("vip_user");
			if(!empty($_POST['name'])){
				$name=$_POST['name'];
				$data=$user->where(array("username"=>$name))->select();
				if(empty($data)){
					$this->error("没有找到该用户,请重新搜索!", 1, "index/ssbl");
				}
			}
			$site=D("qs_subsite")->field("s_id,s_districtname")->select();
			foreach ($data as $i=>$v){
				$data[$i]['dq']="全站";
				foreach ($site as $k=>$s){
					if($s['s_id']==$data[$i]['subsite_id']){
						$data[$i]['dq']=$s['s_districtname'];
					}
				}
			}
			$this->assign("data",$data[0]);
			$this->display(ssblvip);
		}
		//删除企业已办理的套餐
		function tcdel(){
			header("Content-type: text/html; charset=gb2312"); 
			if(!empty($_GET['id'])){
				$id=D("vip_zt")->delete($_GET['id']);
				if(!empty($id)){
					$user=D("vip_user")->where(array("id"=>$_GET['uid']))->update("bl=0"); 
					//$this->success("删除这条用户套餐成功!", 1, "index");
					$this->ok("删除这条用户套餐成功!!",1,"/../kunkunhaobang/admin_vip.php?act=selecttcvip");
				}else{
					//$this->error("删除这条用户套餐失败!", 1, "index");
					$this->xw("删除这条用户套餐失败!",1,"/../kunkunhaobang/admin_vip.php?act=selecttcvip");
				}
			}
		}
		//删除企业以办理的套餐
		function csdel(){
			header("Content-type: text/html; charset=gb2312"); 
			if(!empty($_GET['id'])){
				$id=D("vip_zt")->delete($_GET['id']);
				if(!empty($id)){
					$user=D("vip_user")->where(array("id"=>$_GET['uid']))->update("bl=0"); 
					//$this->success("删除这条用户套餐成功!", 1, "index");
					$this->ok("删除这条用户套餐成功!!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
				}else{
					//$this->error("删除这条用户套餐失败!", 1, "index");
					$this->xw("删除这条用户套餐失败!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
				}
			}
		}
		//办理企业套餐
		function addtc(){
			//echo "办理套餐";exit;
			header("Content-type: text/html; charset=gb2312"); 
			$zt=D("vip_zt");
			if(!empty($_POST)){
				/*-----过滤不查找用户直接添加套餐---------------*/
				if($_POST['uid']=="" and $_POST['qid']==""){
					$this->error("请先查找用户才可以办理套餐!", 2, "index/ssbl");
				}
				/*-----过滤不查找用户直接添加套餐-------------*/
				if($_POST['type']==0){
					$_POST['duration']="";
					$_POST['add_time']=time();
					$_POST['activation']=0;
					if($_POST['bout']!="" and $_POST['cs_ks_time']!="" and $_POST['cs_end_time']!=""){
						$_POST['cs_ks_time']=strtotime($_POST['cs_ks_time']);
						$_POST['cs_end_time']=strtotime($_POST['cs_end_time']);
						$_POST['bout_6']=isset($_POST['bout_6'])?intval($_POST['bout_6']):0;
						$id=$zt->insert();
					}else{
						$this->error("请输入完整再提交，谢谢!", 1, "index/ssbl");
					}
					if(!empty($id)){
						$user=D("vip_user")->where(array("id"=>$_POST['uid']))->update("bl=1"); 
						//$this->success("办理次数套餐成功!", 1, "index");
						$this->ok("办理次数套餐成功!!",1,"/../kunkunhaobang/admin_vip.php?act=selectcsvip");
					}else{
						//$this->error("办理次数套餐失败!", 1, "index/");
						$this->xw("办理次数套餐失败!",1,"/../kunkunhaobang/admin_vip.php?act=ckvip");
					}
				}else{
					/*过滤没有输入展位号*/
					if($_POST['number']==""){
							$this->error("请输入展位号，谢谢!", 2, "index/ssbl");
					}
					/*过滤没有输入展位号*/
					$a=$zt->where(array("number"=>$_POST['number'],"subsite_id"=>$_POST['subsite_id']))->select();
					if(empty($a)){
						
						$_POST['activation']=0;
						if($_POST['add_time']==""){
							$t=time();
							$_POST['add_time']=time();
						}else{
							$t=strtotime($_POST['add_time']);
							$_POST['add_time']=strtotime($_POST['add_time']);
						}
						if($_POST['duration']=="1"){
							$_POST['end_time']=strtotime(date("Y-m-d H:i:s",strtotime("+1 year",$t)));				//1年套餐
						}
						if($_POST['duration']=="2"){
							$_POST['end_time']=strtotime(date("Y-m-d H:i:s",strtotime("+6 months",$t)));			//半年套餐
						}
						if($_POST['duration']=="3"){
							$_POST['end_time']=strtotime(date("Y-m-d H:i:s",strtotime("+3 months",$t)));			//1季套餐
						}
						//p($_POST);echo date('Y-m-d',1475856000);
						$id=$zt->insert();
						//echo $id;exit;
						if(!empty($id)){
							$user=D("vip_user")->where(array("id"=>$_POST['uid']))->update("bl=1"); 
							//$this->success("办理时间套餐成功!", 1, "index");
							$this->ok("办理时间套餐成功!!",1,"/../kunkunhaobang/admin_vip.php?act=selecttcvip");
						}else{
							//$this->error("办理时间套餐失败!", 1, "index");
							$this->xw("办理时间套餐失败!",1,"/../kunkunhaobang/admin_vip.php?act=ckvip");
						}
						
					}else{
						$this->error("这个展位已被别的用户预定过了, 请更换展位号重新办理!",5,"index/blvip/id/".$_POST['uid']);
					}
				}
			}
		}
/*-----------------------------------------------用户操作-------------------------------------------------*/
		//添加企业用户界面
		function addvip(){
			header("Content-type: text/html; charset=gb2312"); 
			$dq=D("qs_subsite")->field("s_id,s_districtname")->select();
			$this->assign("dq",$dq);
			if(!empty($_GET['id'])){
				$this->assign("dq_dq",$_GET['id']);
			}
			$this->display(addvip);
		}
		//添加企业用户代码
		function addqy(){
			header("Content-type: text/html; charset=gb2312"); 
			$user=D("vip_user");
			if(!empty($_POST)){
				if($_POST['qid']!="" && $_POST['username']!=""){
				/*-----------------------------------------------------------------------------*/
						//免费体验会员
						if($_POST['huiyuan']=='2'){		//免费体验会员
							$_POST['huiyuan']='2';
							$_POST['addtime']=time();
							$_POST['bl']=1;
							$id=$user->insert($_POST);
							if(!empty($id)){
								$_POST['uid']=$id;
								$_POST['qid']=$_POST['qid'];
								$_POST['subsite_id']=$_POST['subsite_id'];
								$_POST['type']='0';
								$_POST['bout']='1';
								$_POST['cs_ks_time']=time();
								$_POST['cs_end_time']=strtotime(date('Y-m-d',strtotime('7 days')));
								$_POST['duration']="";
								$_POST['add_time']=time();
								$_POST['activation']='1';
								$a=D('vip_zt')->insert($_POST);
								if(!empty($a)){
									$this->ok("添加体验用户成功并添加了一次参展机会!",1,"/../kunkunhaobang/admin_vip.php?act=ckvip");
								}
							}else{
								$this->xw("您添加的用户已存在!",1,"/../kunkunhaobang/admin_vip.php?act=ckvip");
							}
						}
						/*-----------------------------------------------------------------------------*/
						//橱窗赠送会员
						if($_POST['huiyuan']=='3'){		//橱窗赠送会员
							$_POST['huiyuan']='3';
							$_POST['addtime']=time();
							$_POST['bl']=1;
							$id=$user->insert($_POST);
							if(!empty($id)){
								header("Location: chuchuangzs/id/".$id);		//添加次数
							}
						}
						/*-----------------------------------------------------------------------------*/
						//正式会员
						if($_POST['huiyuan']=='1'){		//正式会员
							$_POST['huiyuan']='0';
							$_POST['addtime']=time();
							$_POST['bl']=0;
							$id=$user->insert($_POST);
							if(!empty($id)){
								//$this->success("添加用户成功!", 1, "index/ckvip");
								$this->ok("添加用户成功!",1,"/../kunkunhaobang/admin_vip.php?act=ckvip");
							}else{
								//$this->error("您添加的用户已存!!,不需要重新添加!", 1, "index/addvip");
								$this->xw("您添加的用户已存在!",1,"/../kunkunhaobang/admin_vip.php?act=ckvip");
							}
						}
				/*-----------------------------------------------------------------------------*/
				}else{
					$this->xw("不是网站会员用户请注册再添加!",3,"/vipgn/index.php/index/addvip");
				}
			}
		}
		//橱窗预定赠送次数界面
		function chuchuangzs(){
			header("Content-type: text/html; charset=gb2312"); 
			$user=D("vip_user");
			if(!empty($_GET['id'])){
				$id=$_GET['id'];
				$data=$user->where(array("id"=>$id))->select();
				$site=D("qs_subsite")->field("s_id,s_districtname")->select();
				foreach ($data as $i=>$v){
					$data[$i]['dq']="全站";
					foreach ($site as $k=>$s){
						if($s['s_id']==$data[$i]['subsite_id']){
							$data[$i]['dq']=$s['s_districtname'];
						}
					}
				}
			$this->assign("data",$data[0]);
			$this->display(chuchuangblvip);
			}
		}
		//橱窗预定赠送次数代码
		function chuchuangaddtc(){
				$_POST['duration']="";
				$_POST['add_time']=time();
				$_POST['activation']=1;
				$_POST['cs_ks_time']=time();
				$_POST['cs_end_time']=strtotime(date('Y-m-d',strtotime('30 days')));
				$id=D('vip_zt')->insert($_POST);
				if(!empty($id)){
					$this->ok("添加用户并添加预定展会次数成功!",3,"/../kunkunhaobang/admin_vip.php?act=ckvip");
				}else{
					$this->xw("添加用户并添加预定展会次数失败!",3,"/../kunkunhaobang/admin_vip.php?act=ckvip");
				}
		
		}
		//查看企业用户
		/*
			已在源程序添加
		*/
		//修改企业用户界面
		function upvip(){
			header("Content-type: text/html; charset=gb2312"); 
			$user=D("vip_user");
			if(!empty($_GET['id'])){
				$id=$_GET['id'];
				$data=$user->where(array("id"=>$id))->select();
				$this->assign("data",$data[0]);
			}
			$dq=D("qs_subsite")->select();
			$this->assign("dq",$dq);
			$this->display(upvip);
		}
		//修改企业用户信息
		function upmod(){
			header("Content-type: text/html; charset=gb2312"); 
			$user=D("vip_user");
			if(!empty($_POST)){
				if($_POST['huiyuan']=='1'){$_POST['huiyuan']='0';}
				$id=$user->update();
				if(!empty($id)){
					//$this->success("修改用户成功!", 1, "index/ckvip");
					$this->ok("修改用户成功!",1,"/../kunkunhaobang/admin_vip.php?act=ckvip");
				}else{
					//$this->error("修改用户失败!", 1, "index/ckvip");
					$this->xw("修改用户失败!",1,"/../kunkunhaobang/admin_vip.php?act=ckvip");
				}
			}
		}
		//删除用户
		function udel(){
			header("Content-type: text/html; charset=gb2312"); 
			if(!empty($_GET['id'])){
				$id=$_GET['id'];
				$user=D("vip_user");
				$id=$user->delete($id);
				if(!empty($id)){
					//$this->success("删除这条用户成功!", 1, "index/ckvip");
					$this->ok("删除这条用户成功!",1,"/../kunkunhaobang/admin_vip.php?act=ckvip");
				}else{
					//$this->error("删除这条用户失败!", 1, "index/ckvip");
					$this->xw("删除这条用户失败!",1,"/../kunkunhaobang/admin_vip.php?act=ckvip");
				}
			}
		}
		
		//删除验证--------
		function scyz(){
			unset($_SESSION['qx']);
			$this->success("删除验证成功!", 1, "index/index");
		}
	}