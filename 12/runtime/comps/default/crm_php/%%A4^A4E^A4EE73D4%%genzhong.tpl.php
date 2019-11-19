<?php /* Smarty version 2.6.18, created on 2014-09-02 10:44:35
         compiled from huiyuan/genzhong.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'huiyuan/genzhong.tpl', 57, false),)), $this); ?>
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

<body class="bodycolor"  width='100%'>

<br/>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">

<tr>
	<td colspan="21" class="biaoti" align="left">&nbsp;跟踪记录</span></td>
</tr>
<tr class="biaoti">
	<td noWrap width="40">隶属人</td>
	<td noWrap width="40">编号</td>
	<td noWrap width="45">姓名</td>
	<td noWrap width="45">手机号</td>
	<td noWrap width="45">联系时间</td>
	<td noWrap width="65">联系内容</td>
    <td nowrap width="50">预约联系时间</td>
	<td nowrap width="80">预约联系内容</td>
</tr>
<?php if ($this->_tpl_vars['data']): ?>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<tr class="khbox tab" onDblClick="location.href='#'">
	<td noWrap  align='center'> <?php echo $this->_tpl_vars['item']['lsrname']; ?>
 </td>
	<td noWrap  align='center'><?php echo $this->_tpl_vars['item']['bianhao']; ?>
 </td>
	<td noWrap  align='center'> <?php echo $this->_tpl_vars['item']['name']; ?>
 </td>
	<td noWrap  align='center'> <?php echo $this->_tpl_vars['item']['sphone']; ?>
 </td>
	<td noWrap  align='left'> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['lianxitime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>
 </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['lianxineirong']; ?>
 </td>
	<td noWrap  align='left'> <?php if ($this->_tpl_vars['item']['nexttime'] != '0'): ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['nexttime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>
 <?php endif; ?> </td>
	<td noWrap  align='left'> <?php echo $this->_tpl_vars['item']['nextneirong']; ?>
 </td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<tr>
    	<td colspan="14">
        	没有找到相关信息
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