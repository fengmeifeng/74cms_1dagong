<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<{$public}>/css/common.css" rel="stylesheet" type="text/css">
<title>修改用户</title>
</head>
<style>
table th{
	font-size: 12px;
	font-weight : 500;
}
</style>
<body style="background-color:#E0F0FE">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 修该用户 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>修改：</h2>
</div>
<br />

<form action="<{$url}>/upmod" method="post" name="form1">
<table width="100%" border="0" cellpadding="3" cellspacing="3"  class="admin_table">
  <tr>
    <th scope="row" width="100" align="right">地区：&nbsp;</th>
    <td>
    <select name="subsite_id" >
		<{section loop=$dq name="ls"}>
	  	<option value="<{$dq[ls].s_id}>"><{$dq[ls].s_districtname}></option>
		<{/section}>
    </select>
    </td>
  </tr>
  <tr>
	<input type="hidden" name="id" value="<{$data.id}>" /><!--id-->
    <th scope="row" align="right">企业id：&nbsp;</th>
    <td>&nbsp;<input type="text" name="qid" size="40" value="<{$data.qid}>" readonly="readonly" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业用户名：&nbsp;</th>
    <td>&nbsp;<input type="text" name="username" size="40" value="<{$data.username}>" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业公司名：&nbsp;</th>
    <td>&nbsp;<input type="text" name="title" size="40" value="<{$data.title}>" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业logo：&nbsp;</th>
    <td>&nbsp;
    	<img src="" class="xsgslogo"/>
    	<input type="hidden" name="pic" value="<{$data.pic}>" />
    </td>
  </tr>
  <tr>
    <th scope="row" align="right">企业介绍&nbsp;</th>
    <td>&nbsp;<textarea rows="10" cols="60" class="qyjs" name="contents"><{$data.contents}></textarea></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业类型：&nbsp;</th>
    <td>
	  <select name="huiyuan" >
		<option value="1">正式会员</option>
		<option value="2">免费体验会员</option>
		<option value="3">橱窗赠送会员</option>
	  </select>
	</td>
  </tr>
  <tr>
    <th scope="row" align="right">企业电话：&nbsp;</th>
    <td>&nbsp;<input type="text" name="phone" size="40" value="<{$data.phone}>" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业邮箱：&nbsp;</th>
    <td>&nbsp;<input type="text" name="email" size="40" value="<{$data.email}>" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">销售代表：&nbsp;</th>
    <td>&nbsp;<input type="text" name="xs_user" size="40" value="<{$data.xs_user}>" /></td>
  </tr>
</table>
<input type="submit" value="修改" class="admin_submit" />
</form>
</div>
<!---->
<script type="text/javascript">
document.form1.subsite_id.value = "<{$data.subsite_id}>";
if("<{$data.huiyuan}>"==0){
	document.form1.huiyuan.value = "1";
}else{  
	document.form1.huiyuan.value = "<{$data.huiyuan}>";
}
</script>
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