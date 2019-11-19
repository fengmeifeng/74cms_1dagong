<?php /* Smarty version 2.6.18, created on 2015-10-20 16:56:15
         compiled from tixian/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'tixian/index.tpl', 84, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['res']; ?>
/js/WdatePicker/WdatePicker.js"></script>
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
	<td colspan="21" class="biaoti" align="left"><span style="float:left;">&nbsp;提现查询</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<?php echo $this->_tpl_vars['url']; ?>
/index" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="tx.username">姓名</option>
				<option value="tx.userbianhao">编号</option>
			</select>
			
			<input type="text" class="SmallInput" name="findvalue">
			
			<select name="txzhuangtai" class="SmallSelect">
				<?php if ($this->_tpl_vars['quanxian'] == 5): ?>
					<option value="2" selected='selected' >审核成功</option>
				<?php else: ?>
					<option value="">选择审核状态</option>
					<option value="2">审核成功</option>
					<option value="3">审核失败</option>
					<option value="1">未审核</option>
				<?php endif; ?>
			</select>
			
			<select name="fafangzhangtai" class="SmallSelect">
				<option value="">选择支付状态</option>
				<option value="2">已支付</option>
				<option value="3">支付失败</option>
				<option value="1" <?php if ($this->_tpl_vars['quanxian'] == 5): ?> selected='selected' <?php endif; ?> >未支付</option>
				
			</select>
			时间段：
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			
			<input type="submit" value=" 查找 " class="sub">
			<input type="button" value=" 导出 " class="sub" onclick="location='<?php echo $this->_tpl_vars['url']; ?>
/daochuexcel?<?php echo $this->_tpl_vars['changshu']; ?>
';">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap>编号</td>
	<td noWrap>姓名</td>
	<td noWrap>现有奖金</td>
	<td noWrap>用户提现金额</td>
	<td noWrap>剩余奖金</td>
	<td noWrap>申请时间</td>
	<td nowrap>申请状态</td>
	<td nowrap>是否发放</td>
	<td nowrap>发放时间</td>
</tr>
<?php if ($this->_tpl_vars['data']): ?>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<tr class="khbox tab">
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['userbianhao']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['username']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['tjmoney']; ?>
元 </td>
	<td noWrap  align='left' style="background:red;"> <?php echo $this->_tpl_vars['item']['txmoney']; ?>
元 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['cyjiangjin']; ?>
元 </td>
	<td noWrap  align='left'> <?php if ($this->_tpl_vars['item']['add_time'] != '0'): ?>  <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['add_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
 <?php endif; ?> </td>
	<td noWrap  align='left'> <?php if ($this->_tpl_vars['item']['txzhuangtai'] == '2'): ?> <font color="green">审核成功</font> <?php elseif ($this->_tpl_vars['item']['txzhuangtai'] == '3'): ?> <font color="red">审核失败</font> <?php else: ?> 未审核 <?php endif; ?> </td>
	<td noWrap  align='left'> <?php if ($this->_tpl_vars['item']['fafangzhangtai'] == '2'): ?> <font color="green">已支付</font> <?php elseif ($this->_tpl_vars['item']['fafangzhangtai'] == '3'): ?> <font color="red">支付失败</font> <?php else: ?> 未支付 <?php endif; ?> </td>
	<td noWrap  align='left'> <?php if ($this->_tpl_vars['item']['fafang_time'] != '0'): ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['fafang_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
 <?php endif; ?> </td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<tr>
    	<td colspan="14">
        	没有找到！
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