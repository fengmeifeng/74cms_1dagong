<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<{$public}>/css/common.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<{$public}>/js/jquery.js"></script>
<title>办理套餐</title>
</head>

<body style="background-color:#E0F0FE">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 办理套餐 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>办理：</h2>
</div>
<br />
<!------------->
<form action="<{$url}>/selectcsvip/dqid/<{$dqid}>" method="post">
查找vip用户：<input type="text" name="username" id="name"/>
<input type="submit" value="查询企业用户">		&nbsp;&nbsp;<a href="<{$url}>/selectcsvip/jh/1/dqid/<{$dqid}>">激活</a>	&nbsp;&nbsp;<a href="<{$url}>/selectcsvip/jh/2/dqid/<{$dqid}>">未激活</a>
</form>
<hr />
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="list" class="link_bk" >
  <tr>
  	<th scope="col" class="admin_list_tit" width="55"><input type="checkbox" />id</th>
    <th scope="col" class="admin_list_tit" width="100" align="left">企业用户名</th>
    <th scope="col" class="admin_list_tit" width="250" align="left">企业公司名</th>
	<th scope="col" class="admin_list_tit" width="50" align="center">地区</th>
	<th scope="col" class="admin_list_tit" width="80" align="center">套餐类型</th>
	<th scope="col" class="admin_list_tit" width="40" align="center">套餐次数</th>
	<th scope="col" class="admin_list_tit" width="70" align="center">开始时间</th>
	<th scope="col" class="admin_list_tit" width="70" align="center">结束时间</th>
	<th scope="col" class="admin_list_tit" width="70" align="center">添加时间</th>
	<th scope="col" class="admin_list_tit" width="80" align="center">套餐是否激活</th>
	<th scope="col" class="admin_list_tit" width="100" align="center">操作</th>
  </tr>
<{section loop=$data name="ls"}>
  <tr>
    <td class="admin_list" align="left" style="padding-left:20px;"><input type="checkbox" name="id[]" value='<{$data[ls].id}>'><{$data[ls].id}></td>
    <td class="admin_list"><{$data[ls].username}></td>
    <td class="admin_list"><{$data[ls].title}></td>
	<td class="admin_list" align="center"><{$data[ls].dq}></td>
    <td class="admin_list" align="center"><{$data[ls].type|replace:"1":"时间套餐"|replace:"0":"次数套餐"}></td>
	<td class="admin_list" align="center"><{$data[ls].bout}></td>
	<td class="admin_list" align="center"><{$data[ls].cs_ks_time|date_format:"%Y-%m-%d"}></td>
	<td class="admin_list" align="center"><{$data[ls].cs_end_time|date_format:"%Y-%m-%d"}></td>
	<td class="admin_list" align="center"><{$data[ls].add_time|date_format:"%Y-%m-%d"}></td>
	<td class="admin_list" align="center"><{$data[ls].activation|replace:"1":"以激活"|replace:"0":"未激活"}></td>
	<td class="admin_list" align="center">&nbsp;<a href="<{$url}>/cjh/id/<{$data[ls].id}>">激活</a>&nbsp;&nbsp;<a href="<{$url}>/operating/id/<{$data[ls].id}>">操作</a>&nbsp;&nbsp;<a href="<{$url}>/tcdel/id/<{$data[ls].id}>/uid/<{$data[ls].uid}>" onclick="return confirm('你确定要删除吗？')">删除</a></td>
  </tr>
<{sectionelse}>
   <tr>
     <td colspan="11">暂时没有找到用户!</td>
   </tr>
<{/section}>
</table>
<!------------->
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