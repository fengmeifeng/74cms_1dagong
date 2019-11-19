<?php /* Smarty version 2.6.18, created on 2014-09-06 08:10:21
         compiled from danwei/nr.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="bodycolor">
<style type="text/css">
body {
	width: 100%;
	margin: 0;
	padding: 0;
	overflow: scroll;
}
</style>
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
<tr class="TableControl">
	<td align="left" colspan="12">
		<input type="button" value=" 新建 " class="sub" onclick="location='<?php echo $this->_tpl_vars['url']; ?>
/add_user';" />
		<FORM action="<?php echo $this->_tpl_vars['url']; ?>
/nr" method="post" style="display:inline;">
		<select class="SmallSelect" name="searchfield" >
			<option value="user">用户名</option>
			<option value="name">用户姓名</option>
			<option value="telephone">电话</option>
			<option value="phone">手机</option>
			<option value="email">电子邮件</option>
		</select>
		<input type="text" class="SmallInput" maxlength="200" size="12" name="searchvalue" />
		<input class="sub" type="submit"  value="查找"  />
		</FORM>
		<!---->
		<select class="SmallSelect" onchange="var jmpURL='<?php echo $this->_tpl_vars['url']; ?>
/nr/user_priv/' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}" name="user_priv">
			<option value="">用户权限[所有记录]</option>
			<?php $_from = $this->_tpl_vars['qx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
			<option value="<?php echo $this->_tpl_vars['list']['priv']; ?>
"><?php echo $this->_tpl_vars['list']['priv_name']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
		<!---->
		<select class="SmallSelect" onchange="var jmpURL='<?php echo $this->_tpl_vars['url']; ?>
/nr/dept_id/' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}" name="dept_id">
			<option value="">部门名称[所有记录]</option>
			<?php $_from = $this->_tpl_vars['bm']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
			<option value="<?php echo $this->_tpl_vars['list']['dept_id']; ?>
"><?php echo $this->_tpl_vars['list']['dept_name']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
</tr>
<tr class="TableControl">
	<td class="tabhead" align="left" colspan="12">&nbsp; 用户信息列表</td>
</tr>
<tr class="biaoti">
	<td align="middle" width="55">选择</td>
	<td align="middle" width="60">用户名</td>
	<td align="middle" width="60">用户姓名</td>
	<td align="middle" width="40">性别</td>
	<td align="middle" width="55">密码</td>
	<td align="middle" width="55">用户权限</td>
	<td align="middle">部门名称</td>
	<td align="middle">电话</td>
	<td align="middle">手机</td>
	<td align="middle">电子邮件</td>
	<td align="middle">操作</td>	
</tr>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
<tr class="tab">
	<td>
		<input type="checkbox" name="selectid[]" id="selectid" value="<?php echo $this->_tpl_vars['list']['id']; ?>
">
		<a href="<?php echo $this->_tpl_vars['url']; ?>
/mod_user/id/<?php echo $this->_tpl_vars['list']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['res']; ?>
/images/edit1.gif" border="0"></a>
	</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['user']; ?>
</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['name']; ?>
</td>
	<td align="center"><?php echo $this->_tpl_vars['list']['sex']; ?>
</td>
	<td align="center"><?php if ($this->_tpl_vars['list']['pass'] === ""): ?> <span style="color:red">密码为空</span> <?php else: ?> <span style="color:green">存在密码</span> <?php endif; ?></td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['privs']; ?>
</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['depts']; ?>
</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['telephone']; ?>
</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['phone']; ?>
</td>
	<td align="left">&nbsp;<?php echo $this->_tpl_vars['list']['email']; ?>
</td>
	<td> <a href="<?php echo $this->_tpl_vars['url']; ?>
/del_user/id/<?php echo $this->_tpl_vars['list']['id']; ?>
" onclick="return confirm('你确定要删除吗? ')" >删除</a> </td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<tr>
	<td colspan="12" align="left">
		&nbsp;&nbsp;<input type="checkbox" class="ckbox" style="display:inline-block">全选
		&nbsp;&nbsp;<?php echo $this->_tpl_vars['fpage']; ?>

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