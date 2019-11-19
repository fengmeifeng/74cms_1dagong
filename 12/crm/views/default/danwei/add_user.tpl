<{include file="public/head.tpl"}>
<div class="bodycolor">
<form action="<{$url}>/ad_user" method="post">
<table align="center" class="addtab" width="450" cellspacing='0' cellpadding='0' border="1">
<tr>
	<td class="tabhead" align="left" colspan="2">&nbsp;新增用户</td>
</tr>
<tr>
	<td colspan="2" class="tabhead"></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;用户名:</td>
	<td align="left">&nbsp;<input type="text" name="user" class="SmallInput" maxlength="200" size="30" />&nbsp;&nbsp;必填</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;密码:</td>
	<td align="left">&nbsp;<input type="text" name="pass" class="SmallInput" maxlength="200" size="30" />&nbsp;&nbsp;必填</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;用户姓名:</td>
	<td align="left">&nbsp;<input type="text" name="name" class="SmallInput" maxlength="200" size="30" />&nbsp;&nbsp;必填</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;性别:</td>
	<td align="left">&nbsp;
		<select class="SmallSelect" name="sex">
			<option value="男">男</option>
			<option value="女">女</option>
		</select>
	</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;用户权限:</td>
	<td align="left">&nbsp;
		<select class="SmallSelect" name="priv">
			<{foreach from=$qx item=list}>
			<option value="<{$list.priv}>"><{$list.priv_name}></option>
			<{/foreach}>
		</select>
	</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;部门名称:</td>
	<td align="left">&nbsp;
		<select class="SmallSelect" name="dept">
			<{foreach from=$bm item=list}>
			<option value="<{$list.dept_id}>"><{$list.kg}><{$list.dept_name}></option>
			<{/foreach}>
		</select>
	</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;电话:</td>
	<td align="left">&nbsp;<input type="text" name="telephone" class="SmallInput" maxlength="200" size="30" /></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;手机:</td>
	<td align="left">&nbsp;<input type="text" name="phone" class="SmallInput" maxlength="200" size="30" /></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;电子邮件:</td>
	<td align="left">&nbsp;<input type="text" name="email" class="SmallInput" maxlength="200" size="30" /></td>
</tr>
<tr>
	<td colspan="2" class="tabhead" align="left">
		&nbsp;<input type="submit" value=" 保存 " class="sub">
	</td>
</tr>
</form>
</div>
<{include file="public/foot.tpl"}>