<?php /* Smarty version 2.6.18, created on 2014-09-06 08:10:37
         compiled from danwei/mod_user.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="bodycolor">
<script type="text/javascript">
	/******************************/
	function dqForm(data){
		var text=data.options[data.selectedIndex].text;
		var value=data.value;
		$("#dq_t").val(text);
		$("#dq_v").val(value);
	}
	/******************************/
	function qxForm(data){
		var text=data.options[data.selectedIndex].text;
		var value=data.value;
		$("#qx_t").val(text);
		$("#qx_v").val(value);
	}
	/******************************/
	function bmForm(data){
		var text=data.options[data.selectedIndex].text;
		var value=data.value;
		$("#bm_t").val(text);
		$("#bm_v").val(value);
	}
	/******************************/
	function xbForm(data){
		var text=data.options[data.selectedIndex].text;
		var value=data.value;
		$("#xb_t").val(text);
		$("#xb_v").val(value);
	}
	/******************************/
</script>
<FORM action="<?php echo $this->_tpl_vars['url']; ?>
/up_user" method="post">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['data']['id']; ?>
">
<table align="center" class="addtab" width="450" cellspacing='0' cellpadding='0' border="1">
<tr>
	<td class="tabhead" align="left" colspan="2">&nbsp;新增用户</td>
</tr>
<tr>
	<td colspan="2" class="tabhead"></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;用户名:</td>
	<td align="left">&nbsp;<input type="text" name="user" class="SmallInput" maxlength="200" size="30" value="<?php echo $this->_tpl_vars['data']['user']; ?>
" />&nbsp;&nbsp;必填</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;密码:</td>
	<td align="left">&nbsp;<input type="radio" name="pass" value="123456">初始密码&nbsp;&nbsp;<input type="radio" name="pass" value="">保持不变
</tr>
<tr>
	<td width="20%" align="left">&nbsp;用户姓名:</td>
	<td align="left">&nbsp;<input type="text" name="name" class="SmallInput" maxlength="200" size="30" value="<?php echo $this->_tpl_vars['data']['name']; ?>
" />&nbsp;&nbsp;必填</td>
</tr>

<tr>
	<td width="20%" align="left">&nbsp;性别:</td>
	<td align="left">&nbsp;<input type="text" id="xb_t" readonly class="SmallInput" size="15" value="<?php echo $this->_tpl_vars['data']['sex']; ?>
" />
	<input type="hidden" name="sex" id="xb_v">
		<select class="SmallSelect" onchange="xbForm(this)" >
			<option>修改的用户性别</option>
			<option value="男">男</option>
			<option value="女">女</option>
		</select>
	</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;用户权限:</td>
	<td align="left">&nbsp;<input type="text" id="qx_t" readonly class="SmallInput" maxlength="200" size="15" value="<?php echo $this->_tpl_vars['data']['priv']; ?>
" />
	<input type="hidden" name="priv" id="qx_v">
		<select class="SmallSelect" onchange="qxForm(this)" >
			<option>选择要修改的用户权限</option>
			<?php $_from = $this->_tpl_vars['zw']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
			<option value="<?php echo $this->_tpl_vars['list']['priv']; ?>
"><?php echo $this->_tpl_vars['list']['priv_name']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;部门名称:</td>
	<td align="left">&nbsp;<input type="text" id="bm_t" readonly class="SmallInput" maxlength="200" size="15" value="<?php echo $this->_tpl_vars['data']['dept']; ?>
" />
	<input type="hidden" name="dept" id="bm_v">
		<select class="SmallSelect" onchange="bmForm(this)" >
			<option>选择要修改的部门名称</option>
			<?php $_from = $this->_tpl_vars['bm']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
			<option value="<?php echo $this->_tpl_vars['list']['dept_id']; ?>
"><?php echo $this->_tpl_vars['list']['kg']; ?>
<?php echo $this->_tpl_vars['list']['dept_name']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;电话:</td>
	<td align="left">&nbsp;<input type="text" name="telephone" class="SmallInput" maxlength="200" size="30" value="<?php echo $this->_tpl_vars['data']['telephone']; ?>
" /></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;手机:</td>
	<td align="left">&nbsp;<input type="text" name="phone" class="SmallInput" maxlength="200" size="30" value="<?php echo $this->_tpl_vars['data']['phone']; ?>
" /></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;电子邮件:</td>
	<td align="left">&nbsp;<input type="text" name="email" class="SmallInput" maxlength="200" size="30" value="<?php echo $this->_tpl_vars['data']['email']; ?>
" /></td>
</tr>
<tr>
	<td colspan="2" class="tabhead" align="left">
		&nbsp;<input type="submit" value=" 保存 " class="sub">
	</td>
</tr>
</FORM>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>