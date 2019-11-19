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
	
	//(入/离)职----
	function status(a,b){
		if(b=='lz'){
			$(".mz").html("离职时间");
			$("input[id='shijian']").attr("name","lizhi_time");
			$("#formshijian").attr("action","<{$url}>/lizhi");
		}
		if(b=='rz'){
			$(".mz").html("入职时间");
			$("input[id='shijian']").attr("name","ruzhi_time");
			$("#formshijian").attr("action","<{$url}>/ruzhi");
		}
		$(".statusxianshi"+a).css("display","");
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
	<td colspan="21" class="biaoti" align="left">&nbsp;今天新增的会员列表</span></td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<{$url}>/jinrenuser" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="name">姓名</option>
				<option value="bianhao">编号</option>
				<option value="sphone">手机号</option>
				<option value="id_number">身份证号</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap width="40">伯乐</td>
	<td noWrap width="95">编号</td>
	<td noWrap width="110">姓名</td>
	<td noWrap width="100">推荐人编号</td>
	<td noWrap width="70">推荐人姓名</td>
	<td noWrap width="45">关系</td>
	<td noWrap width="65">手机号</td>
	<td noWrap width="45">qq</td>
	<td noWrap width="62">会员类型</td>
	<td nowrap width="135">入职时间</td>
    <td nowrap width="135">激活时间</td>
	<td nowrap width="135">添加时间</td>
    <td nowrap width="80">状态</td>
	<td nowrap>备注</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab" onDblClick="location.href='#'">
	<td noWrap > <{$item.xiezhu}> </td>
	<td noWrap  align='left'>&nbsp; <{$item.bianhao}> </td>
	<td noWrap  align='left'> <{$item.name}> </td>
	<td noWrap  align='left'> <{if $item.f_bianghao!='0'}> <{$item.f_bianghao}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.f_name}> </td>
	<td noWrap  align='left'> <{$item.guanxi}> </td>
	<td noWrap  align='right'> <{$item.sphone}> </td>
	<td noWrap  align='right'> <{$item.qq}> </td>
	<td noWrap  align='left'> <{$item.jibie}> </td>
	<td noWrap  align='left'> <{if $item.ruzhi_time!=0}> <{$item.ruzhi_time|date_format:"%Y-%m-%d %H:%M:%S"}> <{/if}> </td>
	<td noWrap  align='left'> <{if $item.jihuo_time!=0}> <{$item.jihuo_time|date_format:"%Y-%m-%d %H:%M:%S"}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.add_time|date_format:"%Y-%m-%d %H:%M:%S"}> </td>
	<td noWrap  align='left'> 
	<{if $item.jihuo=='1'}> <font color="green">已激活</font> <{else}> <font color="red">未激活</font> <{/if}> &nbsp;
	<{if $item.status=='1'}> <font color="green">已入职</font> <{elseif $item.status=='2'}> <font color="red">离职</font>  <{else}> <font color="red">未入职</font> <{/if}>
	</td>
	<td noWrap  align='left'> <{$item.beizu}> </td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="14">
        	没有今天的客户信息
        </td>
    </tr>
<{/if}>
<tr class="biaoti">
	<td align="left" colspan="20">
		<{$fpage_weihu}>
	</td>
</tr>
</table>

<{include file="public/foot.tpl"}>