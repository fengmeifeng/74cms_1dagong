<{include file="public/head.tpl"}>
<div class="bodycolor">
<script type="text/javascript">
	$(function(){
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	})
</script>
<table align="center" class="addtab" width='120%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="15">&nbsp;待报销人员管理</td>
</tr>
<tr class="TableControl">
	<td class="Tabhead" align="left" colspan="15">
		<form action="<{$url}>/cg" method="get" style="display:inline;">&nbsp;
		查找人员：	
		<input type="text" class="SmallInput" maxlength="200" size="20" name="name" style="display:inline-block">
		<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td width="80">姓名</td>
	<td width="70">入职已满</td>
	<td width="100">电话</td>
	<td width="120">身份证号码</td>
	<td width="60">公司名</td>
	<td width="120">开户行</td>
	<td width="165">卡号</td>
	<td width="80">入职时间</td>
	<td width="80">报名时间</td>
	<td width="65">审核人</td>
	<td width="80">路费发放人</td>
	<td width="60">路费金额</td>
	<td width="80">操作</td>
</tr>
<{foreach from=$data item=list}>
<tr class="tab">
	<td><input type="checkbox" name="box" value="<{$list.id}>">&nbsp;<{$list.xingming}></td>
	<td align="left">&nbsp;&nbsp;<{$list.rzt}></td>
	<td align="left">&nbsp;&nbsp;<{$list.dianhua}></td>
	<td align="left">&nbsp;&nbsp;<{$list.nameid}></td>
	<td align="left">&nbsp;&nbsp;<{$list.gongshiming}></td>
	<td align="left">&nbsp;&nbsp;<{$list.yinhangming}></td>
	<td align="left">&nbsp;&nbsp;<b><{$list.yinghaohao}></b></td>
	<td align="left">&nbsp;&nbsp;<{$list.rztime|date_format:"%Y-%m-%d"}></td>
	<td align="left">&nbsp;&nbsp;<{$list.baoming_time}></td>
	<td align="left">&nbsp;&nbsp;<b><{$list.shenheren}></b></td>
	<td align="left">&nbsp;&nbsp;<b><{$list.fafangren}></b></td>
	<td align="left">&nbsp;&nbsp;<b><{$list.jine}></b></td>
	<td align="center">
		<{if $list.audit==1}>
		发放成功
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