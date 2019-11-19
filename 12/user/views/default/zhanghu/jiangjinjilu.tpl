<{include file="public/head.tpl"}>

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
	<td colspan="21" class="biaoti" align="left">&nbsp;奖金记录列表</td>
</tr>

<tr class="biaoti">
	<td noWrap>编号</td>
	<td noWrap>操作</td>
	<td noWrap>奖金金额</td>
	<td noWrap>当前余额</td>
	<td noWrap>备注</td>
	<td noWrap>获得时间</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab" >
	<td noWrap  align='center'> <{$item.hyhumber}> </td>
	<td noWrap  align='center'> <{if $item.caozuo=='增加'}> <font color="green"><{$item.caozuo}></font> <{elseif $item.caozuo=='减少'}> <font color="red"><{$item.caozuo}></font>  <{/if}> </td>
	<td noWrap  align='center'> <{$item.money}>元 </td>
	<td noWrap  align='center'> <{$item.leftmoney}>元 </td>
	<td noWrap  align='center'> <{$item.beizhu}> </td>
	<td noWrap  align='center'> <{$item.addtime}> </td>
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