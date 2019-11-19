<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-09 15:14 中国标准时间 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<link rel="shortcut icon" href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
favicon.ico" />
<title>Powered by 74CMS</title>
<link href="css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$("li").first().addClass("hover");
$("li>a").click(function(){
	$("li").removeClass("hover");
	$(this).parent().addClass("hover");
	$(this).blur();
	})
})
</script>
<style type="text/css">
.admin_left_box p{
	width: 80px;
	height: 23px;
	line-height: 23px;
	margin-left: 38px;
	font-size: 12px;
	font-weight: 400;
}
</style>
</head>
<body>
<div class="admin_left_box">
<ul>
<!---->
<li><a href="admin_vip.php"  target="mainFrame">vip套餐介绍</a></li>
</ul>
<!--更改url-->
<p>|-招聘会-|</p>
<ul>
<li><a href="/../vipgn/index.php/index/?id=<?php echo $this->_vars['QISHI']['subsite_id']; ?>
"  target="mainFrame">查看招聘会</a></li>
<!--<li><a href="/../vipgn/index.php/index/ckchqy/?id=<?php echo $this->_vars['QISHI']['subsite_id']; ?>
"  target="mainFrame">查看参会企业</a></li>-->
<li><a href="/../vipgn/index.php/dzshuju/?id=<?php echo $this->_vars['QISHI']['subsite_id']; ?>
"  target="mainFrame">查看企业预定情况</a></li>
<li><a href="/../vipgn/index.php/dzshuju/sells"  target="mainFrame">查看临时企业预定情况</a></li>
</ul>
<p>|-套餐-|</p>
<ul>
<li><a href="admin_vip.php?act=selecttcvip"  target="mainFrame" >查看套餐会员</a></li>
<li><a href="admin_vip.php?act=selectcsvip"  target="mainFrame" >查看次数会员</a></li>
<li><a href="/../vipgn/index.php/index/ssbl"  target="mainFrame">办理</a></li>
</ul>
<p>|-会员-|</p>
<ul>
<li><a href="admin_vip.php?act=ckvip"  target="mainFrame">查看会员</a></li>
<li><a href="/../vipgn/index.php/index/addvip/?id=<?php echo $this->_vars['QISHI']['subsite_id']; ?>
"  target="mainFrame">添加会员</a></li>
</ul>
<?php if ($this->_vars['name'] == "spadmin"): ?>
<p>|-管理员-|</p>
<ul>
<li><a href="/../vipgn/index.php/adminuser"  target="mainFrame">查看权限管理</a></li>
<li><a href="/../vipgn/index.php/adminuser/adminuseradd"  target="mainFrame">添加权限</a></li>
<li><a href="/../vipgn/index.php/adminuser/rz"  target="mainFrame">查看日志</a></li>
</ul>
<?php else: ?>
<p>|-管理者-|</p>
<ul>
<li><a href="/../vipgn/index.php/adminuser/modmima/name/<?php echo $this->_vars['name']; ?>
"  target="mainFrame">修改权限密码</a></li>
<li><a href="/../vipgn/index.php/adminuser/rz"  target="mainFrame">查看日志</a></li>
</ul>
<?php endif; ?>
</div>
</body>
</html>