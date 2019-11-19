<?php
	class sousuo {
		//----------------------------
		function index(){
		
		}
		
		//搜索会员--
		function sousuohuiyuan(){
			switch($_SESSION['priv']){
				case $_SESSION['priv']==3 || $_SESSION['priv']==4:
					//报单中心搜索
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" status!='0' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
						$page=new page(D("tuijian")->where($where_sql)->total(),20);
						$data=D("tuijian")->where($where_sql)->limit($page->limit)->order($paixun)->select();
						$jibei=D("jibie")->select();
						foreach ($data as $k => $v){
							foreach ($jibei as $i => $s){
								if($s['id']==$v['jibie']){
									$data[$k]['jibie']=$s['jibie'];
								}
							}
						}
						$this->assign('fpage_weihu',$page->fpage());	//分页
					}
					break;
				case 1:
					//管理员搜索
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" status!='0' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
						$page=new page(D("tuijian")->where($where_sql)->total(),20);
						$data=D("tuijian")->where($where_sql)->limit($page->limit)->order($paixun)->select();
						$jibei=D("jibie")->select();
						foreach ($data as $k => $v){
							foreach ($jibei as $i => $s){
								if($s['id']==$v['jibie']){
									$data[$k]['jibie']=$s['jibie'];
								}
							}
						}
						$this->assign('fpage_weihu',$page->fpage());	//分页
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			
			$this->assign("data",$data);
			$this->display();
		}
		
		//提现提醒-------------
		function jiangjintixing(){
		
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4:
				
					$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
					$where_sql=" jihuo='1' and status!='0' and path like '%,".$user['id'].",%' and jiangjin!=0 ";
					
					break;
				case 1:
					
					$where_sql=" jihuo='1' and status!='0' and jiangjin!=0";
					
					break;
				default:	//默认无
					exit('没权访问！');
			}
			
			
			$page=new page(D("tuijian")->where($where_sql)->total(),20);
			$data=D("tuijian")->where($where_sql)->limit($page->limit)->order("jiangjin desc")->select();
			$jibei=D("jibie")->select();
			$tizhuangtai=D("tixiantixing")->field("binhao")->where(array("nian"=>date("Y"),"yue"=>date("m")))->select();	//查询这个月提醒的所有成员
			
			foreach ($data as $k => $v){
				foreach ($jibei as $i => $s){
					if($s['id']==$v['jibie']){
						$data[$k]['jibie']=$s['jibie'];
					}
				}
				foreach($tizhuangtai as $ti => $ts){
					if($ts['binhao']==$v['bianhao']){
						$data[$k]['tixing']='1';
					}
				}
			}
			$this->assign('fpage_weihu',$page->fpage());	//分页
			$this->assign("data",$data);
			$this->display();
		}
		
		//发送提醒
		function fasongtixing(){
			if(!empty($_GET['id'])){
				$d=intval(date("d"));
				if($d>=1 and $d<=31){
					//---------------------------------------
					$user=D("tuijian")->field("id,bianhao,name,sex,address,sphone,id_number,qq,jiangjin,tj_num,add_time,f_bianghao,f_name,pid,jibie,path")->where(array("id"=>$_GET['id']))->find();
					$tizhuangtai=D("tixiantixing")->where(array("binhao"=>$user['bianhao'],"yue"=>date("m")))->find();
					if(empty($tizhuangtai)){
						//写入提醒记录
						$tx=array();
						$tx['binhao']=$user['bianhao'];
						$tx['nian']=date("Y");
						$tx['yue']=date("m");
						$tx['tixing_time']=date("Y-m-d H:i:s", time());
						$id=D("tixiantixing")->insert($tx);
						//执行成功！,发送提醒短息
						if($id > 0){
							if(DUANXIN){
								$content="【壹打工网】尊敬的壹打工网会员：恭喜您参与的1+2事业平台账户已产生内荐奖金，请登陆网站申请提现。咨询电话4001185188";
								$dx=new bb_duanxin($user['sphone'],$content);
								$dx->fs();
							}
							//写入日志
							//--记录日志---and--------------------------------
							$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'提醒会员提现  编号：'.$user['bianhao'].'， 姓名：'.$user['name'].'，会员奖金：'.$user['jiangjin']);
							D("caozuolog")->insert($caozuo);
							//--记录日志---end----------------------------
							$this->success("提醒成功！", 1);
						}
					}else{
						$this->error("这个“会员”这个“月”提醒过了！，下个月再来提醒吧！", 5);
					}
					//--------------------------------------------
				}else{
					$this->error("还不可以提醒，1-3号再来吧！", 5);
				}
			}else{
				$this->error("没有找到！", 1);
			}
		}
		
		//一键发送短信提醒会员
		function yijianfasong(){
		
			ini_set('max_execution_time', '0');		
			
			$d=intval(date("d"));
			if($d>=1 and $d<=31){
				//---------------------------------------------------------------------
				switch($_SESSION['priv']){
					case $_SESSION['priv']==2 || $_SESSION['priv']==4:
					
						$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
						$where_sql=" jihuo='1' and status!='0' and path like '%,".$user['id'].",%' and jiangjin!=0 ";
						
						break;
					case 1:
						
						$where_sql=" jihuo='1' and status!='0' and jiangjin!=0";
						
						break;
					default:	//默认无
						exit('没权访问！');
				}
				
				$data=D("tuijian")->where($where_sql)->order("jiangjin desc")->select();
				$jibei=D("jibie")->select();
				$tizhuangtai=D("tixiantixing")->field("binhao")->where(array("nian"=>date("Y"),"yue"=>date("m")))->select();	//查询这个月提醒的所有成员
				//--------------------------
				if(!empty($tizhuangtai)){
					foreach ($data as $k => $v){
						
						$tixing=D("tixiantixing")->where(array("binhao"=>$v['bianhao'],"yue"=>date("m")))->find();
						if(!empty($tixing)){
							echo "<font color='red'>".$v['name']."提醒过了！</font> <br/>";
						}else{
							//写入提醒记录
							$tx=array();
							$tx['binhao']=$v['bianhao'];
							$tx['nian']=date("Y");
							$tx['yue']=date("m");
							$tx['tixing_time']=date("Y-m-d H:i:s", time());
							$id=D("tixiantixing")->insert($tx);
							//执行成功！,发送提醒短息
							if($id > 0){
								if(DUANXIN){
									$content="【壹打工网】尊敬的壹打工网会员：恭喜您参与的1+2事业平台账户已产生内荐奖金，请登陆网站申请提现。咨询电话4001185188";
									$dx=new bb_duanxin($v['sphone'],$content);
									$dx->fs();
								}
								//写入日志
								//--记录日志---and--------------------------------
								$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'提醒会员提现  编号：'.$v['bianhao'].'， 姓名：'.$v['name'].'，会员奖金：'.$v['jiangjin']);
								D("caozuolog")->insert($caozuo);
								//--记录日志---end----------------------------
								
							}
							echo "<font color='green'>".$v['name']."发送提醒成功！</font> <br/>";
						}
						//------------------------------------------------
						usleep(100000);		//1秒=1000毫秒
						ob_flush(); 		//强制将缓存区的内容输出
						flush(); 			//强制将缓冲区的内容发送给客户
					}
				}else{
					foreach ($data as $k => $v){
						
						//写入提醒记录
						$tx=array();
						$tx['binhao']=$v['bianhao'];
						$tx['nian']=date("Y");
						$tx['yue']=date("m");
						$tx['tixing_time']=date("Y-m-d H:i:s", time());
						$id=D("tixiantixing")->insert($tx);
						//执行成功！,发送提醒短息
						if($id > 0){
							if(DUANXIN){
								$content="【壹打工网】尊敬的壹打工网会员：恭喜您参与的1+2事业平台账户已产生内荐奖金，请登陆网站申请提现。咨询电话4001185188";
								$dx=new bb_duanxin($v['sphone'],$content);
								$dx->fs();
							}
							//写入日志
							//--记录日志---and--------------------------------
							$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'提醒会员提现  编号：'.$v['bianhao'].'， 姓名：'.$v['name'].'，会员奖金：'.$v['jiangjin']);
							D("caozuolog")->insert($caozuo);
							//--记录日志---end----------------------------
							
						}
						echo "<font color='green'>".$v['name']."发送提醒成功！</font><br/>";
						//------------------------------------------------
						usleep(100000);		//1秒=1000毫秒
						ob_flush(); 		//强制将缓存区的内容输出
						flush(); 			//强制将缓冲区的内容发送给客户
					}
				}
				
				echo "<font color='green'>全部发送完成！ </font> <input type='button' value=' 点击关闭 ' class='sub_b' onclick='location=\"".$GLOBALS["url"]."jiangjintixing\";'> <br/>";
				
			}else{
				$this->error("还不可以提醒，1-3号再来吧！", 5);
			}
		}
	}