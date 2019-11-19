<?php /* Smarty version 2.6.18, created on 2015-10-20 16:56:14
         compiled from jiangjin/fafang.tpl */ ?>
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
	<td colspan="21" class="biaoti" align="left"><span style="float:left;">&nbsp;已发放奖金记录</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<?php echo $this->_tpl_vars['url']; ?>
/fafang" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="hyname">姓名</option>
				<option value="hyhumber">编号</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			
			结算时间：
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap>姓名</td>
	<td noWrap>编号</td>
	<td noWrap>奖金来源</td>
	<td noWrap>操作</td>
	<td noWrap>奖金增和减</td>
	<td noWrap>剩余奖金</td>
	<td noWrap>结算时间</td>
</tr>
<?php if ($this->_tpl_vars['data']): ?>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<tr class="khbox tab">
	<td noWrap align='center'> <?php echo $this->_tpl_vars['item']['hyname']; ?>
 </td>
	<td noWrap align='center'> <?php echo $this->_tpl_vars['item']['hyhumber']; ?>
 </td>
	<td noWrap align='center'> <?php echo $this->_tpl_vars['item']['beizhu']; ?>
 </td>
	<td noWrap align='center'> <?php if ($this->_tpl_vars['item']['caozuo'] == '增加'): ?> <font color="green"><?php echo $this->_tpl_vars['item']['caozuo']; ?>
</font> <?php elseif ($this->_tpl_vars['item']['caozuo'] == '减少'): ?> <font color="red"><?php echo $this->_tpl_vars['item']['caozuo']; ?>
</font> <?php else: ?> <?php echo $this->_tpl_vars['item']['caozuo']; ?>
 <?php endif; ?></td>
	<td noWrap align='center'> <?php echo $this->_tpl_vars['item']['money']; ?>
元 </td>
	<td noWrap align='center'> <?php echo $this->_tpl_vars['item']['leftmoney']; ?>
元 </td>
	<td noWrap align='center'> <?php echo $this->_tpl_vars['item']['addtime']; ?>
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