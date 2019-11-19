<{include file="public/head.tpl"}>
<div class="bodycolor">
<!---->
<form action="<{$url}>/addf" method="post" enctype="multipart/form-data">
<input type="hidden" name="pid" value="0"/>
<input type="hidden" name="path" value="0,"/>
<table align="center" class="addtab" width='85%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="6">&nbsp;新增 父类系统菜单</td>
</tr>
<tr>
	<td class="tabhead" nowrap="" align="middle" colspan="6">&nbsp;&nbsp;</td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">菜单名称:</td>
	<td align="left"><input type="text" name="name" size="30" /></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">图标:</td>
	<td align="left"><input type="file" name="pic" /></td>
</tr>
<tr class="tabhead">
	<td class="TableHeader" align="left" colspan="6">
		<input type="submit" value=" 保存 " class="sub">
	</td>
</tr>
</table>
</form>
<!---->
</div>
<{include file="public/foot.tpl"}>