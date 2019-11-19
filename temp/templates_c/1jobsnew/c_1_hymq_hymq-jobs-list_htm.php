<?php require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.cat.php'); $this->register_modifier("cat", "tpl_modifier_cat",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_hymq_jobs_list.php'); $this->register_function("qishi_hymq_jobs_list", "tpl_function_qishi_hymq_jobs_list",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-09-28 15:00 中国标准时间 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>行业名企招聘  - <?php echo $this->_vars['QISHI']['site_name']; ?>
</title>
<meta name="description" content="壹打工网行业名企频道，提供全国大型企业普通招聘，工人招聘，同时提供合肥联宝招聘，昆山仁宝招聘，上海达丰电脑等招工信息。">
<meta name="keywords" content="工人招聘，名企招聘，普工招聘">
<meta name="author" content="壹打工网" />
<meta name="copyright" content="1dagong.com" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<link rel="shortcut icon" href="favicon.ico" />
<link href="/files/css/jobs.css" rel="stylesheet" type="text/css" />
<link href="/files/css/common.css" rel="stylesheet" type="text/css" />

<link href="../files/css/all.css" rel="stylesheet" type="text/css" />
<link href="../files/css/font-awesome.min.css" rel="stylesheet" >

<link href="/files/css/company.css" rel="stylesheet" type="text/css" />
<script src="/files/js/jquery.js" type="text/javascript" language="javascript"></script>
<script src="/files/js/jquery.hoverDelay.js" type='text/javascript'></script>

<script src="/data/cache_classify.js" type='text/javascript' charset="utf-8"></script>
<!--搜索js-->
<script src="/files/js/jquery.hymq-jobs-search.js" type='text/javascript' ></script>
<!--搜索js-->
</head>
<body>
<!--头部开始-->
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<!--头部结束-->
<!-- 当前位置 -->
<!--<div class="page_location link_bk">
	当前位置：<a href="/">首页</a>>黄页
</div>
-->	<!-- 主体内容 -->
    
    
    
<div class="kuang over">
	<div class="left_list"> 
    	
        <div class="com_sousuo">
            <dl class="reset">
                    <dt>行业领域：</dt>
                    <dd id="hangye">
                     <a class="ye" href="/hymq/jobs-list.php" id="41">不限</a>   
                     <a href="/hymq/jobs-list.php?jobcategory=30.0&citycategory=&settr=" id="53">销售/市场</a>
                     <a href="/hymq/jobs-list.php?jobcategory=42.0&citycategory=&settr=" id="50">经营管理</a>
                     <a href="/hymq/jobs-list.php?jobcategory=56.0&citycategory=&settr=" id="46">IT管理/技术支持</a>
                     <a href="/hymq/jobs-list.php?jobcategory=211.0&citycategory=&settr=" id="49">物流/仓储/采购</a>
                     <a href="/hymq/jobs-list.php?jobcategory=157.0&citycategory=&settr=" id="52">建筑/装修</a>
                     <a href="/hymq/jobs-list.php?jobcategory=369.0&citycategory=&settr=" id="151">行政/后勤</a>
                     <a href="/hymq/jobs-list.php?jobcategory=413.0&citycategory=&settr=" id="47">酒店/餐饮/旅游/服务</a>
                     <a href="/hymq/jobs-list.php?jobcategory=424.0&citycategory=&settr=" id="51">汽车/摩托车修理</a>
                    </dd>
                </dl>
                 <dl class="reset">
                    <dt>工作地区：</dt>
                    <dd  class="option" id="jobsuptime">
                    <a class="ye" title="" href="/hymq/jobs-list.php" id="-1">不限</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&citycategory=13.224&settr=" id="settr-3">合肥</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&citycategory=2.0&settr=" id="settr-7">上海</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&citycategory=13.225&settr=" id="settr-30">芜湖</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&citycategory=13.226&settr=" id="settr-30">蚌埠</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&citycategory=4.0&settr=" id="settr-30">重庆</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&citycategory=18.0&settr=" id="settr-30">湖北</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&citycategory=11.204&settr=" id="settr-30">苏州</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&citycategory=11.201&settr=" id="settr-30">无锡</a>
                    </dd>
                </dl>
                <dl class="reset">
                    <dt>更新时间：</dt>
                    <dd>
                    <a class="ye" title="" href="/hymq/jobs-list.php" id="-1">不限</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&settr=1" id="settr-1">1天内</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&settr=3" id="settr-3">3天内</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&settr=7" id="settr-7">7天内</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&settr=15" id="settr-15">15天内</a>
                    <a href="/hymq/jobs-list.php?jobcategory=&settr=30" id="settr-30">30天内</a>
                    </dd>
                </dl>
        </div>
    <!--<div class="jobselected" id="jobselected">
	<div class="tit">已选条件：</div>
	<div class="showselected" id="showselected"></div>
	<div class="clearjobs" id="clearallopt">清空所选项</div>
	<div class="clear"></div>
	</div>-->
<?php echo tpl_function_qishi_hymq_jobs_list(array('set' => "分页显示:12,列表名:jobslist,显示数目:6,填补字符:...,职位名长度:13,企业名长度:19,描述长度:65,关键字:GET[key],职位分类:GET[jobcategory],职位大类:GET[category],职位小类:GET[subclass],地区分类:GET[citycategory],地区大类:GET[district],地区小类:GET[sdistrict],行业:GET[trade],日期范围:GET[settr],工资:GET[wage],年龄:GET[age],公司规模:GET[scale],排序:id>desc"), $this);?>
        <div class="in-list">
        	<?php if (count((array)$this->_vars['jobslist'])): foreach ((array)$this->_vars['jobslist'] as $this->_vars['list']): ?>
        	 <div class="in-list-con awidth <?php if ($this->_vars['list']['y'] % 3 == 0): ?>mrnone<?php endif; ?>" title="<?php echo $this->_vars['list']['companyname']; ?>
">
            	<h3><a href="<?php echo $this->_vars['list']['jobs_url']; ?>
"><?php echo $this->_vars['list']['companyname']; ?>
</a></h3>
                <P>月 工 资：<span><?php echo $this->_vars['list']['wage_cn']; ?>
</span></P>
                <P>接 待 站：<?php echo $this->_vars['list']['jiezhan']; ?>
</P>
                <P class="infdk"><?php echo $this->_vars['list']['shortitle']; ?>
</P>
                <a href="<?php echo $this->_vars['list']['jobs_url']; ?>
"><img src="/data/hymq_img/<?php echo $this->_vars['list']['logo']; ?>
" width="220px" height="101px" /></a>
                <div class="over wdids">
                	<p class="fl"><strong><?php echo $this->_vars['list']['bmrenshu'];  echo $this->_vars['trade']; ?>
人</strong>报名</p>
                    <a href="<?php echo $this->_vars['list']['jobs_url']; ?>
">去看看</a>
                </div>
               <div class="<?php if ($this->_vars['list']['zp_cn'] == '热聘'): ?>hot<?php endif; ?> <?php if ($this->_vars['list']['zp_cn'] == '急聘'): ?>urgent<?php endif; ?>"></div>
           </div>
			<?php endforeach; endif; ?>
          
        </div>   
        <?php if (! $this->_vars['jobslist']): ?>
		<div class="emptytip">抱歉，没有符合此条件的信息！</div>
		<?php endif; ?>
         <div class="over"></div>  
<table border="0" align="center" cellpadding="0" cellspacing="0" class="link_bk">
          <tr>
            <td height="50" align="center"><?php if ($this->_vars['page']): ?><div class="page link_bk"><?php echo $this->_vars['page']; ?>
</div><?php endif; ?></td>
          </tr>
      </table>    </div>
    
    <div class="right_list">
    	<div class="ewma">
        	<img src="/files/img/app.jpg" title="壹打工网客户端"  />
            扫描二维码，手机轻松找工作
        </div>
        
        <div class="rzhao">
        	<h2>相关招聘企业</h2>
            
            <ul class="rzlist">
            	<?php echo tpl_function_qishi_hymq_jobs_list(array('set' => $this->_run_modifier("列表名:jobs,显示数目:5,填补字符:...,职位名长度:13,企业名长度:19,排序:id > asc,行业:", 'cat', 'plugin', 1, $this->_vars['trade'])), $this);?>
				<?php if (count((array)$this->_vars['jobs'])): foreach ((array)$this->_vars['jobs'] as $this->_vars['list']): ?>
            	<li>
                	<h3><a href="<?php echo $this->_vars['list']['jobs_url']; ?>
"><?php echo $this->_vars['list']['companyname']; ?>
</a></h3>
                    <p><?php echo $this->_vars['list']['shortitle']; ?>
</p>
                    <font>月薪范围：<?php echo $this->_vars['list']['wage_cn']; ?>
</font>
                </li>
                <?php endforeach; endif; ?>
                
            </ul>
        </div>
    </div>
</div>



	<!-- 主体内容 结束 -->
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>