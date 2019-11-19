<?php /* Smarty version 2.6.18, created on 2015-08-24 10:48:26
         compiled from index/cztaocan.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'index/cztaocan.tpl', 41, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<?php echo $this->_tpl_vars['public']; ?>
/css/common.css" rel="stylesheet" type="text/css">
<title>更改展位</title>
</head>

<body style="background-color:#E0F0FE">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 更改展位 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>更改：</h2>
</div>
<br />

<form action="<?php echo $this->_tpl_vars['url']; ?>
/updata" method="post">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['data']['id']; ?>
" />
<input type="hidden" name="subsite_id" value="<?php echo $this->_tpl_vars['dqid']; ?>
" />
<input type="hidden" name="nf" value="1" />
现在展位：<b><?php echo $this->_tpl_vars['data']['number']; ?>
</b><br />
更改展位：<input type="text" name="number" /><br />
<input type="submit" value="更改" class="admin_submit"/>
</form>

<hr/>
<br/>

<div class="toptip">
<h2>增加时间：</h2>
</div>

<form action="<?php echo $this->_tpl_vars['url']; ?>
/zjshijian" method="post">
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['data']['id']; ?>
" />
	<input type="hidden" name="subsite_id" value="<?php echo $this->_tpl_vars['dqid']; ?>
" />
	到期时间：<b><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['end_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</b><br />
	<input type="hidden" name="end_time" value="<?php echo $this->_tpl_vars['data']['end_time']; ?>
" />
	选择：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="1"  checked="checked" name="sj"/>增加&nbsp;<input type="radio" value="2" name="sj"/>减少<br />
	增减天数：<input type="text" name="tianshu" /></br>
	<input type="submit" value="修改" class="admin_submit"/>
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