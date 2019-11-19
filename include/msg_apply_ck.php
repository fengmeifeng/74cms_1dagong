<?php

		//--企业申请查看简历发送短息 开始 By Z
		require_once(QISHI_ROOT_PATH.'include/bb_duanxin.class.php');
		//------发送短信开始
			$duanxineirong="【壹打工网】您好，有一家企业申请查看您在壹打工网发布的简历，请及时登录壹打工网www.1dagong.com查看。4001185188";
			//转码
            //$duanxineirong=mb_convert_encoding($duanxineirong,"GBK","UTF-8");
            $dx=new duanxin($username,$duanxineirong);		//申明短信类
			$id_ck=$dx->fs();			
		//------发送短信结束
		//--企业申请查看简历发送短息 结束 By Z


?>