<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-09 15:14 中国标准时间 */  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>

<div class="admin_main_nr_dbox">
 <div class="pagetit">
	<div class="ptit"> <?php echo $this->_vars['pageheader']; ?>
</div>
  <div class="clear"></div>
</div>
  <div class="toptip">
	<h2>介绍：</h2>
	<h3>免费体验会员</h3>
	<p>添加用户会自动添加1次预定展会机会.使用期限是7天,不使用就过期.</p>
	<h3>橱窗赠送会员</h3>
	<p>添加用户会跳转到添加预定展会机会里,输入赠送的次数就行,使用期限是30天,不使用就过期.</p>
	<h3>改变会员用户类型</h3>
	<p>＇免费体验会员＇和＇橱窗赠送会员＇用户如果想变成＇正式会员＇只要＂查看会员＂中修改用户类型就行了.</p>
  </div>
</div>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>