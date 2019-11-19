<?php require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.replace.php'); $this->register_modifier("replace", "tpl_modifier_replace",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-09 15:26 中国标准时间 */  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>

<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> 办理套餐 </div>
  <div class="clear"></div>
</div>
<div class="toptip">
<h2>办理：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/../vipgn/index.php/excel/cstcyh">生成Excel</a>
<?php if ($this->_vars['dq'] != ""): ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;地址：&nbsp;
<?php if (count((array)$this->_vars['dq'])): foreach ((array)$this->_vars['dq'] as $this->_vars['l']): ?> 
<a href="admin_vip.php?act=selectcsvip&qdid=<?php echo $this->_vars['l']['s_id']; ?>
"><?php echo $this->_vars['l']['s_districtname']; ?>
</a>&nbsp;&nbsp;
<?php endforeach; endif; ?>
<?php endif; ?>
</h2></div>
<br />
<!------------->
<form action="admin_vip.php" method="get">
<input type="hidden" name="act" value="selectcsvip" />
企业公司名：<input type="text" name="username" id="name"/>
<input type="submit" value="查询企业">  &nbsp;&nbsp;<a href="admin_vip.php?act=selectcsvip&jh=1">激活</a>	&nbsp;&nbsp;<a href="admin_vip.php?act=selectcsvip&jh=2">未激活</a>
</form>
<hr />
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="list" class="link_bk" >
  <tr> 
  	<th scope="col" class="admin_list_tit" width="110" align="left" style="padding-left:5px;"><input type="checkbox" />企业用户名</th>
    <th scope="col" class="admin_list_tit" width="230" align="left">企业公司名</th>
	<th scope="col" class="admin_list_tit" width="60" align="left">销售代表</th>
	<th scope="col" class="admin_list_tit" width="50" align="center">地区</th>
	<th scope="col" class="admin_list_tit" width="65" align="center">套餐类型</th>
	<th scope="col" class="admin_list_tit" width="65" align="center">用户类型</th>
	<th scope="col" class="admin_list_tit" width="50" align="center">套餐次数</th>
    <?php if ($this->_vars['dqid'] == 5): ?>
    <th scope="col" class="admin_list_tit" width="50" align="center">周六次数</th>
    <?php endif; ?>
	<th scope="col" class="admin_list_tit" width="70" align="center">开始时间</th>
	<th scope="col" class="admin_list_tit" width="70" align="center">结束时间</th>
	<th scope="col" class="admin_list_tit" width="70" align="center">添加时间</th>
	<th scope="col" class="admin_list_tit" width="80" align="center">套餐是否激活</th>
	<th scope="col" class="admin_list_tit" width="100" align="center">操作</th>
  </tr>
<?php if (count((array)$this->_vars['data'])): foreach ((array)$this->_vars['data'] as $this->_vars['list']): ?>  
  <tr>
	<td class="admin_list" align="left" style="padding-left:5px;"><input type="checkbox" name="id[]" value='<?php echo $this->_vars['list']['id']; ?>
'><?php echo $this->_vars['list']['username']; ?>
</td>
    <td class="admin_list"><?php echo $this->_vars['list']['title']; ?>
</td>
	<td class="admin_list"><?php echo $this->_vars['list']['xs_user']; ?>
</td>
	<td class="admin_list" align="center"><?php echo $this->_vars['list']['dq']; ?>
</td>
    <td class="admin_list" align="center"><?php echo $this->_run_modifier($this->_run_modifier($this->_vars['list']['type'], 'replace', 'plugin', 1, "1", "时间套餐"), 'replace', 'plugin', 1, "0", "次数套餐"); ?>
</td>
	<td class="admin_list" align="center"><?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_vars['list']['huiyuan'], 'replace', 'plugin', 1, "0", "正式会员"), 'replace', 'plugin', 1, "2", "免费体验"), 'replace', 'plugin', 1, "3", "橱窗赠送"); ?>
</td>
	<td class="admin_list" align="center"><?php echo $this->_vars['list']['bout']; ?>
</td>
    <?php if ($this->_vars['dqid'] == 5): ?>
    <td class="admin_list" align="center"><?php echo $this->_vars['list']['bout_6']; ?>
</td>
    <?php endif; ?>
    <td class="admin_list" align="center"><?php echo $this->_run_modifier($this->_vars['list']['cs_ks_time'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>
</td>
	<td class="admin_list" align="center"><?php echo $this->_run_modifier($this->_vars['list']['cs_end_time'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>
</td>
	<td class="admin_list" align="center"><?php echo $this->_run_modifier($this->_vars['list']['add_time'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>
</td>
	<td class="admin_list" align="center"><?php echo $this->_run_modifier($this->_run_modifier($this->_vars['list']['activation'], 'replace', 'plugin', 1, "1", "已激活"), 'replace', 'plugin', 1, "0", "未激活"); ?>
</td>
	<td class="admin_list" align="center">&nbsp;<a href="/../vipgn/index.php/index/cjh/id/<?php echo $this->_vars['list']['id']; ?>
">激活</a>&nbsp;&nbsp;<a href="/../vipgn/index.php/index/operating/id/<?php echo $this->_vars['list']['id']; ?>
">操作</a>&nbsp;&nbsp;<a href="/../vipgn/index.php/index/tcdel/id/<?php echo $this->_vars['list']['id']; ?>
/uid/<?php echo $this->_vars['list']['uid']; ?>
" onclick="return confirm('你确定要删除吗？')">删除</a></td>
  </tr>
<?php endforeach; endif; ?>
<tr>
		<td colspan="11" class="admin_list"><?php echo $this->_vars['fpage']; ?>
</td>
	<tr>
</table>
<!------------->
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