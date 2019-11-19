<?php /* Smarty version 2.6.18, created on 2015-08-21 16:48:30
         compiled from index/addvip.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<?php echo $this->_tpl_vars['public']; ?>
/css/common.css" rel="stylesheet" type="text/css">
<title>添加用户</title>
</head>
<style>
table th{
	font-size: 12px;
	font-weight : 500;
}
</style>
<body style="background-color:#E0F0FE">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 添加用户 </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>添加：</h2>
</div>
<br />
<!------->
<form action="<?php echo $this->_tpl_vars['url']; ?>
/selsecqy" method="post">
查询企业用户名：<input id="qname" name="qname" type="text" />
<input type="hidden" name="dq_id" value="<?php echo $this->_tpl_vars['dq_dq']; ?>
" />
<input id="select" type="submit" value="查询企业信息" />
</form>
<!-------->

<hr />
<br />
<form action="<?php echo $this->_tpl_vars['url']; ?>
/addqy" method="post">
<table width="100%" border="0" cellpadding="3" cellspacing="3"  class="admin_table">
  <tr>
    <th scope="row" width="100" align="right">地区：&nbsp;</th>
    <td>
	  <select name="subsite_id" >
		<?php unset($this->_sections['ls']);
$this->_sections['ls']['loop'] = is_array($_loop=$this->_tpl_vars['dq']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			<option value="<?php echo $this->_tpl_vars['dq'][$this->_sections['ls']['index']]['s_id']; ?>
" <?php if ($this->_tpl_vars['dq'][$this->_sections['ls']['index']]['s_id'] == $this->_tpl_vars['dq_dq']): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['dq'][$this->_sections['ls']['index']]['s_districtname']; ?>
</option>
		<?php endfor; endif; ?>
	  </select>
	</td>
  </tr>
  <tr>
    <th scope="row" width="100" align="right">企业id：&nbsp;</th>
    <td>&nbsp;<input type="text" name="qid" size="40" value="<?php echo $this->_tpl_vars['data']['uid']; ?>
" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业用户名：&nbsp;</th>
    <td>&nbsp;<input type="text" name="username" size="40" value="<?php echo $this->_tpl_vars['data']['username']; ?>
" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业公司名：&nbsp;</th>
    <td>&nbsp;<input type="text" name="title" size="40" value="<?php echo $this->_tpl_vars['data']['companyname']; ?>
" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业logo：&nbsp;</th>
    <td>&nbsp;
    	<img src="/data/logo/<?php echo $this->_tpl_vars['data']['logo']; ?>
" class="xsgslogo"/>
    	<input type="hidden" name="pic" value="<?php echo $this->_tpl_vars['data']['logo']; ?>
" />
    </td>
  </tr>
  <tr>
    <th scope="row" align="right">企业介绍：&nbsp;</th>
    <td>&nbsp;<textarea rows="10" cols="60" class="qyjs" name="contents"><?php echo $this->_tpl_vars['data']['contents']; ?>
</textarea></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业类型：&nbsp;</th>
    <td>
	  <select name="huiyuan" >
		<option value="1">正式会员</option>
		<option value="2">免费体验会员</option>
		<option value="3">橱窗赠送会员</option>
	  </select>
	</td>
  </tr>
  <tr>
    <th scope="row" align="right">企业电话：&nbsp;</th>
    <td>&nbsp;<input type="text" name="phone" size="40" value="<?php echo $this->_tpl_vars['data']['telephone']; ?>
" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">企业邮箱：&nbsp;</th>
    <td>&nbsp;<input type="text" name="email" size="40" value="<?php echo $this->_tpl_vars['data']['email']; ?>
" /></td>
  </tr>
  <tr>
    <th scope="row" align="right">销售代表: &nbsp;</th>
    <td>&nbsp;<input type="text" name="xs_user" size="40" value="<?php echo $this->_tpl_vars['data']['xs_user']; ?>
" /></td>
  </tr>
</table>
<input type="submit" value="提交" class="admin_submit" />
</form>
<!---->
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