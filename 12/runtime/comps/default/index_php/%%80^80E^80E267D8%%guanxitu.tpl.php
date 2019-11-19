<?php /* Smarty version 2.6.18, created on 2014-09-01 17:43:02
         compiled from user/guanxitu.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['res']; ?>
/css/zTreeStyle/zTreeStyle.css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['res']; ?>
/js/jquery.ztree-3.5.js"></script>

<style type="text/css">
	.content_wrap {
		height: 100%;
		margin: 0;
		padding: 0;
		text-align: center;
		overflow-y: auto;
		overflow-x: hidden;
	}
	ul#treeDemo{
	
	}
</style>

<div class="bodycolor">
	<br />
	<form action="<?php echo $this->_tpl_vars['url']; ?>
/guanxitu" method="get">
		<select name="search" class="SmallSelect">
			<option value="name">姓名</option>
			<option value="bianhao">编号</option>
		</select>
		<input type="text" class="SmallInput" name="findvalue">
		<input type="submit" value=" 查找 " class="sub">
	</form>
	<br />
	
	<div class="yh_bj">
		<div class="content_wrap">
			<ul id="treeDemo" class="ztree"></ul>
		</div>
	</div>
</div>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>