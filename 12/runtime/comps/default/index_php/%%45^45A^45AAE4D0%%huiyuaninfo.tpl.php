<?php /* Smarty version 2.6.18, created on 2014-09-02 11:00:27
         compiled from user/huiyuaninfo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'user/huiyuaninfo.tpl', 102, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['res']; ?>
/js/WdatePicker/WdatePicker.js"></script>
<style>
.regwrap {
	margin-top: -5px;
	padding: 30px;
	text-align: left;
}
.regwrap h3 {
	display: block;
	color: #025db3;
	font-size: 14px;
	font-weight: bold;
	line-height: 40px;
	height: 40px;
	border-top: 1px solid #eee;
	margin-bottom: 5px;
}
.regwrap ul {
	display: block;
	padding-left: 20px;
}
ul {
	list-style-image: none;
	list-style-type: none;
}
.regwrap li {
	display: block;
	clear: both;
	margin-bottom: 10px;
	font-size: 14px;
	color: #111;
}
.regwrap label {
	width: 100px;
	text-align: right;
	display: block;
	float: left;
	margin-right: 5px;
	font-size: 14px;
	font-weight: normal;
	color: #999;
}
.ipt {
	height: 18px;
	line-height: 18px;
	padding: 3px 4px;
	font-family: Verdana,宋体,微软雅黑;
	background: url(/public/images/ipt.gif) 0 0 no-repeat;
	border: 1px solid #9A9A9A;
	border-bottom: 1px solid #CDCDCD;
	border-right: 1px solid #CDCDCD;
}
.regwrap span.red {
	font-family: 宋体;
	color: red;
	font-size: 12px;
}
.bt {
	height: 28px;
	line-height: 28px;
	width: 88px;
	background: url(/public/images/bt.gif) no-repeat;
	border: 0px;
	color: #fff;
	font-weight: bold;
	font-size: 14px;
	text-align: center;
}
</style>


<div class="regwrap">
<form method="post" action="<?php echo $this->_tpl_vars['url']; ?>
/modinfo/dqurl/<?php echo $this->_tpl_vars['dqurl']; ?>
" >
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['info']['id']; ?>
" />
	<h3>推荐信息</h3>
	<ul class="">
	  <li><label>姓名：</label> <?php echo $this->_tpl_vars['info']['name']; ?>
 </li>
	  <li><label>我的编号：</label><?php echo $this->_tpl_vars['info']['bianhao']; ?>
</li>
	  <li><label>推荐链接：</label> <a href="http://www.1dagong.com/tj.php?bh=<?php echo $this->_tpl_vars['tjurl']; ?>
" target="_blank">http://www.1dagong.com/tj.php?bh=<?php echo $this->_tpl_vars['tjurl']; ?>
</a> &nbsp; </li>
	  <li><label>推荐人数：</label>  <?php echo $this->_tpl_vars['info']['tj_num']; ?>
人 &nbsp; </li>
	  <li><label>获得的奖金：</label>  <?php echo $this->_tpl_vars['info']['jiangjin']; ?>
元 &nbsp; </li>
	</ul>
    <h3>个人信息</h3>
	<ul class="">
	  <li><label>姓别：</label><input name="sex" type="radio" value="男" <?php if ($this->_tpl_vars['info']['sex'] == '男'): ?> checked <?php endif; ?> > 男 &nbsp;&nbsp; <input type="radio" name="sex" value="女" <?php if ($this->_tpl_vars['info']['sex'] == '女'): ?> checked <?php endif; ?> > 女 <span class="red">*</span></li>
	  <li><label>联系电话：</label><input class="ipt" type="text" name="sphone" value="<?php echo $this->_tpl_vars['info']['sphone']; ?>
" size="20"> <span class="red">*</span></li>
	  <li><label>身份证号：</label><input class="ipt" type="text" name="id_number" value="<?php echo $this->_tpl_vars['info']['id_number']; ?>
" size="25" > <span class="red">*</span></li>
	  <li><label>详细地址：</label><input class="ipt" type="text" name="address" value="<?php echo $this->_tpl_vars['info']['address']; ?>
" size="35" > <span class="red">*</span></li>
	  <li><label>QQ/MSN：</label><input class="ipt" type="text" name="qq" value="<?php echo $this->_tpl_vars['info']['qq']; ?>
" size="20" ></li>
	  <li><label>推荐人关系：</label><select class="ipt" name="guanxi" style="height: 28px;">
			<option value="">请选择</option>
			<?php $_from = $this->_tpl_vars['guanxi']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<option value="<?php echo $this->_tpl_vars['item']['guanxi']; ?>
" <?php if ($this->_tpl_vars['item']['guanxi'] == $this->_tpl_vars['info']['guanxi']): ?> selected="selected"  <?php endif; ?> > <?php echo $this->_tpl_vars['item']['guanxi']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
			</select> </li>
	</ul>
	
	<h3>职位信息</h3>
	<ul class="">
	  <li><label>入职企业：</label> <input class="ipt" type="text" name="ruzhi_name" value="<?php echo $this->_tpl_vars['info']['ruzhi_name']; ?>
" size="20"> <span class="red">*</span></li>
	  <li><label>入职时间：</label> <input class="ipt" type="text" name="ruzhi_time" value="<?php if ($this->_tpl_vars['info']['ruzhi_time'] != '0'): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['info']['ruzhi_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
<?php endif; ?>" size="20" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})"> <span class="red">*</span> </li>
	</ul>
	
	<h3>银行信息</h3>
	<ul class="">
	  <?php if ($this->_tpl_vars['user'] != 'admin'): ?><li><label>  </label> <span class="red"> (没有权限修改银行账户信息!) </span> </li><?php endif; ?>
	  <li><label>开户银行：</label><input type="text" class="ipt" name="bank" value="<?php echo $this->_tpl_vars['info']['bank']; ?>
"  <?php if ($this->_tpl_vars['user'] != 'admin'): ?> disabled <?php endif; ?> /> <span class="red">*</span></li>
	  <li><label>开户所在支行：</label><input type="text" class="ipt" name="subbranch" value="<?php echo $this->_tpl_vars['info']['subbranch']; ?>
"  <?php if ($this->_tpl_vars['user'] != 'admin'): ?> disabled <?php endif; ?> /> <span class="red">*</span></li>
	  <li><label>银行账号：</label><input type="text" class="ipt" name="bank_account" value="<?php echo $this->_tpl_vars['info']['bank_account']; ?>
"  <?php if ($this->_tpl_vars['user'] != 'admin'): ?> disabled <?php endif; ?> /> <span class="red">* 开户名默认和您注册的真实姓名保持一致</span></li>
	</ul>
	<ul class="">
	  <li><label>&nbsp;</label><input type="submit" value="确定提交" ID="Submit1" class="bt"></li>
	</ul>
	
</form>

</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "public/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>