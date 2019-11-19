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
	});
</script>

<body class="bodycolor">

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="21" class="biaoti" align="left"><span style="float:left;">&nbsp;提现查询</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<{$url}>/index" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="tx.username">姓名</option>
				<option value="tx.userbianhao">编号</option>
			</select>
			
			<input type="text" class="SmallInput" name="findvalue">
			
			<select name="txzhuangtai" class="SmallSelect">
				<{if $quanxian==5}>
					<option value="2" selected='selected' >审核成功</option>
				<{else}>
					<option value="">选择审核状态</option>
					<option value="2">审核成功</option>
					<option value="3">审核失败</option>
					<option value="1">未审核</option>
				<{/if}>
			</select>
			
			<select name="fafangzhangtai" class="SmallSelect">
				<option value="">选择支付状态</option>
				<option value="2">已支付</option>
				<option value="3">支付失败</option>
				<option value="1" <{if $quanxian==5}> selected='selected' <{/if}> >未支付</option>
				
			</select>
			时间段：
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			
			<input type="submit" value=" 查找 " class="sub">
			<input type="button" value=" 导出 " class="sub" onclick="location='<{$url}>/daochuexcel?<{$changshu}>';">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap>编号</td>
	<td noWrap>姓名</td>
	<td noWrap>现有奖金</td>
	<td noWrap>用户提现金额</td>
	<td noWrap>剩余奖金</td>
	<td noWrap>申请时间</td>
	<td nowrap>申请状态</td>
	<td nowrap>是否发放</td>
	<td nowrap>发放时间</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab">
	<td noWrap  align='left'> <{$item.userbianhao}> </td>
	<td noWrap  align='left'> <{$item.username}> </td>
	<td noWrap  align='left'> <{$item.tjmoney}>元 </td>
	<td noWrap  align='left' style="background:red;"> <{$item.txmoney}>元 </td>
	<td noWrap  align='left'> <{$item.cyjiangjin}>元 </td>
	<td noWrap  align='left'> <{if $item.add_time!='0'}>  <{$item.add_time|date_format:"%Y-%m-%d %H:%M:%S"}> <{/if}> </td>
	<td noWrap  align='left'> <{if $item.txzhuangtai=='2'}> <font color="green">审核成功</font> <{elseif $item.txzhuangtai=='3'}> <font color="red">审核失败</font> <{else}> 未审核 <{/if}> </td>
	<td noWrap  align='left'> <{if $item.fafangzhangtai=='2'}> <font color="green">已支付</font> <{elseif $item.fafangzhangtai=='3'}> <font color="red">支付失败</font> <{else}> 未支付 <{/if}> </td>
	<td noWrap  align='left'> <{if $item.fafang_time!='0'}> <{$item.fafang_time|date_format:"%Y-%m-%d %H:%M:%S"}> <{/if}> </td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="14">
        	没有找到！
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