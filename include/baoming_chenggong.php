<?php
		// echo 'ok1111';exit; 
		//--注册成功发送短息 开始 By Z
		require_once('/bb_duanxin.class.php');
		// echo '1111';exit;
		//------发送短信开始
			// $duanxineirong="恭喜您成为壹打工网会员，账号为您手机号，初始密码是手机后四位,更多招聘信息详见www.1dagong.com。4001185188【壹打工网】";
			$duanxineirong="【壹打工网】您好，恭喜您已通过“2015年合肥市社会服务岗位”报名初步审核，请于10月30日之前登录壹打工网（www.1dagong.com）下载打印准考证，并上传本人身份证、毕业证书、学位证书扫描件及一寸蓝底照片。联系电话：0551-62980763,0551-62980767。";
			//转码
            // $duanxineirong=mb_convert_encoding($duanxineirong,"GBK","UTF-8");
			$username=$phone;
            $dx=new duanxin($username,$duanxineirong);		//申明短信类
			$id=$dx->fs();			
		//------发送短信结束
		//--注册成功发送短息 结束 By Z


?>