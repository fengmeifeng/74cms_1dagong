<?php /* Smarty version 2.6.18, created on 2014-09-02 11:24:11
         compiled from jichu/baodan.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'jichu/baodan.tpl', 38, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
	$(function(){
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	})
</script>

<div class="bodycolor">

<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
	<td align="left" colspan="7">
		<input type="button" value=" 新建 " class="sub" onclick="location='<?php echo $this->_tpl_vars['url']; ?>
/adduser';" >
	</td>
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="7">&nbsp;报单中心管理</td>
</tr>
<tr class="biaoti">
	<td noWrap >选择</td>
	<td noWrap >编号</td>
	<td noWrap >姓名</td>
	<td noWrap >会员级别</td>
	<td noWrap >开通时间</td>
	<td noWrap >操作</td>
</tr>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
<tr class="tab">
	<td noWrap >
		<input type="checkbox" name="box" value="<?php echo $this->_tpl_vars['list']['id']; ?>
">
		<a href="<?php echo $this->_tpl_vars['url']; ?>
/moduser/id/<?php echo $this->_tpl_vars['list']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['res']; ?>
/images/edit1.gif" border="0"></a>
	</td>
	<td noWrap align="center">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['bianhao']; ?>
</td>
	<td noWrap align="left"> &nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['url']; ?>
/guanli/bianhao/<?php echo $this->_tpl_vars['list']['bianhao']; ?>
"> <?php echo $this->_tpl_vars['list']['name']; ?>
管理人员</a> </td>
	<td noWrap align="center">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['jibie']; ?>
</td>
	<td noWrap align="center">&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['list']['add_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</td>
	<td noWrap > <?php if ($this->_tpl_vars['list']['jihuo'] == '0'): ?><a href="<?php echo $this->_tpl_vars['url']; ?>
/jihuo/id/<?php echo $this->_tpl_vars['list']['id']; ?>
">激活</a> |&nbsp;&nbsp;<?php endif; ?>  <a href="<?php echo $this->_tpl_vars['url']; ?>
/moduser/id/<?php echo $this->_tpl_vars['list']['id']; ?>
">修改</a> |&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['url']; ?>
/deluser/id/<?php echo $this->_tpl_vars['list']['id']; ?>
" onclick="return confirm('你确定要删除吗? ')" >删除</a> |&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['app']; ?>
/zhuce/bdzc/bianhao/<?php echo $this->_tpl_vars['list']['bianhao']; ?>
/id/<?php echo $this->_tpl_vars['list']['id']; ?>
">注册会员</a> </td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="7">&nbsp;<?php echo $this->_tpl_vars['fpage']; ?>
</td>
</tr>
</table>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>