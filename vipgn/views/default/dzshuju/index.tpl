<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<{$public}>/css/common.css" rel="stylesheet" type="text/css">
<link href="<{$public}>/css/zhqy.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<{$public}>/js/jquery.js"></script>
<title>查看参会企业</title>
</head>
<script type="text/javascript">
  $(function(){
    //隔行换色
    $(".tab:even").css("background","#FFFFFF");
    $(".tab:odd").css("background","#F8F8F8");  
    //鼠标移上换色
    $(".tab").hover(
      function(){
        $(this).css("background","#CFDDEA");
      },
      function(){
        $(".tab:even").css("background","#FFFFFF");
      $(".tab:odd").css("background","#F8F8F8");
    });
  });
</script>
<body style="background-color:#E0F0FE;">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
  <div class="ptit"> 查看的参会企业 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>查看: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<{if $dq!=""}>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;地址：&nbsp;
<{foreach from=$dq item=l}>  
<a href="<{$url}>/index/id/0/dqid/<{$l.s_id}>"><{$l.s_districtname}></a>&nbsp;&nbsp;
<{/foreach}>
<{/if}>
</h2>
</div>

<form action="<{$url}>/index/id/<{$dqid}>" method="post" style="display:inline-block;">
查找企业: <input type="text" name="name" >
<input type="hidden" name="dqid" value="<{$dqid}>" />
<input type="submit" value="查找" >
</form>
<hr />
<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0" id="list" class="link_bk" >
  <tr>
  <th scope="col" class="admin_list_tit" width="220" align="left" style="padding-left:10px;"><input type="checkbox" />企业用户名</th>
  <th scope="col" class="admin_list_tit" width="320" align="left">企业公司名</th>
  <th scope="col" class="admin_list_tit" width="80" align="left">销售代表</th>
  <th scope="col" class="admin_list_tit" width="80" align="center">地区</th>
  <th scope="col" class="admin_list_tit" width="80" align="center">企业qq</th>
  <th scope="col" class="admin_list_tit" width="120" align="center">企业电话</th>
  <th scope="col" class="admin_list_tit" width="180" align="center">企业邮箱</th>
  <th scope="col" class="admin_list_tit" width="100" align="center">操作</th>
  </tr>
<{section loop=$data name="ls"}>
  <tr class="tab">
  <td class="admin_list" align="left" style="padding-left:10px;"><input type="checkbox" name="id[]" value='<{$data[ls].id}>'><{$data[ls].username}></td>
  <td class="admin_list"><a href="<{$url}>/ckdz/id/<{$data[ls].qid}>"><{$data[ls].title}></a></td>
  <td class="admin_list"><{$data[ls].xs_user}></td>
  <td class="admin_list" align="center"><{$data[ls].dq}></td>
  <td class="admin_list" align="center"><{$data[ls].qq}></td>
  <td class="admin_list" align="center"><{$data[ls].phone}></td>
  <td class="admin_list" align="center"><{$data[ls].email}></td>
  <td class="admin_list" align="center"><a href="<{$url}>/ckdz/id/<{$data[ls].qid}>">查看</a></td>
  </tr>
<{sectionelse}>
   <tr>
     <td colspan="9">暂时没有找到用户!</td>
   </tr>
<{/section}>

<tr>
  <td colspan="10" class="admin_list"><{$fpage}></td>
<tr>

</table>

</div>
</body>
</html>