<?php /* Smarty version 2.6.18, created on 2015-08-22 10:18:20
         compiled from index/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'index/index.tpl', 48, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<?php echo $this->_tpl_vars['public']; ?>
/css/common.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['public']; ?>
/js/jquery.js"></script>

<title>查看展会</title>
</head>

<body style="background-color:#E0F0FE">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 查看展会 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>查看：&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['url']; ?>
/index/id/<?php echo $this->_tpl_vars['dqid']; ?>
">查看未过期</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['url']; ?>
/indexckqb/id/<?php echo $this->_tpl_vars['dqid']; ?>
">查看过期</a></h2>
</div>

<?php if ($this->_tpl_vars['dq'] != ""): ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;地址：&nbsp;
<?php $_from = $this->_tpl_vars['dq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['l']):
?>  
	<a href="<?php echo $this->_tpl_vars['url']; ?>
/index/id/0/dqid/<?php echo $this->_tpl_vars['l']['s_id']; ?>
"><?php echo $this->_tpl_vars['l']['s_districtname']; ?>
</a>&nbsp;&nbsp;
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>

<br />
<div class="pagetit">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="list" class="link_bk">
    <tbody><tr>
      <td height="26" class="admin_list_tit admin_list_first" width="120">
      <label id="chkAll" style="color: rgb(102, 102, 102);"><input type="checkbox" name=" " title="全选/反选" id="chk">举办时间</label>
	  </td>
      <td class="admin_list_tit">招聘会标题</td>
	  <td width="80" align="center" class="admin_list_tit"> 地区 </td>
      <td width="80" align="center" class="admin_list_tit"> 预定状态 </td>
      <td width="180" align="center" class="admin_list_tit">预定期限</td>
      <td width="120" align="center" class="admin_list_tit">添加日期</td>
      <td width="100" align="center" class="admin_list_tit">操作</td>
    </tr>
	<?php unset($this->_sections['ls']);
$this->_sections['ls']['loop'] = is_array($_loop=$this->_tpl_vars['data']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ls']['name'] = 'ls';
$this->_sections['ls']['show'] = true;
$this->_sections['ls']['max'] = $this->_sections['ls']['loop'];
$this->_sections['ls']['step'] = 1;
$this->_sections['ls']['start'] = $this->_sections['ls']['step'] > 0 ? 0 : $this->_sections['ls']['loop']-1;
if ($this->_sections['ls']['show']) {
    $this->_sections['ls']['total'] = $this->_sections['ls']['loop'];
    if ($this->_sections['ls']['total'] == 0)
        $this->_sections['ls']['show'] = false;
} else
    $this->_sections['ls']['total'] = 0;
if ($this->_sections['ls']['show']):

            for ($this->_sections['ls']['index'] = $this->_sections['ls']['start'], $this->_sections['ls']['iteration'] = 1;
                 $this->_sections['ls']['iteration'] <= $this->_sections['ls']['total'];
                 $this->_sections['ls']['index'] += $this->_sections['ls']['step'], $this->_sections['ls']['iteration']++):
$this->_sections['ls']['rownum'] = $this->_sections['ls']['iteration'];
$this->_sections['ls']['index_prev'] = $this->_sections['ls']['index'] - $this->_sections['ls']['step'];
$this->_sections['ls']['index_next'] = $this->_sections['ls']['index'] + $this->_sections['ls']['step'];
$this->_sections['ls']['first']      = ($this->_sections['ls']['iteration'] == 1);
$this->_sections['ls']['last']       = ($this->_sections['ls']['iteration'] == $this->_sections['ls']['total']);
?>
	<tr style="">
		<td class="admin_list admin_list_first">
			<input name="id[]" type="checkbox" id="id" value="<?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['id']; ?>
">    
			<span"><?php echo ((is_array($_tmp=$this->_tpl_vars['data'][$this->_sections['ls']['index']]['holddates'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</span>
		</td>
		<td class="admin_list">
			<a href="<?php echo $this->_tpl_vars['url']; ?>
/selqy/id/<?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['id']; ?>
"><span style="color:#005b7e;font-weight:bold;">查看这期-><?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['title']; ?>
<-企业名单</span></a>
		</td>
		<td align="center" class="admin_list">
			<?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['dq']; ?>

		</td>
        <td align="center" class="admin_list">
		允许预定	
		</td>
		<td align="center" class="admin_list">
			<?php echo ((is_array($_tmp=$this->_tpl_vars['data'][$this->_sections['ls']['index']]['predetermined_start'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>

			≈
			<?php echo ((is_array($_tmp=$this->_tpl_vars['data'][$this->_sections['ls']['index']]['predetermined_end'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>

		</td>
        <td align="center" class="admin_list">
			<?php echo ((is_array($_tmp=$this->_tpl_vars['data'][$this->_sections['ls']['index']]['addtime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>

		</td>
		<td align="center" class="admin_list">
			<a href="<?php echo $this->_tpl_vars['url']; ?>
/addzw/id/<?php echo $this->_tpl_vars['data'][$this->_sections['ls']['index']]['id']; ?>
/dqid/<?php echo $this->_tpl_vars['dqid']; ?>
">定展位</a> &nbsp;&nbsp;
		</tr>
	  <?php endfor; else: ?>
   <tr>
     <td colspan="7" class="admin_list">暂时没有找到展会，你可以刷新重试!</td>
   </tr>
<?php endif; ?>
<tr>
	<td colspan="7" class="admin_list"><?php echo $this->_tpl_vars['fpage']; ?>
</td>
</tr>
    </tbody>
</table>
</div>
</div>
<div class="admin_frameset">
	<div id="open_frame" class="open_frame" title="全屏"></div>
	<div id="close_frame" class="close_frame" title="还原窗口" style="display: none;"></div>
</div>
</body>