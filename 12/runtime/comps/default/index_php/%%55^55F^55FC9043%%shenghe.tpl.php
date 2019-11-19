<?php /* Smarty version 2.6.18, created on 2014-09-01 17:27:41
         compiled from tixian/shenghe.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'tixian/shenghe.tpl', 68, false),)), $this); ?>
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
	<td colspan="21" class="biaoti" align="left"><span style="float:left;">&nbsp;提现审核</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<?php echo $this->_tpl_vars['url']; ?>
/shenghe" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="name">姓名</option>
				<option value="bianhao">编号</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			
			&nbsp;时间段：
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap>编号</td>
	<td noWrap>姓名</td>
	<td noWrap>现有奖金</td>
	<td noWrap>用户提现金额</td>
	<td noWrap>剩余奖金</td>
	<td noWrap>银行信息</td>
	<td noWrap>银行卡号</td>
	<td noWrap>申请时间</td>
	<td nowrap width='200'>操作</td>
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
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['bank']; ?>
<?php echo $this->_tpl_vars['item']['subbranch']; ?>
 </td>
	<td noWrap  align='left'> <b><?php echo $this->_tpl_vars['item']['bank_account']; ?>
</b> </td>
	<td noWrap  align='left'> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['add_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
 </td>
	<td noWrap  align='left'> &nbsp; 
	<?php if ($this->_tpl_vars['item']['txzhuangtai'] != '2'): ?><a href="<?php echo $this->_tpl_vars['url']; ?>
/shenghetixian/id/<?php echo $this->_tpl_vars['item']['id']; ?>
/zhangtai/cg" onclick="return confirm('你确定要审核成功吗? ')" >审核成功</a><?php endif; ?> 
	<?php if ($this->_tpl_vars['item']['txzhuangtai'] != '2'): ?> &nbsp;&nbsp; <a href="<?php echo $this->_tpl_vars['url']; ?>
/shenghetixian/id/<?php echo $this->_tpl_vars['item']['id']; ?>
/zhangtai/sb"  onclick="return confirm('你确定要审核失败吗? ')">审核失败</a><?php endif; ?>   </td>
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