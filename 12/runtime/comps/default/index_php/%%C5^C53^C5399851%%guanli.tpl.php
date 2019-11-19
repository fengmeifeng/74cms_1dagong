<?php /* Smarty version 2.6.18, created on 2014-09-02 14:38:48
         compiled from jichu/guanli.tpl */ ?>
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
/addguanli/bianhao/<?php echo $this->_tpl_vars['bianhao']; ?>
';" >
	</td>
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="7">&nbsp;报单中心管理</td>
</tr>
<tr class="biaoti">
	<td noWrap >选择</td>
	<td noWrap >登录名</td>
	<td noWrap >姓名</td>
	<td noWrap >会员级别</td>
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
/modguanli/id/<?php echo $this->_tpl_vars['list']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['res']; ?>
/images/edit1.gif" border="0"></a>
	</td>
	<td noWrap align="center">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['username']; ?>
</td>
	<td noWrap align="left"> &nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['name']; ?>
 </td>
	<td noWrap align="center">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['priv_name']; ?>
</td>
	<td noWrap > <a href="<?php echo $this->_tpl_vars['url']; ?>
/modguanli/id/<?php echo $this->_tpl_vars['list']['id']; ?>
">修改</a> |&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['url']; ?>
/guanlidel/id/<?php echo $this->_tpl_vars['list']['id']; ?>
" onclick="return confirm('你确定要删除吗? ')" >删除</a> </td>
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