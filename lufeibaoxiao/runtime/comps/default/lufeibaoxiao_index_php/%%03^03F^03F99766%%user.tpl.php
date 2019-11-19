<?php /* Smarty version 2.6.18, created on 2014-04-17 15:40:52
         compiled from site/user.tpl */ ?>
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
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td align="left" colspan="7">
		<input type="button" value=" 新建 " class="sub" onclick="location='<?php echo $this->_tpl_vars['url']; ?>
/useradd';" >
	</td>
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="10">&nbsp;管理员</td>
</tr>
<tr class="biaoti">
	<td>姓名</td>
	<td>帐号</td>
	<td>权限</td>
	<td>地区</td>
	<td>操作</td>
</tr>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
<tr class="tab">
	<td><input type="checkbox" name="box" value="<?php echo $this->_tpl_vars['list']['id']; ?>
">&nbsp;<?php echo $this->_tpl_vars['list']['dqname']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['user']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['qx_name']; ?>
</td>
	<td align="center">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['name']; ?>
</td>
	<td align="center"><a href="<?php echo $this->_tpl_vars['url']; ?>
/usermod/id/<?php echo $this->_tpl_vars['list']['id']; ?>
">修改</a> &nbsp; <a onclick="return confirm('你确定要删除吗? ')" href="<?php echo $this->_tpl_vars['url']; ?>
/userdel/id/<?php echo $this->_tpl_vars['list']['id']; ?>
">删除</a></td>
</tr>
<?php endforeach; endif; unset($_from); ?>

</table>

</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>