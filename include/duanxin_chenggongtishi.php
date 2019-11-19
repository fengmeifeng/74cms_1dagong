<?php

		//--注册成功发送短息 开始 By Z
		require_once(QISHI_ROOT_PATH.'include/bb_duanxin.class.php');
		//------发送短信开始
			$duanxineirong="恭喜您成为壹打工网会员，账号为您手机号，初始密码是手机后四位,更多招聘信息详见www.1dagong.com。4001185188【壹打工网】";
			//转码
            //$duanxineirong=mb_convert_encoding($duanxineirong,"GBK","UTF-8");
            $dx=new duanxin($username,$duanxineirong);		//申明短信类
			$id=$dx->fs();			
		//------发送短信结束
		//--注册成功发送短息 结束 By Z


?>