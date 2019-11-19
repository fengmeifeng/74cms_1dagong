<{include file="public/head.tpl"}>
<div class="bodycolor">
<table align="left" class="addtab" width="65%" cellspacing='0' cellpadding='0' border="1">
	<tr>
		<td class="tabhead" align="left" colspan="2">&nbsp;我的账户</td>
	</tr>
	<tr>
		<td colspan="2" class="tabhead"></td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;用户名:</td>
		<td align="left">&nbsp;<input type="text" class="SmallInput" size="15" value="<{$user.username}>" /></td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;姓名:</td>
		<td align="left">&nbsp;<input type="text" class="SmallInput" size="15" value="<{$user.name}>" /></td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;权限:</td>
		<td align="left">&nbsp;<input type="text" class="SmallInput" size="15" value="<{$user.priv_name}>" /></td>
	</tr>
	<tr>
		<td colspan="2" class="tabhead"></td>
	</tr>
	
</table>
</div>
<{include file="public/foot.tpl"}>