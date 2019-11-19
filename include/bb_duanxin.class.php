<?php
/**
*短信类。2014-2-13 冰冰写
*/
define("ROOT", str_replace("\\", "/", dirname(__FILE__)).'/');  //类的目录

class Duanxin {
		private $phone="";    				//手机号码
		private $content=""; 	 			//短信内容
		private $url="http://61.191.26.181:8888/SmsPort.asmx/SendSms?Epid=1000&User_Name=shenbohr&password=5b805590a1636888";		//短信发送地址
		

	function __construct($phone="",$content=""){	
		$this->phone=$phone; 
		$this->content=$content;
	}
	function fs(){
		//如果不是手机号码，不发送短信，节省短信条数 By Z
		if(substr($this->phone, 0, 1)!=1){
			return 0;
			exit;
		}
		$this->url.="&phone=".$this->phone."&content=".$this->content;
		$xml=$this->scurl($this->url);
		$data=$this->xml2array($xml);
		if(!empty($data)){
			switch ($data[0]){
				//获取短信状态
				case 00:
					$str=date("Y-m-d H:i:s",time())."	号码:".$this->phone."	验证码发送成功！\r\n";
					error_log($str,3,ROOT.'../errors_cg.log');
					return "1";
					break;  
				case 01:
					$str=date("Y-m-d H:i:s",time())."  号码,内容等为空或内容长度超过210字符 \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;
				case 02:
					$str=date("Y-m-d H:i:s",time())."  鉴权失败 \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;
				case 10:
					$str=date("Y-m-d H:i:s",time())."  余额不足 \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;
				case -99:
					$str=date("Y-m-d H:i:s",time())."  服务器接受失败 \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;
				default:
					$str=date("Y-m-d H:i:s",time())."  内容有屏蔽字  短信内容：".$data[0]." \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
			}
		}else{
			$str=date("Y-m-d H:i:s",time())."  网络故障短信发送失败 \r\n";
			error_log($str,3,ROOT.'../errors.log');
			return "0";
		}
	}
	//xml 转 数组	
	private function xml2array($xmlobject) {
		$xml = simplexml_load_string($xmlobject);
		if ($xml) {
			foreach ((array)$xml as $k=>$v) {
				$data[$k] = !is_string($v) ? xml2array($v) : $v;
			}
			return $data;
		}
	}	
	//curl函数
	private function scurl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);        
		return curl_exec($ch);
		curl_close($ch);
	}
}