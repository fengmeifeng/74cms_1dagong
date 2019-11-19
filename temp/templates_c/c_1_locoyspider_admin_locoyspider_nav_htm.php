<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-09 15:14 中国标准时间 */ ?>
<div class="topnav">
<a href="?act=set" <?php if ($this->_vars['navlabel'] == 'set'): ?>class="select"<?php endif; ?>><u>基本设置</u></a>
<a href="?act=set_news" <?php if ($this->_vars['navlabel'] == 'set_news'): ?>class="select"<?php endif; ?>><u>资讯采集</u></a>
<a href="?act=set_company" <?php if ($this->_vars['navlabel'] == 'set_company'): ?>class="select"<?php endif; ?>><u>企业采集</u></a>
<a href="?act=set_jobs" <?php if ($this->_vars['navlabel'] == 'set_jobs'): ?>class="select"<?php endif; ?>><u>职位采集</u></a>
<a href="?act=set_user" <?php if ($this->_vars['navlabel'] == 'set_user'): ?>class="select"<?php endif; ?>><u>生成会员</u></a>
<div class="clear"></div>
</div>
<script src="<?php echo $this->_vars['QISHI']['site_dir']; ?>
data/cache_classify.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function()
{
	showmenu("#company_nature_cn","#menu1","#company_nature");
	showmenu("#company_trade_cn","#menu2","#company_trade");
	showmenulayer("#company_district_cn","#menu3","#district","#company_district","",QS_city);
	showmenu("#company_scale_cn","#menu4","#company_scale");
	showmenulayer("#jobs_category_cn","#menu5","#jobs_category","#jobs_subclass","#thirdclass",QS_jobs);
	showmenulayer("#jobs_district_cn","#menu6","#sdistrict","#jobs_district","",QS_city);
	showmenu("#jobs_education_cn","#menu7","#jobs_education");
	showmenu("#jobs_experience_cn","#menu8","#jobs_experience");
	showmenu("#jobs_wage_cn","#menu9","#jobs_wage");
	
	
		
	//指定密码类型
	var password_tpye=$("#reg_password_tpye  :radio[checked]").val();
	password_tpye=="3"?$("#show_reg_password").show():$("#show_reg_password").hide();
	$("#reg_password_tpye :radio").click(function(){
	var password_tpye=$("#reg_password_tpye  :radio[checked]").val();
	password_tpye=="3"?$("#show_reg_password").show():$("#show_reg_password").hide();
	});	 
});
</script>