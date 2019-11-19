<?php
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/plus.common.inc.php');
define("TOKEN", $_CFG['weixin_apptoken']);
define("APPID", $_CFG['weixin_appid']);
define("APPSECRET", $_CFG['weixin_appsecret']);
define("ROOT",$_CFG['site_domain']);
define("FIRST_PIC",$_CFG['weixin_first_pic']);
define("DEFAULT_PIC",$_CFG['weixin_default_pic']);
define("SITE_NAME",$_CFG['site_name']);
define("WAP_DOMAIN",rtrim($_CFG['wap_domain'],"/")."/");
define("APIOPEN", $_CFG['weixin_apiopen']);
define("PHP_VERSION",PHP_VERSION);
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');

class wechatCallbackapiTest extends mysql
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature())
		{
        	exit($echoStr);
        }
    }
    public function responseMsg()
    {
		if(!$this->checkSignature())
		{
        	exit();
        };
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		
		if (!empty($postStr))
		{
			if($this->check_php_version("5.2.11")){
				libxml_disable_entity_loader(true);
			}
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = addslashes($postObj->FromUserName);
            $toUsername = addslashes($postObj->ToUserName);
            $keyword = trim($postObj->Content);
			$keyword = utf8_to_gbk($keyword);
			$keyword = addslashes($keyword);
            $time = time();
			$event = trim($postObj->Event);
			
			if ($event === "subscribe")
			{
				$word= "欢迎使用微信平台,我们努力打造最人性化的服务平台,绑定帐号后可以享受更多便捷服务!<a href='".WAP_DOMAIN."wap-binding.php?from=".$fromUsername."'>".立即绑定."</a> ";
				$this->exit_word_message($word,$fromUsername,$toUsername,$time);			
			}	
			
			$default_pic=ROOT."/data/images/".DEFAULT_PIC;
			$first_pic=ROOT."/data/images/".FIRST_PIC;
			
			if($event === "unsubscribe"){
				$sql = "update ".table('members')." set weixin_openid='' where weixin_openid='".$fromUsername."'";
				$this->query($sql);
			}

			if($event === "CLICK"){
				if(APIOPEN=='0')
				{
					$word="网站微信接口已经关闭";
					$this->exit_word_message($word,$fromUsername,$toUsername,$time);
				}
				
				if($postObj->EventKey=="binding"){
					$usinfo = $this->get_user_info($fromUsername);
					if(!empty($usinfo)){
						$word="您已绑定帐号";
					}else{
						$word="<a href='".WAP_DOMAIN."wap-binding.php?from=".$fromUsername."'>".请先绑定帐号."</a>";
					}
					$this->exit_word_message($word,$fromUsername,$toUsername,$time);
				}
				
				elseif($postObj->EventKey=="apply_jobs"){
					$usinfo = $this->get_user_info($fromUsername);
					if(!empty($usinfo)){
						$word="";
						$apply_info = array();
						$uid = $usinfo['uid'];
						$apply_obj = $this->query("select * from ".table('personal_jobs_apply')." where personal_uid=".$uid);
						while($row = $this->fetch_array($apply_obj)){
							$jobs_url = WAP_DOMAIN."wap-jobs-show.php?id=".$row['jobs_id']."&from=".$fromUsername;
							$look = intval($row['personal_look'])==1?"未查看":"已查看";
							$word.="【".date('Y-m-d',$row['apply_addtime'])."】【".$look."】\n<a href='".$jobs_url."&from=".$fromUsername."'>".$row['jobs_name']."</a>\n".$row['company_name']."\n--------------------------\n";
						}
						if(empty($word)){
							$word = "没有找到对应的信息!";
						}
					}else{
						$word = "<a href='".WAP_DOMAIN."wap-binding.php?from=".$fromUsername."'>".请先绑定帐号."</a>";
					}
					$this->exit_word_message($word,$fromUsername,$toUsername,$time);
				}
				
				elseif($postObj->EventKey=="resume_refresh"){
					$usinfo = $this->get_user_info($fromUsername);
					if(!empty($usinfo)){
						$uid = $usinfo['uid'];
						$time = time();
						$this->query("update ".table('resume')." set refreshtime=".$time." where uid=".$uid);
						$this->query("update ".table('resume_search_key')." set refreshtime=".$time." where uid=".$uid);
						$this->query("update ".table('resume_search_rtime')." set refreshtime=".$time." where uid=".$uid);
						$word = "刷新成功!";
					}else{
						$word = "<a href='".WAP_DOMAIN."wap-binding.php?from=".$fromUsername."'>".请先绑定帐号."</a>";
					}
					$this->exit_word_message($word,$fromUsername,$toUsername,$time);
				}
				
				
				elseif($postObj->EventKey=="interview"){
					$usinfo = $this->get_user_info($fromUsername);
					if(!empty($usinfo)){
						$word="";
						$interview_info = array();
						$uid = $usinfo['uid'];
						$interview_obj = $this->query("select * from ".table('company_interview')." where resume_uid=".$uid);
						while($row = $this->fetch_array($interview_obj)){
							$jobs_url = WAP_DOMAIN."wap-jobs-show.php?id=".$row['jobs_id']."&from=".$fromUsername;
							$company_url = WAP_DOMAIN."wap-company-show.php?id=".$row['company_id']."&from=".$fromUsername;
							$word.="【".date('Y-m-d',$row['interview_addtime'])."】\n<a href='".$company_url."&from=".$fromUsername."'>".$row['company_name']."</a>邀请你面试<a href='".$jobs_url."&from=".$fromUsername."'>".$row['jobs_name']."</a>\n--------------------------\n";
						}
						if(empty($word)){
							$word = "没有找到对应的信息!";
						}
					}else{
						$word = "<a href='".WAP_DOMAIN."wap-binding.php?from=".$fromUsername."'>".请先绑定帐号."</a>";
					}
					$this->exit_word_message($word,$fromUsername,$toUsername,$time);
				}
				
				
				else{
					switch ($postObj->EventKey)
					{
						case "newjobs":
							$type=1;
							$jobstable=table('jobs_search_rtime');	
							break;
						case "emergencyjobs":
							$type=1;
							$jobstable=table('jobs_search_rtime');
							$wheresql=" where `emergency`=1 ";	
							break;
						case "recommendjobs":
							$type=1;
							$jobstable=table('jobs_search_rtime');
							$wheresql=" where `recommend`=1 ";	
							break;
						case "resume":
							$type=2;
							$jobstable=table('resume_search_rtime');	
							break;
						default:
							$type=1;
							$jobstable=table('jobs_search_rtime');	
							break;
					}
					$limit=" LIMIT 5";
					$orderbysql=" ORDER BY refreshtime DESC";
					$word='';
					$list = $id = array();
					$idresult = $this->query("SELECT id FROM {$jobstable} ".$wheresql.$orderbysql.$limit);
					while($row = $this->fetch_array($idresult))
					{
					$id[]=$row['id'];
					}
					if (!empty($id))
					{
						$wheresql=" WHERE id IN (".implode(',',$id).") ";
						if($type==1){
							$result = $this->query("SELECT * FROM ".table('jobs').$wheresql.$orderbysql);
						}elseif($type==2){
							$result = $this->query("SELECT * FROM ".table('resume').$wheresql.$orderbysql);
						}
						
						$count=mysql_num_rows($result);
						$i=1;
						$strmiddle="";
						$strbegin="<xml>
								 <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
								 <FromUserName><![CDATA[".$toUsername."]]></FromUserName>
								 <CreateTime>".$time."</CreateTime>
								 <MsgType><![CDATA[news]]></MsgType>
								 <ArticleCount>".$count."</ArticleCount>
								 <Articles>";	
						while($row = $this->fetch_array($result))
						{
							if($i==1){
		                        $picurl=$first_pic;	
							}else{
								$picurl=$default_pic;	
							}
							$i++;
							if($type==1){
								$jobs_name=gbk_to_utf8($row['jobs_name']);				
							    $companyname=gbk_to_utf8($row['companyname']);
							    $title=$jobs_name."--".$companyname;
							    $url=WAP_DOMAIN."wap-jobs-show.php?id=".$row['id']."&from=".$fromUsername;
							}elseif($type==2){
								$fullname=gbk_to_utf8($row['fullname'])."(".gbk_to_utf8($row['sex_cn']).")";				
							    $intention_jobs=gbk_to_utf8($row['intention_jobs']);
							    $title=$fullname."--".$intention_jobs;
							    $url=WAP_DOMAIN."wap-resume-show.php?id=".$row['id']."&from=".$fromUsername;
							}
							$strmiddle.="<item>
										 <Title><![CDATA[".$title."]]></Title> 
										 <Description><![CDATA[".$con."]]></Description>
										 <PicUrl><![CDATA[".$picurl."]]></PicUrl>	
										 <Url><![CDATA[".$url."]]></Url>
										 </item>";
						}
						$strend = "</Articles>
								 <FuncFlag>1</FuncFlag>
								 </xml>";
						$word = $strbegin.$strmiddle.$strend;
					}
					if(empty($word))
					{
						$word="没有找到相应的信息";
						$this->exit_word_message($word,$fromUsername,$toUsername,$time);	
					}
					else
					{
						exit($word);
					}
				}
				
			}elseif($event === "SCAN"){
				$event_key = $postObj->EventKey;
				$usinfo = $this->get_user_info($fromUsername);
				if(!empty($usinfo)){
					$word = "<a href='".WAP_DOMAIN."wap_login.php?act=weixin_login&openid=".$fromUsername."&uid=".$usinfo['uid']."&event_key=".$event_key."'>点此立即登录".SITE_NAME."网页</a>";
				}else{
					$word = "<a href='".WAP_DOMAIN."wap-binding.php?from=".$fromUsername."'>".请先绑定帐号."</a>";
				}
				$this->exit_word_message($word,$fromUsername,$toUsername,$time);	
			}
			
			
	       	if (!empty($keyword))
			{
			
				if($_CFG['weixin_apiopen']=='0')
				{
						$word="网站微信接口已经关闭";
						$this->exit_word_message($word,$fromUsername,$toUsername,$time);	
				}
				if(strstr($keyword,"/")){
					global $QS_pwdhash;
					$key_arr = explode("/",$keyword);
					$username = $key_arr[0];
					$password = $key_arr[1];
					$usinfo = array();
					$usinfo_obj = $this->query("select * from ".table('members')." where username = '{$username}' LIMIT 1");
					while($row = $this->fetch_array($usinfo_obj)){
						$usinfo = $row;
					}
					if(!empty($usinfo)){
						$success = false;
						$pwd_hash=$usinfo['pwd_hash'];
						$usname=$usinfo['username'];
						$pwd=md5(md5($password).$pwd_hash.$QS_pwdhash);
						if ($usinfo['password']==$pwd)
						{
							$this->query("update ".table('members')." set `weixin_openid`='".$fromUsername."',bindingtime=".time()." where uid=".$usinfo['uid']);
							$success = true;
						}
						else
						{
							$success = false;
						}
						if($success){
							$word="绑定成功!"; 
						}else{
							$word="用户名或密码错误!";
						}
					}else{
						$word="用户名或密码错误!";
					}
					
					$this->exit_word_message($word,$fromUsername,$toUsername,$time);	
				}else{
					$limit=" LIMIT 5";
					$orderbysql=" ORDER BY refreshtime DESC";
					if($keyword=="n")
					{
						$jobstable=table('jobs_search_rtime');			 
					}
					else if($keyword=="j")
					{
						$jobstable=table('jobs_search_rtime');
						$wheresql=" where `emergency`=1 ";	
					}
					else
					{
					$jobstable=table('jobs_search_key');
					$wheresql.=" where likekey LIKE '%{$keyword}%' ";
					}
					$word='';
					$list = $id = array();
					$idresult = $this->query("SELECT id FROM {$jobstable} ".$wheresql.$orderbysql.$limit);
					while($row = $this->fetch_array($idresult))
					{
					$id[]=$row['id'];
					}
					if (!empty($id))
					{
						$wheresql=" WHERE id IN (".implode(',',$id).") ";
						$result = $this->query("SELECT * FROM ".table('jobs').$wheresql.$orderbysql);
						$count=mysql_num_rows($result);
						$i=1;
						$strmiddle="";
						$strbegin="<xml>
								 <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
								 <FromUserName><![CDATA[".$toUsername."]]></FromUserName>
								 <CreateTime>".$time."</CreateTime>
								 <MsgType><![CDATA[news]]></MsgType>
								 <ArticleCount>".$count."</ArticleCount>
								 <Articles>";	
						while($row = $this->fetch_array($result))
						{
							$jobs_name=gbk_to_utf8($row['jobs_name']);				
						    $companyname=gbk_to_utf8($row['companyname']);
						    $title=$jobs_name."--".$companyname;
						    $url=ROOT."/wap/wap-jobs-show.php?id=".$row['id']."&from=".$fromUsername;

						    if($i==1){
		                        $picurl=$first_pic;	
							}else{
								$picurl=$default_pic;	
							}
							$i++;
							$strmiddle.="<item>
										 <Title><![CDATA[".$title."]]></Title> 
										 <Description><![CDATA[".$con."]]></Description>
										 <PicUrl><![CDATA[".$picurl."]]></PicUrl>	
										 <Url><![CDATA[".$url."]]></Url>
										 </item>";
						}
						$strend = "</Articles>
								 <FuncFlag>1</FuncFlag>
								 </xml>";
						$word = $strbegin.$strmiddle.$strend;
					}
					if(empty($word))
					{
						$word="没有找到包含关键字 {$keyword} 的信息，试试其他关键字";
						$this->exit_word_message($word,$fromUsername,$toUsername,$time);	
					}
					else
					{
						exit($word);
					}	
				}
				 
			}
			else 
			{
			exit("");
			}
    	}
	}	
	private function checkSignature()
	{
	    $signature = $_GET["signature"];
	    $timestamp = $_GET["timestamp"];
	    $nonce = $_GET["nonce"];        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );		
		if($tmpStr == $signature )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	private function get_user_info($fromUsername){
		$usinfo = array();
		$usinfo_obj = $this->query("select * from ".table('members')." where weixin_openid='".$fromUsername."' limit 1");
		while($row = $this->fetch_array($usinfo_obj)){
			$usinfo = $row;
		}
		return $usinfo;
	}
	private function update_user_info($fromUsername,$record=true,$setcookie=true,$cookie_expire=NULL)
	{
	 	global $timestamp, $online_ip,$db,$QS_cookiepath,$QS_cookiedomain,$_CFG;
		$user = $this->get_user_info($fromUsername);
		if (empty($user))
		{
		return false;
		}
		else
		{
	 	$_SESSION['uid'] = intval($user['uid']);
	 	$_SESSION['username'] = addslashes($user['username']);
		$_SESSION['utype']=intval($user['utype']);
		}
		if ($setcookie)
		{
			$expire=intval($cookie_expire)>0?time()+3600*24*$cookie_expire:0;
			setcookie('QS[uid]',$user['uid'],$expire,$QS_cookiepath,$QS_cookiedomain);
			setcookie('QS[username]',addslashes($user['username']),$expire,$QS_cookiepath,$QS_cookiedomain);
			setcookie('QS[password]',$user['password'],$expire,$QS_cookiepath,$QS_cookiedomain);
			setcookie('QS[utype]',$user['utype'], $expire,$QS_cookiepath,$QS_cookiedomain);
		}
		return true;
	 }
	private function exit_word_message($word,$fromUsername,$toUsername,$time){
		$word = gbk_to_utf8($word);
		$text="<xml>
		<ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
		<FromUserName><![CDATA[".$toUsername."]]></FromUserName>
		<CreateTime>".$time."</CreateTime>
		<MsgType><![CDATA[text]]></MsgType>
		<Content><![CDATA[".$word."]]></Content>
		</xml> ";
		exit($text);
	}
	private function check_php_version($version) {
		 $php_version = explode('-',phpversion());
		 // strnatcasecmp( $php_version[0], $version ) 0表示等于，1表示大于，-1表示小于
		 $is_pass = strnatcasecmp($php_version[0],$version)>=0?true:false;
		 return $is_pass;
	 }
}
//
$wechatObj = new wechatCallbackapiTest($dbhost,$dbuser,$dbpass,$dbname);
if(isset($_REQUEST['echostr']))
			 $wechatObj->valid();
elseif(isset($_REQUEST['signature']))
{			  
	$wechatObj->responseMsg();
}
		
?>