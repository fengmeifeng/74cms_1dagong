<?php
// echo $sphone.'ok2';exit;
					$content="您好，您的壹打工网新的密码为：".$mima."。电脑或手机访问www.1dagong.com，随时随地找工作。【壹打工网】";
					// $content=mb_convert_encoding($content,"GBK","UTF-8");
					$dx=new duanxin($sphone,$content);		//申明短信类
					$id=$dx->fs();							//发送短信
					// echo '123ok'.$sphone.$mima.'==='.$id;exit;

?>