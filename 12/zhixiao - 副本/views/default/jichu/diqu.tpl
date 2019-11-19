<{include file="public/head.tpl"}>

<script type="text/javascript">
	$(function(){
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	})
</script>


<table align="center" class="addtab" width='90%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td align="left" colspan="7">
		<input type="button" value=" 新建 " class="sub" onclick="location='<{$url}>/add_region';" >
	</td>
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="7">&nbsp;一级系统菜单</td>
</tr>
<tr class="biaoti">
	<td width="15%">选择</td>
	<td width="20%">报单地区</td>
	<td width="10%">操作</td>
</tr>
<{foreach from=$data item=list}>
<tr class="tab">
	<td>
		<input type="checkbox" name="box" value="<{$list.id}>">
		<a href="<{$url}>/mod_region/id/<{$list.id}>"><img src="<{$res}>/images/edit1.gif" border="0"></a>
	</td>
	<td align="center">&nbsp;&nbsp;<{$list.region}></td>
	<td><a  href="<{$url}>/mod_region/id/<{$list.id}>">修改</a> |&nbsp;&nbsp;<a href="<{$url}>/del_region/id/<{$list.id}>">删除</a></td>
</tr>
<{/foreach}>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="7">&nbsp;<{$fpage}></td>
</tr>
</table>


<{include file="public/foot.tpl"}>