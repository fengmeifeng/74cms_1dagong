<?php require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_curriculum_list.php'); $this->register_function("qishi_curriculum_list", "tpl_function_qishi_curriculum_list",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_get_classify.php'); $this->register_function("qishi_get_classify", "tpl_function_qishi_get_classify",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.qishi_url.php'); $this->register_modifier("qishi_url", "tpl_modifier_qishi_url",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.qishi_categoryname.php'); $this->register_modifier("qishi_categoryname", "tpl_modifier_qishi_categoryname",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.cat.php'); $this->register_modifier("cat", "tpl_modifier_cat",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-09-28 14:59 中国标准时间 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php if ($_GET['trade']):  echo $this->_run_modifier($this->_run_modifier("QS_trade,", 'cat', 'plugin', 1, $_GET['trade']), 'qishi_categoryname', 'plugin', 1); ?>
 - <?php endif; ?>教育培训  - <?php echo $this->_vars['QISHI']['site_name']; ?>
</title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="骑士CMS" />
<meta name="copyright" content="74cms.com" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<link rel="shortcut icon" href="favicon.ico" />
<link href="/files/css/font-awesome.min.css" rel="stylesheet" >
<link href="/files/css/common.css" rel="stylesheet" type="text/css" />
<link href="/files/css/train.css" rel="stylesheet" type="text/css" />
<link href="/files/css/train/sub_train.css" rel="stylesheet" type="text/css" />
<script src="/files/js/jquery.js" type='text/javascript' ></script>
<script type="text/javascript">
$(document).ready(function()
{
 	$(".train_list .list:last").css("border-bottom","1px solid #d5d5d5");
 	$("#key").focus(function()
	{
	 var patrn=/^(请输入关键字...)/i; 
	 var key=$(this).val();
		if (patrn.exec(key))
		{
		$(this).css('color','').val('');
		} 
		$('input[id="key"]').keydown(function(e)
		{
		if(e.keyCode==13){
	   index_search_location()
		}
		});
	});
	$("#soall").click(function()
	{
		index_search_location();
	});
	function index_search_location()
	{
	var dir="/";
		$("body").append('<div id="pageloadingbox">页面加载中....</div><div id="pageloadingbg"></div>');
		$("#pageloadingbg").css("opacity", 0.5);
	 	var patrn=/^(请输入关键字...)/i; 
		var key=$("#key").val();
		if (patrn.exec(key))
		{
		$("#key").val('');
		key='';
		}
		$.get(dir+"plus/ajax_search_location.php", {"act":"QS_train_curriculum","key":key,"district":"<?php echo $_GET['district']; ?>
","sdistrict":"<?php echo $_GET['sdistrict']; ?>
","category":"<?php echo $_GET['category']; ?>
","classtype":"<?php echo $_GET['classtype']; ?>
","refre":"<?php echo $_GET['refre']; ?>
","start":"<?php echo $_GET['start']; ?>
"},
			function (data,textStatus)
			 {
				 window.location.href=data;
			 }
		);
	}
});
</script>
</head>
<body>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div class="page_location link_bk">
当前位置：<a href="/">首页</a>&nbsp;>&nbsp;<a href="<?php echo $this->_run_modifier("QS_train", 'qishi_url', 'plugin', 1); ?>
">教育培训</a>&nbsp;>&nbsp;课程列表
</div>
<div class="trainsel link_lan">
<div class="tit">
<h3>搜索课程</h3>
</div>
<div class="listbox">


<div class="s1">
<div class="litit keysel">关键字：</div>
	<div class="littxt">
		<div class="keybox">
			<div id="searcform" >
				<div class="keyinputbox">
				<input name="key" type="text" id="key" maxlength="25" <?php if ($_GET['key'] == ""): ?>value="请输入关键字..."<?php else: ?>value="<?php echo $_GET['key']; ?>
"<?php endif; ?> />
				</div>
				<div class="subinputbox"><input type="button" name=""  id="soall" value="搜索" /></div>
			</div>
		</div>
	</div>
</div>
 <!-- -->	

	<div class="bleft" >课程类别：</div>
	<div class="bright">
		<ul class="link_bk classify">
        <?php if ($_GET['category'] <> ""): ?>
		<?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_train,列表名:train"), $this);?>
		<?php if (count((array)$this->_vars['train'])): foreach ((array)$this->_vars['train'] as $this->_vars['li']): ?>
		<?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_train,id:" . $this->_vars['li']['id'] . ",列表名:train_sub"), $this);?>
		<?php if (count((array)$this->_vars['train_sub'])): foreach ((array)$this->_vars['train_sub'] as $this->_vars['list']): ?>
        <?php if ($_GET['category'] == $this->_vars['list']['id']): ?>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,category:", 'cat', 'plugin', 1, $this->_vars['list']['id']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-classtype:"), 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
"  style="color:#f60"><?php echo $this->_vars['list']['categoryname']; ?>
</a></li>
		<?php endif; ?>
        <?php endforeach; endif; ?>
		<?php endforeach; endif; ?>
        <?php else: ?>
        <?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_train,列表名:train"), $this);?>
		<?php if (count((array)$this->_vars['train'])): foreach ((array)$this->_vars['train'] as $this->_vars['li']): ?>
		<?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_train,id:" . $this->_vars['li']['id'] . ",列表名:train_sub"), $this);?>
		<?php if (count((array)$this->_vars['train_sub'])): foreach ((array)$this->_vars['train_sub'] as $this->_vars['list']): ?>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,category:", 'cat', 'plugin', 1, $this->_vars['list']['id']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-classtype:"), 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" ><?php echo $this->_vars['list']['categoryname']; ?>
</a></li>
        <?php endforeach; endif; ?>
		<?php endforeach; endif; ?>
        <?php endif; ?>
		<div class="clear"></div>
		</ul>
		
	</div>
	<div class="clear"></div>
	<!-- -->
	 <div class="bleft" >开课地区：</div>
	<div class="bright">
		<ul class="link_bk classify">					
	<?php if ($_GET['district'] <> ""): ?>
		<?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_district,id:0,列表名:c_province"), $this);?>
		<?php if (count((array)$this->_vars['c_province'])): foreach ((array)$this->_vars['c_province'] as $this->_vars['list']): ?>
		<?php if ($_GET['district'] == $this->_vars['list']['id']): ?>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,district:", 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-classtype:"), 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" style="color:#f60"><?php echo $this->_vars['list']['categoryname']; ?>
</a>
		</li>
		<?php endif; ?>
		<?php endforeach; endif; ?>
	<?php else: ?>
		<?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_district,id:0,列表名:c_province"), $this);?>
		<?php if (count((array)$this->_vars['c_province'])): foreach ((array)$this->_vars['c_province'] as $this->_vars['list']): ?>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,district:", 'cat', 'plugin', 1, $this->_vars['list']['id']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-classtype:"), 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" ><?php echo $this->_vars['list']['categoryname']; ?>
</a></li>
		<?php endforeach; endif; ?>
	<?php endif; ?>
		<div class="clear"></div>
		</ul>
	</div>
<?php if ($_GET['district']): ?>
	 <div class="bleft" >地区小类：</div>
	<div class="bright">
		<ul class="link_bk classify">	
	<?php if ($_GET['sdistrict'] <> ""): ?>
		<?php echo tpl_function_qishi_get_classify(array('set' => $this->_run_modifier($this->_run_modifier("类型:QS_district,id:", 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, ",列表名:c_province")), $this);?>
		<?php if (count((array)$this->_vars['c_province'])): foreach ((array)$this->_vars['c_province'] as $this->_vars['list']): ?>
		<?php if ($_GET['sdistrict'] == $this->_vars['list']['id']): ?>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,sdistrict:", 'cat', 'plugin', 1, $this->_vars['list']['id']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-classtype:"), 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
"  style="color:#f60"><?php echo $this->_vars['list']['categoryname']; ?>
</a></li>
		<?php endif; ?>
		<?php endforeach; endif; ?>
	<?php else: ?>
		<?php echo tpl_function_qishi_get_classify(array('set' => $this->_run_modifier($this->_run_modifier("类型:QS_district,id:", 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, ",列表名:c_province")), $this);?>
		<?php if (count((array)$this->_vars['c_province'])): foreach ((array)$this->_vars['c_province'] as $this->_vars['list']): ?>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,sdistrict:", 'cat', 'plugin', 1, $this->_vars['list']['id']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-classtype:"), 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" ><?php echo $this->_vars['list']['categoryname']; ?>
</a></li>
		<?php endforeach; endif; ?>
	<?php endif; ?>
		<div class="clear"></div>
		</ul>
	</div>
<?php endif; ?>
	<div class="clear"></div>
	<!-- -->
	 <div class="bleft" >上课班制：</div>
	<div class="bright">
		<ul class="link_bk classify">					
	<?php if ($_GET['classtype'] <> ""): ?>
		<?php echo tpl_function_qishi_get_classify(array('set' => "列表名:c_nature,类型:QS_train_classtype"), $this);?>
		<?php if (count((array)$this->_vars['c_nature'])): foreach ((array)$this->_vars['c_nature'] as $this->_vars['list']): ?>
			<?php if ($_GET['classtype'] == $this->_vars['list']['id']): ?>
				<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $this->_vars['list']['id']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" style="color:#f60"><?php echo $this->_vars['list']['categoryname']; ?>
</a></li>
			<?php endif; ?>
		<?php endforeach; endif; ?>
	<?php else: ?>
		<?php echo tpl_function_qishi_get_classify(array('set' => "列表名:c_nature,类型:QS_train_classtype"), $this);?>
		<?php if (count((array)$this->_vars['c_nature'])): foreach ((array)$this->_vars['c_nature'] as $this->_vars['list']): ?>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $this->_vars['list']['id']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" ><?php echo $this->_vars['list']['categoryname']; ?>
</a></li>
		<?php endforeach; endif; ?>
	<?php endif; ?>
		<div class="clear"></div>
		</ul>
		
	</div>
	<div class="clear"></div>
		<!-- -->
		 <div class="bleft" >开课时间：</div>
	<div class="bright">
		<ul class="link_bk classify">	
	<?php if ($_GET['start'] <> ""): ?>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" style="color:#f60"><?php echo $_GET['start']; ?>
天内</a></li>
	<?php else: ?>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-start:3"), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" >3天内</a></li>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-start:7"), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" >7天内</a></li>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-start:30"), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" >30天内</a></li>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-start:360"), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" >常年开课</a></li>
	<?php endif; ?>
		<div class="clear"></div>
		</ul>
		
	</div>
	<div class="clear"></div>
	<!-- -->
	
	<div class="bleft" >更新时间：</div>
	<div class="bright">
		<ul class="link_bk classify">	
	<?php if ($_GET['refre'] <> ""): ?>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" style="color:#f60"><?php echo $_GET['refre']; ?>
天内</a></li>
	<?php else: ?>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-refre:3"), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" >3天内</a></li>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-refre:7"), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" >7天内</a></li>
		<li><a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-refre:30"), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" >30天内</a></li>
		<div class="clear"></div>
	<?php endif; ?>
		</ul>
	</div>
	<div class="clear"></div>
	<!-- -->
</div>
<?php if ($_GET['category'] || $_GET['district'] || $_GET['sdistrict'] || $_GET['classtype'] || $_GET['start'] || $_GET['refre'] || $_GET['key']): ?>
  <div class="myselbox"  style="display:block;">
		  <div class="left">已选条件：</div>
		  <div class="optcentet">
		<?php if ($_GET['key']): ?>
		  <a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,key:-classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'qishi_url', 'plugin', 1); ?>
" title="点击取消"><u>关键字:</u><?php echo $_GET['key']; ?>
</a>
		<?php endif; ?>
		<?php if ($_GET['category']): ?>
		  <a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,category:-classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" title="点击取消"><u>课程类别:</u>

		 <?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_train,列表名:train"), $this);?>
		<?php if (count((array)$this->_vars['train'])): foreach ((array)$this->_vars['train'] as $this->_vars['li']): ?>
		<?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_train,id:" . $this->_vars['li']['id'] . ",列表名:train_sub"), $this);?>
		<?php if (count((array)$this->_vars['train_sub'])): foreach ((array)$this->_vars['train_sub'] as $this->_vars['list']): ?>
        <?php if ($this->_vars['list']['id'] == $_GET['category']): ?>
		<?php echo $this->_vars['list']['categoryname']; ?>

        <?php endif; ?>
        <?php endforeach; endif; ?>
		<?php endforeach; endif; ?>
          </a>
		<?php endif; ?>
		<?php if ($_GET['district']): ?>
		  <a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,district:", 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, "-classtype:"), 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
"  title="点击取消"><u>地区大类:</u><?php echo $this->_run_modifier($this->_run_modifier("QS_district,", 'cat', 'plugin', 1, $_GET['district']), 'qishi_categoryname', 'plugin', 1); ?>
</a>
		<?php endif; ?>
		<?php if ($_GET['sdistrict']): ?>
		  <a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:", 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
"  title="点击取消"><u>地区小类:</u><?php echo $this->_run_modifier($this->_run_modifier("QS_district,", 'cat', 'plugin', 1, $_GET['sdistrict']), 'qishi_categoryname', 'plugin', 1); ?>
</a>
		<?php endif; ?>
		<?php if ($_GET['classtype']): ?>
		  <a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,classtype:-category:", 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
"  title="点击取消"><u>上课班制:</u><?php echo $this->_run_modifier($this->_run_modifier("QS_train_classtype,", 'cat', 'plugin', 1, $_GET['classtype']), 'qishi_categoryname', 'plugin', 1); ?>
</a>
		<?php endif; ?>
		<?php if ($_GET['start']): ?>
		  <a  href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,start:-category:", 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-classtype:"), 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" title="点击取消"><u>开课时间:</u><?php echo $_GET['start']; ?>
天内</a>
		<?php endif; ?>
		<?php if ($_GET['refre']): ?>
		  <a  href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,refre:-category:", 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-district:"), 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-classtype:"), 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" title="点击取消"><u>刷新时间:</u><?php echo $_GET['refre']; ?>
天内</a>
		<?php endif; ?>
		  <div class="clear"></div>
		  </div>
		  <div class="right"><div class="clearoptall"><a  href="<?php echo $this->_run_modifier("QS_train_curriculum", 'qishi_url', 'plugin', 1); ?>
" class="clearall">清除所有</a></div></div>
		  <div class="clear"></div>
  </div>
<?php endif; ?>
</div>
<!--课程列表 -->
<div class="train_list">	
	<div class="sort">
		   <a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,district:", 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-classtype:"), 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-sort:rtime"), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" <?php if ($_GET['sort'] == "rtime" || $_GET['sort'] == ""): ?>class="select"<?php endif; ?>>更新时间</a>
		    <a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_train_curriculum,district:", 'cat', 'plugin', 1, $_GET['district']), 'cat', 'plugin', 1, "-category:"), 'cat', 'plugin', 1, $_GET['category']), 'cat', 'plugin', 1, "-sdistrict:"), 'cat', 'plugin', 1, $_GET['sdistrict']), 'cat', 'plugin', 1, "-classtype:"), 'cat', 'plugin', 1, $_GET['classtype']), 'cat', 'plugin', 1, "-start:"), 'cat', 'plugin', 1, $_GET['start']), 'cat', 'plugin', 1, "-refre:"), 'cat', 'plugin', 1, $_GET['refre']), 'cat', 'plugin', 1, "-sort:hot"), 'cat', 'plugin', 1, "-key:"), 'cat', 'plugin', 1, $_GET['key']), 'qishi_url', 'plugin', 1); ?>
" <?php if ($_GET['sort'] == "hot"): ?>class="select"<?php endif; ?>>关注度</a>
	</div>
<?php echo tpl_function_qishi_curriculum_list(array('set' => "分页显示:1,列表名:course,显示数目:GET[inforow],填补字符:...,显示数目:GET[inforow],描述长度:70,开课时间:GET[start],日期范围:GET[refre],课程类别:GET[category],地区大类:GET[district],地区小类:GET[sdistrict],上课班制:GET[classtype],关键字:GET[key],排序:GET[sort],列表页:QS_train_curriculum"), $this); if (count((array)$this->_vars['course'])): foreach ((array)$this->_vars['course'] as $this->_vars['list']): ?>
		<div class="list link_lan">
          <div class="curriculumname">
		  <a href="<?php echo $this->_vars['list']['course_url']; ?>
" target="_blank"><?php echo $this->_vars['list']['course_name']; ?>
</a>
		  <?php if ($this->_vars['list']['recommend'] == "1"): ?> <img src="<?php echo $this->_vars['QISHI']['site_template']; ?>
images/62.gif" border="0" align="absmiddle" title="推荐课程" class="vtip"/><?php endif; ?>
		  </div>
		  <div class="trainname link_bku"><a href="<?php echo $this->_vars['list']['train_url']; ?>
" target="_blank"><?php echo $this->_vars['list']['trainname']; ?>
</a></div>
		  <div class="clear"></div>
		  <!-- -->
		  <div class="tli link_bku">课程类别：<?php echo $this->_vars['list']['category_cn']; ?>
</div>
		  <div class="tli link_bku">上课班制：<?php echo $this->_vars['list']['classtype_cn']; ?>
</div>
		  <div class="tli peixun_price"> 培训费用：<?php if ($this->_vars['list']['train_expenses'] == 0): ?><span>面议</span><?php else: ?><span style="text-decoration: line-through"><?php echo $this->_vars['list']['train_expenses']; ?>
元</span><?php endif; ?></div>
          <div class="tli peixun_price">优惠价格：<?php if ($this->_vars['list']['favour_expenses'] == 0): ?><span>面议</span><?php else: ?><span><?php echo $this->_vars['list']['favour_expenses']; ?>
元</span><?php endif; ?></div>
		  <div class="tli">开课时间：<?php if ($this->_vars['list']['starttime'] == 0): ?>常年开课<?php else:  echo $this->_run_modifier($this->_vars['list']['starttime'], 'date_format', 'plugin', 1, "%Y-%m-%d");  endif; ?></div>
          <div class="tli">截止日期：<?php echo $this->_run_modifier($this->_vars['list']['addtime'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>
</div>
		  <div class="tli link_bku">所在地区：<?php echo $this->_vars['list']['district_cn']; ?>
</div>
		  <!--<div class="tli">总学时：<?php echo $this->_vars['list']['classhour']; ?>
学时</div>-->          
		  <div class="tli"> 更新日期：<?php echo $this->_run_modifier($this->_vars['list']['refreshtime'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>
</div>
		  <div class="clear"></div>
		  <div class="briefly">授课对象：<?php echo $this->_vars['list']['train_object']; ?>
</div>
		  <div class="briefly1">课程简介：<?php echo $this->_vars['list']['briefly']; ?>
</div>
  </div>
<?php endforeach; endif;  if ($this->_vars['page']): ?>
<table border="0" align="center" cellpadding="0" cellspacing="0" class="link_bk">
          <tr>
            <td height="50" align="center"> <div class="page link_bk"><?php echo $this->_vars['page']; ?>
</div></td>
          </tr>
      </table>
      <?php endif; ?>
		<?php if (! $this->_vars['course']): ?>
		<div class="emptytip">抱歉，没有符合此条件的信息！</div>
		<?php endif; ?>
</div>

		
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>