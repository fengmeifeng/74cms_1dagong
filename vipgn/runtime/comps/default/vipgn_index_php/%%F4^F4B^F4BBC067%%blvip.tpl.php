<?php /* Smarty version 2.6.18, created on 2015-08-22 10:43:23
         compiled from index/blvip.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'index/blvip.tpl', 95, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<?php echo $this->_tpl_vars['public']; ?>
/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['public']; ?>
/js/jquery.js"></script>
<link href="<?php echo $this->_tpl_vars['public']; ?>
/css/date_input.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src="<?php echo $this->_tpl_vars['public']; ?>
/js/jquery.date_input.js" language="javascript"></script>
<style>
table th{
	font-size: 12px;
	font-weight : 500;
}

</style>
<title>办理套餐</title>
</head>
<script>
function changetxt(i){
	if($(i).val()=='0'){
		$('.cishu').show();
		$('.zhanwei').hide();
	}
	else{
		$('.cishu').hide();
		$('.zhanwei').show();
	}
}
$(document).ready(function(){
	//日期
	$(function() { 
		$(".date_input").date_input(); 
	});
});
</script>

<body style="background-color:#E0F0FE">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 办理套餐 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>办理：</h2>
</div>
<br />
<form action="<?php echo $this->_tpl_vars['url']; ?>
/addtc" method="post">

<input type="hidden" name="uid" value="<?php echo $this->_tpl_vars['data']['id']; ?>
" />
<input type="hidden" name="qid" value="<?php echo $this->_tpl_vars['data']['qid']; ?>
" />
<table width="100%" border="0" cellpadding="3" cellspacing="3"  class="admin_table">
  <tr>
    <th scope="row" width="100" align="right">企业用户名：</th>
    <td><?php echo $this->_tpl_vars['data']['username']; ?>
</td>
  </tr>
  <tr>
    <th scope="row" align="right">企业公司名：</th>
    <td><?php echo $this->_tpl_vars['data']['title']; ?>
</td>
  </tr>
  <tr>
    <th scope="row" align="right">地区：</th>
    <td><?php echo $this->_tpl_vars['data']['dq']; ?>
</td>
	<input type="hidden" name="subsite_id" value="<?php echo $this->_tpl_vars['data']['subsite_id']; ?>
" />
  </tr>
  <tr>
    <th scope="row" align="right">办理套餐类型：</th>
    <td>
    <select id="type" name="type" onchange="changetxt(this)">
	  	<option value="0">次数会员</option>
      	<option value="1">时间会员</option>
    </select>
    </td>
  </tr>
  <?php if ($this->_tpl_vars['data']['subsite_id'] == '5'): ?>
  <tr class="cishu">
    <th scope="row" align="right">普通次数：</th>
    <td><input type="text" name="bout" /></td>
  </tr>
  <tr class="cishu">
    <th scope="row" align="right">周六次数：</th>
    <td><input type="text" name="bout_6" /></td>
  </tr>
  <?php else: ?>
  <tr class="cishu">
    <th scope="row" align="right">办理次数：</th>
    <td><input type="text" name="bout" /></td>
  </tr>
  <?php endif; ?>
  <!-------------------->
  <tr class="cishu">
	<th align="right">开始时间：</th>
	<td>
		<input type="text" name="cs_ks_time" class="date_input"  value="<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" />
	</td>
  </tr>
  <tr class="cishu">
	<th align="right">结束时间：</th>
	<td>
		<input type="text" name="cs_end_time" class="date_input"  value="" />
	</td>
  </tr>
  <!-------------------->
  <tr class="zhanwei"style="display:none" >
	<th scope="row" align="right">开始时间：</th>
	<td>
		<input type="text" name="add_time" class="date_input"  value="" />  !不选择就是当前时间
	</td>
  </tr>
  <tr class="zhanwei"style="display:none" >
    <th scope="row" align="right">时间套餐时长：</th>
    <td>
    <select name="duration" onchange="changetxt(this)">
	  	<option value="1">一年套餐(12个月)</option>
		<option value="2">半年套餐(6个月)</option>
		<option value="3">一季套餐(3个月)</option>
    </select>
    </td>
  </tr>
  <tr class="zhanwei" style="display:none" >
    <th scope="row" align="right">展位号：</th>
    <td><input type="text" name="number" /></td>
  </tr>
</table>
<input type="submit" value="办理套餐" class="admin_submit" />
</form>
</div>
<!--底栏-->
<div class="footer link_lan">
Powered by <a href="http://www.74cms.com" target="_blank"><span style="color:#009900">74</span><span style="color: #FF3300">CMS</span></a> 3.3.20130614
</div>
<div class="admin_frameset" >
  <div class="open_frame" title="全屏" id="open_frame"></div>
  <div class="close_frame" title="还原窗口" id="close_frame"></div>
</div>
</body>
</html>