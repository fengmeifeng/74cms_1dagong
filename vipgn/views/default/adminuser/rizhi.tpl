<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<{$public}>/css/common.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<{$public}>/js/jquery.js"></script>
<title>查看管理员</title>
</head>

<body style="background-color:#E0F0FE">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 查看日志 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>查看</h2>
</div>
<br />
<div>
<form action="<{$url}>/rz" method="post">
关键词:<input type="text" name="key" style="">
<input type="submit" value="查找">
</form>
</div>
<br />
<div class="pagetit">
<table width="1800" border="0" cellpadding="0" cellspacing="0" id="list" class="link_bk">
<tr>
	<th scope="col" class="admin_list_tit" width="80" align="left" style="padding-left:10px;"><input type="checkbox" />操作人</th>
	<th scope="col" class="admin_list_tit" width="80" align="center">ip</th>
	<th scope="col" class="admin_list_tit" width="150" align="center">时间</th>
	<th scope="col" class="admin_list_tit" width="1000" align="left">sql</th>
</tr>
<{section loop=$data name="ls"}>
<tr>
	<td class="admin_list" align="left" style="padding-left:10px;"><input type="checkbox" name="id[]" value='<{$data[ls].rz_id}>'><{$data[ls].rz_id}> <{$data[ls].name}></td>
	<td class="admin_list" align="center"><{$data[ls].ip}></td>
    <td class="admin_list" align="center"><{$data[ls].time|date_format:"%Y-%m-%d %H:%M:%S"}></td>
	<td class="admin_list" align="left" ><{$data[ls].sqlx}></td>
</tr>
<{sectionelse}>
   <tr>
     <td colspan="4">没有找到!</td>
   </tr>
<{/section}>
<tr>
 <td colspan="4"><{$fpage}></td>
</tr>
</table>
</div>
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