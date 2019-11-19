<{include file="public/head.tpl"}>
<div class="bodycolor">
<script type="text/javascript">
	$(function(){
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	})
</script>
<table align="center" class="addtab" width='90%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="7">
		<div style="display:inline-block; float:right; margin-right: 20px;">g:根菜单&nbsp;&nbsp;z:子菜单</div>
	</td>
</tr>
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="7">&nbsp;系统菜单</td>
</tr>
<tr class="biaoti">
	<td width="15%">选择</td>
	<td width="20%">菜单名称</td>
	<td width="15%">链接地址</td>
	<td width="10%">图片</td>
	<td width="10%">操作</td>
</tr>
<{foreach from=$data item=list}>
<tr class="tab">
	<td><input type="checkbox" name="box" value="<{$list.id}>">
	<{if $list.operating=="g" || $list.operating=="z"}>
		<a href="<{$url}>/modf/id/<{$list.id}>"><img src="<{$res}>/images/edit1.gif" border="0"></a>
	<{else}>
		<a href="<{$url}>/modz/id/<{$list.id}>"><img src="<{$res}>/images/edit1.gif" border="0"></a>
	<{/if}>
	</td>
	<td align="left">&nbsp;&nbsp;<{$list.kg}><{$list.name}></td>
	<td><{$list.operating}></td>
	<td><img src="<{$res}>/ico/<{$list.ico}>" title="图标" border="0"></td>
	<td><{if $list.operating=="g" || $list.operating=="z"}><a href="<{$url}>/add_zmenu/pid/<{$list.id}>">添加子菜单</a><{/if}>&nbsp;&nbsp;<a onclick="return confirm('你确定要删除吗? 注意：删除父类会删除父类里的所有子类')" href="<{$url}>/del/id/<{$list.id}>">删除</a></td>
</tr>
<{/foreach}>
</table>
<br /><br /><br /><br />
</div>
<{include file="public/foot.tpl"}>