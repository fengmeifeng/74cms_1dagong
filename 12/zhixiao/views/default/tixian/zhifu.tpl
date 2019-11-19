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
	<td colspan="21" class="biaoti" align="left"><span style="float:left;">&nbsp;提现支付</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<{$url}>/zhifu" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="name">姓名</option>
				<option value="bianhao">编号</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			
			&nbsp;时间段：
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap>编号</td>
	<td noWrap>姓名</td>
	<td noWrap>奖金</td>
	<td noWrap>用户提现金额</td>
	<td noWrap>剩余奖金</td>
	<td noWrap>银行信息</td>
	<td noWrap>银行卡号</td>
	<td noWrap>申请时间</td>
	<td nowrap width='200'>操作</td>
</tr>
<{if $data}>
<{foreach from=$data item=item}>
<tr class="khbox tab">
	<td noWrap  align='left'> <{$item.userbianhao}> </td>
	<td noWrap  align='left'> <{$item.username}> </td>
	<td noWrap  align='left'> <{$item.tjmoney}>元 </td>
	<td noWrap  align='left'> <{$item.txmoney}>元 </td>
	<td noWrap  align='left'> <{$item.cyjiangjin}>元 </td>
	<td noWrap  align='left'> <{$item.bank}><{$item.subbranch}> </td>
	<td noWrap  align='left'> <b><{$item.bank_account}></b> </td>
	<td noWrap  align='left'> <{$item.add_time|date_format:"%Y-%m-%d %H:%M:%S"}> </td>
	<td noWrap  align='left'> &nbsp; 
	<{if $item.fafangzhangtai!='2'}><a href="<{$url}>/fafangjiangjin/id/<{$item.id}>/zhangtai/cg" onclick="return confirm('你确定要支付成功吗? ')">支付成功</a><{/if}> &nbsp;&nbsp; 
	<a href="<{$url}>/fafangjiangjin/id/<{$item.id}>/zhangtai/sb" onclick="return confirm('你确定要支付失败吗? ')">支付失败</a>  </td>
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