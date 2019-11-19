<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<{$public}>/css/common.css" rel="stylesheet" type="text/css">
<title>查看用户</title>
</head>

<body style="background-color:#E0F0FE">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 查看用户 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>查看：</h2>
</div>
<br />
<form action="<{$url}>/ckvip" method="post">
<input type="text" name="name" />
<input type="submit" value="查找用户">	&nbsp;&nbsp;<a href="<{$url}>/ckvip">查看全部</a>	&nbsp;&nbsp;<a href="<{$url}>/ckvip/bl/1">已办理</a>	&nbsp;&nbsp;<a href="<{$url}>/ckvip/bl/2">未办理</a>
</form>
<hr />
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="list" class="link_bk" >
  <tr>
  	 <th scope="col" class="admin_list_tit" width="55" ><input type="checkbox" />id</th>
    <th scope="col" class="admin_list_tit" width="90" align="left">企业用户名</th>
    <th scope="col" class="admin_list_tit" width="220" align="left">企业公司名</th>
	<th scope="col" class="admin_list_tit" width="50" align="left">地区</th>
    <th scope="col" class="admin_list_tit" width="80" align="center">企业QQ</th>
    <th scope="col" class="admin_list_tit" width="80" align="center">企业电话</th>
    <th scope="col" class="admin_list_tit" width="120" align="center">企业邮箱</th>
	<th scope="col" class="admin_list_tit" width="100" align="center">添加时间</th>
	<th scope="col" class="admin_list_tit" width="65" align="center">是否办理业务</th>
	<th scope="col" class="admin_list_tit" width="120" align="center">操作</th>
  </tr>
<{section loop=$data name="ls"}>
  <tr>
    <td class="admin_list" align="left" style="padding-left:20px;"><input type="checkbox" name="id[]" value='<{$data[ls].id}>'><{$data[ls].id}></td>
    <td class="admin_list"><{$data[ls].username}></td>
    <td class="admin_list"><{$data[ls].title}></td>
	<td class="admin_list"><{$data[ls].dq}></td>
    <td class="admin_list" align="center"><{$data[ls].qq}></td>
    <td class="admin_list" align="center"><{$data[ls].phone}></td>
    <td class="admin_list" align="center"><{$data[ls].email}></td>
    <td class="admin_list" align="center"><{$data[ls].addtime|date_format:"%Y-%m-%d %H:%M:%S"}></td>
	<td class="admin_list" align="center"><{$data[ls].bl|replace:"1":"已办理"|replace:"0":"未办理"}></td>
	<td class="admin_list" align="center">&nbsp;<a href="<{$url}>/upvip/id/<{$data[ls].id}>">修改</a>&nbsp;&nbsp;<a href="<{$url}>/del/id/<{$data[ls].id}>" onclick="return confirm('你确定要删除吗？')">删除</a>&nbsp;&nbsp;<a href="<{$url}>/blvip/id/<{$data[ls].id}>">办理</a></td>
  </tr>
<{sectionelse}>
   <tr>
     <td colspan="10">暂时找到用户!</td>
   </tr>
<{/section}>

</table>
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