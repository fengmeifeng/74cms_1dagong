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
	<td colspan="21" class="biaoti" align="left"><span style="float:left;">&nbsp;提现记录</td>
</tr>

<tr class="biaoti">
	<td noWrap width='10%'>编号</td>
	<td noWrap width='10%'>姓名</td>
	<td noWrap width='10%'>奖金</td>
	<td noWrap width='10%'>用户提现金额</td>
	<td noWrap width='10%'>剩余奖金</td>
	<td noWrap width='10%'>申请时间</td>
    <td nowrap width='10%'>审核状态</td>
    <td nowrap width='10%'>支付状态</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab">
	<td noWrap  align='left'> <{$item.userbianhao}> </td>
	<td noWrap  align='left'> <{$item.username}> </td>
	<td noWrap  align='left'> <{$item.tjmoney}>元 </td>
	<td noWrap  align='left'> <{$item.txmoney}>元 </td>
	<td noWrap  align='left'> <{$item.cyjiangjin}>元 </td>
	<td noWrap  align='left'> <{$item.add_time|date_format:"%Y-%m-%d %H:%M:%S"}> </td>
	<td noWrap  align='left'> <{if $item.txzhuangtai=='2'}> <font color="green"><b>审核成功(每月10号支付)</b></font> <{elseif $item.txzhuangtai=='3'}> <font color="red"><b>审核失败</b></font> <{else}> <font color="green"><b>已提交</b></font> <{/if}> </td>
	<td noWrap  align='left'> <{if $item.fafangzhangtai=='2'}> <font color="green"><b>已支付</b></font> <{elseif $item.fafangzhangtai=='3'}> <font color="red"><b>支付不成功</b></font> <{else}> <font color="red"><b>未支付</b></font> <{/if}> </td>
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