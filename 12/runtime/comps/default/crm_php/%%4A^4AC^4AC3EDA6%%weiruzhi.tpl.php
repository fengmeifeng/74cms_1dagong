<?php /* Smarty version 2.6.18, created on 2014-09-02 10:44:33
         compiled from huiyuan/weiruzhi.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'huiyuan/weiruzhi.tpl', 108, false),)), $this); ?>
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
		
		//checkbox,全选/全不选
		$(".ckbox").bind("click", function(){ 
			if($(".ckbox:checkbox").attr("checked")){
				$("[name = selectid[]]:checkbox").attr("checked", true);
			}else{
				$("[name = selectid[]]:checkbox").attr("checked", false);
			}
        });
	});	
</script>

<body class="bodycolor">

<br/>
<table align="center" class="addtab" cellspacing='0' cellpadding='0' border="1" width="100%"  >

<tr>
	<td colspan="21" align="left">
		&nbsp;查找：<form action="<?php echo $this->_tpl_vars['url']; ?>
/weiruzhi" method="get" style="display:inline;">
			<select name="search" class="SmallSelect">
				<option value="name">姓名</option>
				<option value="bianhao">编号</option>
				<option value="sphone">手机号</option>
				<option value="id_number">身份证号</option>
				<option value="ruzhi_name">入职企业</option>
			</select>
			<input type="text" class="SmallInput" name="findvalue">
			
			
			<select name="lsr" class="SmallSelect">
				<option value="">选择隶属人</option>
				<?php $_from = $this->_tpl_vars['user']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['u']):
?>
					<option value="<?php echo $this->_tpl_vars['u']['id']; ?>
"> <?php echo $this->_tpl_vars['u']['name']; ?>
 </option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
			
			<select name="shijianduan" class="SmallSelect">
				<option value="">选择时间段</option>
				<option value="add_time">添加时间</option>
				<option value="ruzhi_time">入职时间</option>
				<option value="jihuo_time">激活时间</option>
			</select>
			<input type="text" class="SmallInput" name="q_time" id="q_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> -
			<input type="text" class="SmallInput" name="h_time" id="h_time" size="10" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
			<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>

<tr>
	<td colspan="21" class="biaoti" align="left">&nbsp;离职会员</span></td>
</tr>
<tr class="biaoti">
	<td noWrap width="115">隶属人</td>
	<td noWrap width="40">联系</td>
	<td noWrap width="45">编号</td>
	<td noWrap width="60">姓名</td>
	<td noWrap width="70">推荐人编号</td>
	<td noWrap width="70">推荐人姓名</td>
	<td noWrap width="40">关系</td>
	<td noWrap width="35">性别</td>
	<td noWrap width="45">手机号</td>
	<td noWrap width="45">QQ</td>
	<td noWrap width="65">地址</td>
    <td nowrap width="50">添加时间</td>
	<td nowrap width="85">入职状态于时间</td>
	<td nowrap width="55">入职企业</td>
	<td nowrap width="85">激活状态于时间</td>
	<td nowrap width="80">备注</td>
</tr>
<?php if ($this->_tpl_vars['data']): ?>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<tr class="khbox tab" onDblClick="location.href='<?php echo $this->_tpl_vars['url']; ?>
/upuser/id/<?php echo $this->_tpl_vars['item']['id']; ?>
'">
	<td noWrap  align='left'> 
		<input type="checkbox" name="selectid[]" id="selectid" value="未知">
		<a href="<?php echo $this->_tpl_vars['url']; ?>
/upuser/id/<?php echo $this->_tpl_vars['item']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['res']; ?>
/images/edit1.gif" title="修改记录" border="0"></a>
		<a href="<?php echo $this->_tpl_vars['url']; ?>
/gzuser/id/<?php echo $this->_tpl_vars['item']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['res']; ?>
/images/6710a.gif" title="跟踪记录" border="0"></a>
		<?php if ($this->_tpl_vars['item']['lsr'] != ''): ?> <?php echo $this->_tpl_vars['item']['lsr']; ?>
 <?php endif; ?> </td>
	<td noWrap  align='left'><?php echo $this->_tpl_vars['item']['lxts']; ?>
 </td>
	<td noWrap  align='left'><?php echo $this->_tpl_vars['item']['bianhao']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['name']; ?>
 </td>
	<td noWrap  align='left'> <?php if ($this->_tpl_vars['item']['f_bianghao'] != '0'): ?> <?php echo $this->_tpl_vars['item']['f_bianghao']; ?>
 <?php endif; ?> </td>
	<td noWrap  align='left'> <?php if ($this->_tpl_vars['item']['f_name'] != ''): ?> <?php echo $this->_tpl_vars['item']['f_name']; ?>
 <?php endif; ?> </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['guanxi']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['sex']; ?>
 </td>
	<td noWrap  align='right'> <?php echo $this->_tpl_vars['item']['sphone']; ?>
 </td>
	<td noWrap  align='right'> <?php echo $this->_tpl_vars['item']['qq']; ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['address']; ?>
 </td>
	<td noWrap  align='center'> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['add_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
 </td>
	<td noWrap  align='center'> <?php if ($this->_tpl_vars['item']['status'] == '1'): ?> <font color="green">已入职</font> <?php elseif ($this->_tpl_vars['item']['status'] == '2'): ?> <font color="red">离职</font> <?php else: ?> <font color="red">未入职</font> <?php endif; ?>		<?php if ($this->_tpl_vars['item']['ruzhi_time'] != '0'): ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['ruzhi_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
 <?php endif; ?> </td>
	<td noWrap  align='right'> <?php echo $this->_tpl_vars['item']['ruzhi_name']; ?>
 </td>
	<td noWrap  align='center'> <?php if ($this->_tpl_vars['item']['jihuo'] == '1'): ?> <font color="green">已激活</font> <?php else: ?> <font color="red">未激活</font> <?php endif; ?>		<?php if ($this->_tpl_vars['item']['jihuo_time'] != '0'): ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['jihuo_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
 <?php endif; ?> </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['beizu']; ?>
 </td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<tr>
    	<td colspan="21">
        	没有找到相关信息
        </td>
    </tr>
<?php endif; ?>
<tr class="biaoti">
	<td align="left" colspan="21">
		<input type="checkbox" name="rowid[]" id="selectid" class="ckbox">全选
		<?php echo $this->_tpl_vars['fpage_weihu']; ?>

	</td>
</tr>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>