<?php
	class tixian {
		//提现的记录----------------------------
		function index(){
			$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4 || $_SESSION['priv']==5:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" where tj.path like '%,".$user['id'].",%' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" where tj.path like '%,".$user['id'].",%' ";
					}
					break;
				case 1:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" where ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql='';
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			//审核状态
			if($_GET['txzhuangtai']!=''){
				if($where_sql!=''){ $s=' and'; }else{ $s=' where '; }
				$where_sql.=$s." tx.txzhuangtai='".$_GET['txzhuangtai']."' ";
			}
			//支付状态
			if($_GET['fafangzhangtai']!=''){
				if($where_sql!=''){ $s=' and'; }else{ $s=' where '; }
				$where_sql.=$s." tx.fafangzhangtai='".$_GET['fafangzhangtai']."' ";
			}
			//---时间段搜索-----and------------------------------------------------------------------------------------------------------------------------------------------------
			if($_GET['q_time']!='' && $_GET['h_time']!=''){
				if($where_sql!=''){ $s=' and'; }else{ $s=' where '; }
				$where_sql.=$s." to_days(FROM_UNIXTIME(tx.add_time ,'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
			}
			//-------end----------------------------------
			
			$sql="select tx.*,tj.name,tj.bianhao from tixian as tx left join tuijian as tj on tx.userbianhao=tj.bianhao".$where_sql;
			$num=D("tixian")->query($sql,"total");
			$page=new Page($num, 20);
			$sql="select tx.*,tj.name,tj.bianhao from tixian as tx left join tuijian as tj on tx.userbianhao=tj.bianhao".$where_sql." ORDER BY tx.add_time desc limit ".$page->limit;
			$data=D("tixian")->query($sql,"select");
			$this->assign("data",$data);
			$this->assign("fpage_weihu", $page->fpage());
			$this->assign("changshu",$_SERVER['QUERY_STRING']);			//当前url参数---
			$this->assign("quanxian",$_SESSION['priv']);
			$this->display();
		}
		
		//提现审核界面----------
		function shenghe(){
			$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4:
					if(!empty($_GET['search'])){
						$where_sql=" and tj.path like '%,".$user['id'].",%' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" and tj.path like '%,".$user['id'].",%' ";
					}
					break;
				case 1:
					if(!empty($_GET['search'])){
						$where_sql=" and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql='';
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			
			//---时间段搜索-----and------------------------------------------------------------------------------------------------------------------------------------------------
			if($_GET['q_time']!='' && $_GET['h_time']!=''){
				if($where_sql!=''){ $s=' and'; }else{ $s=' where '; }
				$where_sql.=$s." to_days(FROM_UNIXTIME(tx.add_time ,'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
			}
			//-------end----------------------------------
			
			$sql="select tx.* from tixian as tx left join tuijian as tj on tx.userbianhao=tj.bianhao where txzhuangtai=1".$where_sql;
			$num=D("tixian")->query($sql,"total");
			$page=new Page($num, 20);
			$sql="select tx.*,tj.sphone,tj.bank,tj.subbranch,tj.bank_account from tixian as tx left join tuijian as tj on tx.userbianhao=tj.bianhao where txzhuangtai=1 ".$where_sql." limit ".$page->limit;
			$data=D("tixian")->query($sql,"select");
			$this->assign("data",$data);
			$this->assign("fpage_weihu", $page->fpage());
			$this->display();
		}
		//提现支付界面----------
		function zhifu(){
			$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==5:
					if(!empty($_GET['search'])){
						$where_sql=" and tj.path like '%,".$user['id'].",%' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" and tj.path like '%,".$user['id'].",%' ";
					}
					break;
				case 1:
					if(!empty($_GET['search'])){
						$where_sql=" and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql='';
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			
			//---时间段搜索-----and------------------------------------------------------------------------------------------------------------------------------------------------
			if($_GET['q_time']!='' && $_GET['h_time']!=''){
				if($where_sql!=''){ $s=' and'; }else{ $s=' where '; }
				$where_sql.=$s." to_days(FROM_UNIXTIME(tx.add_time ,'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
			}
			//-------end----------------------------------
			
			$sql="select tx.* from tixian as tx left join tuijian as tj on tx.userbianhao=tj.bianhao where txzhuangtai!=1 and txzhuangtai!=3 and fafangzhangtai=1".$where_sql;
			$num=D("tixian")->query($sql,"total");
			$page=new Page($num, 20);
			$sql="select tx.*,tj.sphone,tj.bank,tj.subbranch,tj.bank_account from tixian as tx left join tuijian as tj on tx.userbianhao=tj.bianhao where txzhuangtai!=1 and txzhuangtai!=3 and fafangzhangtai=1 ".$where_sql." limit ".$page->limit;
			$data=D("tixian")->query($sql,"select");
			$this->assign("data",$data);
			$this->assign("fpage_weihu", $page->fpage());
			$this->display();
		}
		 
		//审核提现   有短信通知  2条
		function shenghetixian(){
			if($_SESSION['name']!=''){
				if($_GET['id']){
					//---------------------------------------
					if($_SESSION['priv']==1 || $_SESSION['priv']==4){
					//---------------------------------
					//审核成功
					if($_GET['zhangtai']=='cg'){
						$id=D("tixian")->where(array("id"=>$_GET['id']))->update(array("txzhuangtai"=>'2'));
						if($id > 0){
							//--发短信通知用户你申请的提现审核成功！-------------
							if(DUANXIN){
								$phone=getsphone($_GET['id']);
								$content="您好，你申请的提现已经审核成功，我们会每个月的10号支付给您！【壹打工网】";
								$dx=new bb_duanxin($phone,$content);
								$dx->fs();
							}else{
								$content="您好，你申请的提现已经审核成功，我们会每个月的10号支付给您！";
								$str=date("Y-m-d H:i:s",time())."   内容：".$content."	 \r\n";
								error_log($str,3,PROJECT_PATH.'/log/errors_dxnr.log');
							}
							//-------------------------------------------------
							//--记录日志---and--------------------------------
							$usertx=D("tixian")->where(array("id"=>$_GET['id']))->find();
							$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'审核成功  编号：'.$usertx['userbianhao'].'， 姓名：'.$usertx['username']);
							D("caozuolog")->insert($caozuo);
							//--记录日志---end----------------------------
							$this->success("操作成功！", 1, "shenghe");
						}else{
							$this->error("操作失败！", 1, "shenghe");
						}
					//审核失败
					}elseif($_GET['zhangtai']=='sb'){
						$id=D("tixian")->where(array("id"=>$_GET['id']))->update(array("txzhuangtai"=>'3'));
						if($id > 0){
							//--发短信通知用户你申请的提现审核失败！-------------
							if(DUANXIN){
								$phone=getsphone($_GET['id']);
								$content="您好，您申请的提现审核失败，可能你的账户信息不完整，或者银行信息不正确！【壹打工网】";
								$dx=new bb_duanxin($phone,$content);
								$dx->fs();
							}else{
								$content="您好，您申请的提现审核失败，可能你的账户信息不完整，或者银行信息不正确！";
								$str=date("Y-m-d H:i:s",time())."   内容：".$content."	 \r\n";
								error_log($str,3,PROJECT_PATH.'/log/errors_dxnr.log');
							}
							//-------------------------------------------------
							//--记录日志---and--------------------------------
							$usertx=D("tixian")->where(array("id"=>$_GET['id']))->find();
							$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'审核失败  编号：'.$usertx['userbianhao'].'， 姓名：'.$usertx['username']);
							D("caozuolog")->insert($caozuo);
							//--记录日志---end----------------------------
							
							$data=D("tixian")->where(array("id"=>$_GET['id']))->find();
							
							/*---返还提现失败的金额--and---*/
							$up=D("tuijian")->where(array("bianhao"=>$data['userbianhao']))->update("jiangjin=jiangjin+".intval($data['txmoney']));
							/*---返还提现失败的金额--end---*/
							
							/*------奖金提现的日志--and------*/
							$recordmoney=array(
								"hyhumber"=>$data['userbianhao'],
								"hyname"=>$data['username'],
								"money"=>intval($data['txmoney']),
								"leftmoney"=>intval($data['cyjiangjin'])+intval($data['txmoney']),
								"caozuo"=>"增加",
								"newbianhao"=>'',
								"beizhuxinming"=>"审核失败！退还".intval($data['txmoney'])."元奖金",
								"beizhu"=>"审核失败！退还".intval($data['txmoney'])."元奖金",
								"pid"=>'',
								"path"=>'',
								"addtime"=>date("Y-m-d H:i:s",time())
							);
							$inrecordmoney=D("recordmoney")->insert($recordmoney);
							/*------奖金提现的日志--end------*/
							//-------------------------------------------------
							$this->success("操作成功！", 1, "shenghe");
						}else{
							$this->error("操作失败！", 1, "shenghe");
						}
					}else{
						$this->error("出错了", 1, "shenghe");
						exit();
					}
					//---------------------------
					}else{
						exit("没有权限！");
					}
					//----------------------------
				}
			}
		}
		//发放奖金   有短信通知  2条
		function fafangjiangjin(){
			if($_SESSION['name']!=''){
				if($_GET['id']){
					//---------------------------------------
					if($_SESSION['priv']==1 || $_SESSION['priv']==5){
					//---------------------------------------
					//支付成功
					if($_GET['zhangtai']=='cg'){
						$id=D("tixian")->where(array("id"=>$_GET['id']))->update(array("fafangzhangtai"=>'2',"fafang_time"=>time()));
						if($id > 0){
							//--发短信通知用户你的提现支付成功-------------
								if(DUANXIN){
									$phone=getsphone($_GET['id']);
									$content="您好，你申请的提现已支付。【壹打工网】";
									$dx=new bb_duanxin($phone,$content);
									$dx->fs();
								}else{
									$content="您好，你申请的提现已支付。【壹打工网】";
									$str=date("Y-m-d H:i:s",time())."   内容：".$content."	 \r\n";
									error_log($str,3,PROJECT_PATH.'/log/errors_dxnr.log');
								}
							//-------------------------------------------------
							
							//--记录日志---and--------------------------------
							$usertx=D("tixian")->where(array("id"=>$_GET['id']))->find();
							$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'支付成功  编号：'.$usertx['userbianhao'].'， 姓名：'.$usertx['username']);
							D("caozuolog")->insert($caozuo);
							//--记录日志---end----------------------------
							
							$this->success("操作成功！", 1, "zhifu");
						}else{
							$this->error("操作失败！", 1, "zhifu");
						}
					//支付失败
					}elseif($_GET['zhangtai']=='sb'){
						$id=D("tixian")->where(array("id"=>$_GET['id']))->update(array("fafangzhangtai"=>'3',"fafang_time"=>time()));
						if($id > 0){
							//--发短信通知用户你的提现支付失败-------------
								if(DUANXIN){
									$phone=getsphone($_GET['id']);
									$content="您好，你申请的提现支付失败，请检查你的银行信息是否有误。【壹打工网】";
									$dx=new bb_duanxin($phone,$content);
									$dx->fs();
								}else{
									$content="您好，你申请的提现支付失败，请检查你的银行信息是否有误。";
									$str=date("Y-m-d H:i:s",time())."   内容：".$content."	 \r\n";
									error_log($str,3,PROJECT_PATH.'/log/errors_dxnr.log');
								}
								
								//--记录日志---and--------------------------------
								$usertx=D("tixian")->where(array("id"=>$_GET['id']))->find();
								$caozuo=array("name"=>$_SESSION['name'],"ip"=>getip(),"time"=>time(),"caozuo"=>'支付失败  编号：'.$usertx['userbianhao'].'， 姓名：'.$usertx['username']);
								D("caozuolog")->insert($caozuo);
								//--记录日志---end----------------------------
								
								$data=D("tixian")->where(array("id"=>$_GET['id']))->find();
								
								/*---返还支付失败的金额--and---*/
								$up=D("tuijian")->where(array("bianhao"=>$data['userbianhao']))->update("jiangjin=jiangjin+".intval($data['txmoney']));
								/*---返还支付失败的金额--and---*/
								
								/*------奖金提现的日志--and------*/
								$recordmoney=array(
									"hyhumber"=>$data['userbianhao'],
									"hyname"=>$data['username'],
									"money"=>intval($data['txmoney']),
									"leftmoney"=>intval($data['cyjiangjin'])+intval($data['txmoney']),
									"newbianhao"=>'',
									"caozuo"=>"增加",
									"beizhuxinming"=>"支付失败！退还".intval($data['txmoney'])."元奖金",
									"beizhu"=>"支付失败！退还".intval($data['txmoney'])."元奖金",
									"pid"=>'',
									"path"=>'',
									"addtime"=>date("Y-m-d H:i:s",time())
								);
								$inrecordmoney=D("recordmoney")->insert($recordmoney);
								/*------奖金提现的日志--and------*/
							//-------------------------------------------------
							$this->success("操作成功！", 1, "zhifu");
						}else{
							$this->error("操作失败！", 1, "zhifu");
						}
					}else{
						$this->error("出错了", 1, "zhifu");
						exit();
					}
					//-------------------------
					}else{
						exit('没有权限');
					}
					//------------------------
				}
			}
		}
		
		/*-------------------------------------------------------------------------------*/
		function daochuexcel(){
			$user=D("tuijian")->field("id")->where(array("bianhao"=>$_SESSION['user']))->find();
			switch($_SESSION['priv']){
				case $_SESSION['priv']==2 || $_SESSION['priv']==4 || $_SESSION['priv']==5:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" where tj.path like '%,".$user['id'].",%' and ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql=" where tj.path like '%,".$user['id'].",%' ";
					}
					break;
				case 1:
					if(!empty($_GET['search']) && $_GET['findvalue']!=''){
						$where_sql=" where ".$_GET['search']." like '%".$_GET['findvalue']."%' ";
					}else{
						$where_sql='';
					}
					break;
				default:	//默认无
					exit('没权访问！');
			}
			//审核状态
			if($_GET['txzhuangtai']!=''){
				if($where_sql!=''){ $s=' and'; }else{ $s=' where '; }
				$where_sql.=$s." tx.txzhuangtai='".$_GET['txzhuangtai']."' ";
			}
			//支付状态
			if($_GET['fafangzhangtai']!=''){
				if($where_sql!=''){ $s=' and'; }else{ $s=' where '; }
				$where_sql.=$s." tx.fafangzhangtai='".$_GET['fafangzhangtai']."' ";
			}
			//---时间段搜索-----and------------------------------------------------------------------------------------------------------------------------------------------------
			if($_GET['q_time']!='' && $_GET['h_time']!=''){
				if($where_sql!=''){ $s=' and'; }else{ $s=' where '; }
				$where_sql.=$s." to_days(FROM_UNIXTIME(tx.add_time ,'%Y-%m-%d')) BETWEEN to_days('".$_GET['q_time']."') AND to_days('".$_GET['h_time']."')";
			}
			//-------end----------------------------------
			
			$sql="select tx.*,tj.name,tj.bianhao,tj.sex,tj.sphone,tj.qq,tj.address,tj.id_number,tj.ruzhi_name,tj.bank,tj.subbranch,tj.bank_account from tixian as tx left join tuijian as tj on tx.userbianhao=tj.bianhao".$where_sql;
			$num=D("tixian")->query($sql,"total");
			$page=new Page($num, 20);
			$sql="select tx.*,tj.name,tj.bianhao,tj.sex,tj.sphone,tj.qq,tj.address,tj.id_number,tj.ruzhi_name,tj.bank,tj.subbranch,tj.bank_account from tixian as tx left join tuijian as tj on tx.userbianhao=tj.bianhao".$where_sql." ORDER BY tx.add_time desc limit ".$page->limit;
			$data=D("tixian")->query($sql,"select");
			
			$name="申请提现记录，导出时间-".date('Y-m-d',time());
			
			$title=array("A"=>"编号",
						 "B"=>"姓名",
						 "C"=>"性别",
						 "D"=>"联系电话",
						 "E"=>"QQ",
						 "F"=>"详细地址",
						 "G"=>"身份证号码",
						 "H"=>"在职企业",
						 "I"=>"开户银行和支行",
						 "J"=>"银行卡号",
						 "K"=>"现有奖金",
						 "L"=>"提现奖金",
						 "M"=>"剩余奖金",
						 "N"=>"申请提现状态",
						 "O"=>"申请提现时间",
						 "P"=>"支付状态",
						 "Q"=>"支付时间",
						);	
				
			$this->excel($name,$title,$data);
			
			
		}
		
		
		//-------------------------
		function excel($name,$title,$data){
			include 'PHPExcel.php';
			include 'PHPExcel/Writer/Excel5.php'; 		//用于输出.xls的
			//创建一个excel
			$objPHPExcel = new PHPExcel();			
			//设置excel的属性：
			$objPHPExcel->getProperties()->setCreator("1dagong.com");					//创建人
			$objPHPExcel->getProperties()->setLastModifiedBy("1dagong.com");			//最后修改人
			$objPHPExcel->getProperties()->setTitle("Office 2003 XLSX Test Document");		//标题			
			$objPHPExcel->getProperties()->setSubject("Office 2003 XLSX Test Document");	//题目			
			$objPHPExcel->getProperties()->setDescription("Test document for Office 2003 XLSX.");	//描述			
			$objPHPExcel->getProperties()->setKeywords("office 2003 openxml php");		//关键字			
			$objPHPExcel->getProperties()->setCategory("Test result file");				//种类
			$objPHPExcel->setActiveSheetIndex(0);	
			//设置excel的文件名
			//设置sheet的name
			$objPHPExcel->getActiveSheet()->setTitle($name);
			//设置列宽为自动
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10); 
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6); 
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(18);
			//标题-------------------------------------------------------------------------------
			foreach ($title as $k=>$v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k."1", $v);
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->getStartColor()->setARGB('FFDFEDF7');
			}
			//内容-------------------------------------------------------------------------------
			foreach ($data as $k=>$v) {
			
				$k=$k+2;
				$objPHPExcel->getActiveSheet()->setCellValue("A".$k, strval($v['userbianhao']));
				$objPHPExcel->getActiveSheet()->setCellValue("B".$k, $v['username']);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$k, $v['sex']);
				$objPHPExcel->getActiveSheet()->setCellValue("D".$k, $v['sphone']);
				$objPHPExcel->getActiveSheet()->setCellValue("E".$k, $v['qq']);
				$objPHPExcel->getActiveSheet()->setCellValue("F".$k, $v['address']);
				$objPHPExcel->getActiveSheet()->setCellValue("G".$k, " ".$v['id_number']);
				$objPHPExcel->getActiveSheet()->setCellValue("H".$k, $v['ruzhi_name']);
				$objPHPExcel->getActiveSheet()->setCellValue("I".$k, $v['bank'].' '.$v['subbranch']);
				$objPHPExcel->getActiveSheet()->setCellValue("J".$k, " ".$v['bank_account']);
				$objPHPExcel->getActiveSheet()->setCellValue("K".$k, $v['tjmoney']);
				$objPHPExcel->getActiveSheet()->getStyle("L".$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle("L".$k)->getFill()->getStartColor()->setARGB('FFFF3030');
				$objPHPExcel->getActiveSheet()->setCellValue("L".$k, $v['txmoney']);
				$objPHPExcel->getActiveSheet()->setCellValue("M".$k, $v['cyjiangjin']);
				if($v['txzhuangtai']==1){	
					$txzhuangtai='未审核';	
					$objPHPExcel->getActiveSheet()->getStyle("N".$k)->getFont()->getColor()->setARGB('FF000000');
				}elseif($v['txzhuangtai']==2){	
					$txzhuangtai='审核成功';
					$objPHPExcel->getActiveSheet()->getStyle("N".$k)->getFont()->getColor()->setARGB('FF008000');
				}elseif($v['txzhuangtai']==3){	
					$txzhuangtai='审核失败';
					$objPHPExcel->getActiveSheet()->getStyle("N".$k)->getFont()->getColor()->setARGB('FFFF3030');
				}
				$objPHPExcel->getActiveSheet()->setCellValue("N".$k, $txzhuangtai);
				$objPHPExcel->getActiveSheet()->setCellValue("O".$k, date('Y-m-d H:i:s',$v['add_time']));
				if($v['fafangzhangtai']==1){	
					$fafangzhangtai='未支付';
					$objPHPExcel->getActiveSheet()->getStyle("P".$k)->getFont()->getColor()->setARGB('FF000000');
				}elseif($v['fafangzhangtai']==2){	
					$fafangzhangtai='支付成功';	
					$objPHPExcel->getActiveSheet()->getStyle("P".$k)->getFont()->getColor()->setARGB('FF008000');
				}elseif($v['fafangzhangtai']==3){	
					$fafangzhangtai='支付失败';	
					$objPHPExcel->getActiveSheet()->getStyle("P".$k)->getFont()->getColor()->setARGB('FFFF3030');
				}
				
				$objPHPExcel->getActiveSheet()->setCellValue("P".$k, $fafangzhangtai);
				if($v['fafang_time']!=0){ $fafang_time=date('Y-m-d H:i:s',$v['fafang_time']); }
				$objPHPExcel->getActiveSheet()->setCellValue("Q".$k, $fafang_time);
				
				//$objFontA5->getColor()->setARGB('FF999999');/
				//$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			}
			//直接输出到浏览器
			$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
			header("Content-Type:application/force-download");
			header("Content-Type:application/vnd.ms-execl");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");
			header('Content-Disposition:attachment;filename="'.$name.'.xls"');
			header("Content-Transfer-Encoding:binary");
			$objWriter->save('php://output');
		}
		//-----------------------------------------
		
	}