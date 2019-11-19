<?php
class tj extends Action{
	//登录页面模版
	function index(){
		if(!empty($_GET['bh'])){
			$bh=base64_decode($_GET['bh']);
			$data=D("tuijian")->where(array("bianhao"=>$bh))->select();
			if(!empty($data)){
				$bianhao="s".rand(100000,999999);
				//使用死循环防止纯在重复的随机数
				$i=1;
				while($i){
					$data=D("tuijian")->where(array("bianhao"=>$bianhao))->select();
					if(!empty($data)){
						$bianhao="s".rand(100000,999999);
						$i=1;
					}else{
						break;
					}
				}
				$this->assign('bianhao',$bianhao);
				$gx=D('guanxi')->select();	//关系
				$this->assign('guanxi',$gx);
				$this->assign('tuijianbianhao',$_GET['bh']);
				$this->display();
			}else{
				$this->errorbb('链接有误，正在为你跳转到壹打工首页', 2, "http://www.1dagong.com");
			}
		}else{
			$this->errorbb('链接有误，正在为你跳转到壹打工首页', 1, "http://www.1dagong.com");
		}
	}
	
	//注册推荐
	function zhucetuijian(){
		if(!empty($_POST)){
			$_POST['tuijianbiaohao']=base64_decode($_POST['tuijianbiaohao']);
			
			if($_POST['guanxi']==''){
				$this->error('推荐关系未选择！', 1);
			}
			
			if($_POST['name']!='' && $_POST['sphone']!='' && $_POST['id_number']){
				$data=D("tuijian")->where(array("sphone"=>$_POST['sphone']),array("id_number"=>$_POST['id_number']))->find();
			}else{
				$this->error('姓名，手机号和身份证号必须填写！', 1);
			}

			if(empty($data)){
				if($_POST['tuijianbiaohao']!=''){
					//存在
					$user=D("tuijian")->where(array("bianhao"=>$_POST['tuijianbiaohao']))->find();	
					$m=substr_count($user['path'],",");
					if($m <= 2){ $_POST['jibie']="2"; }else{ $_POST['jibie']="3"; }
					$_POST['add_time']=time();
					$_POST['f_bianghao']=$user['bianhao'];
					$_POST['pid']=$user['id'];
					$_POST['path']=$user['path'].$user['id'].',';
					$id=D("tuijian")->insert();
				}
			}else{
				$this->error('这个人已经被推荐了', 1);
			}
			
			if($id > 0){
				$this->success("注册用户成功！", 1);        
			}else{
				$this->error("注册用户失败！", 1);
			}
		}
	}
	
	
	//导入数据
	function daorushuju(){
		/*
		id			id
		hyname		姓名
		hynumber	编号
		hytjnumber	推荐者编号
		hytjid		推荐者id
		
		hyqqmsn		qq字段
		hycardno	身份证号码
		hytel		电话号码
		hyaddress	详细地址
		hybirth		生日
		hysex		性别
		
		addtime		添加时间
		ruzhitime	入职时间
		ruzhidanwei	入职企业
		
		*/
		
		echo
		"导入数据<br/>
				/dr/1	<a href='".$GLOBALS["url"]."daorushuju/dr/1/sjc/".time()."'>呼叫中心</a><br>
				/dr/2	<a href='".$GLOBALS["url"]."daorushuju/dr/2/sjc/".time()."'>合肥申博</a><br>
				/dr/3	<a href='".$GLOBALS["url"]."daorushuju/dr/3/sjc/".time()."'>常熟</a><br>
				/dr/4	<a href='".$GLOBALS["url"]."daorushuju/dr/4/sjc/".time()."'>仙桃</a><br>
				
				/dr/5	<a href='".$GLOBALS["url"]."daorushuju/dr/5/sjc/".time()."'>上海</a><br>
				/dr/6	<a href='".$GLOBALS["url"]."daorushuju/dr/6/sjc/".time()."'>重庆</a><br>
				
				/dr/dj	<a href='".$GLOBALS["url"]."daorushuju/dr/dj/sjc/".time()."'>余下的</a><br>
				
				<a href='".$GLOBALS["url"]."daorushuju/dr/0'>返回</a>
				<br/><br/><br/>
		";
		
		if($_GET['dr']==1){
		
			echo "壹打工（呼叫中心）<br/><br/><br/>";
				
				$num=D("hyclub")->where(array("hytjnumber"=>'000001',"id > "=>15))->total();
				
				echo "呼叫中心".$num."条数据";
				
				$data=D("hyclub")->where(array("hytjnumber"=>'000001',"id > "=>15))->field("id,hyname,hynumber,hytjnumber,hytjid,hyqqmsn,addtime,hysex,hybirth,hycardno,hytel,hyaddress,ruzhitime,ruzhidanwei,ShouhuoAddr")->LIMIT()->select();

				$s=0;	//导入成功的个数
				$b=0;	//导入失败的个数
				foreach ($data as $i=>$v){
					$uadata=array(
						"id"=>$v['id'],
						"bianhao"=>$v['hynumber'],
						"pasword"=>MD5(USERPASS.$v['hytel']),
						"name"=>$v['hyname'],
						"sex"=>$v['hysex'],
						"birthday"=>strtotime($v['hybirth']),
						"address"=>$v['hyaddress'],
						"sphone"=>$v['hytel'],
						"id_number"=>$v['hycardno'],
						"qq"=>$v['hyqqmsn'],
						"add_time"=>strtotime($v['addtime']),			//要换成时间戳
						"jihuo"=>'0',
						"jihuo_time"=>'0',
						"status"=>'1',
						"ruzhi_name"=>$v['ruzhidanwei'],
						"ruzhi_time"=>strtotime($v['ruzhitime']),
						"lizhi_time"=>'0',
						"guanxi"=>$v['ShouhuoAddr'],
						"f_bianghao"=>$v['hytjnumber'],
						"f_name"=>'壹打工（呼叫中心）',
						"pid"=>'2',
						"jibie"=>'2',
						"path"=>'0,1,2,'
					);
					
					$id=D("tuijian")->insert($uadata);
					if($id){
						$s++;
					}else{
						$sid=D("tuijiancf")->insert($uadata);
						if($sid){
							$b++;
						}
					}
				}
				
				echo "<br/><br/>导入成功".$s."条";
				
				echo "<br/><br/>导入失败".$b."条";
		
		
		}elseif($_GET['dr']==2){
			echo "壹打工（合肥申博）<br><br><br><br>";
			
				$num=D("hyclub")->where(array("hytjnumber"=>'000002'))->total();
				
				echo "合肥申博".$num."条数据<br><br>";
				
				
				$data=D("hyclub")->where(array("hytjnumber"=>'000002'))->field("id,hyname,hynumber,hytjnumber,hytjid,hyqqmsn,addtime,hysex,hybirth,hycardno,hytel,hyaddress,ruzhitime,ruzhidanwei,ShouhuoAddr")->LIMIT()->select();

				$s=0;	//导入成功的个数
				$b=0;	//导入失败的个数
				foreach ($data as $i=>$v){
					$uadata=array(
						"id"=>$v['id'],
						"bianhao"=>$v['hynumber'],
						"pasword"=>MD5(USERPASS.$v['hytel']),
						"name"=>$v['hyname'],
						"sex"=>$v['hysex'],
						"birthday"=>strtotime($v['hybirth']),
						"address"=>$v['hyaddress'],
						"sphone"=>$v['hytel'],
						"id_number"=>$v['hycardno'],
						"qq"=>$v['hyqqmsn'],
						"add_time"=>strtotime($v['addtime']),			//要换成时间戳
						"jihuo"=>'0',
						"jihuo_time"=>'0',
						"status"=>'1',
						"ruzhi_name"=>$v['ruzhidanwei'],
						"ruzhi_time"=>strtotime($v['ruzhitime']),
						"lizhi_time"=>'0',
						"guanxi"=>$v['ShouhuoAddr'],
						"f_bianghao"=>$v['hytjnumber'],
						"f_name"=>'壹打工（合肥申博）',
						"pid"=>'3',
						"jibie"=>'2',
						"path"=>'0,1,3,'
					);
					
					
					$id=D("tuijian")->insert($uadata);
					if($id){
						$s++;
					}else{
						$sid=D("tuijiancf")->insert($uadata);
						if($sid){
							$b++;
						}
					}
				}
				
				echo "<br/><br/>导入成功".$s."条";
				
				echo "<br/><br/>导入失败".$b."条";
				
			
		}elseif($_GET['dr']==3){
			echo "壹打工（常熟）<br><br><br>";
			
				$num=D("hyclub")->where(array("hytjnumber"=>'000006'))->total();
				
				echo "常熟".$num."条数据<br><br>";
				
				$data=D("hyclub")->where(array("hytjnumber"=>'000006'))->field("id,hyname,hynumber,hytjnumber,hytjid,hyqqmsn,addtime,hysex,hybirth,hycardno,hytel,hyaddress,ruzhitime,ruzhidanwei,ShouhuoAddr")->LIMIT()->select();
	
				$s=0;	//导入成功的个数
				$b=0;	//导入失败的个数
				
				foreach ($data as $i=>$v){
					$uadata=array(
						"id"=>$v['id'],
						"bianhao"=>$v['hynumber'],
						"pasword"=>MD5(USERPASS.$v['hytel']),
						"name"=>$v['hyname'],
						"sex"=>$v['hysex'],
						"birthday"=>strtotime($v['hybirth']),
						"address"=>$v['hyaddress'],
						"sphone"=>$v['hytel'],
						"id_number"=>$v['hycardno'],
						"qq"=>$v['hyqqmsn'],
						"add_time"=>strtotime($v['addtime']),			//要换成时间戳
						"jihuo"=>'0',
						"jihuo_time"=>'0',
						"status"=>'1',
						"ruzhi_name"=>$v['ruzhidanwei'],
						"ruzhi_time"=>strtotime($v['ruzhitime']),
						"lizhi_time"=>'0',
						"guanxi"=>$v['ShouhuoAddr'],
						"f_bianghao"=>$v['hytjnumber'],
						"f_name"=>'壹打工（常熟）',
						"pid"=>'7',
						"jibie"=>'2',
						"path"=>'0,1,7,'
					);
					
					$id=D("tuijian")->insert($uadata);
					if($id){
						$s++;
					}else{
						$sid=D("tuijiancf")->insert($uadata);
						if($sid){
							$b++;
						}
					}
				}
				
				echo "<br/><br/>导入成功".$s."条";
				
				echo "<br/><br/>导入失败".$b."条";
				
			
		}elseif($_GET['dr']==4){
			echo "壹打工（仙桃）<br><br><br><br>";
			
				$num=D("hyclub")->where(array("hytjnumber"=>'000010'))->total();
				
				echo "仙桃".$num."条数据<br><br>";
				
				$data=D("hyclub")->where(array("hytjnumber"=>'000010'))->field("id,hyname,hynumber,hytjnumber,hytjid,hyqqmsn,addtime,hysex,hybirth,hycardno,hytel,hyaddress,ruzhitime,ruzhidanwei,ShouhuoAddr")->LIMIT()->select();
	
				$s=0;	//导入成功的个数
				$b=0;	//导入失败的个数
				
				foreach ($data as $i=>$v){
					$uadata=array(
						"id"=>$v['id'],
						"bianhao"=>$v['hynumber'],
						"pasword"=>MD5(USERPASS.$v['hytel']),
						"name"=>$v['hyname'],
						"sex"=>$v['hysex'],
						"birthday"=>strtotime($v['hybirth']),
						"address"=>$v['hyaddress'],
						"sphone"=>$v['hytel'],
						"id_number"=>$v['hycardno'],
						"qq"=>$v['hyqqmsn'],
						"add_time"=>strtotime($v['addtime']),			//要换成时间戳
						"jihuo"=>'0',
						"jihuo_time"=>'0',
						"status"=>'1',
						"ruzhi_name"=>$v['ruzhidanwei'],
						"ruzhi_time"=>strtotime($v['ruzhitime']),
						"lizhi_time"=>'0',
						"guanxi"=>$v['ShouhuoAddr'],
						"f_bianghao"=>$v['hytjnumber'],
						"f_name"=>'壹打工（仙桃）',
						"pid"=>'11',
						"jibie"=>'2',
						"path"=>'0,1,11,'
					);
					
					$id=D("tuijian")->insert($uadata);
					if($id){
						$s++;
					}else{
						$sid=D("tuijiancf")->insert($uadata);
						if($sid){
							$b++;
						}
					}
				}
				
				echo "<br/><br/>导入成功".$s."条";
				
				echo "<br/><br/>导入失败".$b."条";
			
			
		}elseif($_GET['dr']==5){
			echo "壹打工（上海）<br><br><br><br>";
			
				$num=D("hyclub")->where(array("hytjnumber"=>'000005'))->total();
				
				echo "上海".$num."条数据<br><br>";
				
				
				$data=D("hyclub")->where(array("hytjnumber"=>'000005'))->field("id,hyname,hynumber,hytjnumber,hytjid,hyqqmsn,addtime,hysex,hybirth,hycardno,hytel,hyaddress,ruzhitime,ruzhidanwei,ShouhuoAddr")->LIMIT()->select();
	
				$s=0;	//导入成功的个数
				$b=0;	//导入失败的个数
				
				foreach ($data as $i=>$v){
					$uadata=array(
						"id"=>$v['id'],
						"bianhao"=>$v['hynumber'],
						"pasword"=>MD5(USERPASS.$v['hytel']),
						"name"=>$v['hyname'],
						"sex"=>$v['hysex'],
						"birthday"=>strtotime($v['hybirth']),
						"address"=>$v['hyaddress'],
						"sphone"=>$v['hytel'],
						"id_number"=>$v['hycardno'],
						"qq"=>$v['hyqqmsn'],
						"add_time"=>strtotime($v['addtime']),			//要换成时间戳
						"jihuo"=>'0',
						"jihuo_time"=>'0',
						"status"=>'1',
						"ruzhi_name"=>$v['ruzhidanwei'],
						"ruzhi_time"=>strtotime($v['ruzhitime']),
						"lizhi_time"=>'0',
						"guanxi"=>$v['ShouhuoAddr'],
						"f_bianghao"=>$v['hytjnumber'],
						"f_name"=>'壹打工（上海）',
						"pid"=>'6',
						"jibie"=>'2',
						"path"=>'0,1,6,'
					);
					
					$id=D("tuijian")->insert($uadata);
					if($id){
						$s++;
					}else{
						$sid=D("tuijiancf")->insert($uadata);
						if($sid){
							$b++;
						}
					}
				}
				
				echo "<br/><br/>导入成功".$s."条";
				
				echo "<br/><br/>导入失败".$b."条";
			
		}elseif($_GET['dr']==6){
		
			echo "壹打工（重庆）<br><br><br><br>";
			
				$num=D("hyclub")->where(array("hytjnumber"=>'000009'))->total();
				
				echo "重庆".$num."条数据<br><br>";
				
				
				$data=D("hyclub")->where(array("hytjnumber"=>'000009'))->field("id,hyname,hynumber,hytjnumber,hytjid,hyqqmsn,addtime,hysex,hybirth,hycardno,hytel,hyaddress,ruzhitime,ruzhidanwei,ShouhuoAddr")->LIMIT()->select();
	
				$s=0;	//导入成功的个数
				$b=0;	//导入失败的个数
				
				foreach ($data as $i=>$v){
					$uadata=array(
						"id"=>$v['id'],
						"bianhao"=>$v['hynumber'],
						"pasword"=>MD5(USERPASS.$v['hytel']),
						"name"=>$v['hyname'],
						"sex"=>$v['hysex'],
						"birthday"=>strtotime($v['hybirth']),
						"address"=>$v['hyaddress'],
						"sphone"=>$v['hytel'],
						"id_number"=>$v['hycardno'],
						"qq"=>$v['hyqqmsn'],
						"add_time"=>strtotime($v['addtime']),			//要换成时间戳
						"jihuo"=>'0',
						"jihuo_time"=>'0',
						"status"=>'1',
						"ruzhi_name"=>$v['ruzhidanwei'],
						"ruzhi_time"=>strtotime($v['ruzhitime']),
						"lizhi_time"=>'0',
						"guanxi"=>$v['ShouhuoAddr'],
						"f_bianghao"=>$v['hytjnumber'],
						"f_name"=>'壹打工（重庆）',
						"pid"=>'10',
						"jibie"=>'2',
						"path"=>'0,1,10,'
					);
					
					$id=D("tuijian")->insert($uadata);
					if($id){
						$s++;
					}else{
						$sid=D("tuijiancf")->insert($uadata);
						if($sid){
							$b++;
						}
					}
				}
				
				echo "<br/><br/>导入成功".$s."条";
				
				echo "<br/><br/>导入失败".$b."条";
			
		}elseif($_GET['dr']=='dj'){
			
				echo "多级推荐 <br><br><br><br>";
			
				$num=D("hyclub")->where(array("hytjnumber not like"=>'%0000%',"id!"=>1))->total();
				
				echo "多级推荐".$num."条数据<br><br>";
				
				$data=D("hyclub")->where(array("hytjnumber not like"=>'%0000%',"id!"=>1))->field("id,hyname,hynumber,hytjnumber,hytjid,hyqqmsn,addtime,hysex,hybirth,hycardno,hytel,hyaddress,ruzhitime,ruzhidanwei,ShouhuoAddr")->LIMIT()->select();
	
				$s=0;	//导入成功的个数
				$b=0;	//导入失败的个数
				
				foreach ($data as $i=>$v){
					
					$f=$this->getid($v['hytjnumber']);
					
					if(!empty($f)){
						$uadata=array(
							"id"=>$v['id'],
							"bianhao"=>$v['hynumber'],
							"pasword"=>MD5(USERPASS.$v['hytel']),
							"name"=>$v['hyname'],
							"sex"=>$v['hysex'],
							"birthday"=>strtotime($v['hybirth']),
							"address"=>$v['hyaddress'],
							"sphone"=>$v['hytel'],
							"id_number"=>$v['hycardno'],
							"qq"=>$v['hyqqmsn'],
							"add_time"=>strtotime($v['addtime']),			//要换成时间戳
							"jihuo"=>'0',
							"jihuo_time"=>'0',
							"status"=>'1',
							"ruzhi_name"=>$v['ruzhidanwei'],
							"ruzhi_time"=>strtotime($v['ruzhitime']),
							"lizhi_time"=>'0',
							"guanxi"=>$v['ShouhuoAddr'],
							"f_bianghao"=>$f['bianhao'],
							"f_name"=>$f['name'],
							"pid"=>$f['id'],
							"jibie"=>'3',
							"path"=>$f['path'].$f['id'].',',
						);
					
					
						$id=D("tuijian")->insert($uadata);
						if($id){
							$s++;
						}else{
							$sid=D("tuijiancf")->insert($uadata);
							if($sid){
								$b++;
							}
						}
					
					}else{
					
						$uadata=array(
							"id"=>$v['id'],
							"bianhao"=>$v['hynumber'],
							"pasword"=>MD5(USERPASS.$v['hytel']),
							"name"=>$v['hyname'],
							"sex"=>$v['hysex'],
							"birthday"=>strtotime($v['hybirth']),
							"address"=>$v['hyaddress'],
							"sphone"=>$v['hytel'],
							"id_number"=>$v['hycardno'],
							"qq"=>$v['hyqqmsn'],
							"add_time"=>strtotime($v['addtime']),			//要换成时间戳
							"jihuo"=>'0',
							"jihuo_time"=>'0',
							"status"=>'1',
							"ruzhi_name"=>$v['ruzhidanwei'],
							"ruzhi_time"=>strtotime($v['ruzhitime']),
							"lizhi_time"=>'0',
							"guanxi"=>$v['ShouhuoAddr'],
							"f_bianghao"=>$f['bianhao'],
							"f_name"=>$f['name'],
							"pid"=>$f['id'],
							"jibie"=>'3',
							"path"=>$f['path'].$f['id'].',',
						);
						
						D("tuijiancf")->insert($uadata);
					}
				}
				echo "<br/><br/>导入成功".$s."条";
				
				echo "<br/><br/>导入失败".$b."条";
				
			
		}else{
		
			echo "
				
				
				删除导入的数据：DELETE FROM `zhixiao`.`tuijian` WHERE `tuijian`.`id` > 15;
				";
		}
		
	}
	
	function getid($bh){

		$data=D('tuijian')->where(array("bianhao"=>$bh))->field('id,bianhao,name,path')->find();
		return $data;
	}
}