<{include file="public/head.tpl"}>
<div class="bodycolor">
<!---->
<form action="<{$url}>/addz" method="post" enctype="multipart/form-data">
<input type="hidden" name="path" value="<{$data.path}><{$data.id}>,"/>
<table align="center" class="addtab" width='85%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="6">&nbsp;新增 子类系统菜单</td>
</tr>
<tr>
	<td class="tabhead" nowrap="" align="middle" colspan="6">&nbsp;&nbsp;</td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">父菜单名称:</td>
	<td align="left">
		<select name="pid">
			<option value='<{$data.id}>'><{$data.name}></option>
		</select>
	</td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">子菜单名称:</td>
	<td align="left"><input type="text" name="name" size="30" /></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">链接地址:</td>
	<td align="left"><input type="text" name="operating" size="30" /></td>
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