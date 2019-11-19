<?php /* Smarty version 2.6.18, created on 2014-09-22 13:36:33
         compiled from huiyuan/gzuser.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'huiyuan/gzuser.tpl', 53, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['res']; ?>
/css/duihuakuang.css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['res']; ?>
/js/example.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['res']; ?>
/js/WdatePicker/WdatePicker.js"></script>

<style>
td{
	background-color:#fff;
}
</style>

<div class="bodycolor">
<form action="<?php echo $this->_tpl_vars['url']; ?>
/addgzjl" method="post">

<input type="hidden" name="lsrid" value="<?php echo $this->_tpl_vars['user']['id']; ?>
">
<input type="hidden" name="lsrname" value="<?php echo $this->_tpl_vars['user']['name']; ?>
">

<table align="center" class="addtab" width='550' cellspacing='0' cellpadding='0' border="1" bgcolor="#fff">
	<tr>
		<td class="tabhead" align="left" colspan="2">&nbsp; 新建联系记录</td>
	</tr>
	<tr>
		<td colspan="2" class="tabhead" align="left">
			<input type="button" value=" 返回 " class="sub" onclick="javascript:history.back();">
		</td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;编号:</td>
		<input type="hidden" name="kuhuid" value="<?php echo $this->_tpl_vars['data']['id']; ?>
">
		<input type="hidden" name="bianhao" value="<?php echo $this->_tpl_vars['data']['bianhao']; ?>
">
		<td align="left">&nbsp; <?php echo $this->_tpl_vars['data']['bianhao']; ?>
 </td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;姓名:</td>
		<input type="hidden" name="name" value="<?php echo $this->_tpl_vars['data']['name']; ?>
">
		<td align="left">&nbsp;	<?php echo $this->_tpl_vars['data']['name']; ?>
 </td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;联系电话:</td>
		<input type="hidden" name="sphone" value="<?php echo $this->_tpl_vars['data']['sphone']; ?>
">
		<td align="left">&nbsp;	<?php echo $this->_tpl_vars['data']['sphone']; ?>
</td>
	</tr>
	
	<tr>
		<td width="20%" align="left">&nbsp;联系内容:</td>
		<td align="left">&nbsp;
			<textarea class="BigInput" name="lianxineirong" title="" rows="3" cols="40"></textarea>
		</td>
	</tr>	
	<tr>
		<td width="20%" align="left">&nbsp;联系时间:</td>
		<td align="left">&nbsp;
			<input class="SmallInput" maxlength="20" name="lianxitime" readonly value="<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>
" style="background:#E0E0E0"> 
			<img src="<?php echo $this->_tpl_vars['res']; ?>
/images/clock.gif" width="16" height="16" title="设置时间" align="absMiddle" border="0" style="cursor:pointer" onclick="alert('不可以修改时间的')">
		</td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;预约联系时间:</td>
		<td align="left">&nbsp;
			<input class="SmallInput" maxlength="20" name="nexttime" value="" title="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"> <img src="<?php echo $this->_tpl_vars['res']; ?>
/images/clock.gif" width="16" height="16" title="设置时间" align="absMiddle" border="0" style="cursor:pointer" onclick="nextcontacttime.click();">
		</td>
	</tr>
	<tr>
		<td width="20%" align="left">&nbsp;预约联系内容:</td>
		<td align="left">&nbsp;
			<textarea class="BigInput" name="nextneirong" title="" rows="3" cols="40"></textarea>
		</td>
	</tr>
	<tr align="left">
		<td colspan="2" class="tabhead"><input type="submit" class="sub" value="提交"></td>
	</tr>
</table>

</form>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>