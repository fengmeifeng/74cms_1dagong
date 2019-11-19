<?php
/**
*短信类。2014-2-13 冰冰写
*/
define("ROOT", str_replace("\\", "/", dirname(__FILE__)).'/');  //类的目录

class Duanxin {
		private $phone="";    				//手机号码
		private $msgcont=""; 	 			//短信内容
		private $url="http://qd.qxt666.cn/interface/tomsg.jsp?user=shenbo&pwd=shenborl";		//短信发送地址
		

	function __construct($phone="",$msgcont=""){	
		$this->phone=$phone; 
		$this->content=$msgcont;
	}
	function fs(){
		$this->url.="&phone=".$this->phone."&msgcont=".$this->content."【要工作网】";
		$xml=$this->scurl($this->url);
		$data=$this->xml2array($xml);
		if(!empty($data)){
			switch ($data[0]){
				//获取短信状态
				case 00:
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