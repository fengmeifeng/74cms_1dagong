<html>
<head>
<title>菜单头部条</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<style type="text/css">
*{margin: 0px; padding: 0px;}
#welcome{
	width: 360px;
	padding-left: 0px;
	font-size: 14px;
	text-align: left;
	height: 26px;
	margin-left: 10px; 
	line-height: 26px;
	display: inline-block;
}
#welcome span {
	color: #E94200;
	font-weight: bold;
}
.caidan{
	display: inline-block;
	width: 180px;
}
.tz{
	width: 100px;
	display: inline-block;
}
.timer{
	font-size: 13px;
}
</style>

<script language="JavaScript">
// 显示服务器的当前时间
function timeview(){
  timestr=new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());
  time_area.innerHTML = timestr;
  window.setTimeout( "timeview()", 1000 );
}
</script>
</head>
<body bgcolor="#D6F6FF" onload="timeview();">
<div style="height:27px;background: url(<{$res}>/css/img/head-right-bg.jpg) top right repeat-x;)">
	<div style="height:27px;background: url(<{$res}>/css/img/head-bg.jpg) top right no-repeat;">
		<div id="welcome">
			欢迎您，<span><{$user.dqname}></span> [<{$user.qx_name}>]
		</div>
		<div class="caidan">
					
		</div>
		<div class="tz">
			<a href="javascript:history.back();" ><img src="<{$res}>/css/img/back.gif" align="absmiddle"></a>&nbsp;
			<a href="javascript:history.forward();" ><img src="<{$res}>/css/img/forward.gif" align="absmiddle"></a>
		</div>
		<span id="time_area" class="timer"> </span>
	</div>
</div>
</body>
</html>