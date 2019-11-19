<?php /* Smarty version 2.6.18, created on 2014-04-17 15:19:01
         compiled from lufei/shcg.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'lufei/shcg.tpl', 39, false),)), $this); ?>
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
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="10">&nbsp;审核成功未满15天用户管理</td>
</tr>
<tr class="TableControl">
	<td class="Tabhead" align="left" colspan="10">
		<form action="<?php echo $this->_tpl_vars['url']; ?>
/shcg" method="get" style="display:inline;">&nbsp;
		查找人员：	
		<input type="text" class="SmallInput" maxlength="200" size="20" name="name" style="display:inline-block">
		<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td>姓名</td>
	<td>入职已满</td>
	<td>电话</td>
	<td>公司名</td>
	<td>入职时间</td>
	<td>审核人</td>
	<td>操作</td>
</tr>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
<tr class="tab">
	<td><input type="checkbox" name="box" value="<?php echo $this->_tpl_vars['list']['id']; ?>
">&nbsp;<?php echo $this->_tpl_vars['list']['xingming']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['rzt']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['dianhua']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['gongshiming']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['list']['rztime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</td>
	<td align="left">&nbsp;&nbsp;<b><?php echo $this->_tpl_vars['list']['shenheren']; ?>
</b></td>
	<td align="left">&nbsp;&nbsp;
	<?php if ($this->_tpl_vars['list']['lz'] == 1): ?>
		<a href="<?php echo $this->_tpl_vars['url']; ?>
/ylz/id/<?php echo $this->_tpl_vars['list']['id']; ?>
/zaizi/1">在职</a>
	<?php else: ?>
		<a href="<?php echo $this->_tpl_vars['url']; ?>
/ylz/id/<?php echo $this->_tpl_vars['list']['id']; ?>
/zaizi/2">离职</a>
	<?php endif; ?>
	</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="10">&nbsp;<?php echo $this->_tpl_vars['fpage']; ?>
</td>
</tr>
</table>

</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>