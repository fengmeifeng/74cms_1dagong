<html>
	<head>
		<title>登录</title>
		<link rel="stylesheet" type="text/css" href="<{$res}>/css/login.css" />
	</head>
	<body>
	<div class="box">
		<div class="lgbox">
			<div class="left">
				<div class="titjs">
					<h3>欢迎使用申博集团定展系统后台</h3>
					<p><span class="t"> </span>领先的定展系统解决方案</p>
					<p><span class="t"> </span>系统可在线进行网络升级</p>
					<p><span class="t"> </span>安全易用并且功能强大</p>
					<p><span class="t"> </span>低拥有成本</p>
					<p><span class="t"> </span>默认用户名:admin 密码为空</p>
				</div>
			</div>
			<div class="zz"> </div>
			<div class="reft">
				<span><img height="121" alt="" src="<{$res}>/css/img/login3_r3_c14.jpg" width="234" border="0" name="login3_r3_c14"></span>
				<form action="<{$url}>/denlu" method="post">
				<table border="0" style="margin-left:40px;">
					<tr>
						<td>
							<img src="<{$res}>/css/img/login_dot1.gif" align="absMiddle" width="13" height="15">&nbsp;用户名:
						</td>
						<td>&nbsp;<input type="text" name="user" class="input" /></td>
					</tr>
					<tr>
						<td>
							<img height="14" src="<{$res}>/css/img/login_dot2.gif" width="14" align="absMiddle">&nbsp;密&nbsp;&nbsp;码:
						</td>
						<td>&nbsp;<input type="password" name="pass" class="input"/></td>
					</tr>
					<tr>
						<td><img height="14" src="<{$res}>/css/img/asset.gif" width="14" >&nbsp;验证码:</td>
						<td>&nbsp;<input type="text" name="code" class="input" style="width:80px;" onkeyup="if (this.value != this.value.toUpperCase()) this.value=this.value.toUpperCase();" /><img align=top src="<{$url}>/code" onclick="this.src='<{$url}>/code/'+Math.random()" title="点击切换验证码"/>
						</td>
					</tr>
				</table>
					<input type="submit" value="" class="sub" />
				</form>
			</div>
		</div>
	</div>
	</body>
</html>