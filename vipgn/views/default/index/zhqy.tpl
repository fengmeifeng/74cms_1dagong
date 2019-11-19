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
<body style="background-color:#E0F0FE; width:120%;">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 查看 <{$jobfair_text}> 预定名单</div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>查看: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<{$app}>/excel/zhqy/zhid/<{$zid}>">生成Excel</a></h2>
</div>

<input type="button" value="添加" class="tj admin_submit">&nbsp;&nbsp;
| &nbsp;&nbsp;
<form action="<{$url}>/selssqy" method="post" style="display:inline-block;">
<input type="hidden" name="id" value="<{$zid}>" />
<input type="text" name="name" >
<input type="submit" value="查找" >
</form>
<hr />
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="list" class="link_bk" >
  <tr>
  <th scope="col" class="admin_list_tit" width="130" align="left" style="padding-left:5px;"><input type="checkbox" />企业用户名</th>
  <th scope="col" class="admin_list_tit" width="220" align="left">企业公司名</th>
    <th scope="col" class="admin_list_tit" width="60" align="center">销售代表</th>
	<th scope="col" class="admin_list_tit" width="60" align="center">地区</th>
  <th scope="col" class="admin_list_tit" width="80" align="center">企业电话</th>
  <th scope="col" class="admin_list_tit" width="150" align="center">企业邮箱</th>
  <th scope="col" class="admin_list_tit" width="50" align="center">展位号</th>
  <th scope="col" class="admin_list_tit" width="80" align="center">会员类型</th>
	<th scope="col" class="admin_list_tit" width="65" align="center">套餐类型</th>
	<th scope="col" class="admin_list_tit" width="65" align="center">预定方式</th>
	<th scope="col" class="admin_list_tit" width="120" align="center">预定时间</th>
	<th scope="col" class="admin_list_tit" width="120" align="center">操作</th>
  <th scope="col" class="admin_list_tit" align="center">备注</th>
  </tr>
<{section loop=$data name="ls"}>
  <tr class="tab">
    <td class="admin_list" align="left" style="padding-left:5px;"><input type="checkbox" name="id[]" value='<{$data[ls].id}>'><{$data[ls].username}></td>
    <td class="admin_list"><{$data[ls].title}></td>
	<td class="admin_list" align="center"><{$data[ls].xs_user}></td>
	<td class="admin_list" align="center"><{$data[ls].dq}></td>
    <td class="admin_list" align="center"><{$data[ls].phone}></td>
    <td class="admin_list" align="center"><{$data[ls].email}></td>
    <td class="admin_list" align="center"><{$data[ls].number}></td>
	<td class="admin_list" align="center"><{$data[ls].huiyuan|replace:"0":"正式会员"|replace:"2":"免费体验"|replace:"3":"橱窗赠送"|replace:"4":"苏州用户"}></td>
	<td class="admin_list" align="center"><{$data[ls].yhtype|replace:"1":"套餐用户"|replace:"2":"积分用户"|replace:"3":"临时用户"|replace:"4":"无"}></td>
	<td class="admin_list" align="center"><{$data[ls].online_aoto|replace:"1":"自动预定"|replace:"2":"在线预定"|replace:"3":"手动添加"|replace:"4":"无"}></td>
	<td class="admin_list" align="center"><{$data[ls].add_time|date_format:"%Y-%m-%d %H:%M:%S"}></td>
	<td class="admin_list" align="center"><a href="<{$url}>/gzw/id/<{$data[ls].id}>">更改展位</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<{$url}>/gdel/id/<{$data[ls].id}>/zhid/<{$zid}>" onclick="return confirm('你确定要删除吗？')">删除</a></div>
  <td class="admin_list" align="left"><{$data[ls].text}></td>
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

<script type="text/javascript">
  $(function(){
      $(".tj").click(function(){
          $(".box").show();
      })
      //--------------------------------------------
      $(".yd").click(function(){
          var a=$(this).text();
          $("#number").val(a);
          $(".yd").css("color","#000");
          $(this).css("color","red");
      });
      //--------------------------------------------
      $(".ydl").click(function(){
          alert("这个展位被预定了 （＞﹏＜）");
      })
      //--------------------------------------------
      $(".sub").click(function(){
          var url=$(this).attr("url");
          var number=$("#number").val(),
              zid=$("input[name=zid]").val(),
              yhtype=$("input[name=yhtype]").val(),
              online_aoto=$("input[name=online_aoto]").val(),
              title=$("input[name=title]").val(),
              subsite_id=$("input[name=subsite_id]").val(),
              qq=$("input[name=qq]").val(),
              phone=$("input[name=phone]").val(),
              email=$("input[name=email]").val(),
			  xs_user=$("input[name=xs_user]").val(),
              text=$("textarea[name=text]").val();
			  //验证是否是否输入-------------------------
			  if(number==""){
					alert("展位号必须选择！才可以预定！");
			  }else if(title==""){
					alert("企业公司名必须选择！才可以预定！");
			  }else{
			  //--------------------------
				  $.post(url, { number:number,zid:zid,yhtype:yhtype,online_aoto:online_aoto,title:title,subsite_id:subsite_id,qq:qq,phone:phone,email:email,text:text,xs_user:xs_user },
				  function(data){
					  alert(data);
					  window.location.reload(); 
				  });
			  }
      })
  });
  //--------------------
  function gb(){
     $(".box").hide();
  };

</script>
<!--***************************************-->
<div class="box">
    <div class="ock" onclick="gb();"> </div>
    <div class="nr">

      <div class="myd">
        <p style="text-align: center; padding-bottom: 10px;">没有被预订的展位 o(∩_∩)o </p>
        <!--没有预定的展位-->
        <{section loop=$all name="ls"}>
        <div class="z yd" title="这个展位还没被预定。"><span class="yc"> <{$all[ls].number}> </span></div>
        <{/section}>
      </div>
      <div class="yyd">
        <p style="text-align: center; padding-bottom: 10px;">已经被预订的展位 (╯＾╰) </p>
        <!--预定过的展位-->
        <{section loop=$ok name="ls"}>
        <div class="z ydl" title="这个展位被<{$ok[ls].title}>预定了，请下次再来把!"><span class="yc"><{$ok[ls].number}></span></div>
        <{/section}>
      </div>
    <!--**********************-->
  <input type="hidden" name="number" id="number" value="" />
  <input type="hidden" name="zid" value="<{$zid}>" />
  <input type="hidden" name="yhtype" value="3" />
  <input type="hidden" name="online_aoto" value="3" />
  <div style="float:none;"></div>
  <table width="100%" border="0" cellpadding="3" cellspacing="3"  class="admin_table" style="float:left; margin-top: 10px; ">
  <tr>
    <th scope="row" align="right" width="100">企业公司名：&nbsp;</th>
    <td width="240">&nbsp;<input type="text" name="title" size="40" value="" /></td>
    <td rowspan="5">
      <span style="font-size: 12px; font-weight: bolder;">备注：</span><br/>
      <textarea rows="8" cols="33" name="text"></textarea>
    </td>
  </tr>
  <tr>
    <th scope="row" align="right">地区：</th>
    <td><{$dq}></td>
  <input type="hidden" name="subsite_id" value="<{$dqid}>" />
  </tr>
  <tr>
    <th scope="row" align="right">企业qq：&nbsp;</th>
    <td>&nbsp;<input type="text" name="qq" size="40" value="" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业电话：&nbsp;</th>
    <td>&nbsp;<input type="text" name="phone" size="40" value="" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业邮箱：&nbsp;</th>
    <td>&nbsp;<input type="text" name="email" size="40" value="" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">销售代表：&nbsp;</th>
    <td>&nbsp;<input type="text" name="xs_user" size="40" value="" /></td>
  </tr>
</table>
<input type="button" value="添加" class="admin_submit sub" url="<{$url}>/jinji">
    </div>
</div>
<!--***************************************-->
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