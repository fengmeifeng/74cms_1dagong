<?php /* Smarty version 2.6.18, created on 2014-04-17 15:40:54
         compiled from site/usermod.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="bodycolor">
<form action="<?php echo $this->_tpl_vars['url']; ?>
/user_mod" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" size="30" value="<?php echo $this->_tpl_vars['data']['id']; ?>
" />
<table align="center" class="addtab" width='60%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="6">&nbsp;新增 管理员</td>
</tr>
<tr>
	<td class="tabhead" nowrap="" align="middle" colspan="6" >&nbsp;&nbsp;</td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">姓名:</td>
	<td align="left"><input type="text" name="dqname" size="30" class="SmallInput" value="<?php echo $this->_tpl_vars['data']['dqname']; ?>
" /></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">帐号:</td>
	<td align="left"><input type="text" name="user" size="30" class="SmallInput" value="<?php echo $this->_tpl_vars['data']['user']; ?>
" /></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">密码:</td>
	<td align="left"><input type="password" name="mima" size="30" class="SmallInput" /></td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">权限:</td>
	<td align="left">
		<select class="SmallSelect" name="quanxian">
			<option value="<?php echo $this->_tpl_vars['data']['quanxian']; ?>
"><?php echo $this->_tpl_vars['data']['qx_name']; ?>
</option>
			<?php $_from = $this->_tpl_vars['quanxian']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
				<option value="<?php echo $this->_tpl_vars['list']['id']; ?>
"><?php echo $this->_tpl_vars['list']['qx_name']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
</tr>
<tr>
	<td align="left" width="20%" class="cdm">地区:</td>
	<td align="left">
		<select class="SmallSelect" name="dq">
			<option value=""><?php echo $this->_tpl_vars['data']['name']; ?>
</option>
			<?php $_from = $this->_tpl_vars['dq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
				<option value="<?php echo $this->_tpl_vars['list']['name']; ?>
"><?php echo $this->_tpl_vars['list']['name']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>