<{include file="public/head.tpl"}>
<div class="bodycolor">
<script type="text/javascript">
	$(function(){
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	})
	
</script>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="15">&nbsp;待报销人员管理</td>
</tr>
<tr class="TableControl">
	<td class="Tabhead" align="left" colspan="15">
		<form action="<{$url}>/dbxlf" method="get" style="display:inline;">&nbsp;
		查找人员：	
		<input type="text" class="SmallInput" maxlength="200" size="20" name="name" style="display:inline-block">
		<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td width="100">姓名</td>
	<td width="100">入职已满</td>
	<td width="120">电话</td>
	<td>身份证号码</td>
	<td>户籍</td>
	<td>公司名</td>
	<td>开户行</td>
	<td width="180">卡号</td>
	<td width="85">入职时间</td>
	<td width="85">报名时间</td>
	<td>审核人</td>
	<td width="80">操作</td>
</tr>
<{foreach from=$data item=list}>
<tr class="tab">
	<td><input type="checkbox" name="box" value="<{$list.id}>">&nbsp;<{$list.xingming}></td>
	<td align="left">&nbsp;&nbsp;<{$list.rzt}></td>
	<td align="left">&nbsp;&nbsp;<{$list.dianhua}></td>
	<td align="left" class="nameid">&nbsp;&nbsp;<{$list.nameid}></td>
	<td> <a href="http://api.k780.com/?app=idcard.get&appkey=10003&sign=b59bc3ef6191eb9f747dd4e83c99f2a4&format=json&idcard=<{$list.nameid}>" target="_blank">查看户籍</a> </td>
	<td align="left">&nbsp;&nbsp;<{$list.gongshiming}></td>
	<td align="left">&nbsp;&nbsp;<{$list.yinhangming}></td>
	<td align="left">&nbsp;&nbsp;<b><{$list.yinghaohao}></b></td>
	<td align="left">&nbsp;&nbsp;<{$list.rztime|date_format:"%Y-%m-%d"}></td>
	<td align="left">&nbsp;&nbsp;<{$list.baoming_time}></td>
	<td align="left">&nbsp;&nbsp;<b><{$list.shenheren}></b></td>
	<td align="center">
		<{if $list.grants==0}>
			<a href="<{$url}>/faf/id/<{$list.id}>">立即发放</a>
		<{elseif $list.grants==1}>
			<a href="">发放成功</a>
		<{/if}>
	</td>
</tr>
<{/foreach}>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="15">&nbsp;<{$fpage}></td>
</tr>
</table>




</div>
<{include file="public/foot.tpl"}>