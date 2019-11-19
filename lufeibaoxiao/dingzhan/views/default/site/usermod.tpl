<{include file="public/head.tpl"}>
<div class="bodycolor">
<form action="<{$url}>/user_mod" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" size="30" value="<{$data.id}>" />
<table align="center" class="addtab" width='60%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="6">&nbsp;新增 管理员</td>
</tr>
<tr>
	<td class="tabhead" nowrap="" align="middle" colspan="6" >&nbsp;&nbsp;</td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">姓名:</td>
	<td align="left"><input type="text" name="dqname" size="30" class="SmallInput" value="<{$data.dqname}>" /></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">帐号:</td>
	<td align="left"><input type="text" name="user" size="30" class="SmallInput" value="<{$data.user}>" /></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">密码:</td>
	<td align="left"><input type="password" name="mima" size="30" class="SmallInput" /></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">权限:</td>
	<td align="left">
		<select class="SmallSelect" name="quanxian">
			<option value="<{$data.quanxian}>"><{$data.qx_name}></option>
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
			<option value=""><{$data.name}></option>
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