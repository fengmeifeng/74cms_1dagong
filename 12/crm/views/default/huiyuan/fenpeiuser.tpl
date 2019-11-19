<{include file="public/head.tpl"}>

<div class="bodycolor">

<form action="<{$url}>/yjdaima" method="post">
<input type="hidden" name="id" value="<{$uid}>">

<table align="center" class="addtab" width="450" cellspacing='0' cellpadding='0' border="1">
<tr>
	<td class="tabhead" align="left" colspan="2">&nbsp;把这些用户分配给</td>
</tr>
<tr>
	<td colspan="2" class="tabhead"></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;要移交的客户:</td>
	<td align="left">&nbsp;<{$name}></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;移交给:</td>
	<td align="left">&nbsp;
		<{if $qx < '5'}>
			<select class="SmallSelect" name="lsrid">
				<option>所属人</option>
				<{foreach from=$crm_user item=item}>
					<option value="<{$item.id}>"><{$item.name}></option>
				<{/foreach}>
			</select>
		<{/if}>
	</td>
</tr>

<tr>
	<td colspan="2" class="tabhead" align="left">
		&nbsp;<input type="submit" value=" 保存 " class="sub">
	</td>
</tr>
</table>

</form>
</div>
<{include file="public/foot.tpl"}>