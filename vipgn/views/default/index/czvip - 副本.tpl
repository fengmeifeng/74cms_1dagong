<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<{$public}>/css/common.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<{$public}>/js/jquery.js"></script>
<link href="<{$public}>/css/date_input.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src="<{$public}>/js/jquery.date_input.js" language="javascript"></script>
<title>修改</title>
</head>
<script>
$(document).ready(function(){
	//日期
	$(function() { 
		$(".date_input").date_input(); 
	});
});

function bout(){
	return $('#boutj').val();
}

</script>
<body style="background-color:#E0F0FE">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 修改 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>添加：</h2>
</div>
<br />
<form action="<{$url}>/updata" method="post">
<input type="hidden" name="id" value="<{$data.id}>" />
<input type="hidden" name="bout1" value="<{$data.bout}>" />
<input type="hidden" name="bout1_6" value="<{$data.bout_6}>" />
<input type="hidden" name="subsite_id" value="<{$data.subsite_id}>" />
<input type="hidden" name="cs" value="1" />
当前剩余展会次数：<b><{$data.bout}></b><br /><br />

操作次数：&nbsp;&nbsp;<input type="radio" value="1"  checked="checked" name="cz"/>增加&nbsp;<input type="radio" value="2" name="cz"/>减少<br />
增减次数：<input type="text" name="bout"/><br />
<{ if $data.subsite_id == 5}>
当前剩余周六次数：<b><{$data.bout_6}></b><br /><br />

操作次数：&nbsp;&nbsp;<input type="radio" value="1"  checked="checked" name="cz_6"/>增加&nbsp;<input type="radio" value="2" name="cz_6"/>减少<br />
增减次数：<input type="text" name="bout_6"/><br />
<{/if}>
<input type="submit" value="确定" class="admin_submit" />
</form>
<hr />
<br />

<h3>修改生效时间</h3>
<form action="<{$url}>/updatasj" method="post">
<input type="hidden" name="id" value="<{$data.id}>" />
<!-------------------->
开始时间：<input type="text" name="cs_ks_time" class="date_input"  value="<{$smarty.now|date_format:'%Y-%m-%d'}>" /><br />
结束时间：<input type="text" name="cs_end_time" class="date_input"  value="" /><br />
<!-------------------->
<input type="submit" value="确定" class="admin_submit" />
</form>
</div>
<!--底栏-->
<div class="footer link_lan">
Powered by <a href="http://www.74cms.com" target="_blank"><span style="color:#009900">74</span><span style="color: #FF3300">CMS</span></a> 3.3.20130614
</div>
<div class="admin_frameset" >
  <div class="open_frame" title="全屏" id="open_frame"></div>
  <div class="close_frame" title="还原窗口" id="close_frame"></div>
</div>
</body>
</html>