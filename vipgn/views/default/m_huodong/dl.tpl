<!DOCTYPE HTML>
<html>
	<head>
		<title>手机寅特尼人才网</title>
		<meta http-equiv="content-type" content="text/html; charset=gb2312" />
		<link rel="shortcut icon" href="<{$res}>/images/favicon.ico" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<meta name="keywords" content="合肥人才网,合肥招聘会,寅特尼人才网,安徽人才网,合肥人才市场" />
		<meta name="description" content="合肥人才网是安徽合肥招聘求职首选的人才网，同时也是安徽省寅特尼人才市场的网上求职招聘平台。" />
		<link href="<{$res}>/css/wap.css" rel="stylesheet" type="text/css" />
		<script src="js/jquery.min.js"></script>
	</head>
	<body>
	<div class="top">
		<div class="top1">
		<a href="<{$url}>/index">
			<img src="/data/images/wap_logo.gif" alt="寅特尼人才网" border="0" align="absmiddle" />
		</a>
		<{if $user==""}>
		<span><a href="<{$url}>/login">会员登录</a>&nbsp;&nbsp;<a href="../../user/user_reg.php">注册</a></span>
		<{else}>
		<span><a href="#"><{$user.username}></a>&nbsp;&nbsp;<a href="<{$url}>/tologin">退出</a></a></span>
		<{/if}>
		</div>
	</div>

	<div class="dl">
	<form action="<{$url}>/dl" method="post">
		<table border="0" align="cen">
			<tr>
				<td align="right">用户名：</td>
				<td><input type="text" name="user" class="input"></td>
			</tr>
			<tr>
				<td align="right">密码：</td>
				<td><input type="password" name="pass" class="input"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="登录" class="sub" /></td>
			</tr>
		</table>
	</form>
	</div>
	<div class="footer">
		<div class="db"></div>
		<div class="djies bj">
			<p>寅特尼人才网是最专业的求职招聘网站，致力打造安徽人才网第一品牌！</p>
			<p>联系地址：合肥市经济开发区明珠广场上海城市  安徽省寅特尼人才市场  联系电话：0551-62589728</p>
			<p>Copyright 2012-2013 www.1jobs.cn  皖ICP备12006327号-1</p>
		</div>
	</div>
	</body>
</html>

