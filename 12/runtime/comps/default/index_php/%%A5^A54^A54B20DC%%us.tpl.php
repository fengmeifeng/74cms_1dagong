<?php /* Smarty version 2.6.18, created on 2014-09-02 11:24:04
         compiled from user/us.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
		<td align="left">&nbsp;<input type="text" class="SmallInput" size="15" value="<?php echo $this->_tpl_vars['user']['username']; ?>
" /></td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;姓名:</td>
		<td align="left">&nbsp;<input type="text" class="SmallInput" size="15" value="<?php echo $this->_tpl_vars['user']['name']; ?>
" /></td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;权限:</td>
		<td align="left">&nbsp;<input type="text" class="SmallInput" size="15" value="<?php echo $this->_tpl_vars['user']['priv_name']; ?>
" /></td>
	</tr>
	<tr>
		<td colspan="2" class="tabhead"></td>
	</tr>
	
</table>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>