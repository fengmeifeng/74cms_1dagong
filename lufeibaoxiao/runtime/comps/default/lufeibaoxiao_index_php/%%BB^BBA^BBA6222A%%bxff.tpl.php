<?php /* Smarty version 2.6.18, created on 2014-04-21 09:18:37
         compiled from lufei/bxff.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'lufei/bxff.tpl', 61, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['res']; ?>
/css/lufei.css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['res']; ?>
/js/example.js"></script>

<div class="bodycolor">
<script type="text/javascript">
	$(function(){
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
	})
	//立即申请发放
	function sh(id){
		$('.id').val(id);
		$(".duihuakuangbox").show();


	}
	//正在等待发放
	function cg(){
		$('.id').val(id);
		$(".duihuakuangbox").show();

	}
</script>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr class="TableControl">
</tr>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="10">&nbsp;审核成功满15天用户管理</td>
</tr>
<tr class="TableControl">
	<td class="Tabhead" align="left" colspan="10">
		<form action="<?php echo $this->_tpl_vars['url']; ?>
/bxff" method="get" style="display:inline;">&nbsp;
		查找人员：	
		<input type="text" class="SmallInput" maxlength="200" size="20" name="name" style="display:inline-block">
		<input type="submit" value=" 查找 " class="sub">
		</form>
	</td>
</tr>
<tr class="biaoti">
	<td width="100">姓名</td>
	<td width="100">入职已满</td>
	<td width="120">电话</td>
	<td>身份证号码</td>
	<td>公司名</td>
	<td>开户行</td>
	<td width="180">卡号</td>
	<td width="100">入职时间</td>
	<td width="100">审核人</td>
	<td width="80">操作</td>
</tr>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
<tr class="tab">
	<td><input type="checkbox" name="box" value="<?php echo $this->_tpl_vars['list']['id']; ?>
">&nbsp;<?php echo $this->_tpl_vars['list']['xingming']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['rzt']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['dianhua']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['nameid']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['gongshiming']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['list']['yinhangming']; ?>
</td>
	<td align="left">&nbsp;&nbsp;<b><?php echo $this->_tpl_vars['list']['yinghaohao']; ?>
</b></td>
	<td align="left">&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['list']['rztime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</td>
	<td align="left">&nbsp;&nbsp;<b><?php echo $this->_tpl_vars['list']['shenheren']; ?>
</b></td>
	<td align="center">
		<?php if ($this->_tpl_vars['list']['dff'] == 0): ?>
			<a href="javascript:;" onclick="sh('<?php echo $this->_tpl_vars['list']['id']; ?>
')">立即申请发放</a>
		<?php elseif ($this->_tpl_vars['list']['dff'] == 1): ?>
			<a href="javascript:;" onclick="cg('<?php echo $this->_tpl_vars['list']['id']; ?>
')">正在等待发放</a>
		<?php endif; ?>
	</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<tr class="TableControl">
	<td class="biaoti" align="left" colspan="10">&nbsp;<?php echo $this->_tpl_vars['fpage']; ?>
</td>
</tr>
</table>

</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



<div class="duihuakuangbox" id="duihuakuangbox">
	<div class="duihuakuang">
		<div class="tit" id="tit">
			<div class="title" id="title">是否合格</div>
			<div class="close" onclick="gb()"> </div>
		</div>
		<div class="com">
			<form method="post" action="<?php echo $this->_tpl_vars['url']; ?>
/sf">
				<div class="xz"><input type="radio" name="sh" value="1"  checked="checked" onclick="radio_click(this)">合格&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="sh" value="0" onclick="radio_click(this)" >已离职</div>
				<div class="text"><input type="hidden" name="id" class="id" value=""><textarea name="text" class="tt"></textarea><input type="submit" value="提交" class="but"></div>

			</form>
		</div>
	</div>
</div>

<script>
var exampB = new DragObject({
	el: 'duihuakuangbox',
	attachEl: 'tit'
});
//关闭
function gb(){
	$(".duihuakuangbox").hide();
}
//-----------
function radio_click(obj){
	if(obj.value==0){
		$(".tt").show();
	}else{
		$(".tt").hide();
	}
}

</script>