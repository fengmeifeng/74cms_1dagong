<{include file="public/head.tpl"}>
<script type="text/javascript" src="<{$res}>/js/WdatePicker/WdatePicker.js"></script>

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
		
		//checkbox,全选/全不选
		$(".ckbox").bind("click", function(){ 
			if($(".ckbox:checkbox").attr("checked")){
				$("[name = selectid[]]:checkbox").attr("checked", true);
			}else{
				$("[name = selectid[]]:checkbox").attr("checked", false);
			}
        });
	});
	
	//离职----
	function statusl(a,b){
		if(b=='lz'){
			$(".mz").html("离职时间");
			$("input[id='shijian']").attr("name","lizhi_time");
			$("#formshijian").attr("action","<{$url}>/lizhi");
		}
		$(".statusxianshil"+a).css("display","");
		$("body").append("<div class='zhezhao' onclick='gb()'> </div>");
	}
	
	//入职----
	function statusr(a,b){
		if(b=='rz'){
			$(".mz").html("入职时间");
			$("input[id='shijian']").attr("name","ruzhi_time");
		}
		$(".statusxianshir"+a).css("display","");
		$("body").append("<div class='zhezhao' onclick='gb()'> </div>");
	}
	//关闭弹出框---
	function gb(){
		$(".status").css("display","none");
		$(".zhezhao").remove();
	}
	
</script>

<body class="bodycolor">

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="21" class="biaoti" align="left">&nbsp;已激活会员列表</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<{$url}>/jihuiuser" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="name">姓名</option>
				<option value="bianhao">编号</option>
				<option value="sphone">手机号</option>
				<option value="id_number">身份证号</option>
				<option value="ruzhi_name">入职企业</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			
			<select name="shijianduan" class="SmallSelect">
				<option value="">选择时间段</option>
				<option value="add_time">添加时间</option>
				<option value="ruzhi_time">入职时间</option>
				<option value="jihuo_time">激活时间</option>
			</select>
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			<input type="submit" value=" 查找 " class="sub">
			<input type="button" value=" 导出 " class="sub" onclick="location='<{$url}>/daochuexcel?<{$changshu}>';">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap width="75">编号</td>
	<td noWrap width="120">姓名</td>
	<td noWrap width="70">推荐人编号</td>
	<td noWrap width="70">推荐人姓名</td>
	<td noWrap width="50">关系</td>
	<td noWrap width="65" onDblClick="location.href='<{$url}>/jihuiuser/paixu/jiangjin/fs/<{$fs}>' " style="cursor:pointer" >奖金</td>
	<td noWrap width="45">推荐</td>
	<td noWrap width="65">会员类型</td>
	<td nowrap width="80">入职时间</td>
	<td nowrap width="70">入职企业</td>
	<td nowrap width="135">激活时间</td>
    <td nowrap width="85">添加时间</td>
    <td nowrap width="50">状态</td>
	<td nowrap width="60">添加地区</td>
    <td nowrap width="200">操作</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab" >
	<td noWrap  align='left'>&nbsp; <{$item.bianhao}> </td>
	<td noWrap  align='left'> <{$item.name}> </td>
	<td noWrap  align='left'> <{if $item.f_bianghao!='0'}> <{$item.f_bianghao}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.f_name}> </td>
	<td noWrap  align='left'> <{$item.guanxi}> </td>
	<td noWrap  align='right'> <{$item.jiangjin}>元 </td>
	<td noWrap  align='right'> <{$item.tj_num}>人 </td>
	<td noWrap  align='left'> <{$item.jibie}> </td>
	<td noWrap  align='center'> <{$item.ruzhi_time|date_format:"%Y-%m-%d"}> </td>
	<td noWrap  align='center'> <div style="width:80px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; " title="<{$item.ruzhi_name}>"> <{$item.ruzhi_name}> </div> </td>
	<td noWrap  align='center'> <{$item.jihuo_time|date_format:"%Y-%m-%d %H:%M:%S"}> </td>
	<td noWrap  align='center'> <{$item.add_time|date_format:"%Y-%m-%d"}> </td>
	<td noWrap  align='center'> <{if $item.status=='1'}> <font color="green">在职</font> <{elseif $item.status=='2'}> <font color="red">已离职</font>  <{else}> 无 <{/if}> </td>
    <td noWrap  align='left'> <{$item.add_gs}> </td>
	<td noWrap  align='center'> <a href="<{$url}>/huiyuaninfo/id/<{$item.id}>/dqurl/jihuiuser">查资料</a> <a href="<{$url}>/huiyuantuijian/id/<{$item.id}> "> 推荐列表</a>  
		 <{if $item.status=='1'}>
		 <a href="javascript:;" onclick="statusl(<{$item.id}>,'lz')"> 离职 </a> 
		 <{elseif $item.status=='2'}>
		 <a href="javascript:;" onclick="statusr(<{$item.id}>,'rz')"> 入职 </a> 
		 <{/if}>
		 
		 <div class="status statusxianshil<{$item.id}>" style='display:none;margin: 4px -25px;'>  
			<div class="content"> 
				<form method="post" action="<{$url}>/lizhi" id="formshijian">
					<input type="hidden" name="id" value="<{$item.id}>" />
					<span class="mz"></span>：<input type="text" id="shijian" size="8" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})" />
					<input type="submit" value="提交"/>
				</form> </div><s style="left: 162px"><i></i></s> 
		 </div>
		 
		<div class="status statusxianshir<{$item.id}>" style='display:none;margin: 4px -25px;'>  
			<div class="content" style="height:60px;line-height:25px; padding-top:15px;"> 
				<form method="post" action="<{$url}>/ruzhihuiyuan" id="formshijian">
					<input type="hidden" name="id" value="<{$item.id}>" />
					<span>入职公司</span>：<input type="text" id="ruzhi_name" name="ruzhi_name" size="13" /> <br/>
					<span class="mz"></span>：<input type="text" id="shijian" size="8" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})" />
					<input type="submit" value="提交"/>
				</form> </div><s style="left: 162px"><i></i></s> 
		</div>
		
	</td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="21">
        	没有找到激活的会员
        </td>
    </tr>
<{/if}>
<tr class="biaoti">
	<td align="left" colspan="20" >
		<{$fpage_weihu}>
	</td>
</tr>
</table>

<{include file="public/foot.tpl"}>