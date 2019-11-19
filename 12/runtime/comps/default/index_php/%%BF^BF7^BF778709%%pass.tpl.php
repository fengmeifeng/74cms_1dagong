<?php /* Smarty version 2.6.18, created on 2014-09-02 11:24:03
         compiled from user/pass.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="bodycolor">
<form action="<?php echo $this->_tpl_vars['url']; ?>
/passdm" method="post" >
	<table align="center" class="addtab" width="450" cellspacing='0' cellpadding='0' border="1">
		<tr>
			<td class="tabhead" align="left" colspan="2">&nbsp;修改密码</td>
		</tr>
		<tr>
			<td colspan="2" class="tabhead"></td>
		</tr>
		<tr>
			<td width="20%" align="left">&nbsp;原密码:</td>
			<td align="left">&nbsp;<input type="password" name="pass1" class="SmallInput" size="15" value="" /></td>
		</tr>
		<tr>
			<td width="20%" align="left">&nbsp;新密码:</td>
			<td align="left">&nbsp;<input type="password" name="pass2" class="SmallInput" size="15" value="" /></td>
		</tr>
		<tr>
			<td width="20%" align="left">&nbsp;确认密码:</td>
			<td align="left">&nbsp;<input type="password" name="pass3" class="SmallInput" size="15" value="" /></td>
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