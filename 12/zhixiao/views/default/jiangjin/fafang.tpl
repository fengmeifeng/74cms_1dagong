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
	<td colspan="21" class="biaoti" align="left"><span style="float:left;">&nbsp;已发放奖金记录</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<{$url}>/fafang" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="hyname">姓名</option>
				<option value="hyhumber">编号</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			
			结算时间：
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap>姓名</td>
	<td noWrap>编号</td>
	<td noWrap>奖金来源</td>
	<td noWrap>操作</td>
	<td noWrap>奖金增和减</td>
	<td noWrap>剩余奖金</td>
	<td noWrap>结算时间</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab">
	<td noWrap align='center'> <{$item.hyname}> </td>
	<td noWrap align='center'> <{$item.hyhumber}> </td>
	<td noWrap align='center'> <{$item.beizhu}> </td>
	<td noWrap align='center'> <{if $item.caozuo=='增加'}> <font color="green"><{$item.caozuo}></font> <{elseif $item.caozuo=='减少'}> <font color="red"><{$item.caozuo}></font> <{else}> <{$item.caozuo}> <{/if}></td>
	<td noWrap align='center'> <{$item.money}>元 </td>
	<td noWrap align='center'> <{$item.leftmoney}>元 </td>
	<td noWrap align='center'> <{$item.addtime}> </td>
</tr>
<{/foreach}>
<{else}>
	<tr>
    	<td colspan="14">
        	没有推荐任何人
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