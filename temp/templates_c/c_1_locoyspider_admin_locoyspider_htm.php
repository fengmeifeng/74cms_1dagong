<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-09 15:14 中国标准时间 */  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div class="admin_main_nr_dbox">
 <div class="pagetit">
	<div class="ptit"> <?php echo $this->_vars['pageheader']; ?>
</div>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("locoyspider/admin_locoyspider_nav.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
  <div class="clear"></div>
</div>
    <div class="toptip">
	<h2>提示：</h2>
	<p>火车头采集规则请到论坛下载！</p>
	</div>
	<div class="toptit">基本设置</div>
	 <form action="?act=set_save" method="post"  name="form1" id="form1">
	 <?php echo $this->_vars['inputtoken']; ?>

    <table width="700" border="0" cellspacing="5" cellpadding="1" style=" margin-bottom:3px;">
    <tr>
      <td width="180" align="right">开启采集接口：</td>
      <td ><label for="label">
        <input name="open" type="radio" id="label" value="1"  <?php if ($this->_vars['show']['open'] == "1"): ?>checked="checked"<?php endif; ?>/>
        开启</label>
&nbsp;&nbsp;&nbsp;&nbsp;
<label for="label2">
<input type="radio" name="open" value="0" id="label2"  <?php if ($this->_vars['show']['open'] == "0"): ?>checked="checked"<?php endif; ?>/>
关闭 </label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td height="50"><span style="font-size:14px;">
        <input name="submit2" type="submit" class="admin_submit"    value="保存修改"/>
      </span></td>
    </tr>
  </table>
  </form>
  <div class="toptit">模糊匹配阀值</div>
	 <form action="?act=set_save" method="post"  name="form1" id="form1">
	 <?php echo $this->_vars['inputtoken']; ?>

    <table width="100%" border="0" cellspacing="5" cellpadding="1" style=" margin-bottom:3px; margin-top:10px;">
    <tr>
      <td width="180" align="right">模糊匹配阀值：</td>
      <td >
	  <input name="search_threshold" type="text" class="input_text_200" id="search_threshold" value="<?php echo $this->_vars['show']['search_threshold']; ?>
" maxlength="3"/>
	  <span style="color:#666666">(范围:1-100，如设置为100则为精确匹配，推荐设为：50-80)</span></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td height="50"><span style="font-size:14px;">
        <input name="submit2" type="submit" class="admin_submit"    value="保存修改"/>
      </span></td>
    </tr>
  </table>
  </form>
</div>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>