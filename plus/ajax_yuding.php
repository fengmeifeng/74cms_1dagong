<?php
	$phone = !empty($_POST['phone']) ? trim($_POST['phone']) : '';
	$infoid = !empty($_POST['infoid']) ? trim($_POST['infoid']) : '';
	//echo "返回预定成功信息<br />"."手机号：".$phone."<br />记录id:".$infoid;
	echo "{statu:'success',phone:".$phone."}";
?>