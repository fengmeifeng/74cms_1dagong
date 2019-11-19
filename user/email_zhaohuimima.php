<?php
// echo $sphone.'ok2';exit;
			if ($_SESSION['sendemail_time'] && (time()-$_SESSION['sendemail_time'])<10)
			{
			exit("请60秒后再进行找回！");
			}
			
			if (smtp_mail($email,"{$_CFG['site_name']}邮件找回密码","{$QISHI['site_name']}提醒您：<br>您正在进行邮箱找回密码，你在{$QISHI['site_name']}上的新密码为:<strong>".$mima."</strong>"))
			{
			//$_SESSION['verify_email']=$email;
			//$_SESSION['email_rand']=$rand;
			//$_SESSION['sendemail_time']=time();
			//exit("success");
			}
			else
			{
			exit("邮箱配置出错，请联系网站管理员");
			}

?>