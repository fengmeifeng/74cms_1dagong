<?php /* Smarty version 2.6.18, created on 2014-04-28 13:56:29
         compiled from site/menu.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="bodycolor">
<script type="text/javascript">
	$(function(){
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	})
</script>
<table align="center" class="addtab" width='90%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="7">
		<div style="display:inline-block; float:right; margin-right: 20px;">g:根菜单&nbsp;&nbsp;z:子菜单</div>
	</td>
</tr>
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="7">&nbsp;系统菜单</td>
</tr>
<tr class="biaoti">
	<td width="15%">选择</td>
	<td width="20%">菜单名称</td>
	<td width="15%">链接地址</td>
	<td width="10%">图片</td>
	<td width="10%">操作</td>
</tr>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
<tr class="tab">
	<td><input type="checkbox" name="box" value="<?php echo $this->_tpl_vars['list']['id']; ?>
">
	<?php if ($this->_tpl_vars['list']['operating'] == 'g' || $this->_tpl_vars['list']['operating'] == 'z'): ?>
		<a href="<?php echo $this->_tpl_vars['url']; ?>
/modf/id/<?php echo $this->_tpl_vars['list']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['res']; ?>
/images/edit1.gif" border="0"></a>
	<?php else: ?>
		<a href="<?php echo $this->_tpl_vars['url']; ?>
/modz/id/<?php echo $this->_tpl_vars['list']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['res']; ?>
/images/edit1.gif" border="0"></a>
	<?php endif; ?>
	</td>
	<td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['kg']; ?>
<?php echo $this->_tpl_vars['list']['name']; ?>
</td>
	<td><?php echo $this->_tpl_vars['list']['operating']; ?>
</td>
	<td><img src="<?php echo $this->_tpl_vars['res']; ?>
/ico/<?php echo $this->_tpl_vars['list']['ico']; ?>
" title="图标" border="0"></td>
	<td><?php if ($this->_tpl_vars['list']['operating'] == 'g' || $this->_tpl_vars['list']['operating'] == 'z'): ?><a href="<?php echo $this->_tpl_vars['url']; ?>
/add_zmenu/pid/<?php echo $this->_tpl_vars['list']['id']; ?>
">添加子菜单</a><?php endif; ?>&nbsp;&nbsp;<a onclick="return confirm('你确定要删除吗? 注意：删除父类会删除父类里的所有子类')" href="<?php echo $this->_tpl_vars['url']; ?>
/del/id/<?php echo $this->_tpl_vars['list']['id']; ?>
">删除</a></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<br /><br /><br /><br />
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>