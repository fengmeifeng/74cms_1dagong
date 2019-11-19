<?php /* Smarty version 2.6.18, created on 2015-10-20 16:56:11
         compiled from sousuo/sousuohuiyuan.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sousuo/sousuohuiyuan.tpl', 66, false),)), $this); ?>
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
	});
</script>

<body class="bodycolor">

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<td colspan="21" class="biaoti" align="left">&nbsp; 搜索会员详情</td>
</tr>
<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<?php echo $this->_tpl_vars['url']; ?>
/sousuohuiyuan" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="name">姓名</option>
				<option value="bianhao">编号</option>
				<option value="sphone">手机号</option>
				<option value="id_number">身份证号</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td noWrap width="40">伯乐</td>
	<td noWrap width="75">编号</td>
	<td noWrap width="75">姓名</td>
	<td noWrap width="70">推荐人编号</td>
	<td noWrap width="70">推荐人姓名</td>
	<td noWrap width="50">关系</td>
	<td noWrap width="55">推荐人数</td>
	<td noWrap width="110">手机号</td>
	<td noWrap width="130">身份证号码</td>
	<td noWrap width="120">地址</td>
	<td noWrap width="65">会员类型</td>
	<td nowrap width="80">入职时间</td>
	<td nowrap width="70">入职企业</td>
	 <td nowrap width="50">状态</td>
	<td nowrap width="135">激活时间</td>
    <td nowrap width="85">添加时间</td>
	<td nowrap>备注</td>
</tr>
<?php if ($this->_tpl_vars['data']): ?>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<tr class="khbox tab" >
	<td noWrap > <?php echo $this->_tpl_vars['item']['xiezhu']; ?>
 </td>
	<td noWrap  align='left'>&nbsp; <?php echo $this->_tpl_vars['item']['bianhao']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['name']; ?>
 </td>
	<td noWrap  align='left'> <?php if ($this->_tpl_vars['item']['f_bianghao'] != '0'): ?> <?php echo $this->_tpl_vars['item']['f_bianghao']; ?>
 <?php endif; ?> </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['f_name']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['guanxi']; ?>
 </td>
	<td noWrap  align='right'> <?php echo $this->_tpl_vars['item']['tj_num']; ?>
人 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['sphone']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['id_number']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['address']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['jibie']; ?>
 </td>
	<td noWrap  align='center'> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['ruzhi_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
 </td>
	<td noWrap  align='center'> <div style="width:80px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; " title="<?php echo $this->_tpl_vars['item']['ruzhi_name']; ?>
"> <?php echo $this->_tpl_vars['item']['ruzhi_name']; ?>
 </div> </td>
	<td noWrap  align='center'> <?php if ($this->_tpl_vars['item']['status'] == '1'): ?> <font color="green">在职</font> <?php elseif ($this->_tpl_vars['item']['status'] == '2'): ?> <font color="red">已离职</font>  <?php else: ?> 无 <?php endif; ?> </td>
	<td noWrap  align='center'> <?php if ($this->_tpl_vars['item']['jihuo_time'] != '0'): ?> <font color="green">已激活</font> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['jihuo_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
 <?php else: ?> <font color="red"> 未激活 </font>  <?php endif; ?> </td>
	<td noWrap  align='center'> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['add_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['beizu']; ?>
 </td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<tr>
    	<td colspan="21">
        	请搜索要找的会员！
        </td>
    </tr>
<?php endif; ?>
<tr class="biaoti">
	<td align="left" colspan="21" >
		<?php echo $this->_tpl_vars['fpage_weihu']; ?>

	</td>
</tr>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>