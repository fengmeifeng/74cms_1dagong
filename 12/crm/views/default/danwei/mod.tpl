<{include file="public/head.tpl"}>
<div class="bodycolor">
<FORM action="<{$url}>/updata" method="post" encType="multipart/form-data" >
<table align="center" class="addtab" width="450" cellspacing='0' cellpadding='0' border="1">
<tr>
	<td class="tabhead" align="left" colspan="2">&nbsp;新增部门</td>
</tr>
<tr>
	<td colspan="2" class="tabhead"></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;部门编号:</td>
	<td align="left">&nbsp;<input type="text" readonly name="dept_id" class="jinzhi" size="15" value="<{$data.dept_id}>" /></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;部门名称:</td>
	<td align="left">&nbsp;<input type="text" name="dept_name"  class="SmallInput" size="30" value="<{$data.dept_name}>"> &nbsp;&nbsp;必填</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;办公电话:</td>
	<td align="left">&nbsp;<input type="text" name="tel_no"  class="SmallInput" size="30" value="<{$data.tel_no}>" /> &nbsp;&nbsp;必填</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;父部门:</td>
	<td align="left">&nbsp;<input type="text" readonly  class="jinzhi" size="15" value="<{$f.dept_name}>" />
	<input type="hidden" name="dept_parent_id" value="<{$data.dept_parent_id}>" />
	</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;部门主管:</td>
	<td align="left">&nbsp;<input type="text" name="manager" class="SmallInput" size="30" value="<{$data.manager}>" /></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;部门职能:</td>
	<td align="left">
		<textarea style="margin-left:6px" name="dept_func" title="" wrap="yes" rows="4" cols="45" class="SmallInput"><{$data.dept_func}></textarea>
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