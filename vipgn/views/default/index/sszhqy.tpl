<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<{$public}>/css/common.css" rel="stylesheet" type="text/css">
<title>查看参会企业</title>
</head>

<body style="background-color:#E0F0FE">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 查看参会企业 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>查看：</h2>
</div>
<br />
<form action="<{$url}>/selqy" method="post">
<select name="id">
	<{section loop=$data name="ls"}>
	<option value="<{$data[ls].id}>"><{$data[ls].holddates|date_format:"%Y-%m-%d"}>--><{$data[ls].title}></option>
	<{sectionelse}>
		<option>你的地区暂时没有开招聘会</option>
	<{/section}>
	
</select>
<input type="submit" value="查看参会企业">
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