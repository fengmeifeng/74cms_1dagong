<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-09 15:14 中国标准时间 */ ?>
<a href="<?php echo $this->_vars['QISHI']['main_domain']; ?>
mobile/" class="mphone">手机频道</a>
<a href="<?php echo $this->_vars['QISHI']['main_domain']; ?>
salary">薪酬统计</a>
<a href="/">网站首页</a>
<a href="/plus/shortcut.php">保存到桌面</a>
<script type="text/javascript">
//顶部部登录
$.get("/plus/ajax_user.php", {"act":"top_loginform"},
function (data,textStatus)
{			
$("#top_loginform").html(data);
}
);
</script>