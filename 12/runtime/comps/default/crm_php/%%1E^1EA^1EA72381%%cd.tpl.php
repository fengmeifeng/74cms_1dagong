<?php /* Smarty version 2.6.18, created on 2014-09-06 08:10:21
         compiled from danwei/cd.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['res']; ?>
/css/yhqx.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['res']; ?>
/css/zTreeStyle/zTreeStyle.css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['public']; ?>
/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['res']; ?>
/js/jquery.ztree-3.5.js"></script>

<style type="text/css">
	body{
		background:#eee;
	}
	.content_wrap {
		height: 100%;
		margin: 0;
		padding: 0;
		text-align: center;
		overflow-y: scroll;
		overflow-x: hidden;
		
	}
	ul#treeDemo {
		width: 210px;
		height: 100%;
	}
</style>

<div class="content_wrap">
	<ul id="treeDemo" class="ztree"></ul>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>