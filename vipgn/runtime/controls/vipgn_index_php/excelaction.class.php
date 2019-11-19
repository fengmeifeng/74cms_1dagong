<?php
	class ExcelAction extends Common {
		function index(){
			

		}
		//所有报名人员信息导出Excel
		function bmxx_all(){
		// echo '11';exit;
/* 		$cfg_dbhost = '192.168.3.246';
		$cfg_dbname_1 = 'demo';
		$cfg_dbuser = '1jobstest';
		$cfg_dbpwd = 'shenbo@123';
		$link1  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd );
		$db_selected1  =  mysql_select_db ( $cfg_dbname_1 ,  $link1 );
		$query="select * from qs_baoming where status=1";
		$result1=mysql_query($query,$link1);
		$data  =  mysql_fetch_array ( $result1 );
		var_dump($data);exit; */
			$bm=D("qs_baoming");
			$data=$bm->select();
			// var_dump($data);exit;
			$title = array("A"=>"姓名",
						   "B"=>"性别",
						   "C"=>"身份证号",
						   "D"=>"报考职位",
						   "E"=>"联系电话",
						   "F"=>"政治面貌",
						   "G"=>"户籍所在地",
						   "H"=>"档案所在地",
						   "I"=>"学历",
						   "J"=>"学历性质",
						   "K"=>"毕业院校",
						   "L"=>"专业",
						   "M"=>"毕业时间",
						   "N"=>"出生日期",
						   "O"=>"审核状态",
						   "P"=>"身份证正面",
						   "Q"=>"身份证反面",
						   "R"=>"证件照",
							);
			$this->exl_bmxx_all($title,$data);
			
		}
		//所有报名人员信息，生成Excel--------------------------------------------------------------
		function exl_bmxx_all($title,$data){
		// echo '====';
		// var_dump($data);exit;
			include 'PHPExcel.php';
			include 'PHPExcel/Writer/Excel5.php'; 		//用于输出.xls的
			//创建一个excel
			$objPHPExcel = new PHPExcel();			
			//设置excel的属性：
			$objPHPExcel->getProperties()->setCreator("1dagong.com");				//创建人
			$objPHPExcel->getProperties()->setLastModifiedBy("1dagong.com");		//最后修改人
			$objPHPExcel->getProperties()->setTitle("Office 2003 XLSX Test Document");		//标题			
			$objPHPExcel->getProperties()->setSubject("Office 2003 XLSX Test Document");	//题目			
			$objPHPExcel->getProperties()->setDescription("Test document for Office 2003 XLSX.");	//描述			
			$objPHPExcel->getProperties()->setKeywords("office 2003 openxml php");		//关键字			
			$objPHPExcel->getProperties()->setCategory("Test result file");				//种类
			$objPHPExcel->setActiveSheetIndex(0);	
			//设置excel的文件名
			//$name=date('Y-m-d',$na[0]['holddates'])."-".$na[0]['title'];
			$name="000";
			//设置sheet的name
			$objPHPExcel->getActiveSheet()->setTitle($this->convertUTF8($name));
			// $objPHPExcel->getActiveSheet()->setCellValueExplicit('C', '847475847857487584',PHPExcel_Cell_DataType::TYPE_STRING);
			//设置列宽为自动
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(45);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(45);
			$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(45);
			//标题-------------------------------------------------------------------------------
			foreach ($title as $k=>$v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k."1", $this->convertUTF8($v));
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->getStartColor()->setARGB('FFDFEDF7');
			}
			//内容-------------------------------------------------------------------------------
			foreach ($data as $k=>$v) {
				if($v['status'] == 0){
					$v['status'] = '未审核';
				}elseif($v['status'] == 1){
					$v['status'] = '审核通过';
				}elseif($v['status'] == 2){
					$v['status'] = '审核未通过';
				}
				$k=$k+2;
				$objPHPExcel->getActiveSheet()->setCellValue("A".$k, $this->convertUTF8($v['name']));
				$objPHPExcel->getActiveSheet()->setCellValue("B".$k, $this->convertUTF8($v['sex']));
				$objPHPExcel->getActiveSheet()->setCellValue("C".$k, " ".$this->convertUTF8(strval($v['identity_id'])));
				$objPHPExcel->getActiveSheet()->setCellValue("D".$k, $this->convertUTF8($v['baokao_job']));
				$objPHPExcel->getActiveSheet()->setCellValue("E".$k, $this->convertUTF8($v['phone1']));
				$objPHPExcel->getActiveSheet()->setCellValue("F".$k, $this->convertUTF8($v['politics']));
				$objPHPExcel->getActiveSheet()->setCellValue("G".$k, $this->convertUTF8($v['address']));
				$objPHPExcel->getActiveSheet()->setCellValue("H".$k, $this->convertUTF8($v['profile_add']));
				$objPHPExcel->getActiveSheet()->setCellValue("I".$k, $this->convertUTF8($v['education']));
				$objPHPExcel->getActiveSheet()->setCellValue("J".$k, $this->convertUTF8($v['edu_sta']));
				$objPHPExcel->getActiveSheet()->setCellValue("K".$k, $this->convertUTF8($v['graduate_school']));
				$objPHPExcel->getActiveSheet()->setCellValue("L".$k, $this->convertUTF8($v['specialty']));
				$objPHPExcel->getActiveSheet()->setCellValue("M".$k, $this->convertUTF8($v['graduate_time']));
				$objPHPExcel->getActiveSheet()->setCellValue("N".$k, $this->convertUTF8($v['birthday']));
				$objPHPExcel->getActiveSheet()->setCellValue("O".$k, $this->convertUTF8($v['status']));
				
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$k, $this->convertUTF8("点击查看正面"));
				$objPHPExcel->getActiveSheet()->getCell('P'.$k)->getHyperlink()->setUrl("http://www.1dagong.com/zt/hefeizhaomu/".$v['identity_up']);
				//$objPHPExcel->getActiveSheet()->setCellValue("P".$k, "http://www.1dagong.com/zt/hefeizhaomu/".$this->convertUTF8($v['identity_up']));
				
				
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$k, $this->convertUTF8("点击查看反面"));
				$objPHPExcel->getActiveSheet()->getCell('Q'.$k)->getHyperlink()->setUrl("http://www.1dagong.com/zt/hefeizhaomu/".$v['identity_down']);
				//$objPHPExcel->getActiveSheet()->setCellValue("Q".$k, "http://www.1dagong.com/zt/hefeizhaomu/".$this->convertUTF8($v['identity_down']));
				
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$k, $this->convertUTF8("点击查看证件照"));
				$objPHPExcel->getActiveSheet()->getCell('R'.$k)->getHyperlink()->setUrl("http://www.1dagong.com/zt/hefeizhaomu/".$v['photo']);
				//$objPHPExcel->getActiveSheet()->setCellValue("R".$k, "http://www.1dagong.com/zt/hefeizhaomu/".$this->convertUTF8($v['photo']));
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
		//审核通过的报名信息导出Excel
		function bmxx(){
/* 		$cfg_dbhost = '192.168.3.246';
		$cfg_dbname_1 = 'demo';
		$cfg_dbuser = '1jobstest';
		$cfg_dbpwd = 'shenbo@123';
		$link1  =  mysql_connect ( $cfg_dbhost, $cfg_dbuser, $cfg_dbpwd );
		$db_selected1  =  mysql_select_db ( $cfg_dbname_1 ,  $link1 );
		$query="select * from qs_baoming where status=1";
		$result1=mysql_query($query,$link1);
		$data  =  mysql_fetch_array ( $result1 );
		var_dump($data);exit; */
			$bm=D("qs_baoming");
			$data=$bm->where(array("status"=>1))->order("id asc")->select();
			// var_dump($data);
			$title = array("A"=>"姓名",
						   "B"=>"性别",
						   "C"=>"身份证号",
						   "D"=>"报考职位",
						   "E"=>"联系电话",
						   "F"=>"政治面貌",
						   "G"=>"户籍所在地",
						   "H"=>"档案所在地",
						   "I"=>"学历",
						   "J"=>"学历性质",
						   "K"=>"毕业院校",
						   "L"=>"专业",
						   "M"=>"毕业时间",
						   "N"=>"出生日期",
						   "O"=>"身份证正面",
						   "P"=>"身份证反面",
						   "Q"=>"证件照",
							);
			$this->exl_bmxx($title,$data);
			
		}
		//审核通过的报名信息，生成Excel--------------------------------------------------------------
		function exl_bmxx($title,$data){
		// echo '====';
		// var_dump($data);exit;
			include 'PHPExcel.php';
			include 'PHPExcel/Writer/Excel5.php'; 		//用于输出.xls的
			//创建一个excel
			$objPHPExcel = new PHPExcel();			
			//设置excel的属性：
			$objPHPExcel->getProperties()->setCreator("1dagong.com");				//创建人
			$objPHPExcel->getProperties()->setLastModifiedBy("1dagong.com");		//最后修改人
			$objPHPExcel->getProperties()->setTitle("Office 2003 XLSX Test Document");		//标题			
			$objPHPExcel->getProperties()->setSubject("Office 2003 XLSX Test Document");	//题目			
			$objPHPExcel->getProperties()->setDescription("Test document for Office 2003 XLSX.");	//描述			
			$objPHPExcel->getProperties()->setKeywords("office 2003 openxml php");		//关键字			
			$objPHPExcel->getProperties()->setCategory("Test result file");				//种类
			$objPHPExcel->setActiveSheetIndex(0);	
			//设置excel的文件名
			//$name=date('Y-m-d',$na[0]['holddates'])."-".$na[0]['title'];
			$name="000";
			//设置sheet的name
			$objPHPExcel->getActiveSheet()->setTitle($this->convertUTF8($name));
			// $objPHPExcel->getActiveSheet()->setCellValueExplicit('C', '847475847857487584',PHPExcel_Cell_DataType::TYPE_STRING);
			//设置列宽为自动
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(45);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(45);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(45);
			//标题-------------------------------------------------------------------------------
			foreach ($title as $k=>$v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k."1", $this->convertUTF8($v));
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->getStartColor()->setARGB('FFDFEDF7');
			}
			//内容-------------------------------------------------------------------------------
			foreach ($data as $k=>$v) {
				$k=$k+2;
				$objPHPExcel->getActiveSheet()->setCellValue("A".$k, $this->convertUTF8($v['name']));
				$objPHPExcel->getActiveSheet()->setCellValue("B".$k, $this->convertUTF8($v['sex']));
				$objPHPExcel->getActiveSheet()->setCellValue("C".$k, " ".$this->convertUTF8(strval($v['identity_id'])));
				$objPHPExcel->getActiveSheet()->setCellValue("D".$k, $this->convertUTF8($v['baokao_job']));
				$objPHPExcel->getActiveSheet()->setCellValue("E".$k, $this->convertUTF8($v['phone1']));
				$objPHPExcel->getActiveSheet()->setCellValue("F".$k, $this->convertUTF8($v['politics']));
				$objPHPExcel->getActiveSheet()->setCellValue("G".$k, $this->convertUTF8($v['address']));
				$objPHPExcel->getActiveSheet()->setCellValue("H".$k, $this->convertUTF8($v['profile_add']));
				$objPHPExcel->getActiveSheet()->setCellValue("I".$k, $this->convertUTF8($v['education']));
				$objPHPExcel->getActiveSheet()->setCellValue("J".$k, $this->convertUTF8($v['edu_sta']));
				$objPHPExcel->getActiveSheet()->setCellValue("K".$k, $this->convertUTF8($v['graduate_school']));
				$objPHPExcel->getActiveSheet()->setCellValue("L".$k, $this->convertUTF8($v['specialty']));
				$objPHPExcel->getActiveSheet()->setCellValue("M".$k, $this->convertUTF8($v['graduate_time']));
				$objPHPExcel->getActiveSheet()->setCellValue("N".$k, $this->convertUTF8($v['birthday']));
				
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$k, $this->convertUTF8("点击查看正面"));
				$objPHPExcel->getActiveSheet()->getCell('O'.$k)->getHyperlink()->setUrl("http://www.1dagong.com/zt/hefeizhaomu/".$v['identity_up']);

				$objPHPExcel->getActiveSheet()->setCellValue('P'.$k, $this->convertUTF8("点击查看反面"));
				$objPHPExcel->getActiveSheet()->getCell('P'.$k)->getHyperlink()->setUrl("http://www.1dagong.com/zt/hefeizhaomu/".$v['identity_down']);
				// $objPHPExcel->getActiveSheet()->getCell('P')->getHyperlink()->setTooltip('Navigate to website');
				// $objPHPExcel->getActiveSheet()->getStyle('P')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$k, $this->convertUTF8("点击查看证件照"));
				$objPHPExcel->getActiveSheet()->getCell('Q'.$k)->getHyperlink()->setUrl("http://www.1dagong.com/zt/hefeizhaomu/".$v['photo']);
				// $objPHPExcel->getActiveSheet()->getCell('Q')->getHyperlink()->setTooltip('Navigate to website');
				// $objPHPExcel->getActiveSheet()->getStyle('Q')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
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
		//参会企业名单导出Excel
		function zhqy(){
			if(!empty($_GET['zhid'])){
				$zhid=$_GET['zhid'];
				$Zhanhui=D("vip_zhanhui");
				$data=$Zhanhui->where(array("zid"=>$zhid))->order("number asc")->select();
				$site=D("qs_subsite")->field("s_id,s_districtname")->select();
				foreach($data as $i=>$v){
					$data[$i]['dq']="全站";
					foreach ($site as $k=>$s){
						if($s['s_id']==$data[$i]['subsite_id']){
							$data[$i]['dq']=$s['s_districtname'];
						}
					}
					//-------------------------------------------
					if($v['yhtype']==1){
						$data[$i]['yhtype']="套餐用户";
					}
					if($v['yhtype']==2){
						$data[$i]['yhtype']="积分用户";
					}
					if($v['yhtype']==3){
						$data[$i]['yhtype']="临时用户";
					}
					//-------------------------------------------
					if($v['online_aoto']==1){
						$data[$i]['online_aoto']="自动预定";
					}
					if($v['online_aoto']==2){
						$data[$i]['online_aoto']="在线预定";
					}
					if($v['online_aoto']==3){
						$data[$i]['online_aoto']="手动添加";
					}
					//--------------------------------------------
				}

				$name=D("qs_jobfair")->field("id,title,holddates")->where(array("id"=>$zhid))->select();
							 
				$title=array("A"=>"展位号",
							 "B"=>"企业用户名",
							 "C"=>"企业公司名",
							 "D"=>"销售代表",
							 "E"=>"地区",
							 "F"=>"企业qq",
							 "G"=>"企业电话",
							 "H"=>"企业邮箱",
							 "I"=>"用户类型",
							 "J"=>"预定方式",
							 "K"=>"预定时间",
							 "L"=>"备注",
							 );
				
				$this->exlzh($name,$title,$data);
			}		
		}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
		//年费套餐导出Excel
		function nftcyh(){
			$a=D("vip_user");
			$b=D("vip_zt");
			//$sql='select vip_zt.id,vip_zt.uid,vip_user.qid,vip_zt.subsite_id,username,title,xs_user,qq,phone,email,activation,type,duration,bout,number,add_time,end_time from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="1" ';
			$sql='select vip_zt.id,vip_zt.uid,vip_user.qid,vip_zt.subsite_id,username,title,xs_user,phone,email,activation,type,duration,bout,number,add_time,end_time from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="1" ';
			$data=$a->query($sql,"select");
			$site=D("qs_subsite")->field("s_id,s_districtname")->select();
			foreach($data as $i=>$v){
				$data[$i]['dq']="全站";
				foreach ($site as $k=>$s){
					if($s['s_id']==$data[$i]['subsite_id']){
						$data[$i]['dq']=$s['s_districtname'];
					}
				}
				if($v['type']==1){
					$data[$i]['type']="时间套餐";
				}
				if($v['xs_user'] =="" || empty($v['xs_user'])){
					$data[$i]['xs_user']="无";
				}
				if($v['duration']==1){
					$data[$i]['duration']="一年套餐(十二个月)";
				}
				if($v['duration']==2){
					$data[$i]['duration']="半年套餐(六个月)";
				}
				if($v['duration']==3){
					$data[$i]['duration']="一季套餐(三个月)";
				}
				if($v['activation']==0){
					$data[$i]['activation']="未激活";
				}
				if($v['activation']==1){
					$data[$i]['activation']="已激活";
				}
				if($v['activation']==3){
					$data[$i]['activation']="已过期";
				}
			}
			//p($data);
			$name="时间套餐 ".date('Y-m-d',time());

			$title=array("A"=>"企业用户名",
						 "B"=>"企业公司名",
						 "C"=>"销售代表",
						 "D"=>"地区",
						 "E"=>"套餐类型",
						 "F"=>"展位号",
						 "G"=>"套餐时长",
						 "H"=>"结束时间",
						 "I"=>"套餐是否激活",
						 "J"=>"企业电话",
						 "K"=>"企业邮箱",
						 "L"=>"添加时间",
						);	
			$this->exlnf($name,$title,$data);
		}
		//办理年费套餐的企业，生成Excel---------------------------------------------------------
		function exlnf($name,$title,$data){
			include 'PHPExcel.php';
			include 'PHPExcel/Writer/Excel5.php'; 		//用于输出.xls的
			//创建一个excel
			$objPHPExcel = new PHPExcel();			
			//设置excel的属性：
			$objPHPExcel->getProperties()->setCreator("1jobs.com");				//创建人
			$objPHPExcel->getProperties()->setLastModifiedBy("1jobs.com");		//最后修改人
			$objPHPExcel->getProperties()->setTitle("Office 2003 XLSX Test Document");		//标题			
			$objPHPExcel->getProperties()->setSubject("Office 2003 XLSX Test Document");	//题目			
			$objPHPExcel->getProperties()->setDescription("Test document for Office 2003 XLSX.");	//描述			
			$objPHPExcel->getProperties()->setKeywords("office 2003 openxml php");		//关键字			
			$objPHPExcel->getProperties()->setCategory("Test result file");				//种类
			$objPHPExcel->setActiveSheetIndex(0);	
			//设置excel的文件名
			//设置sheet的name
			$objPHPExcel->getActiveSheet()->setTitle($this->convertUTF8($name));
			//设置列宽为自动
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40); 
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10); 
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
			//标题-------------------------------------------------------------------------------
			foreach ($title as $k=>$v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k."1", $this->convertUTF8($v));
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->getStartColor()->setARGB('FFDFEDF7');
			}
			//内容-------------------------------------------------------------------------------
			foreach ($data as $k=>$v) {
				$k=$k+2;
				$objPHPExcel->getActiveSheet()->setCellValue("A".$k, $this->convertUTF8(strval($v['username'])));
				$objPHPExcel->getActiveSheet()->setCellValue("B".$k, $this->convertUTF8($v['title']));
				$objPHPExcel->getActiveSheet()->setCellValue("C".$k, $this->convertUTF8($v['xs_user']));
				$objPHPExcel->getActiveSheet()->setCellValue("D".$k, $this->convertUTF8($v['dq']));
				$objPHPExcel->getActiveSheet()->setCellValue("E".$k, $this->convertUTF8($v['type']));
				$objPHPExcel->getActiveSheet()->setCellValue("F".$k, " ".$this->convertUTF8($v['number']));
				$objPHPExcel->getActiveSheet()->setCellValue("G".$k, $this->convertUTF8($v['duration']));
				$objPHPExcel->getActiveSheet()->setCellValue("H".$k, $this->convertUTF8(date('Y-m-d H:i:s',$v['end_time'])));
				$objPHPExcel->getActiveSheet()->setCellValue("I".$k, $this->convertUTF8($v['activation']));//--fff--qq修改成--activation
				$objPHPExcel->getActiveSheet()->setCellValue("J".$k, $this->convertUTF8($v['phone']));
				$objPHPExcel->getActiveSheet()->setCellValue("K".$k, $this->convertUTF8($v['email']));
				$objPHPExcel->getActiveSheet()->setCellValue("L".$k, $this->convertUTF8(date('Y-m-d H:i:s',$v['add_time'])));
			
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
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/		
		//次数套餐导出Excel
		function cstcyh(){
			$a=D("vip_user");
			$b=D("vip_zt");
			//$sql='select vip_zt.id,vip_zt.uid,vip_user.qid,vip_zt.subsite_id,username,title,xs_user,qq,phone,email,activation,type,duration,bout,number,add_time,end_time from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="0" ';
			$sql='select vip_zt.id,vip_zt.uid,vip_user.qid,vip_zt.subsite_id,username,cs_ks_time,cs_end_time,title,xs_user,phone,email,activation,type,duration,bout,number,add_time,end_time from vip_user right join vip_zt on vip_zt.uid = vip_user.id where type="0" ';
			$data=$a->query($sql,"select");
			$site=D("qs_subsite")->field("s_id,s_districtname")->select();
			foreach($data as $i=>$v){
				$data[$i]['dq']="全站";
				foreach ($site as $k=>$s){
					if($s['s_id']==$data[$i]['subsite_id']){
						$data[$i]['dq']=$s['s_districtname'];
					}
				}
				if($v['type']==0){
					$data[$i]['type']="次数套餐";
				}
				if($v['xs_user'] =="" || empty($v['xs_user'])){
					$data[$i]['xs_user']="无";
				}
				if($v['activation'] =="0"){
					$data[$i]['activation']="未激活";
				}
				if($v['activation'] =="1"){
					$data[$i]['activation']="已激活";
				}
				if($v['activation'] =="3"){
					$data[$i]['activation']="已过期";
				}
					
			}
			//p($data);

			$name="次数套餐 ".date('Y-m-d',time());

			$title=array("A"=>"企业用户名",
						 "B"=>"企业公司名",
						 "C"=>"销售代表",
						 "D"=>"地区",
						 "E"=>"套餐类型",
						 "F"=>"剩余次数",
						 "G"=>"开始时长",
						 "H"=>"结束时间",
						 "I"=>"套餐是否激活",//---企业网qq---修改城---套餐是否激活
						 "J"=>"企业电话",
						 "K"=>"企业邮箱",
						 "L"=>"添加时间",
						);

			$this->exlcs($name,$title,$data);
		}
		//次数套餐用户，生成Excel----------------------------------------------------------------
		function exlcs($name,$title,$data){
			include 'PHPExcel.php';
			include 'PHPExcel/Writer/Excel5.php'; 		//用于输出.xls的
			//创建一个excel
			$objPHPExcel = new PHPExcel();			
			//设置excel的属性：
			$objPHPExcel->getProperties()->setCreator("1jobs.com");				//创建人
			$objPHPExcel->getProperties()->setLastModifiedBy("1jobs.com");		//最后修改人
			$objPHPExcel->getProperties()->setTitle("Office 2003 XLSX Test Document");		//标题			
			$objPHPExcel->getProperties()->setSubject("Office 2003 XLSX Test Document");	//题目			
			$objPHPExcel->getProperties()->setDescription("Test document for Office 2003 XLSX.");	//描述			
			$objPHPExcel->getProperties()->setKeywords("office 2003 openxml php");		//关键字			
			$objPHPExcel->getProperties()->setCategory("Test result file");				//种类
			$objPHPExcel->setActiveSheetIndex(0);	
			//设置excel的文件名
			//设置sheet的name
			$objPHPExcel->getActiveSheet()->setTitle($this->convertUTF8($name));
			//设置列宽为自动
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40); 
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10); 
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
			//标题-------------------------------------------------------------------------------
			foreach ($title as $k=>$v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k."1", $this->convertUTF8($v));
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->getStartColor()->setARGB('FFDFEDF7');
			}
			//内容-------------------------------------------------------------------------------
			foreach ($data as $k=>$v) {
				$k=$k+2;
				$objPHPExcel->getActiveSheet()->setCellValue("A".$k, $this->convertUTF8(strval($v['username'])));
				$objPHPExcel->getActiveSheet()->setCellValue("B".$k, $this->convertUTF8($v['title']));
				$objPHPExcel->getActiveSheet()->setCellValue("C".$k, $this->convertUTF8($v['xs_user']));
				$objPHPExcel->getActiveSheet()->setCellValue("D".$k, $this->convertUTF8($v['dq']));
				$objPHPExcel->getActiveSheet()->setCellValue("E".$k, $this->convertUTF8($v['type']));
				$objPHPExcel->getActiveSheet()->setCellValue("F".$k, $this->convertUTF8($v['bout']));
				$objPHPExcel->getActiveSheet()->setCellValue("G".$k, $this->convertUTF8(date('Y-m-d H:i:s',$v['cs_ks_time'])));
				$objPHPExcel->getActiveSheet()->setCellValue("H".$k, $this->convertUTF8(date('Y-m-d H:i:s',$v['cs_end_time'])));
				$objPHPExcel->getActiveSheet()->setCellValue("I".$k, $this->convertUTF8($v['activation']));//-----企业qq---修改成---是否激活
				$objPHPExcel->getActiveSheet()->setCellValue("J".$k, $this->convertUTF8($v['phone']));
				$objPHPExcel->getActiveSheet()->setCellValue("K".$k, $this->convertUTF8($v['email']));
				$objPHPExcel->getActiveSheet()->setCellValue("L".$k, $this->convertUTF8(date('Y-m-d H:i:s',$v['add_time'])));
			
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
		
		//参加展会的企业，生成Excel--------------------------------------------------------------
		function exlzh($na,$title,$data){
			include 'PHPExcel.php';
			include 'PHPExcel/Writer/Excel5.php'; 		//用于输出.xls的
			//创建一个excel
			$objPHPExcel = new PHPExcel();			
			//设置excel的属性：
			$objPHPExcel->getProperties()->setCreator("1jobs.com");				//创建人
			$objPHPExcel->getProperties()->setLastModifiedBy("1jobs.com");		//最后修改人
			$objPHPExcel->getProperties()->setTitle("Office 2003 XLSX Test Document");		//标题			
			$objPHPExcel->getProperties()->setSubject("Office 2003 XLSX Test Document");	//题目			
			$objPHPExcel->getProperties()->setDescription("Test document for Office 2003 XLSX.");	//描述			
			$objPHPExcel->getProperties()->setKeywords("office 2003 openxml php");		//关键字			
			$objPHPExcel->getProperties()->setCategory("Test result file");				//种类
			$objPHPExcel->setActiveSheetIndex(0);	
			//设置excel的文件名
			//$name=date('Y-m-d',$na[0]['holddates'])."-".$na[0]['title'];
			$name="000";
			//设置sheet的name
			$objPHPExcel->getActiveSheet()->setTitle($this->convertUTF8($name));
			//设置列宽为自动
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(22);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
			//标题-------------------------------------------------------------------------------
			foreach ($title as $k=>$v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k."1", $this->convertUTF8($v));
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->getStartColor()->setARGB('FFDFEDF7');
			}
			//内容-------------------------------------------------------------------------------
			foreach ($data as $k=>$v) {
				$k=$k+2;
				$objPHPExcel->getActiveSheet()->setCellValue("A".$k, " ".$this->convertUTF8(strval($v['number'])));
				$objPHPExcel->getActiveSheet()->setCellValue("B".$k, $this->convertUTF8($v['username']));
				$objPHPExcel->getActiveSheet()->setCellValue("C".$k, $this->convertUTF8($v['title']));
				$objPHPExcel->getActiveSheet()->setCellValue("D".$k, $this->convertUTF8($v['xs_user']));
				$objPHPExcel->getActiveSheet()->setCellValue("E".$k, $this->convertUTF8($v['dq']));
				$objPHPExcel->getActiveSheet()->setCellValue("F".$k, $this->convertUTF8($v['qq']));
				$objPHPExcel->getActiveSheet()->setCellValue("G".$k, $this->convertUTF8($v['phone']));
				$objPHPExcel->getActiveSheet()->setCellValue("H".$k, $this->convertUTF8($v['email']));
				$objPHPExcel->getActiveSheet()->setCellValue("I".$k, $this->convertUTF8($v['yhtype']));
				$objPHPExcel->getActiveSheet()->setCellValue("J".$k, $this->convertUTF8($v['online_aoto']));
				$objPHPExcel->getActiveSheet()->setCellValue("K".$k, $this->convertUTF8(date('Y-m-d H:i:s',$v['add_time'])));
				$objPHPExcel->getActiveSheet()->setCellValue("L".$k, $this->convertUTF8($v['text']));
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
		//------------------------------------------------------------------------------
		function user(){
			$user=D("vip_user");
			$data=$user->select();
			$site=D("qs_subsite")->field("s_id,s_districtname")->select();
			foreach($data as $i=>$v){
				$data[$i]['dq']="全站";
				foreach ($site as $k=>$s){
					if($s['s_id']==$data[$i]['subsite_id']){
						$data[$i]['dq']=$s['s_districtname'];
					}
				}
				if($v['bl']==0){
					$data[$i]['bl']="未办理任何套餐";
				}
				if($v['bl']==1){
					$data[$i]['bl']="以办理套餐";
				}
			}
			//p($data);
			$name="企业用户 ".date('Y-m-d',time());

			$title=array("A"=>"企业用户名",
						 "B"=>"企业公司名",
						 "C"=>"销售代表",
						 "D"=>"地区",
						 "E"=>"企业qq",
						 "F"=>"企业电话",
						 "G"=>"企业邮箱",
						 "H"=>"是否办理套餐",
						 "I"=>"添加时间",
						);

			$this->exluser($name,$title,$data);
		}
		//user用户，生成Excel------------------------------------------------------
		function exluser($name,$title,$data){
			include 'PHPExcel.php';
			include 'PHPExcel/Writer/Excel5.php'; 		//用于输出.xls的
			//创建一个excel
			$objPHPExcel = new PHPExcel();			
			//设置excel的属性：
			$objPHPExcel->getProperties()->setCreator("1jobs.com");				//创建人
			$objPHPExcel->getProperties()->setLastModifiedBy("1jobs.com");		//最后修改人
			$objPHPExcel->getProperties()->setTitle("Office 2003 XLSX Test Document");		//标题			
			$objPHPExcel->getProperties()->setSubject("Office 2003 XLSX Test Document");	//题目			
			$objPHPExcel->getProperties()->setDescription("Test document for Office 2003 XLSX.");	//描述			
			$objPHPExcel->getProperties()->setKeywords("office 2003 openxml php");		//关键字			
			$objPHPExcel->getProperties()->setCategory("Test result file");				//种类
			$objPHPExcel->setActiveSheetIndex(0);	
			//设置excel的文件名
			//设置sheet的name
			$objPHPExcel->getActiveSheet()->setTitle($this->convertUTF8($name));
			//设置列宽为自动
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(22);
			//标题-------------------------------------------------------------------------------
			foreach ($title as $k=>$v) {
				$objPHPExcel->getActiveSheet()->setCellValue($k."1", $this->convertUTF8($v));
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->getStartColor()->setARGB('FFDFEDF7');
			}
			//内容-------------------------------------------------------------------------------
			foreach ($data as $k=>$v) {
				$k=$k+2;
				$objPHPExcel->getActiveSheet()->setCellValue("A".$k, $this->convertUTF8($v['username']));
				$objPHPExcel->getActiveSheet()->setCellValue("B".$k, $this->convertUTF8($v['title']));
				$objPHPExcel->getActiveSheet()->setCellValue("C".$k, $this->convertUTF8($v['xs_user']));
				$objPHPExcel->getActiveSheet()->setCellValue("D".$k, $this->convertUTF8($v['dq']));
				$objPHPExcel->getActiveSheet()->setCellValue("E".$k, $this->convertUTF8($v['qq']));
				$objPHPExcel->getActiveSheet()->setCellValue("F".$k, $this->convertUTF8($v['phone']));
				$objPHPExcel->getActiveSheet()->setCellValue("G".$k, $this->convertUTF8($v['email']));
				$objPHPExcel->getActiveSheet()->setCellValue("H".$k, $this->convertUTF8($v['bl']));
				$objPHPExcel->getActiveSheet()->setCellValue("I".$k, $this->convertUTF8(date('Y-m-d H:i:s',$v['addtime'])));
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
		/*-------------------------------------------------------------------------*/
		//企业公司已近预定的展会整理数据
		function qyzhanghui(){
			if(!empty($_GET['id'])){
				$zid="select zid from vip_zhanhui where vip_zhanhui.qid=".$_GET['id'];
				$sql="select b.id,a.zid,a.qid,a.username,a.title,b.title as qytitle,a.xs_user,a.number,a.add_time,b.holddates,a.online_aoto,a.yhtype,a.subsite_id from vip_zhanhui as a left join qs_jobfair as b on a.zid=b.id where b.id in(".$zid.") and a.qid='".$_GET['id']."'";
				$data=D("qs_jobfair")->query($sql,"select");
				$site=D("qs_subsite")->field("s_id,s_districtname")->select();
					foreach($data as $i=>$v){
						$data[$i]['dq']="全站";
						foreach ($site as $k=>$s){
							if($s['s_id']==$data[$i]['subsite_id']){
								$data[$i]['dq']=$s['s_districtname'];
							}
						}
						//-------------------------------------------
						if($v['yhtype']==1){
							$data[$i]['yhtype']="套餐用户";
						}
						if($v['yhtype']==2){
							$data[$i]['yhtype']="积分用户";
						}
						if($v['yhtype']==3){
							$data[$i]['yhtype']="临时用户";
						}
						//-------------------------------------------
						if($v['online_aoto']==1){
							$data[$i]['online_aoto']="自动预定";
						}
						if($v['online_aoto']==2){
							$data[$i]['online_aoto']="在线预定";
						}
						if($v['online_aoto']==3){
							$data[$i]['online_aoto']="手动添加";
						}
						//--------------------------------------------
					}
				//p($data);
				$name=$data[0]['title']."-".date('Y-m-d',time());
							 
				$title=array("A"=>"招聘会标题",
							 "B"=>"举办时间",
							 "C"=>"企业公司名",
							 "D"=>"销售代表",
							 "E"=>"地区",
							 "F"=>"展位号",
							 "G"=>"用户类型",
							 "H"=>"预定方式",
							 "I"=>"预定时间"
							 );
				
				$this->exzh($name,$title,$data);
				}
			}
			//企业公司已近预定的展会的数据生成Excel
			function exzh($name,$title,$data){
					include 'PHPExcel.php';
					include 'PHPExcel/Writer/Excel5.php'; 		//用于输出.xls的
					//创建一个excel
					$objPHPExcel = new PHPExcel();			
					//设置excel的属性：
					$objPHPExcel->getProperties()->setCreator("1jobs.com");				//创建人
					$objPHPExcel->getProperties()->setLastModifiedBy("1jobs.com");		//最后修改人
					$objPHPExcel->getProperties()->setTitle("Office 2003 XLSX Test Document");		//标题			
					$objPHPExcel->getProperties()->setSubject("Office 2003 XLSX Test Document");	//题目			
					$objPHPExcel->getProperties()->setDescription("Test document for Office 2003 XLSX.");	//描述			
					$objPHPExcel->getProperties()->setKeywords("office 2003 openxml php");		//关键字			
					$objPHPExcel->getProperties()->setCategory("Test result file");				//种类
					$objPHPExcel->setActiveSheetIndex(0);	
					//设置excel的文件名
					//设置sheet的name
					$objPHPExcel->getActiveSheet()->setTitle($this->convertUTF8($name));
					//设置列宽为自动
					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(45);
					$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
					$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
					$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
					$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
					$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
					$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
					$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
					$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(22);
					//标题-------------------------------------------------------------------------------
					foreach ($title as $k=>$v) {
						$objPHPExcel->getActiveSheet()->setCellValue($k."1", $this->convertUTF8($v));
						$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle($k."1")->getFill()->getStartColor()->setARGB('FFDFEDF7');
					}
					//内容-------------------------------------------------------------------------------
					foreach ($data as $k=>$v) {
						$k=$k+2;
						$objPHPExcel->getActiveSheet()->setCellValue("A".$k, $this->convertUTF8($v['qytitle']));
						$objPHPExcel->getActiveSheet()->setCellValue("B".$k, $this->convertUTF8(date('Y-m-d',$v['holddates'])));
						$objPHPExcel->getActiveSheet()->setCellValue("C".$k, $this->convertUTF8($v['title']));
						$objPHPExcel->getActiveSheet()->setCellValue("D".$k, $this->convertUTF8($v['xs_user']));
						$objPHPExcel->getActiveSheet()->setCellValue("E".$k, $this->convertUTF8($v['dq']));
						$objPHPExcel->getActiveSheet()->setCellValue("F".$k, " ".$this->convertUTF8($v['number']));
						$objPHPExcel->getActiveSheet()->setCellValue("G".$k, $this->convertUTF8($v['yhtype']));
						$objPHPExcel->getActiveSheet()->setCellValue("H".$k, $this->convertUTF8($v['online_aoto']));
						$objPHPExcel->getActiveSheet()->setCellValue("I".$k, $this->convertUTF8(date('Y-m-d H:i:s',$v['add_time'])));
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
		/*-------------------------------------------------------------------------*/
		//转码函数------------------------------------------------------------------
 		function convertUTF8($str){
		   if(empty($str)) return '';
		   return  iconv('gb2312', 'utf-8', $str);
		}

}