<{include file="public/head.tpl"}>
<script type="text/javascript" src="<{$res}>/js/WdatePicker/WdatePicker.js"></script>

<script type="text/javascript">
	$(function(){
		//隔行换色
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	});
</script>

<body class="bodycolor">

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="21" class="biaoti" align="left">&nbsp; 搜索会员详情</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<{$url}>/sousuohuiyuan" method="get" style="display:inline;">
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
	<td noWrap width="75">编号</td>
	<td noWrap width="75">姓名</td>
	<td noWrap width="70">推荐人编号</td>
	<td noWrap width="70">推荐人姓名</td>
	<td noWrap width="50">关系</td>
	<td noWrap width="55">推荐人数</td>
	<td noWrap width="110">手机号</td>
	<td noWrap width="130">身份证号码</td>
	<td noWrap width="120">地址</td>
	<td noWrap width="65">会员类型</td>
	<td nowrap width="80">入职时间</td>
	<td nowrap width="70">入职企业</td>
	 <td nowrap width="50">状态</td>
	<td nowrap width="135">激活时间</td>
    <td nowrap width="85">添加时间</td>
	<td nowrap>备注</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab" >
	<td noWrap > <{$item.xiezhu}> </td>
	<td noWrap  align='left'>&nbsp; <{$item.bianhao}> </td>
	<td noWrap  align='left'> <{$item.name}> </td>
	<td noWrap  align='left'> <{if $item.f_bianghao!='0'}> <{$item.f_bianghao}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.f_name}> </td>
	<td noWrap  align='left'> <{$item.guanxi}> </td>
	<td noWrap  align='right'> <{$item.tj_num}>人 </td>
	<td noWrap  align='left'> <{$item.sphone}> </td>
	<td noWrap  align='left'> <{$item.id_number}> </td>
	<td noWrap  align='left'> <{$item.address}> </td>
	<td noWrap  align='left'> <{$item.jibie}> </td>
	<td noWrap  align='center'> <{$item.ruzhi_time|date_format:"%Y-%m-%d"}> </td>
	<td noWrap  align='center'> <div style="width:80px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; " title="<{$item.ruzhi_name}>"> <{$item.ruzhi_name}> </div> </td>
	<td noWrap  align='center'> <{if $item.status=='1'}> <font color="green">在职</font> <{elseif $item.status=='2'}> <font color="red">已离职</font>  <{else}> 无 <{/if}> </td>
	<td noWrap  align='center'> <{if $item.jihuo_time!='0'}> <font color="green">已激活</font> <{$item.jihuo_time|date_format:"%Y-%m-%d %H:%M:%S"}> <{else}> <font color="red"> 未激活 </font>  <{/if}> </td>
	<td noWrap  align='center'> <{$item.add_time|date_format:"%Y-%m-%d"}> </td>
	<td noWrap  align='left'> <{$item.beizu}> </td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="21">
        	请搜索要找的会员！
        </td>
    </tr>
<{/if}>
<tr class="biaoti">
	<td align="left" colspan="21" >
		<{$fpage_weihu}>
	</td>
</tr>
</table>

<{include file="public/foot.tpl"}>