<?php /* Smarty version 2.6.18, created on 2014-09-06 08:10:22
         compiled from danwei/dwgl.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="bodycolor">
<script type="text/javascript">
	$(function(){
		//隔行换色
		$(".tab:even").css("background","#FFFFFF");
		$(".tab:odd").css("background","#F8F8F8");	
		//鼠标移上换色
		$(".tab").hover(
		  function(){
		    $(this).css("background","#CFDDEA");
		  },
		  function(){
		    $(".tab:even").css("background","#FFFFFF");
			$(".tab:odd").css("background","#F8F8F8");
		});
		//checkbox,全选/全不选
		$(".ckbox").bind("click", function(){ 
			if($(".ckbox:checkbox").attr("checked")){
				$("[name = selectid[]]:checkbox").attr("checked", true);
			}else{
				$("[name = selectid[]]:checkbox").attr("checked", false);
			}
        });
	});
</script>
<table align="center" class="addtab" width='100%' cellspacing='0' cellpadding='0' border="1">
<tr>
	<FORM action="<?php echo $this->_tpl_vars['url']; ?>
/dwgl" method="post" style="display:inline;" >
	<td colspan="12" align="left">
		<input type="button" value=" 新建 " class="sub" onclick="alert('no')" /> <!--location='<?php echo $this->_tpl_vars['url']; ?>
/add';-->
		<select class="SmallSelect" name="searchfield" >
			<option value="dept_name">部门名称</option>
			<option value="tel_no">部门电话</option>
			<option value="manager">部门主管</option>
		</select>
		<input type="text" class="SmallInput" maxlength="200" size="12" name="searchvalue" value="" />
		<input type="submit" value=" 查找 " class="sub" />
		</FORM>	
	</td>
</tr>
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="12">&nbsp;系统菜单</td>
</tr>
<tr class="biaoti">
	<td align="middle" width="80">选择</td>
	<td align="middle" width="180">部门名称</td>
	<td align="middle" width="120">部门电话</td>
	<td align="middle" width="120">父部门</td>
	<td align="middle" width="80">部门主管</td>
	<td align="middle">部门人员</td>
	<td align="middle" width="150">操作</td>	
</tr>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
<FORM action="<?php echo $this->_tpl_vars['url']; ?>
/del" method="post" >
<tr class="tab">
	<td>
		<input type="checkbox" name="selectid[]" id="selectid" value="<?php echo $this->_tpl_vars['list']['dept_id']; ?>
">
		<a href="<?php echo $this->_tpl_vars['url']; ?>
/mod/id/<?php echo $this->_tpl_vars['list']['dept_id']; ?>
"><img src="<?php echo $this->_tpl_vars['res']; ?>
/images/edit1.gif" border="0"></a>
	</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['kg']; ?>
<?php echo $this->_tpl_vars['list']['dept_name']; ?>
</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['tel_no']; ?>
</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['dept']; ?>
</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['manager']; ?>
</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['dept_func']; ?>
</td>
	<td>
		<a href="<?php echo $this->_tpl_vars['url']; ?>
/add/dept_parent_id/<?php echo $this->_tpl_vars['list']['dept_id']; ?>
">添加子部门</a>
		<a onclick="return confirm('你确定要删除吗? ')" href="<?php echo $this->_tpl_vars['url']; ?>
/del/id/<?php echo $this->_tpl_vars['list']['dept_id']; ?>
">删除</a>
	</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<tr>
	<td colspan="12" align="left">
		&nbsp;&nbsp;&nbsp;<input type="checkbox" class="ckbox" style="display:inline-block">全选
		<input type="submit" value="删除" class="sub" onclick="return confirm('你确定要删除吗? ')" />
	</td>
</tr>
</FORM>
</table>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>