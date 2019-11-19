<?php

		//--邀请面试发送短息 开始 By Z
		require_once(QISHI_ROOT_PATH.'include/bb_duanxin.class.php');
		//------发送短信开始
			$duanxineirong="【壹打工网】您好，您在壹打工网发布的简历被企业邀请面试，请及时登录壹打工网www.1dagong.com查看。4001185188";
			//转码
            //$duanxineirong=mb_convert_encoding($duanxineirong,"GBK","UTF-8");
            $dx=new duanxin($username,$duanxineirong);		//申明短信类
			$time=date('Y-m-d H:i:s',time());
			$sql="insert into qs_duanxinsend_log (phone,sendtime,content) values ('".$username."','".$time."','".$duanxineirong."')";
			$db->query($sql);
			$id_res=$dx->fs();			
		//------发送短信结束
		//--邀请面试发送短息 结束 By Z


?>