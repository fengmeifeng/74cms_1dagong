<?php
		// echo 'ok1111';exit; 
		//--注册成功发送短息 开始 By Z
		require_once('/bb_duanxin.class.php');
		// echo '1111';exit;
		//------发送短信开始
			// $duanxineirong="恭喜您成为壹打工网会员，账号为您手机号，初始密码是手机后四位,更多招聘信息详见www.1dagong.com。4001185188【壹打工网】";
			$duanxineirong="【壹打工网】您好，感谢您报考“2015年合肥市社会服务岗位”招聘考试，很遗憾的通知您，经招考方审核，您所填写的资料或条件与所报岗位不符，请登录壹打工网（www.1dagong.com）查询修改，感谢您的关注。联系电话：0551-62980763,0551-62980767。";
			//转码
            // $duanxineirong=mb_convert_encoding($duanxineirong,"GBK","UTF-8");
			$username=$phone;
            $dx=new duanxin($username,$duanxineirong);		//申明短信类
			$id=$dx->fs();			
		//------发送短信结束
		//--注册成功发送短息 结束 By Z


?>