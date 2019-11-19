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
	<td align="left" colspan="7">
		<input type="button" value=" 新建 " class="sub" onclick="location='<{$url}>/useradd';" >
	</td>
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="10">&nbsp;管理员</td>
</tr>
<tr class="biaoti">
	<td>姓名</td>
	<td>帐号</td>
	<td>权限</td>
	<td>地区</td>
	<td>操作</td>
</tr>
<{foreach from=$data item=list}>
<tr class="tab">
	<td><input type="checkbox" name="box" value="<{$list.id}>">&nbsp;<{$list.dqname}></td>
	<td align="left">&nbsp;&nbsp;<{$list.user}></td>
	<td align="left">&nbsp;&nbsp;<{$list.qx_name}></td>
	<td align="center">&nbsp;&nbsp;<{$list.name}></td>
	<td align="center"><a href="<{$url}>/usermod/id/<{$list.id}>">修改</a> &nbsp; <a onclick="return confirm('你确定要删除吗? ')" href="<{$url}>/userdel/id/<{$list.id}>">删除</a></td>
</tr>
<{/foreach}>

</table>

</div>
<{include file="public/foot.tpl"}>