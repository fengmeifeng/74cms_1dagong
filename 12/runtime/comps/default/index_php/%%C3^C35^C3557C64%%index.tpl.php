<?php /* Smarty version 2.6.18, created on 2014-09-01 17:46:53
         compiled from rizhi/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'rizhi/index.tpl', 51, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
	$(function(){
		//隔行换色
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
		
		//鼠标移上换色
		$(".tab").hover(
		  function(){
		    $(this).css("background","#CFDDEA");
		  },
		  function(){
		    $(".tab:even").css("background","#FFFFFF");
			$(".tab:odd").css("background","#F8F8F8");
		});
	});
</script>

<body class="bodycolor">

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="21" class="biaoti" align="left"><span style="float:left;">&nbsp;日志记录</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<?php echo $this->_tpl_vars['url']; ?>
/index" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="caozuo">内容</option>
				<option value="name">操作人</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap>操作人</td>
	<td noWrap>IP</td>
	<td noWrap>操作时间</td>
	<td noWrap>操作内容</td>
</tr>
<?php if ($this->_tpl_vars['data']): ?>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<tr class="khbox tab">
	<td noWrap  align='left'> &nbsp;<?php echo $this->_tpl_vars['item']['name']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['ip']; ?>
 </td>
	<td noWrap  align='left'> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['caozuo']; ?>
 </td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<tr>
    	<td colspan="14">
        	没有推荐任何人
        </td>
    </tr>
<?php endif; ?>
<tr class="biaoti">
	<td align="left" colspan="20">
	<?php echo $this->_tpl_vars['fpage_weihu']; ?>

	</td>
</tr>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>