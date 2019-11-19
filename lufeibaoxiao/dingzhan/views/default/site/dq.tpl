<{include file="public/head.tpl"}>
<div class="bodycolor">
<script type="text/javascript">
	$(function(){
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	})
</script>
<table align="center" class="addtab" width='90%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td align="left" colspan="7">
		<input type="button" value=" 新建 " class="sub" onclick="location='<{$url}>/dqadd';" >
	</td>
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="7">&nbsp;地区管理</td>
</tr>
<tr class="biaoti">
	<td width="15%">选择</td>
	<td width="20%">地区</td>
	<td width="20%">操作</td>
</tr>
<{foreach from=$data item=list}>
<tr class="tab">
	<td>
	<input type="checkbox" name="box" value="<{$list.id}>">
	<a href="<{$url}>/dqmod/id/<{$list.id}>"><img src="<{$res}>/images/edit1.gif" border="0"></a>
	</td>
	<td align="left">&nbsp;&nbsp;<{$list.name}></td>
	<td><a onclick="return confirm('你确定要删除吗? ')" href="<{$url}>/dqdel/id/<{$list.id}>">删除</a></td>
</tr>
<{/foreach}>

</table>

</div>
<{include file="public/foot.tpl"}>