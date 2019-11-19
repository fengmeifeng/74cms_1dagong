<?php /* Smarty version 2.6.18, created on 2014-09-22 13:35:23
         compiled from huiyuan/fenpeiuser.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="bodycolor">

<form action="<?php echo $this->_tpl_vars['url']; ?>
/yjdaima" method="post">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['uid']; ?>
">

<table align="center" class="addtab" width="450" cellspacing='0' cellpadding='0' border="1">
<tr>
	<td class="tabhead" align="left" colspan="2">&nbsp;把这些用户分配给</td>
</tr>
<tr>
	<td colspan="2" class="tabhead"></td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;要移交的客户:</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['name']; ?>
</td>
</tr>
<tr>
	<td width="20%" align="left">&nbsp;移交给:</td>
	<td align="left">&nbsp;
		<?php if ($this->_tpl_vars['qx'] < '5'): ?>
			<select class="SmallSelect" name="lsrid">
				<option>所属人</option>
				<?php $_from = $this->_tpl_vars['crm_user']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		<?php endif; ?>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>