<?php
	//全局可以使用的通用函数声明在这个文件中.
	//查询这个用户的信息
	function getsphone($id){
		$sql="select tj.sphone from tixian as tx left join tuijian as tj on tx.userbianhao=tj.bianhao where tx.id='".$id."' ";
		$data=D("tixian")->query($sql,"find");
		return $data['sphone'];
	}
	
	function get_add_gs($id){
		$data=D("adminuser")->where(array("user"=>$id,"priv"=>'2'))->find();
		return $data['name'];
	}
	
	//curl函数
	function scurl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);        
		return curl_exec($ch);
		curl_close($ch);
	}
	
	//下线个数------------------------
	function gs($biao,$bianhao){
		$num=D($biao)->where(array("jihuo"=>'1',"f_bianghao"=>$bianhao))->total();
		return $num;
	}
	
	//计算天数
	function getdays($tim){
		$date1= date('Y-m-d H:i:s', $tim);
		$date2= date('Y-m-d H:i:s', time()); 
		$days=(int)abs((strtotime($date1)-strtotime($date2))/86400);
		return $days;
	}
	
	function renqiantian123($biao,$id){
		$data=D($biao)->where(array("jihuo"=>'0',"status"=>'1',"path"=>"%,".$id.",%"),array("jihuo"=>'1',"status"=>'1',"path"=>"%,".$id.",%"))->order("concat(path,id)")->select();
		$a=0;
		foreach ($data as $k => $v){
			$days=getdays($v['ruzhi_time']);
			if($days >= DAYSTI){
				$v['path']=strstr($v['path'],$id.",");
				$m=substr_count($v['path'],",")-1;
				$m=$m+1;
				if($m >= 1 and $m <= 3){	
					$q = 100;
				}elseif($m >= 4 and $m <= 7){
					$q = 30;
				}elseif($m >= 8 and $m <= 10){
					$q = 25;
				}elseif($m >= 11 and $m <= 12){
					$q = 20;
				}else{
					$q = 0;
				}
				$a+=$q;
			}
		}
		return $a;
	}
	
	//获取ip地址
	function getip(){
		if (getenv('HTTP_CLIENT_IP') and strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown')) {
			$onlineip=getenv('HTTP_CLIENT_IP');
		}elseif (getenv('HTTP_X_FORWARDED_FOR') and strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown')) {
			$onlineip=getenv('HTTP_X_FORWARDED_FOR');
		}elseif (getenv('REMOTE_ADDR') and strcasecmp(getenv('REMOTE_ADDR'),'unknown')) {
			$onlineip=getenv('REMOTE_ADDR');
		}elseif (isset($_SERVER['REMOTE_ADDR']) and $_SERVER['REMOTE_ADDR'] and strcasecmp($_SERVER['REMOTE_ADDR'],'unknown')) {
			$onlineip=$_SERVER['REMOTE_ADDR'];
		}
		preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/",$onlineip,$match);
		return $onlineip = $match[0] ? $match[0] : 'unknown';
	}
	
		

	/*--crm函数库-----------------------------------------------------------------------*/
	function get_user_id($id){
		$data=D("crm_user")->field("id")->where(array("dept"=>$id))->select();
		$id='';
		foreach ($data as $k => $v){	$id.=$v['id'].",";	}
		return rtrim($id,",");
	}