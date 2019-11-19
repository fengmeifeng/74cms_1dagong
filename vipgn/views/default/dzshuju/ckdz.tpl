<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<{$public}>/css/common.css" rel="stylesheet" type="text/css">
<link href="<{$public}>/css/zhqy.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<{$public}>/js/jquery.js"></script>
<title>查看参会企业参加的展会</title>
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
  <div class="ptit"> 查看参会企业 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>查看: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<{$app}>/excel/qyzhanghui/id/<{$qid}>">生成Excel</a></h2>
</div>
<hr />
<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0" id="list" class="link_bk" >
  <tr>
	<th scope="col" class="admin_list_tit" width="280" align="left" style="padding-left:10px;"><input type="checkbox" />招聘会标题</th>
	<th scope="col" class="admin_list_tit" width="120" align="center">举办时间</th>
	<th scope="col" class="admin_list_tit" width="260" align="left">企业公司名</th>
	<th scope="col" class="admin_list_tit" width="80" align="center">销售代表</th>
	<th scope="col" class="admin_list_tit" width="80" align="center">地区</th>
	<th scope="col" class="admin_list_tit" width="50" align="center">展位号</th>
	<th scope="col" class="admin_list_tit" width="80" align="center">用户类型</th>
	<th scope="col" class="admin_list_tit" width="80" align="center">预定方式</th>
	<th scope="col" class="admin_list_tit" width="80" align="center">预定时间</th>
  </tr>
<{section loop=$data name="ls"}>
  <tr class="tab">
  <td class="admin_list" align="left" style="padding-left:10px;"><input type="checkbox" name="id[]" value='<{$data[ls].id}>'><{$data[ls].qytitle}></td>
  <td class="admin_list" align="center"><{$data[ls].holddates|date_format:"%Y-%m-%d"}></td>
  <td class="admin_list"><{$data[ls].title}></td>
  <td class="admin_list" align="center"><{$data[ls].xs_user}></td>
  <td class="admin_list" align="center"><{$data[ls].dq}></td>
  <td class="admin_list" align="center"><{$data[ls].number}></td>
  <td class="admin_list" align="center"><{$data[ls].yhtype|replace:"1":"套餐用户"|replace:"2":"积分用户"|replace:"3":"临时用户"}></td>
  <td class="admin_list" align="center"><{$data[ls].online_aoto|replace:"1":"自动预定"|replace:"2":"在线预定"|replace:"3":"手动添加"}></td>
  <td class="admin_list" align="center"><{$data[ls].add_time|date_format:"%Y-%m-%d"}></td>
  </tr>
<{sectionelse}>
   <tr>
     <td colspan="9">没有找到!</td>
   </tr>
<{/section}>


<tr>
  <td colspan="9" class="admin_list"><{$fpage}></td>
<tr>

</table>

</div>
</body>
</html>