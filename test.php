<?php
    header ( "Content-Type: text/html; charset=gb2312" );
    $reply = "";
    if ( isset($_POST["email_address"]) )
    {
        $email_address = $_POST["email_address"];
        $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        if ( preg_match( $pattern, $email_address ) )
        {
            $reply = "您输入的电子邮件地址合法<br /><br />\n";
            $user_name = preg_replace( $pattern ,"$1", $email_address );
            $domain_name = preg_replace( $pattern ,"$2", $email_address );
            $reply .= "用户名：".$user_name."<br />\n";
            $reply .= "域名：".$domain_name."<br />\n\n";
        }
        else
        {
            $reply = "您输入的电子邮件地址不合法";
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh" xml:lang="zh">
<head>
<title>电子邮件地址验证程序</title>
</head>
<body style="text-align: center;">
<h1>电子邮件地址验证程序</h1>
<form action="#" method="post">
请输入电子邮件地址：<input name="email_address" type="text" style="width: 300px;" /><br />
<input type="submit" value="验证电子邮件地址" />
</form>
<?php
    echo $reply;
///------------------------///
echo "得到百位、十位、各位的数字<br>";
echo $a=123456;
echo "个位是：".substr($a,5,1)."<br>";
echo "十位是：".substr($a,4,1)."<br>";
echo "百位是：".substr($a,3,1)."<br>";
//---------------------------//
//----------------
echo "获得变量的位数：<br>";

	/*$num=56423;
	$t=strlen($num);
	for($i=0;$i<=$t;$i++){
		echo substr($num,($t-$i),1)."<br>";
	}*/
	$num=56423;
	$t=strlen($num);
	for($i=1;$i<=$t;$i++){
		if($i==1){
			$html=substr($num,($t-$i),1)."个";
		}else if($i==2){
			$html.=substr($num,($t-$i),1)."十";
		}else if($i==3){
			$html.=substr($num,($t-$i),1)."百";
		}else if($i==4){
			$html.=substr($num,($t-$i),1)."千";
		}else if($i==5){
			$html.=substr($num,($t-$i),1)."万";
		}
	}
	echo $html;
//--------------
?>
</body>
</html>