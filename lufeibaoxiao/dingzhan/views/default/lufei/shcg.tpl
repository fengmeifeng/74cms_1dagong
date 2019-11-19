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
	<td class="biaoti" align="left" colspan="10">&nbsp;审核成功未满15天用户管理</td>
</tr>
<tr class="TableControl">
	<td class="Tabhead" align="left" colspan="10">
		<form action="<{$url}>/shcg" method="get" style="display:inline;">&nbsp;
		查找人员：	
		<input type="text" class="SmallInput" maxlength="200" size="20" name="name" style="display:inline-block">
		<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td>姓名</td>
	<td>入职已满</td>
	<td>电话</td>
	<td>公司名</td>
	<td>入职时间</td>
	<td>审核人</td>
	<td>操作</td>
</tr>
<{foreach from=$data item=list}>
<tr class="tab">
	<td><input type="checkbox" name="box" value="<{$list.id}>">&nbsp;<{$list.xingming}></td>
	<td align="left">&nbsp;&nbsp;<{$list.rzt}></td>
	<td align="left">&nbsp;&nbsp;<{$list.dianhua}></td>
	<td align="left">&nbsp;&nbsp;<{$list.gongshiming}></td>
	<td align="left">&nbsp;&nbsp;<{$list.rztime|date_format:"%Y-%m-%d"}></td>
	<td align="left">&nbsp;&nbsp;<b><{$list.shenheren}></b></td>
	<td align="left">&nbsp;&nbsp;
	<{if $list.lz==1}>
		<a href="<{$url}>/ylz/id/<{$list.id}>/zaizi/1">在职</a>
	<{else}>
		<a href="<{$url}>/ylz/id/<{$list.id}>/zaizi/2">离职</a>
	<{/if}>
	</td>
</tr>
<{/foreach}>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="10">&nbsp;<{$fpage}></td>
</tr>
</table>

</div>
<{include file="public/foot.tpl"}>