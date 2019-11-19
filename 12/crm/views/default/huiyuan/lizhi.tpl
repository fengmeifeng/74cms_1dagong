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
</script>

<body class="bodycolor">

<br/>
<table align="center" class="addtab" cellspacing='0' cellpadding='0' border="1" width="100%"  >

<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<{$url}>/lizhi" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="name">姓名</option>
				<option value="bianhao">编号</option>
				<option value="sphone">手机号</option>
				<option value="id_number">身份证号</option>
				<option value="ruzhi_name">入职企业</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			
			
			<select name="lsr" class="SmallSelect">
				<option value="">选择隶属人</option>
				<{foreach from=$user item=u}>
					<option value="<{$u.id}>"> <{$u.name}> </option>
				<{/foreach}>
			</select>
			
			<select name="shijianduan" class="SmallSelect">
				<option value="">选择时间段</option>
				<option value="add_time">添加时间</option>
				<option value="ruzhi_time">入职时间</option>
				<option value="jihuo_time">激活时间</option>
			</select>
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>

<tr>
	<td colspan="21" class="biaoti" align="left">&nbsp;离职会员</span></td>
</tr>
<tr class="biaoti">
	<td noWrap width="115">隶属人</td>
	<td noWrap width="40">联系</td>
	<td noWrap width="45">编号</td>
	<td noWrap width="60">姓名</td>
	<td noWrap width="70">推荐人编号</td>
	<td noWrap width="70">推荐人姓名</td>
	<td noWrap width="40">关系</td>
	<td noWrap width="35">性别</td>
	<td noWrap width="45">手机号</td>
	<td noWrap width="45">QQ</td>
	<td noWrap width="65">地址</td>
    <td nowrap width="50">添加时间</td>
	<td nowrap width="85">入职状态于时间</td>
	<td nowrap width="55">入职企业</td>
	<td nowrap width="85">激活状态于时间</td>
	<td nowrap width="80">备注</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab" onDblClick="location.href='<{$url}>/upuser/id/<{$item.id}>'">
	<td noWrap  align='left'> 
		<input type="checkbox" name="selectid[]" id="selectid" value="未知">
		<a href="<{$url}>/upuser/id/<{$item.id}>"><img src="<{$res}>/images/edit1.gif" title="修改记录" border="0"></a>
		<a href="<{$url}>/gzuser/id/<{$item.id}>"><img src="<{$res}>/images/6710a.gif" title="跟踪记录" border="0"></a>
		<{if $item.lsr!=''}> <{$item.lsr}> <{/if}> </td>
	<td noWrap  align='left'><{$item.lxts}> </td>
	<td noWrap  align='left'><{$item.bianhao}> </td>
	<td noWrap  align='left'> <{$item.name}> </td>
	<td noWrap  align='left'> <{if $item.f_bianghao!='0'}> <{$item.f_bianghao}> <{/if}> </td>
	<td noWrap  align='left'> <{if $item.f_name!=''}> <{$item.f_name}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.guanxi}> </td>
	<td noWrap  align='left'> <{$item.sex}> </td>
	<td noWrap  align='right'> <{$item.sphone}> </td>
	<td noWrap  align='right'> <{$item.qq}> </td>
	<td noWrap  align='left'> <{$item.address}> </td>
	<td noWrap  align='center'> <{$item.add_time|date_format:"%Y-%m-%d"}> </td>
	<td noWrap  align='center'> <{if $item.status=='1'}> <font color="green">已入职</font> <{elseif $item.status=='2'}> <font color="red">离职</font> <{else}> <font color="red">未入职</font> <{/if}>		<{if $item.ruzhi_time!='0'}> <{$item.ruzhi_time|date_format:"%Y-%m-%d"}> <{/if}> </td>
	<td noWrap  align='right'> <{$item.ruzhi_name}> </td>
	<td noWrap  align='center'> <{if $item.jihuo=='1'}> <font color="green">已激活</font> <{else}> <font color="red">未激活</font> <{/if}>		<{if $item.jihuo_time!='0'}> <{$item.jihuo_time|date_format:"%Y-%m-%d"}> <{/if}> </td>
	<td noWrap  align='left'> <{$item.beizu}> </td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="21">
        	没有找到相关信息
        </td>
    </tr>
<{/if}>
<tr class="biaoti">
	<td align="left" colspan="21">
		<input type="checkbox" name="rowid[]" id="selectid" class="ckbox">全选
		<{$fpage_weihu}>
	</td>
</tr>
</table>

<{include file="public/foot.tpl"}>