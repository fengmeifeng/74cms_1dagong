<{include file="public/head.tpl"}>
<div class="bodycolor">
<form action="<{$url}>/dq_mod" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" size="30" value="<{$data.id}>" />
<table align="center" class="addtab" width='85%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="6">&nbsp;修改 地区</td>
</tr>
<tr>
	<td class="tabhead" nowrap="" align="middle" colspan="6">&nbsp;&nbsp;</td>
</tr>
<tr>
	<td align="left" width="10%" class="cdm">地区名称:</td>
	<td align="left"><input type="text" name="name" size="30" value="<{$data.name}>" /></td>
</tr>
<tr>
	<td class="tabhead" nowrap="" align="middle" colspan="6">&nbsp;&nbsp;</td>
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