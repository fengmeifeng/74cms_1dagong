<?php require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_link.php'); $this->register_function("qishi_link", "tpl_function_qishi_link",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_hymq_jobs_list.php'); $this->register_function("qishi_hymq_jobs_list", "tpl_function_qishi_hymq_jobs_list",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_jobfair_list.php'); $this->register_function("qishi_jobfair_list", "tpl_function_qishi_jobfair_list",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_companyjobs_list.php'); $this->register_function("qishi_companyjobs_list", "tpl_function_qishi_companyjobs_list",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_jobs_list.php'); $this->register_function("qishi_jobs_list", "tpl_function_qishi_jobs_list",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_ad.php'); $this->register_function("qishi_ad", "tpl_function_qishi_ad",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_get_classify.php'); $this->register_function("qishi_get_classify", "tpl_function_qishi_get_classify",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.qishi_url.php'); $this->register_modifier("qishi_url", "tpl_modifier_qishi_url",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.cat.php'); $this->register_modifier("cat", "tpl_modifier_cat",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_hotword.php'); $this->register_function("qishi_hotword", "tpl_function_qishi_hotword",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_notice_list.php'); $this->register_function("qishi_notice_list", "tpl_function_qishi_notice_list",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.default.php'); $this->register_modifier("default", "tpl_modifier_default",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_pageinfo.php'); $this->register_function("qishi_pageinfo", "tpl_function_qishi_pageinfo",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-09 15:14 中国标准时间 */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" /><?php echo tpl_function_qishi_pageinfo(array('set' => "列表名:page,调用:QS_index"), $this);?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Cache-Control" content="no-transform" />
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<title><?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ""); ?>
壹打工网 - 让工作来找你</title>
	<meta name="keywords" content="<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
打工网，<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
兼职信息，<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, ''); ?>
招聘会信息。" />
	<meta name="description" content="壹打工网<?php echo $this->_run_modifier($this->_vars['QISHI']['subsite_districtname'], 'default', 'plugin', 1, '总'); ?>
站，汇集最新招工、兼职及招聘会信息，壹打工2015招聘会，提供招工信息和兼职招聘服务，免费为您找工作。企业招聘招工，个人找工作找兼职，就上壹打工网。" />
    <link rel="shortcut icon" href="favicon.ico" />
	<!-- css -->
	<link href="/files/css/font-awesome.min.css" rel="stylesheet" >
    <link href="/files/css/common.css" rel="stylesheet" type="text/css" />
    <link href="/files/css/all.css" rel="stylesheet" type="text/css" />
    <link href="/files/css/header-footer.css" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="/files/js/jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="/files/js/jquery.SuperSlide.2.1.1.js"></script>
    <script language="javascript" type="text/javascript" src="/files/js/lrtk.js"></script>
    <script language="javascript" type="text/javascript" src="/files/js/divselect.js"></script>
    <!--#############################################zzzzzzzzz####################################-->
	<script src="/files/js/jquery.jobs-search-shouye.js" type='text/javascript'></script>
    
    <!--<script src="/files/js/jquery.js" type="text/javascript" language="javascript"></script>-->
    <script src="/files/js/jquery.lazyload.js" type="text/javascript"></script>
    <script src="/data/cache_classify.js" type='text/javascript' charset="utf-8"></script>
    <script src="/files/js/jquery.KinSlideshow.min.js" type="text/javascript"></script>
    <!--中部菜单显示-->
    <script src="/files/js/jquery.comtip-min.js" type="text/javascript"></script>
    
    <script src="/files/js/jquery.index.js" type='text/javascript' ></script>
    <!--<script src="/files/js/floatAd.js" type='text/javascript' ></script>-->
    <link  href="/files/css/new.css" rel="stylesheet" type="text/css"/>
    
    
    
<!--------------左侧列表-------------->
   <script>
$(document).ready(function()
{
	index("/","/files/");
	get_right_menu(QS_jobs);
});
$(function(){
	$(".ad_box .ad_img:eq(3)").css("margin-right", 0);
	$(".leftMenu li,.leftmenu_box").hover(function(){
		$(this).addClass("hover");
		$(this).find(".category").stop().animate({
			"position":"relative",
			"left":10
		},200);
		$(".leftMenu li").siblings("li").css("border-right-color","#ffffff");
		
	},function(){
		$(this).removeClass("hover");
		$(this).find(".category").stop().animate({
			"position":"relative",
			"left":0
		},200);
		$(".leftMenu li").siblings("li").css("border-right-color","#CCC");
	});
	
}) 
</script>

<!---     合作企业图片滚动        --->
<script type="text/javascript">

			//图片滚动 调用方法 imgscroll({speed: 30,amount: 1,dir: "up"});
			$.fn.imgscroll = function(o){
				var defaults = {
					speed: 40,
					amount: 0,
					width: 1,
					dir: "left"
				};
				o = $.extend(defaults, o);
				
				return this.each(function(){
					var _li = $("li", this);
					_li.parent().parent().css({overflow: "hidden", position: "relative"}); //div
					_li.parent().css({margin: "0", padding: "0", overflow: "hidden", position: "relative", "list-style": "none"}); //ul
					_li.css({position: "relative", overflow: "hidden"}); //li
					if(o.dir == "left") _li.css({float: "left"});
					
					//初始大小
					var _li_size = 0;
					for(var i=0; i<_li.size(); i++)
						_li_size += o.dir == "left" ? _li.eq(i).outerWidth(true) : _li.eq(i).outerHeight(true);
					
					//循环所需要的元素
					if(o.dir == "left") _li.parent().css({width: (_li_size*3)+"px"});
					_li.parent().empty().append(_li.clone()).append(_li.clone()).append(_li.clone());
					_li = $("li", this);
			
					//滚动
					var _li_scroll = 0;
					function goto(){
						_li_scroll += o.width;
						if(_li_scroll > _li_size)
						{
							_li_scroll = 0;
							_li.parent().css(o.dir == "left" ? { left : -_li_scroll } : { top : -_li_scroll });
							_li_scroll += o.width;
						}
							_li.parent().animate(o.dir == "left" ? { left : -_li_scroll } : { top : -_li_scroll }, o.amount);
					}s
					
					//开始
					var move = setInterval(function(){ goto(); }, o.speed);
					_li.parent().hover(function(){
						clearInterval(move);
					},function(){
						clearInterval(move);
						move = setInterval(function(){ goto(); }, o.speed);
					});
				});
			};

			
			</script>
            
            <!-- 漂浮广告   -->          
            <!--<script type="text/javascript">
				$(function(){
					//调用漂浮插件
					$("body").floatAd({
						imgSrc : '/files/img/sanzhi.gif',
						url:'http://www.1dagong.com/zt/hefeizhaomu/'
					});
				})
			</script>-->
            <!-- 漂浮广告   -->
            <!--顶部大图-->
            <script type="text/javascript"> 
var time = 300; 
var h = 0; 
function addCount() 
{ 
    if(time>0) 
    { 
        time--; 
        h = h+5; 
    } 
    else 
    { 
        return; 
    } 
    if(h>400)  //高度 
    { 
        return; 
    } 
    document.getElementById("ads").style.display = ""; 
    document.getElementById("ads").style.height = h+"px"; 
    setTimeout("addCount()",30); 
} 
window.onload = function showAds() 
{ 
    addCount(); 
    setTimeout("noneAds()",5000); //停留时间自己调了 
} 
var T = 400; 
var N = 400; //高度 
function noneAds() 
{ 
    if(T>0) 
    { 
        T--; 
        N = N-5; 
    } 
    else 
    { 
        return; 
    } 
    if(N<0) 
    { 
        document.getElementById("ads").style.display = "none"; 
        return; 
    } 
    document.getElementById("ads").style.height = N+"px"; 
    setTimeout("noneAds()",30); 
} 
</script> 
<!--顶部大图-->
</head>
<!--<body style="background:#fff url(../files/img/guoqing.jpg) no-repeat top center;">-->
<body>
	<div id="ads" style="width:1920px;height:400px;background:url(/files/img/top.gif);margin:0 auto; position:absolute; left:50%; margin-left:-960px; z-index:1000000; border-bottom:5px solid #606;"></div> 
    <div id="top"></div>

<!--------------头部大横幅 广告-------------->

<SCRIPT> 
function toueme(){ 
document.getElementById("toubiao").style.display="none"; 
} 
</SCRIPT> 

<div id="toubiao"> 
    <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
        <tr> 
            <td>
                <a target="_blank" href="/zt/zonglishicha/">
                    <img class="topb" src="/files/img/topb.gif" alt="李克强总理视察申博人力资源集团" title="李克强总理视察申博人力资源集团" >
                </a>
            </td> 
            <td class="guangbi" align="right">
                <a class="guanbi" onClick=toueme() >X</a>
            </td> 
        </tr> 
    </table> 
</div>


<!--------------1分钟留下信息  广告-------------->
<SCRIPT> 
function baoming(){ 
document.getElementById("mianfei").style.display="none"; 
} 
</SCRIPT> 
<div id="mianfei"> 
    <div class="fei01">
    	<!--<div class="mainfei_word">
        	非一般的极速求职
            <a class="baoming" href="/zt/zhaogz/">1分钟找工作 <i class="fa fa-hand-o-right"></i></a>
           免费为你推荐工作
        </div>-->
        <div class="click_btn"><a href="/zt/zhaogz/" title="" target="_blank"></a></div>
    <a class="guanbi" onClick=baoming() >X</a>
    </div>
</div>
	
	<!--头部开始-->
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<!--头部结束-->
    <div class="kuang">
        <div class="gonggao fr">
            <p class="fl"><i class="fa fa-bullhorn"></i>公告：</p>
            <div class="fr" id="spds" >                
                 <marquee direction="left" align="bottom" height="25" width="100%" onmouseout="this.start()" onmouseover="this.stop()" scrollamount="2" scrolldelay="1"><?php echo tpl_function_qishi_notice_list(array('set' => "列表名:notice,显示数目:6,标题长度:24,分类:1,填补字符:...,排序:id>desc"), $this);?>
				<?php if (count((array)$this->_vars['notice'])): foreach ((array)$this->_vars['notice'] as $this->_vars['list']): ?>
                    <a  href="<?php echo $this->_vars['list']['url']; ?>
" target="_blank"><?php echo $this->_vars['list']['title']; ?>
</a>&nbsp;&nbsp;
                <?php endforeach; endif; ?></marquee>
                </div>
            </div> 
        </div>
    </div>
    
    
<!--------------首页公告------------->
<!--<script> 
var speed=150 
spds2.innerHTML=spds1.innerHTML 
function Marquee(){ 
if(spds2.offsetTop-spds.scrollTop<=100) 
spds.scrollTop-=spds1.offsetHeight 
else{ 
spds.scrollTop++ 
} 
} 
var MyMar=setInterval(Marquee,speed) 
spds.onmouseover=function() {clearInterval(MyMar)} 
spds.onmouseout=function() {MyMar=setInterval(Marquee,speed)} 
</script> -->

    
       <div class="main over">
         <div class="search">
         
<!--------------首页搜索 地区与职位下拉------------->
<script type="text/javascript">
/*屏蔽这两句js，重新写zzzzzz*/
	$(function(){
	$.divselect("#divselect","#inputselect");
	$.divselect("#divselect001","#inputselect001");
});
	$(document).ready(function(){
	/*按公司或者职位进行搜索*/
	/*$('#divselect li a').click(function(){
	$('#divselect .change_area input[name=areacode]').val($(this).attr('rel'));
	$('#divselect cite').text($(this).text());
	$('#divselect ul').hide();
	});*/
	//---ffffff
	$('#divselect li a').click(function(){
	$('#searckeybox input[name=types]').val($(this).attr('selectid'));
	});
	//---fffffflert($(this).text());
	/*按地区搜索*/
	$('#divselect001 li a').click(function(){
	$('#divselect001 input[name=citycategory]').val($(this).attr('selectid'));
	$('#divselect001 cite').text($(this).text());
	$('#divselect001 ul').hide();
	});
	
	});
</script>
            <form name="form1" action="/index_search.php" method="post">
              <div id="divselect">
                  <cite>职位</cite>
                  <ul>
                     <li><a href="javascript:;" selectid="1">职位</a></li>
                     <li><a href="javascript:;" selectid="2">公司</a></li>
                  </ul>
              </div>           
                         
                <div class="text" id="searckeybox">
                	<input type="hidden" name="types" id="types" value="" />
                    <input type="text" name="key" id="searchkey" data="<?php echo $_GET['key']; ?>
"  onfocus="this.value=''"   />
					<!--其他字段-->
					<!--<input name="trade_id" id="trade_id" type="hidden" value="<?php echo $_GET['trade']; ?>
" />
					<input name="jobs_id" id="jobs_id" type="hidden" value="<?php echo $_GET['jobcategory']; ?>
" />
					<input type="hidden" value="<?php echo $_GET['wage']; ?>
" name="wage">
					<input type="hidden" value="<?php echo $_GET['education']; ?>
" name="education">
					<input type="hidden" value="<?php echo $_GET['experience']; ?>
" name="experience">
					<input type="hidden" value="<?php echo $_GET['nature']; ?>
" name="nature">
					<input type="hidden" value="<?php echo $_GET['settr']; ?>
" name="settr">
					<input type="hidden" value="" name="sort">
					<input type="hidden" value="1" name="page">-->
					<!--其他字段结束-->
                </div>
                
              <div id="divselect001">
                  <cite>地区</cite>
				  <input type="hidden" name="citycategory" value="">
                  <ul>
                     <li><a href="javascript:;" selectid="">不限</a></li>
                     <li><a href="javascript:;" selectid="13.224">合肥</a></li>
                     <li><a href="javascript:;" selectid="13.225">芜湖</a></li>
                     <li><a href="javascript:;" selectid="2.0">上海</a></li>
                     <li><a href="javascript:;" selectid="4.0">重庆</a></li>
                     <li><a href="javascript:;" selectid="18.0">湖北</a></li>
                     <li><a href="javascript:;" selectid="18.295">武汉</a></li>
                     <li><a href="javascript:;" selectid="11.0">江苏</a></li>
                     <li><a href="javascript:;" selectid="17.278">郑州</a></li>
                  </ul>
              </div>
                 
                 <div><input class="button" id="btnsearch" ty="QS_jobslist" type="submit" value="搜索" /></div>
                 
            </form>
        </div>
		
		<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.autocomplete.js" type="text/javascript"></script>
					<script language="javascript" type="text/javascript">
					 $(document).ready(function()
					{
						  var a = $('#searchkey').autocomplete({ 
							serviceUrl:'<?php echo $this->_vars['QISHI']['website_dir']; ?>
plus/ajax_common.php?act=hotword',
							minChars:1, 
							maxHeight:400,
							width:360,
							zIndex: 1,
							deferRequestBy: 0 
						  });
					
					});
					  </script>
        <div class="hotse">  热门搜索：
        	<!--热门关键字-->
        	<?php echo tpl_function_qishi_hotword(array('set' => "显示数目:9,列表名:list"), $this);?>
            <?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['li']): ?>
            <a href="<?php echo $this->_run_modifier($this->_run_modifier("QS_jobslist,key:", 'cat', 'plugin', 1, $this->_vars['li']['w_word_code']), 'qishi_url', 'plugin', 1); ?>
" target="_blank"><?php echo $this->_vars['li']['w_word']; ?>
</a>
            <?php endforeach; endif; ?> 
            <!--<a href="#">技工</a>-->
            
        </div>
		
    </div>
<!--------------banner下面 选项卡-------------->  
<script type="text/javascript"> 
function setTab(name,m,n){ 
for( var i=1;i<=n;i++){ 
var menu = document.getElementById(name+i); 
var showDiv = document.getElementById("cont_"+name+"_"+i); 
menu.className = i==m ?"on":""; 
showDiv.style.display = i==m?"block":"none"; 
} 
} 
</script> 

<div class="jieri">
	<div class="jr_l"></div>
	<div class="jr_r"></div>
</div>
<!--社会服务岗位招募横幅 开始 -->
<div class="shehui_zhaomu"><a href="http://www.1dagong.com/zt/hefeizhaomu/" target="_blank" title="合肥市社会服务岗位招募"><img src="/files/img/hengfu_banner.gif" alt="合肥市社会服务岗位招募" /></a></div>
<!--社会服务岗位招募横幅 结束 -->
<div class="kuang over">
    <div class="container fl wid220">
    <!-- 行业职位 -->
	<div class="left">
			
			<div class="category_wrap leftMenu" id="topWrap">
				<div class="h3"><i class="fa fa-bars"></i>全部职位分类</div>
				<ul>
					<?php echo tpl_function_qishi_get_classify(array('set' => "列表名:category,类型:QS_jobs,显示数目:10"), $this);?>
					<?php if (count((array)$this->_vars['category'])): foreach ((array)$this->_vars['category'] as $this->_vars['list']): ?>	
					<li class="clearfix" id="<?php echo $this->_vars['list']['id']; ?>
">
						<div class="category">
                        
							<p><a href="javascript:void(0);"><?php echo $this->_vars['list']['categoryname']; ?>
</a></p>
							<div class="icon_right">
								<span class="angle_right"><i class="submenu-icon fa fa-plus"></i></span>
							</div>
						</div>
						<div class="sub_category"></div>
					</li>
					<?php endforeach; endif; ?>
				</ul>
			</div>
			<div class="leftmenu_box">
					<div class="show">
                    
					</div>
                    
	  </div>
	  </div>      
        
	<!-- 行业职位 结束 -->
   </div>
    
    <div class="wid515 mr25 fl">
<!--------------banner图-------------->  
<script type="text/javascript">
jQuery(function($){
	var index = 0;
	var maximg = 5;
	//$('<div id="flow"></div>').appendTo("#myjQuery");

	//滑动导航改变内容	
	$("#myjQueryNav li").hover(function(){
		if(MyTime){
			clearInterval(MyTime);
		}
		index  =  $("#myjQueryNav li").index(this);
		MyTime = setTimeout(function(){
		ShowjQueryFlash(index);
		$('#myjQueryContent').stop();
		} , 400);

	}, function(){
		clearInterval(MyTime);
		MyTime = setInterval(function(){
		ShowjQueryFlash(index);
		index++;
		if(index==maximg){index=0;}
		} , 3000);
	});
	//滑入 停止动画，滑出开始动画.
	 $('#myjQueryContent').hover(function(){
			  if(MyTime){
				 clearInterval(MyTime);
			  }
	 },function(){
				MyTime = setInterval(function(){
				ShowjQueryFlash(index);
				index++;
				if(index==maximg){index=0;}
			  } , 3000);
	 });
	//自动播放
	var MyTime = setInterval(function(){
		ShowjQueryFlash(index);
		index++;
		if(index==maximg){index=0;}
	} , 3000);
});
function ShowjQueryFlash(i) {
$("#myjQueryContent div").eq(i).animate({opacity: 1},1000).css({"z-index": "1"}).siblings().animate({opacity: 0},1000).css({"z-index": "0"});
//$("#flow").animate({ left: 652+(i*76) +"px"}, 300 ); //滑块滑动
$("#myjQueryNav li").eq(i).addClass("current").siblings().removeClass("current");
}
</script>
        <div class="topvebanner fr">
          <div id="myjQuery">
            <div id="myjQueryContent">
            <?php echo tpl_function_qishi_ad(array('set' => "显示数目:5,调用名称:QS_indexfocus,列表名:ad,排序:show_order>desc"), $this); if (count((array)$this->_vars['ad'])): foreach ((array)$this->_vars['ad'] as $this->_vars['list']): ?>
              <div><a href="<?php echo $this->_vars['list']['img_url']; ?>
" target="_blank"><img src="<?php echo $this->_vars['list']['img_path']; ?>
" title="<?php echo $this->_vars['list']['img_explain']; ?>
"></a></div>
            <?php endforeach; endif; ?>
            </div>
            <ul id="myjQueryNav">
             <!--<li class="current"></li>-->
            <?php echo tpl_function_qishi_ad(array('set' => "显示数目:5,调用名称:QS_indexfocus,列表名:ad,排序:show_order>desc"), $this); if (count((array)$this->_vars['ad'])): foreach ((array)$this->_vars['ad'] as $this->_vars['list']): ?>
               <li></li>
            <?php endforeach; endif; ?>
            </ul>
          </div>
        </div>
        
        <div class="tab"> 
            <div class="yesc"> 
                <ul> 
                    <li id="one1" class="on" onmouseover='setTab("one",1,5)'>最新招聘</li> 
                    <li id="one2" onmouseover='setTab("one",2,5)'>热门招聘</li>
                    <li id="one3" onmouseover='setTab("one",3,5)'>高薪职位</li> 
                	<li id="one4" onmouseover='setTab("one",4,5)'>兼职</li> 
                   <!-- <li class="none" id="one5" onmouseover='setTab("one",5,5)'>高薪职位</li>-->
                </ul> 
            </div> 
            <div class="tabList"> 
                <div id="cont_one_1" class="the01 jinji_zhaoP"> 
                	<ul>
                    <?php echo tpl_function_qishi_jobs_list(array('set' => "列表名:jobs,显示数目:8,填补字符:...,职位名长度:11,排序:rtime>desc"), $this);?>
					<?php if (count((array)$this->_vars['jobs'])): foreach ((array)$this->_vars['jobs'] as $this->_vars['jobslist']): ?>											
                    	<li><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
"><span class="zhaoP_title"><?php echo $this->_vars['jobslist']['jobs_name']; ?>
</span><b class="gongZ"><?php echo $this->_vars['jobslist']['wage_cn']; ?>
</b><!--<span class="memberN"><?php echo $this->_vars['jobslist']['amount']; ?>
人</span>--><span class="date"><?php echo $this->_vars['jobslist']['refreshtime_cn']; ?>
</span></a></li>
					<?php endforeach; endif; ?>
                  </ul>
                </div>

                <div id="cont_one_2" class="the01 one"> 
                	<ul>
                    	<!--热门招聘(推荐企业推广)-->
                        <?php echo tpl_function_qishi_companyjobs_list(array('set' => "列表名:company,显示数目:8,显示职位:4,职位名长度:4,企业名长度:12,排序:hot>desc"), $this);?><!--推荐:1-->
                        <?php if (count((array)$this->_vars['company'])): foreach ((array)$this->_vars['company'] as $this->_vars['list']): ?>
                   	  <li>
                            <!---字体颜色-class="wids"--><P><?php if (count((array)$this->_vars['list']['jobs'])): foreach ((array)$this->_vars['list']['jobs'] as $this->_vars['jobslist']): ?><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" ><?php echo $this->_vars['jobslist']['jobs_name']; ?>
</a><?php endforeach; endif; ?></P>
                            <span><?php echo $this->_vars['list']['refreshtime_cn']; ?>
</span>
                            <!--<span><strong><?php echo $this->_vars['list']['amount']; ?>
</strong>人</span>-->
                        </li>
                        <?php endforeach; endif; ?>
                    </ul>
                </div> 
                <div id="cont_one_3" class="the03 one"> 
                	<ul>
                    	<!--推荐招聘-->
                    	<!--<li>
                        	<a href="#">销售/市场sdfsdg索噶</a>
                            <p>10000-14999<font color="#999" size="2">元/月</font></p>
                            <span>安徽合肥
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </span>
                        </li>
                        <li class="width40">&nbsp;</li>-->
                        
                        <!--推荐招聘-->
                        
                    	 <!--高薪职位-->
                       <?php echo tpl_function_qishi_jobs_list(array('set' => "列表名:list,显示数目:8,排序:wage>desc"), $this);?>
                       <?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['li']): ?>
                    	<li>
                        	<a href="<?php echo $this->_vars['li']['jobs_url']; ?>
"><?php echo $this->_vars['li']['jobs_name']; ?>
</a>
                            <p><?php echo $this->_vars['li']['wage_cn']; ?>
<!--<font color="#999" size="2">元/月</font>--></p>
                            <span><?php echo $this->_vars['li']['district_cn']; ?>

                                <!--<i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>-->
                            </span>
                        </li>
                         <li style="width:20px;">&nbsp;</li>
                        <?php endforeach; endif; ?>
                    </ul>
                </div> 
                <div id="cont_one_4" class="the01 the04 one">
                	
                	<ul>
                    	<!--兼职/实习-->
                        <?php echo tpl_function_qishi_jobs_list(array('set' => "列表名:list,显示数目:8,职位性质:63,排序:rtime>desc"), $this);?>
                           <?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['li']): ?>
                            <li>
                                <P><a href="<?php echo $this->_vars['li']['jobs_url']; ?>
"><?php echo $this->_vars['li']['jobs_name']; ?>
</a></P><span><?php echo $this->_vars['li']['refreshtime_cn']; ?>
</span>
                                <span class="qian"><?php echo $this->_vars['li']['wage_cn']; ?>
</span>
                                <!--<span><?php echo $this->_vars['li']['refreshtime_cn']; ?>
</span>-->
                                <span><?php echo $this->_vars['li']['amount']; ?>
人</span>
                        	</li>
                            <?php endforeach; endif; ?> 
                    </ul>
                </div> 
                
                <div id="cont_one_5" class="the03 one"> 
                	<ul>
                    	<!--高薪职位-->
                    	<!--<li>
                        	<a href="#">销售/市场sdfsdg索噶</a>
                            <p>10000-14999<font color="#999" size="2">元/月</font></p>
                            <span>安徽合肥
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </span>
                        </li>
                        <li class="width40">&nbsp;</li>-->
                        <!--高薪职位-->
                       <?php echo tpl_function_qishi_jobs_list(array('set' => "列表名:list,显示数目:6,排序:wage>desc,日期范围:356"), $this);?>
                       <?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['li']): ?>
                    	<li>
                        	<a href="<?php echo $this->_vars['li']['jobs_url']; ?>
"><?php echo $this->_vars['li']['jobs_name']; ?>
</a>
                            <p><?php echo $this->_vars['li']['wage_cn']; ?>
<!--<font color="#999" size="2">元/月</font>--></p>
                            <span><?php echo $this->_vars['li']['district_cn']; ?>

                                <!--<i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>-->
                            </span>
                        </li>
                         <li style="width:20px;">&nbsp;</li>
                        <?php endforeach; endif; ?>
                        
                        
                    </ul>
                </div> 
            </div>
        </div> 
        
	</div>
    
    <div class="wid270 fr">
    	<div class="zhiwei">
        	<div class="fabu over">
            <p><font>壹打工网，海量职位，任你挑选</font>仅仅只需一步，让工作来找你。</p>
        	<a href="/user/personal/personal_resume.php?act=make1" class="geren fl"><i class="fa fa-file-text"></i>填写简历</a>
            <a href="/user/company/company_jobs.php?act=addjobs" class="qiye fr"><i class="fa fa-align-center"></i>发布职位</a>
        </div>
        <!--<div class="newzw">
        	本周新增职位&nbsp;<span><?php echo $this->_vars['time_display']; ?>
</span>&nbsp;个
        </div>-->
        </div>
        <div class="zhiping_btn"><a href="/zt/">壹打工网职业素质测评</a> </div>
       <!--调取本分站的最新招聘会 开始-->
        <div class="scene">
			<a title="找工作"  class="scene_a"><img src="files/img/beijin.jpg" alt="" /></a>
            <div class="hnsd">
            	<dl>
                	<dt><h3 class="fl">现场招聘会</h3></dt>
					<?php echo tpl_function_qishi_jobfair_list(array('set' => "列表名:jobfair,显示数目:1,标题长度:35,分页显示:1,标题长度:35,填补字符:..."), $this);?>
					<?php if (count((array)$this->_vars['jobfair'])): foreach ((array)$this->_vars['jobfair'] as $this->_vars['list']): ?> 
                    <dd><a href="<?php echo $this->_vars['list']['url']; ?>
&dqid=<?php echo $this->_vars['dqid']; ?>
"><strong>壹打工网</strong>全国巡回招聘会 <br /><font color="#606"></font></a></dd>
                    <dd><i class="fa fa-clock-o"></i><?php echo $this->_run_modifier($this->_vars['list']['holddates'], 'date_format', 'plugin', 1, "%Y年%m月%d日"); ?>
</dd>
                    <dd><i class="fa fa-map-marker"></i><?php echo $this->_vars['list']['address']; ?>
</dd>
                    <dd><i class="fa fa-phone"></i><?php echo $this->_vars['list']['phone']; ?>
</dd>
					<?php endforeach; endif; ?>
                </dl>
                
            </div>
        </div>
    	<!--调取本分站的最新招聘会 结束-->
    	
    </div> 
</div>   
      
    <!--壹打工线下人才市场 -->
<?php echo tpl_function_qishi_jobfair_list(array('set' => "列表名:jobfair,显示数目:7,标题长度:35,分页显示:1,标题长度:35,填补字符:..."), $this);?>
<?php if ($this->_vars['jobfair']): ?>
<div class="kuang company">
	<h2>
            <i class="fa fa-users"></i>壹打工人才市场<span>网上预约，现场招聘。</span> <a href="/jobfair/jobfair-list.php" target="_blank" class="more" title="精挑细选的行业优秀企业">查看更多>></a>
    </h2>
    <div class="company_jobs" id="tab_rencai">
        <div class="hd zhaop_date" id="zhaop_date">
        	<ul class="tab-nav">
            	<?php if (count((array)$this->_vars['jobfair'])): foreach ((array)$this->_vars['jobfair'] as $this->_vars['list']): ?> 
                <li <?php if ($this->_vars['list']['y'] == 1): ?>class="on"<?php endif; ?>><?php echo $this->_run_modifier($this->_vars['list']['holddates'], 'date_format', 'plugin', 1, "%m月%d日"); ?>
</li>
                <?php endforeach; endif; ?>
                <!--<li style="margin-right:0;">9月10日</li>-->
            </ul>
        </div>
        
    	<div class="bd tab-warp company_jobsLeft" >
        	<?php if (count((array)$this->_vars['jobfair'])): foreach ((array)$this->_vars['jobfair'] as $this->_vars['list']): ?> 
        	<div class="box"  <?php if ($this->_vars['list']['y'] == 1): ?>style="display:block;"<?php endif; ?>>
            	<ul>
                <!--合肥-->

            	<li><div class="company_count">
                    	<dl>
                        	<dt><?php echo $this->_vars['list']['title_']; ?>
<span><?php if ($this->_vars['list']['subsite_id'] == 1 || $this->_vars['list']['subsite_id'] == 0): ?>【安徽站】<?php endif;  if ($this->_vars['list']['subsite_id'] == 5): ?>【上海站】<?php endif;  if ($this->_vars['list']['subsite_id'] == 8): ?>【苏州站】<?php endif; ?></span><!--<?php echo $this->_vars['list']['industry']; ?>
招聘会--></dt>
                             <?php if ($this->_vars['list']['predetermined_ok'] == "1" && $this->_vars['list']['predetermined_web'] == "1"): ?>
                            <dd><a href="<?php echo $this->_run_modifier("QS_user,1", 'qishi_url', 'plugin', 1); ?>
company_jobfair.php?act=jobfair" title="" target="_blank" class="yuding"><i class="fa fa-building"></i>企业预定</a></dd>
                            <dd><a href="javascript:void();" title=""  class="yuding yyue_button" id="<?php echo $this->_vars['list']['id']; ?>
"><i class="fa fa-user"></i>求职预约</a></dd>
                            <?php else: ?>
                            <dd><a href="javascript:void();" class="huodong_end">企业预定已结束</a></dd>
                            <?php endif; ?>
                           	<dd style="color:#F00;">已预定企业(<?php echo $this->_vars['list']['yiyuding']; ?>
)个</dd>
                            <dd class="rencai_more"><a href="<?php echo $this->_vars['list']['url']; ?>
&dqid=<?php echo $this->_vars['dqid']; ?>
#pic" target="_blank">查看更多>></a></dd>
                            <!--<dd><a href="javascript:void();" class="huodong_end">企业预定已结束</a></dd>-->
                        </dl>
                    </div></li>
                	<li><div class="picScroll">
                            	<ul>
                                    <li>
                                    <?php if (count((array)$this->_vars['list']['ydqy'])): foreach ((array)$this->_vars['list']['ydqy'] as $this->_vars['li']): ?>
                                    <p><a href="/company_<?php echo $this->_vars['li']['cid']; ?>
.html" target="_blank" title="" class="w1"><?php echo $this->_vars['li']['title']; ?>
</a><span>已预订</span></p>
                                    <?php if ($this->_vars['li']['kehu'] % 2 == 0): ?>
                                    </li>
                                    <li>
                                    <?php endif; ?>
                                    <?php endforeach; endif; ?>
                                    </li>
                                   <!--<li><p><a href="/company_<?php echo $this->_vars['li']['cid']; ?>
.html" target="_blank" title="" class="w1">爱易（北京）科技发展有限公司发展有限公</a><span>已预订</span></p><p><a href="/company_<?php echo $this->_vars['li']['cid']; ?>
.html" target="_blank" title="" class="w1">爱易（北京）科技发展有限公司发展有限公</a><span>已预订</span></p></li>-->
                                </ul>
                                <!--滚动--><!--<script type="text/javascript">jQuery(".picScroll").slide({ mainCell:"ul",autoPlay:true,effect:"leftMarquee",interTime:50,vis:3  });</script>-->
                     </li>
                  </ul>
               </div>
                 <?php endforeach; endif; ?>   
   
                    
        </div>
        <!--滚动--><!--<script type="text/javascript">jQuery(".picScroll").slide({ mainCell:"ul",autoPlay:true,effect:"leftMarquee",interTime:50,vis:3  });</script>-->
        <!--人才市场选项卡切换效果-->
		<script type="text/javascript">jQuery(".company_jobs").slide();</script>        
        <!--人才市场选项卡切换效果-->
        
        
            <!--<div class="zhaop_btn_show">
            <ul>
                <li>查看其它城市招聘会：</li>
                <li><a href="" class="zhaop_btn_show01">安徽</a></li>
                <li><a href="" class="zhaop_btn_show01">上海</a></li>
            </ul>
        </div>-->
   </div>
  </div>
  <div class="QRcode" style="display:none;" id="changeBox001"><!--这里是弹窗开始     href="../ewm.php?id=1161"-->
					<div class="QRcode_main"> 
						<h3><span class="weixin">微信</span>扫码即享个人预约服务</h3>   
						<img src="" class="changeImg" alt="" id="img001" />
					</div>
					<a class="yyue_close" title="关闭"></a>
					<div class="QRcode_zhe"></div>
				</div><!--这里是弹窗结束-->
        </div>

       
        
        <!--点击弹出个人预约效果-->
        <script type="text/javascript">
						$(".yyue_button").click(function(){
							//$(this).siblings(".QRcode").show();
							$.get('../ewm.php', {"id":$(this).attr("id")}, function(data) {
								//alert(data);
								$("#img001").attr('src', data);//把返回的地址，添加到#changeImg图片src地址中
								$("#changeBox001").show();//显示二维码
								
							});	
							//$(this).siblings(".QRcode").show();
						})

						$(".yyue_close").click(function(){
							$(this).parent().hide();
						})
		</script>
    </div>
</div>
 
<!--o2o线下人才市场banner-->
<div class="kuang company xianxia_banner slideBox">
	<div class="bd">
    	<ul>
        <?php echo tpl_function_qishi_ad(array('set' => "显示数目:5,调用名称:jobfair_picture,列表名:ad,排序:show_order>desc"), $this); if (count((array)$this->_vars['ad'])): foreach ((array)$this->_vars['ad'] as $this->_vars['list']): ?>
        	<li><a href="<?php echo $this->_vars['list']['img_url']; ?>
" title="<?php echo $this->_vars['list']['img_explain']; ?>
" target="_blank"><img src="<?php echo $this->_vars['list']['img_path']; ?>
" width="1040" height="70"  alt=""/></a></li>
        <?php endforeach; endif; ?>
        </ul>
        <a href="javascript:void();" class="prev"></a>
        <a href="javascript:void();" class="next"></a>
    </div>
</div>
<?php endif; ?>
<!--人才市场轮播 -->
    <script type="text/javascript">
    jQuery(".slideBox").slide({mainCell:".bd ul",autoPlay:true});
    </script>       
  <!--人才市场结束-->
  <!--行业名企-->
    <div class="kuang company">
    	<h2>
            <i class="fa fa-institution"></i>行业名企<span>精挑细选的行业优秀企业。</span> <a href="/hymq/" class="more" title="精挑细选的行业优秀企业">查看更多>></a>
        </h2>
         <div class="in-list">
			<?php echo tpl_function_qishi_hymq_jobs_list(array('set' => "分页显示:1,列表名:jobslist,显示数目:4,填补字符:...,职位名长度:13,企业名长度:19,描述长度:65,关键字:GET[key],职位分类:GET[jobcategory],职位大类:GET[category],职位小类:GET[subclass],地区分类:GET[citycategory],地区大类:GET[district],地区小类:GET[sdistrict],行业:GET[trade],日期范围:GET[settr],工资:GET[wage],年龄:GET[age],公司规模:GET[scale],排序:id>desc"), $this);?>
        	<?php if (count((array)$this->_vars['jobslist'])): foreach ((array)$this->_vars['jobslist'] as $this->_vars['list']): ?>
         	<div class="in-list-con <?php if ($this->_vars['list']['y'] % 4 == 0): ?>noma<?php endif; ?>" title="<?php echo $this->_vars['list']['companyname']; ?>
">
            	<h3><a href="<?php echo $this->_vars['list']['jobs_url']; ?>
"><?php echo $this->_vars['list']['companyname']; ?>
</a></h3>
                <P>月 工 资：<span><?php echo $this->_vars['list']['wage_cn']; ?>
</span></P>
                <P>接 待 站：<b class="infdk"><?php echo $this->_vars['list']['jiezhan']; ?>
</b></P>
                <P class="infdk infdk_t"><?php echo $this->_vars['list']['shortitle']; ?>
</P>
                <a href="<?php echo $this->_vars['list']['jobs_url']; ?>
"><img src="/data/hymq_img/<?php echo $this->_vars['list']['logo']; ?>
" width="220px" height="101px" /></a>
                <div class="over wdids">
                	<p class="fl"><strong><?php echo $this->_vars['list']['bmrenshu']; ?>
人</strong>报名</p>
                    <a href="<?php echo $this->_vars['list']['jobs_url']; ?>
">去看看</a>
                </div>
                <div class="<?php if ($this->_vars['list']['zp_cn'] == '热聘'): ?>hot<?php endif; ?> <?php if ($this->_vars['list']['zp_cn'] == '急聘'): ?>urgent<?php endif; ?>"></div>
            </div>
            <?php endforeach; endif; ?>
       	  
         </div>
	</div> 
    <div style="clear:both;"></div>
    
    
  <!--------------中部行业名企选项卡-------------->  
<script type="text/javascript">

    $(function(){
            var timeid;
          $("#tab").find("li").each(function(index){
              var sLi=$(this);
              sLi.mouseenter(function(){
                  timeid= setTimeout(function(){
                      sLi.addClass("current").siblings().removeClass("current");
                      sLi.parent().next().find("ul:eq(" + index +")").show().siblings().hide() ;
                 },300);
              }).mouseleave(function(){
                     clearTimeout(timeid);
                      })

          })
        })
	
</script>
		<!--中部分类栏目内容-->
		<div class="kuang company">
        	<h2 class="mb10"><i class="fa fa-tasks"></i>热门招聘<span>最新的热门招聘企业。</span> <a href="zhaopin/index.html" class="more" title="热门招聘企业">查看更多>></a></h2>
            <div class="remen_list">
            	<div class="remen_listTitle"><span>机械/制造 生产/质管</span><a href="zhaopin/index.html" class="more">查看更多>></a></div>
                <div class="remen_job">
                	<div class="remen_jobLeft">
                    	<ul class="job_left">
                        	<li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1121">普工/操作工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1122">维修工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1124" class="display_color">电工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1125">木工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1126">钳工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1127" class="display_color">切割/焊工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1128">铂金工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1129" class="display_color">油漆工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1130">缝纫工</a></li>
                        </ul>
                        <ul class="job_right">
                        	<li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1131">锅炉工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1132" class="display_color">车工/铣工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1142">组装工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1136" class="display_color">包装工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1068.1164">质检员</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1068.1163" class="display_color">品管员 </a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1135">电梯工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1137" class="display_color">手机维修 </a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1065.1067.1133">铲车/叉车工</a></li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                    <div class="remen_jobRight">
                        <?php echo tpl_function_qishi_companyjobs_list(array('set' => "列表名:company,显示数目:10,显示职位:4,职位名长度:4,企业名长度:32,职位大类:1065,排序:rtime>desc"), $this);?><!--推荐:1-->
                        <?php if (count((array)$this->_vars['company'])): foreach ((array)$this->_vars['company'] as $this->_vars['list']): ?>
                    	<dl>
                        	<dt><a href="<?php echo $this->_vars['list']['company_url']; ?>
" class="company_N"><?php echo $this->_vars['list']['companyname']; ?>
</a></dt>
                            <dd class="job_name"><?php if (count((array)$this->_vars['list']['jobs'])): foreach ((array)$this->_vars['list']['jobs'] as $this->_vars['jobslist']): ?><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J"><?php echo $this->_vars['jobslist']['jobs_name']; ?>
</a><?php endforeach; endif; ?></dd>
                            <dd class="job_a"><span><?php echo $this->_vars['list']['district_cn']; ?>
</span></dd>
                        </dl>
                        <?php endforeach; endif; ?>
						<?php if ($this->_vars['buqi_sta'] == '1'): ?>
                        <?php if (count((array)$this->_vars['company_buqi'])): foreach ((array)$this->_vars['company_buqi'] as $this->_vars['list_buqi']): ?>
                    	<dl>
                        	<dt><a href="<?php echo $this->_vars['list_buqi']['company_url']; ?>
" class="company_N"><?php echo $this->_vars['list_buqi']['companyname']; ?>
</a></dt>
                            <dd class="job_name"><?php if (count((array)$this->_vars['list_buqi']['jobs'])): foreach ((array)$this->_vars['list_buqi']['jobs'] as $this->_vars['jobslist']): ?><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J"><?php echo $this->_vars['jobslist']['jobs_name']; ?>
</a><?php endforeach; endif; ?></dd>
                            <dd class="job_a"><span><?php echo $this->_vars['list_buqi']['district_cn']; ?>
</span></dd>
                        </dl>
                        <?php endforeach; endif; ?>
						<?php endif; ?>						
                    </div>
                </div>
            </div>
            
            <div class="remen_list">
            	<div class="remen_listTitle remen_listTitle02"><span>销售/电商  物流/贸易</span><a href="zhaopin/index.html" class="more">查看更多>></a></div>
                <div class="remen_job">
                	<div class="remen_jobLeft">
                    	<ul class="job_left">
                        	<li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1078.1317">销售代表</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1078.1318">销售助理</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1078.1325" class="display_color">医药代表</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1078.1326">医疗机器销售</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1078.1327">网络销售</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1080.1389" class="display_color">淘宝美工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1079.1360">客服助理</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1080.1388" class="display_color">淘宝客服</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1078.1324">汽车销售</a></li>
                        </ul>
                        <ul class="job_right">
                        	<li><a href="/jobs/jobs-list.php?key=&jobcategory=1081.1082.1420">快递员</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1081.1082.1421" class="display_color">仓库管理员</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1081.1085.1449">采购员</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1081.1084.1436" class="display_color">营业员/店员</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1081.1083.1431">货运司机</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1078.1332" class="display_color">大客户经理 </a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1078.1329">渠道专员</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1079.1361" class="display_color">呼叫人员</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1077.1078.1333" class="max_width">团购业务员/经理</a></li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                    <div class="remen_jobRight">
                    	<?php echo tpl_function_qishi_companyjobs_list(array('set' => "列表名:company,显示数目:10,显示职位:4,职位名长度:4,企业名长度:32,职位大类:1077,排序:rtime>desc"), $this);?><!--推荐:1-->
                        <?php if (count((array)$this->_vars['company'])): foreach ((array)$this->_vars['company'] as $this->_vars['list']): ?>
                    	<dl>
                        	<dt><a href="<?php echo $this->_vars['list']['company_url']; ?>
" class="company_N"><?php echo $this->_vars['list']['companyname']; ?>
</a></dt>
                            <dd class="job_name"><?php if (count((array)$this->_vars['list']['jobs'])): foreach ((array)$this->_vars['list']['jobs'] as $this->_vars['jobslist']): ?><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J"><?php echo $this->_vars['jobslist']['jobs_name']; ?>
</a><?php endforeach; endif; ?></dd>
                            <dd class="job_a"><span><?php echo $this->_vars['list']['district_cn']; ?>
</span></dd>
                        </dl>
                        <?php endforeach; endif; ?>
						<?php if ($this->_vars['buqi_sta'] == '1'): ?>
                        <?php if (count((array)$this->_vars['company_buqi'])): foreach ((array)$this->_vars['company_buqi'] as $this->_vars['list_buqi']): ?>
                    	<dl>
                        	<dt><a href="<?php echo $this->_vars['list_buqi']['company_url']; ?>
" class="company_N"><?php echo $this->_vars['list_buqi']['companyname']; ?>
</a></dt>
                            <dd class="job_name"><?php if (count((array)$this->_vars['list_buqi']['jobs'])): foreach ((array)$this->_vars['list_buqi']['jobs'] as $this->_vars['jobslist']): ?><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J"><?php echo $this->_vars['jobslist']['jobs_name']; ?>
</a><?php endforeach; endif; ?></dd>
                            <dd class="job_a"><span><?php echo $this->_vars['list_buqi']['district_cn']; ?>
</span></dd>
                        </dl>
                        <?php endforeach; endif; ?>
						<?php endif; ?>						
                    </div>
                </div>
            </div>
            
            <div class="remen_list">
            	<div class="remen_listTitle remen_listTitle03"><span>餐饮/生活/服务</span><a href="zhaopin/index.html" class="more">查看更多>></a></div>
                <div class="remen_job">
                	<div class="remen_jobLeft">
                    	<ul class="job_left">
                        	<li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1087.1455">服务员</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1087.1456">送餐员</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1087.1459" class="display_color">厨师</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1087.1457">传菜员</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1087.1461">配菜/打荷</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1087.1462" class="display_color">洗碗工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1088.1474">清洁工/保洁</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1087.1470" class="display_color">学徒</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1087.1465">迎宾/接待</a></li>
                        </ul>
                        <ul class="job_right">
                        	<li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1088.1479">钟点工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1088.1482" class="display_color">送水工</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1089.1491">美甲师</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1089.1484" class="display_color">发型师</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1090.1498">酒店前台</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1089.1492" class="display_color">宠物美容 </a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1090.1506">导游</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1086.1090.1503" class="display_color">救生员 </a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1081.1084.1439" class="max_width">理货员/陈列员</a></li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                    <div class="remen_jobRight">
                        <?php echo tpl_function_qishi_companyjobs_list(array('set' => "列表名:company,显示数目:10,显示职位:4,职位名长度:4,企业名长度:32,职位大类:1086,排序:rtime>desc"), $this);?><!--推荐:1-->
                        <?php if (count((array)$this->_vars['company'])): foreach ((array)$this->_vars['company'] as $this->_vars['list']): ?>
                    	<dl>
                        	<dt><a href="<?php echo $this->_vars['list']['company_url']; ?>
" class="company_N"><?php echo $this->_vars['list']['companyname']; ?>
</a></dt>
                            <dd class="job_name"><?php if (count((array)$this->_vars['list']['jobs'])): foreach ((array)$this->_vars['list']['jobs'] as $this->_vars['jobslist']): ?><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J"><?php echo $this->_vars['jobslist']['jobs_name']; ?>
</a><?php endforeach; endif; ?></dd>
                            <dd class="job_a"><span><?php echo $this->_vars['list']['district_cn']; ?>
</span></dd>
                        </dl>
                        <?php endforeach; endif; ?>
						<?php if ($this->_vars['buqi_sta'] == '1'): ?>
						
                        <?php if (count((array)$this->_vars['company_buqi'])): foreach ((array)$this->_vars['company_buqi'] as $this->_vars['list_buqi']): ?>
                    	<dl>
                        	<dt><a href="<?php echo $this->_vars['list_buqi']['company_url']; ?>
" class="company_N"><?php echo $this->_vars['list_buqi']['companyname']; ?>
</a></dt>
                            <dd class="job_name"><?php if (count((array)$this->_vars['list_buqi']['jobs'])): foreach ((array)$this->_vars['list_buqi']['jobs'] as $this->_vars['jobslist']): ?><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J"><?php echo $this->_vars['jobslist']['jobs_name']; ?>
</a><?php endforeach; endif; ?></dd>
                            <dd class="job_a"><span><?php echo $this->_vars['list_buqi']['district_cn']; ?>
</span></dd>
                        </dl>
                        <?php endforeach; endif; ?>
						<?php endif; ?>						
                    <!--    <dl>
                        	<dt><a href="<?php echo $this->_vars['list']['company_url']; ?>
" class="company_N">安徽省寅特尼人才市场管理有限公司</a></dt>
                            <dd class="job_name"><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J">网页美工</a><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J">网页美工</a><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J">网页美工</a><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J">网页美工</a><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J">网页美工</a></dd>
                            <dd class="job_a"><span>合肥市</span></dd>
                        </dl>-->
                    </div>
                </div>
            </div>
            
            <div class="remen_list">
            	<div class="remen_listTitle remen_listTitle04"><span>房产/建筑/物业</span><a href="zhaopin/index.html" class="more">查看更多>></a></div>
                <div class="remen_job">
                	<div class="remen_jobLeft">
                    	<ul class="job_left">
                        	<li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1282.1301">房产经纪人</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1282.1302">职业顾问</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1282.1305" class="display_color">房产客服</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1282.1306">房产内勤</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1281.1291">安防工程师</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1282.1307" class="display_color">房产评估师</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1281.1299">综合布线</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1281.1289" class="display_color">建造师</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1281.1287">土木/土建</a></li>
                        </ul>
                        <ul class="job_right">
                        	<li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1281.1292">安全员</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1281.1295" class="display_color">测绘/测量</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1281.1285">工程监理</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1281.1284" class="display_color">工程项目管理</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1283.1314">招商经理</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1281.1297" class="display_color">资料员 </a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1283.1311">物业维修</a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1281.1286" class="display_color">建筑工程师 </a></li>
                            <li><a href="/jobs/jobs-list.php?key=&jobcategory=1280.1283.1310">物业管理员</a></li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                    <div class="remen_jobRight">
                    	
                    	<?php echo tpl_function_qishi_companyjobs_list(array('set' => "列表名:company,显示数目:10,显示职位:4,职位名长度:4,企业名长度:32,职位大类:1280,排序:rtime>desc"), $this);?><!--推荐:1-->
                        <?php if (count((array)$this->_vars['company'])): foreach ((array)$this->_vars['company'] as $this->_vars['list']): ?>
                    	<dl>
                        	<dt><a href="<?php echo $this->_vars['list']['company_url']; ?>
" class="company_N"><?php echo $this->_vars['list']['companyname']; ?>
</a></dt>
                            <dd class="job_name"><?php if (count((array)$this->_vars['list']['jobs'])): foreach ((array)$this->_vars['list']['jobs'] as $this->_vars['jobslist']): ?><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J"><?php echo $this->_vars['jobslist']['jobs_name']; ?>
</a><?php endforeach; endif; ?></dd>
                            <dd class="job_a"><span><?php echo $this->_vars['list']['district_cn']; ?>
</span></dd>
                        </dl>
                        <?php endforeach; endif; ?>
						<?php if ($this->_vars['buqi_sta'] == '1'): ?>
                        <?php if (count((array)$this->_vars['company_buqi'])): foreach ((array)$this->_vars['company_buqi'] as $this->_vars['list_buqi']): ?>
                    	<dl>
                        	<dt><a href="<?php echo $this->_vars['list_buqi']['company_url']; ?>
" class="company_N"><?php echo $this->_vars['list_buqi']['companyname']; ?>
</a></dt>
                            <dd class="job_name"><?php if (count((array)$this->_vars['list_buqi']['jobs'])): foreach ((array)$this->_vars['list_buqi']['jobs'] as $this->_vars['jobslist']): ?><a href="<?php echo $this->_vars['jobslist']['jobs_url']; ?>
" class="company_J"><?php echo $this->_vars['jobslist']['jobs_name']; ?>
</a><?php endforeach; endif; ?></dd>
                            <dd class="job_a"><span><?php echo $this->_vars['list_buqi']['district_cn']; ?>
</span></dd>
                        </dl>
                        <?php endforeach; endif; ?>
						<?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- 热门招聘tab --开始-->
            <script type="text/javascript">jQuery(".slideTxtBox").slide(); </script>
            <!-- 热门招聘tab --结束-->
        </div>
	  	<!--中部分类栏目内容--结束-->   
       
        
        <!--新闻模块开始-->
       <?php 
       	include("/zhichang/diaoyong/shouye/zongzhan.html");
       ?>
        <!--新闻模块结束-->		
        
        <div class="kuang company hezuo">
            <h2 class="mb10"><i class="fa fa-suitcase"></i>合作企业<!--<span>简略标题，日是否健康的话发。</span>--> <!--<a href="" class="more">查看更多>></a>--></h2>
            <!--滚动-->
            	<div class="picMarquee-left">
                        <div class="bd">
                            <ul>
                                    
                                        <?php echo tpl_function_qishi_ad(array('set' => "显示数目:30,调用名称:QS_indexcentreimg,列表名:ad"), $this);?>
                                        <?php if ($this->_vars['ad']): ?>
                                        <?php if (count((array)$this->_vars['ad'])): foreach ((array)$this->_vars['ad'] as $this->_vars['list']): ?>
                                        <li> 
                                            <img src="<?php echo $this->_vars['list']['img_path']; ?>
" border="0"  title="<?php echo $this->_vars['list']['img_explain']; ?>
" /> 
                                             <!-- ad end -->
                                        </li>
                                       
                                 <?php endforeach; endif; ?>
                                 <?php endif; ?>
                                 </ul>
                        </div>
                    </div>
            
 <!--------------合作企业滚动-------------->             
<script type="text/javascript">jQuery(".picMarquee-left").slide({mainCell:".bd ul",autoPlay:true,effect:"leftMarquee",vis:6,interTime:50});</script>
         





    </div>
    <!--友情链接 开始-->
    	<div class="kuang friendlink">
        	<div class="friendlink">
            	<div class="hd">
                	<ul>
                    	<li>友情链接</li>
                        <li>合作网站</li>
                    </ul>
                </div>
                <div class="bd">
                
                	<ul>
                    	<li>
                        	<?php echo tpl_function_qishi_link(array('set' => "列表名:link,显示数目:100,调用名称:QS_index,类型:1"), $this);?>
							<?php if (count((array)$this->_vars['link'])): foreach ((array)$this->_vars['link'] as $this->_vars['list']): ?>
            				<a href="<?php echo $this->_vars['list']['link_url']; ?>
" title="" target="_blank"><?php echo $this->_vars['list']['title']; ?>
</a>|
                            <?php endforeach; endif; ?>
                        </li>
                    </ul>
                    
                    <ul>
                    	<li>
                        	<?php echo tpl_function_qishi_link(array('set' => "列表名:link,显示数目:100,调用名称:qs_hezuo,类型:1"), $this);?>
							<?php if (count((array)$this->_vars['link'])): foreach ((array)$this->_vars['link'] as $this->_vars['list']): ?>
            				<a href="<?php echo $this->_vars['list']['link_url']; ?>
" title="" target="_blank"><?php echo $this->_vars['list']['title']; ?>
</a>|
                            <?php endforeach; endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <script type="text/javascript">jQuery(".friendlink").slide(); </script>
    <!--友情链接 结束-->
    
    <!--底部开始-->
   <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<!--底部结束-->
</body>
    
</html>

                                                  