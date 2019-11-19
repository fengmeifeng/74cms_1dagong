<{include file="public/head.tpl"}>

<table align="center" class="addtab" width='65%' cellspacing='0' cellpadding='0' border="1">

<form action="<{$url}>/mod_qidu" method="post" >

<input type="hidden" name="id" value="<{$data.id}>"  />

<tr class="TableControl">
	<td class="tabhead" align="left" colspan="6">&nbsp;添加地区</td>
</tr>

<tr>
	<td class="tabhead" nowrap="" align="middle" colspan="6">&nbsp;&nbsp;</td>
</tr>

<tr>
	<td align="left" width="15%" class="cdm">地区:</td>
	<td align="left"><input type="text" name="region" size="30" value="<{$data.region}>"  /></td>
</tr>

<tr>
	<td class="tabhead" nowrap="" align="middle" colspan="6">&nbsp;&nbsp;</td>
</tr>

<tr class="tabhead">
	<td class="TableHeader" align="left" colspan="6">
		<input type="submit" value=" 保存 " class="sub">
	</td>
</tr>

</form>
</table>

<{include file="public/foot.tpl"}>