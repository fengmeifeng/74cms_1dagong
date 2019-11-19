<?php /* Smarty version 2.6.18, created on 2014-09-01 17:51:28
         compiled from index/head.tpl */ ?>
<html>
<head>
<title>菜单头部条</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['public']; ?>
/js/jquery.js"></script>
<style type="text/css">
*{margin: 0px; padding: 0px;}
#welcome{
	width: 320px;
	padding-left: 0px;
	font-size: 14px;
	text-align: left;
	height: 26px;
	margin-left: 10px; 
	line-height: 26px;
	display: inline;
}
#welcome span {
	color: #E94200;
	font-weight: bold;
}
.caidan{
	display: inline;
	width: 300px;
	margin-left: 20px;
	font-size: 12px;
}
.tz{
	width: 250px;
	margin-left: 250px;
	margin-left: 50px\9;
	display: inline;
}
.timer{
	font-size: 13px;
	margin-left:30px;
	margin-left:0px\9;
}
</style>

<script language="JavaScript">

	//显示服务器的当前时间
	function timeview(){
	  timestr=new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());
	  time_area.innerHTML = timestr;
	  window.setTimeout( "timeview()", 1000);
	}
</script>

</head>
<body bgcolor="#D6F6FF" onload="timeview();">
<div style="height:27px;background: url(<?php echo $this->_tpl_vars['res']; ?>
/css/img/head-right-bg.jpg) top right repeat-x;)">
	<div style="height:27px;background: url(<?php echo $this->_tpl_vars['res']; ?>
/css/img/head-bg.jpg) top right no-repeat;">
		<div id="welcome">
			欢迎您，<span><?php echo $this->_tpl_vars['user']['name']; ?>
</span> [<?php echo $this->_tpl_vars['dq']; ?>
, <?php echo $this->_tpl_vars['user']['priv_name']; ?>
]
		</div>
		<div class="caidan">
		</div>
		<div class="tz">
			<a href="javascript:history.back();"><img src="<?php echo $this->_tpl_vars['res']; ?>
/css/img/back.gif" align="absmiddle" border="0"></a>&nbsp;
			<a href="javascript:history.forward();"><img src="<?php echo $this->_tpl_vars['res']; ?>
/css/img/forward.gif" align="absmiddle" border="0"></a>
		</div>
		<span id="time_area" class="timer"> </span>
	</div>
</div>
</body>
</html>