<{include file="public/head.tpl"}>
<div class="bodycolor">
<form action="<{$url}>/user_add" method="post" enctype="multipart/form-data">
<table align="center" class="addtab" width='60%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="6">&nbsp;新增 管理员</td>
</tr>
<tr>
	<td class="tabhead" nowrap="" align="middle" colspan="6" >&nbsp;&nbsp;</td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">姓名:</td>
	<td align="left"><input type="text" name="dqname" size="30" class="SmallInput" /></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">帐号:</td>
	<td align="left"><input type="text" name="user" size="30" class="SmallInput" /></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">密码:</td>
	<td align="left"><input type="password" name="mima" size="30" class="SmallInput" /></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">权限:</td>
	<td align="left">
		<select class="SmallSelect" name="quanxian">
			<{foreach from=$quanxian item=list}>
				<option value="<{$list.id}>"><{$list.qx_name}></option>
			<{/foreach}>
		</select>
	</td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">地区:</td>
	<td align="left">
		<select class="SmallSelect" name="dq">
			<{foreach from=$dq item=list}>
				<option value="<{$list.name}>"><{$list.name}></option>
			<{/foreach}>
		</select>
	</td>
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