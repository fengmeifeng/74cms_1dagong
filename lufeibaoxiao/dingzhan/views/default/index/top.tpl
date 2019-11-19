<html>
<head>
<title>系统顶栏</title>
<meta http-equiv="Content-Type" content="text/html" charset="utf8">
<link rel="stylesheet" type="text/css" href="<{$res}>/css/top.css">
<script language="JavaScript">
// 返回桌面
function GoTable(){
  parent.parent.location="./../index/index";
}
// 询问退出系统
function ifexit()
{
if(window.confirm('确定退出吗？'))
 {
	parent.parent.location="./../login/logout";
	parent.parent.close();
 }
}
// 询问注销系统
function iflogout()
{
if(window.confirm('确定重新登录吗？'))
 {
  parent.parent.location="./../login/logout";        // 页面跳转
 }
}

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0" padding="0" onselectstart="return false" >
<div id="topWrap">
	<h1>欢迎使用申博集团定展系统后台</h1>
	<div id="topInner">
		<div class="topButton" onClick="javascript:ifexit();">
			<div class="topButton-inner">
			<span class="logout">退出</span>
			</div>
		</div>
		<div class="topButton" onClick="javascript:iflogout();">
			<div class="topButton-inner">
			<span class="relogin">注销</span>
			</div>
		</div>
		<div class="topButton" onClick="javascript:GoTable();">
			<div class="topButton-inner">
			<span class="desktop">桌面</span>
			</div>
		</div>
	</div>
</div>
</body>
</html>
