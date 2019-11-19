<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-13 16:37 中国标准时间 */ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>安徽最新招聘信息-安徽招聘网-合肥人才网 - 合肥壹打工网</title>
<meta name="description" content="安徽壹打工网找工作频道，为求职者找工作提供2015最新各类职位招聘信息，精准求职，锁定好工作。安徽找工作，找兼职，就上安徽人才网。">
<meta name="keywords" content="安徽招聘,安徽招聘网,安徽找工作">
<meta name="author" content="壹打工网" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<link rel="shortcut icon" href="favicon.ico" />
<link href="/files/css/common.css" rel="stylesheet" type="text/css" />
<link href="/files/css/jobs.css" rel="stylesheet" type="text/css" />
<link href="/files/css/all.css" rel="stylesheet" type="text/css" />
<link href="/files/css/font-awesome.min.css" rel="stylesheet" >
<script src="/files/js/jquery.js" type='text/javascript' ></script>
<script src="/files/js/jquery.dialog.js" type='text/javascript' ></script>
<script src="/files/js/jquery.jobs-search.js" type='text/javascript'></script>
<script src="../../data/cache_classify.js" type='text/javascript' charset="utf-8"></script>
<script src="/files/js/jquery.hoverDelay.js" type='text/javascript'></script>
<script src="/files/js/jquery.vtip-min.js" type='text/javascript'></script>
<script type="text/javascript">
	$(document).ready(function() {
		// 传过来的搜索条件
		var getstr = new Array();
		getstr[0] = '';
		getstr[1] = '';
		getstr[2] = '';
		getstr[3] = '';
		getstr[4] = '';
		getstr[5] = '';
		getstr[6] = '';
		getstr[7] = '';
		allaround('/',getstr);
		// 显示行业
		$("#jobsTrad").hoverDelay({
		    hoverEvent: function(){
		        $("#divTradCate").show();
		    },
		    outEvent: function(){
                $("#divTradCate").hide();
            }
		});
 		// 显示职位
 		$("#jobsSort").hoverDelay({
		    hoverEvent: function(){
		        $("#divJobCate").show();
		        var dx = $("#divJobCate").offset().left; // 获取弹出框的x坐标
		        var dy = $("#divJobCate").offset().top; // 获取弹出框的y坐标
		        var dwidth = $("#divJobCate").outerWidth(true); // 获取弹出框的宽度
		        var dheight = $("#divJobCate").outerHeight(true); // 获取弹出框的高度
		        var lastx = dx + dwidth; // 加上弹出框的宽度获取弹出框最右边的x坐标
		        var lasty = dy + dheight; // 加上弹出框的高度获取弹出框最下边的y坐标
	 			$("#divJobCate li").each(function(index, el) {
	 				var that = $(this);
	 				var sx = that.offset().left; // 获取当前li的x坐标
	 				var sy = that.offset().top; // 获取当前li的y坐标
	 				that.hoverDelay({
					    hoverEvent: function(){
					        if(that.find('.subcate').length > 0) {
			 					that.addClass('selected');
			 					var tharsub = that.find('.subcate');
			 					var thap = that.find('p');
			 					var swidth = tharsub.outerWidth(true); // 获取三级弹出框的宽度
			 					var sheight = tharsub.outerHeight(true); // 获取三级弹出框的高度
			 					if((lastx - sx) < swidth && (lasty - sy) > sheight) { 
			 						thap.css("border-bottom",0);
			 						tharsub.css("left",-265);
			 					}
			 					if((lastx - sx) > swidth && (lasty - sy) > sheight) { 
			 						thap.css("border-bottom",0);
			 						tharsub.css("left",0); 
			 					}
			 					if((lastx - sx) < swidth && (lasty - sy) < sheight) { 
				 					thap.css({
				 						"border-top": '0px',
				 						"border-bottom": ''
				 					});
			 						tharsub.css("left",-265); 
				 					tharsub.css("top",-(sheight - 2));
			 					}
			 					if((lastx - sx) > swidth && (lasty - sy) < sheight) { 
				 					thap.css({
				 						"border-top": '0px',
				 						"border-bottom": ''
				 					});
			 						tharsub.css("left",0); 
				 					tharsub.css("top",-(sheight - 2));
			 					}
			 					tharsub.show();
			 				} else {
			 					that.find('a').css("color","#f77d40");
			 				}
					    },
					    outEvent: function(){
			                if(that.find('.subcate').length > 0) {
				 				that.removeClass('selected');
				 				that.find('.subcate').hide();
			 				} else {
			 					that.find('a').css("color","#0180cf");
			 				}    
			            }
					});
	 			});
		    },
		    outEvent: function(){
                $("#divJobCate").hide(); 
            }
		});
 		// 显示地区
		/*
		$("#jobsCity").hover(function(){
			$("#divCityCate").show();
			$("#divCityCate li").hover(function(){
				$(this).addClass('selected').children('a').css("color","#f77d40");
				$(this).children(".subcate").show();
			},function(){
				$(this).removeClass('selected').children('a').css("color","#0180cf");;
				$(this).children(".subcate").hide();
			})
		})
		*/
		
 		$("#jobsCity").hoverDelay({
		    hoverEvent: function(){
		        $("#divCityCate").show();
		        var dx = $("#divCityCate").offset().left; // 获取弹出框的x坐标
		        var dwidth = $("#divCityCate").outerWidth(true); // 获取弹出框的宽度
		        var lastx = dx + dwidth; // 加上弹出框的宽度获取弹出框最右边的x坐标
	 			$("#divCityCate li").each(function(index, el) {
	 				var that = $(this);
	 				var sx = that.offset().left; // 获取当前li的x坐标
	 				that.hoverDelay({
					    hoverEvent: function(){
					        if(that.children('.subcate').length > 0) {
			 					that.addClass('selected');
			 					var tharsub = that.children('.subcate');
			 					var thap = that.children('p');
			 					thap.css("border-bottom","0px");
								that.children('a').css("color","#f77d40");
			 					var swidth = tharsub.outerWidth(true); // 获取三级弹出框的宽度
			 					if((lastx - sx) < swidth) { // 判断li与弹出框最右边的距离是否大于三级弹出框的宽度
			 						tharsub.css("left",-265); // 如果小于就改变三级弹出框x方向的位置
			 					}
			 					tharsub.show();
			 				} else {
			 					that.children('a').css("color","#f77d40");
			 				}
					    },
					    outEvent: function(){
			                if(that.children('.subcate').length > 0) {
								that.children('a').css("color","#0180cf");
				 				that.removeClass('selected');
				 				that.children('.subcate').hide();
			 				} else {
			 					that.children('a').css("color","#0180cf");
			 				}    
			            }
					});
	 			});
		    },
		    outEvent: function(){
                $("#divCityCate").hide(); 
            }
		});
		

 		$("#infolists .list:last").css("border-bottom","none");
		//apply_jobs("/");
		//favorites("/");
	});
</script>
</head>
<body>

<SCRIPT> 
function baoming(){ 
document.getElementById("mianfei").style.display="none"; 
} 
</SCRIPT> 
<!--<div id="mianfei"> 
    <div class="fei01">
    <span>没有找到合适的工作？</span>
    <a class="baoming" href="#">1分钟留下信息 <i class="fa fa-arrow-circle-right"></i></a>
    <span>我们会将你推荐给优秀企业！坐等好工作来找你！</span>
    <a class="guanbi" onClick=baoming() >X</a>
    </div>
    
</div>
-->	

	<!--头部开始-->
	<script>
	$(function(){
		// 点击事件
		$(".local_station").live("click",function(){
			if($(".sub_station").attr('data') == "hide") {
				$(this).blur();
				$(this).parent().parent().before("<div class=\"menu_bg_layer\"></div>");
				$(".menu_bg_layer").height($(document).height());
				$(".menu_bg_layer").css({ width: $(document).width(), position: "absolute",left:"0", top:"0","z-index":"77","background-color":"#000000"});
				$(".menu_bg_layer").css("opacity",0);
				$(".sub_station").show();
				$(".sub_station").attr('data',"show");
				$(".menu_bg_layer, .station_close").click(function() {
					$(".sub_station").hide();
					$(".sub_station").attr('data',"hide");
					$(".menu_bg_layer").remove();
				});
			} else {
				$(".sub_station").hide();
				$(".sub_station").attr('data',"hide");
			}
		});
		//单数行变色
		$(".local_station>p").hover(function(){
			$(this).addClass("hover");
		},function(){
			$(this).removeClass("hover");
		});
		$(".sub_st_content li:last").css({
			"border-bottom":"0"
		}).find("div").css({"padding-bottom":"0"});
	});
//顶部部登录
$.get("/plus/ajax_user.php", {"act":"top_loginform"},
function (data,textStatus)
{			
$(".top_nav").html(data);
}
);
</script>
<!--顶部-->
<!--<div class="user_top_nav" >
	<div class="main">
	    <div class="ltit"><span id="top_loginform"></span></div>	
	    <div class="rlink link_lan">
	    	<a href="http://www.1dagong.com/mobile/" class="mphone">手机频道</a>
<a href="http://www.1dagong.com/salary">薪酬统计</a>
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
</script>	    </div>	
	    <div class="clear"></div>
    </div>
</div>-->
<!--头部开始-->
	<div class="header">
    	<div class="kuang">
            <div class="logo fl">
            <a class="fl" href="/"><img src="/files/img/logo.png" alt="" title="壹打工网" ></a>
            
            <!--骑士上的地区切换开始zzzzzz-->
		
								  <div class="sub_station_bbox">
            <div class="local_station didian">
                <h3>安徽</h3>
                <a>切换站点</a>
            </div>

	  	          
            <div class="sub_station" style="display:none;" data="hide">
                <div class="triangle"></div>
                <span href="" class="station_close"></span>
                <div class="sub_st_box">
                    <div class="sub_st_tit">
                        <h3>合肥人才网 - 合肥壹打工网站群</h3>
                    </div>
                    <div class="sub_st_content">
                        <ul>
                            
                                                            <li>
                                  <div class="city_list">
                                  			<a href="http://www.1dagong.com/index.html">总站</a>
                                                                                        <a href="http://hefei.1dagong.com/index.html">安徽</a>
                                                                                        <a href="http://chongqing.1dagong.com/index.html">重庆</a>
                                                                                        <a href="http://zhengzhou.1dagong.com/index.html">河南</a>
                                                                                        <a href="http://wuhan.1dagong.com/index.html">湖北</a>
                                                                                        <a href="http://shanghai.1dagong.com/index.html">上海</a>
                                                                                        <a href="http://suzhou.1dagong.com/index.html">苏州</a>
                                                                                            <div class="clear"></div>
                                            <div>
                                </li>	
                                                    </ul>
                    </div>
                </div>
            </div>	
        </div>
					<!--骑士上的地区切换结束-->
            
            </div>
            	<!--<div class="didian fl">
                	<p>合肥</p>
                	<a href="#">切换城市</a>
                </div>-->
                
				

            <div class="nav fl">
            	<ul>
				<!--导航菜单切换的样式定位开始 By Z-->
				<!--
					<li><a class="yes" href="/">首页</a></li>
                    <li><a href="/jobs/jobs-list2.php">找工作</a></li>
                    <li><a href="/resume/resume-list.php">找人才</a></li>
                    <li><a href="/hymq/">行业名企</a></li>
                    <li><a href="/jobfair/jobfair-list.php">招聘会</a></li>
                    <li><a href="/xiaoyuan/">校园招聘</a></li>
				-->
													<li><a href="http://hefei.1dagong.com/index.html" target="_self" >首  页</a></li>
									<li><a href="http://hefei.1dagong.com/zhaopin/index.html" target="_self" class="yes">找工作</a></li>
									<li><a href="http://hefei.1dagong.com/jianli.html" target="_self" >找人才</a></li>
									<li><a href="http://hefei.1dagong.com/hymq/index.php" target="_self" >行业名企</a></li>
									<li><a href="http://hefei.1dagong.com/jobfair/jobfair-list.php" target="_self" >人才市场</a></li>
									<li><a href="http://hefei.1dagong.com/xiaoyuan/" target="_self" >校园招聘</a></li>
									<li><a href="http://hefei.1dagong.com/train/" target="_self" >技能培训</a></li>
								<!--导航菜单切换的样式定位结束 By Z-->
                </ul>
            </div>
            
            <div class="top_nav">
            </div>
            
        </div>
    </div>
    <!--头部结束-->
<!--头部结束-->


<!--<div class="page_location link_bk">
当前位置：<a href="/">首页</a>&nbsp;>>&nbsp;<a href="http://hefei.1dagong.com/zhaopin/index.html">招聘信息</a>
</div>
-->
<script type="text/javascript">
	var getstr=",,,,,,,,,,";
	var defaultkey="请输入职位名称、公司名称关键字...";
	var getkey="";
	if (getkey=='')
	{
	getkey=defaultkey;
	}
	allaround('/files/','/','http://hefei.1dagong.com/jobs/jobs-list.php',getkey,getstr);
</script>     
<div class="jobsearch">
<!--	 <div class="jobnav">
	 	<a href="http://hefei.1dagong.com/jobs/jobs-list.php" class="select">全能搜索</a>
		<a href="http://hefei.1dagong.com/jobs/jobtag-search.php" >标签搜索</a>
	 </div>
-->     
	 <div class="jobmain" id="searckeybox">
     	<div class="fl gjc" style="margin:0px;">关  键  词</div>
	 	<div class="keybox">
	 		<input type="text" id="searckey" name="key" data="" value="请输入关键字" />
	 		<input type="hidden" value="" name="wage">
	 		<input type="hidden" value="" name="education">
	 		<input type="hidden" value="" name="experience">
	 		<input type="hidden" value="" name="nature">
	 		<input type="hidden" value="" name="settr">
	 		<input type="hidden" value="" name="sort">
	 		<input type="hidden" value="1" name="page">
	 	</div>
     	<div class="over"></div>
            <div class="fl gjc">职&nbsp;&nbsp;&nbsp;&nbsp;位</div>
	 	<div class="box jobsSort" id="jobsSort">
	 		<div class="itemT">
	 			<span id="jobText">&nbsp;</span><i class="fa fa-plus-square"></i>
	 		</div>
	 		<div style="display:none;" id="divJobCate" class="divJobCate">
	 			<table class="jobcatebox">
	 				<div class="acquired">
		 				<div class="l">已选</div>
		 				<div class="c" id="jobAcq"></div>
		 				<div class="r">
		 					<div class="empty" id="jobEmpty"></div>
		 					<div class="sure" id="jobSure">确定</div>
		 					<div class="container" id="jobdropcontent">
								<div class="content">您的选择已达上限（5项）<br>请点击“确定”，或移除部分选项</div>
								<s><e></e></s>
							</div>
		 				</div>
		 			</div>
	 				<tbody></tbody>
	 			</table>
	 		</div>
	 		<input name="jobs_cn" id="jobs_cn" type="hidden" value="" />
			<input name="jobs_id" id="jobs_id" type="hidden" value="" />
	 	</div>
            <div class="fl gjc">行&nbsp;&nbsp;&nbsp;&nbsp;业</div>
	 	<div class="box jobsSort" id="jobsTrad">
	 		<div class="itemT">
	 			<span id="tradText">&nbsp;</span><i class="fa fa-plus-square"></i>
	 		</div>
	 		<div id="divTradCate" class="infoList divIndCate" style="display:none">
	 			<div class="acquired">
	 				<div class="l">已选</div>
	 				<div class="c" id="tradAcq"></div>
	 				<div class="r">
	 					<div class="empty" id="tradEmpty"></div>
	 					<div class="sure" id="tradSure">确定</div>
	 					<div class="container" id="tradropcontent">
							<div class="content">您的选择已达上限（5项）<br>请点击“确定”，或移除部分选项</div>
							<s><e></e></s>
						</div>
	 				</div>
	 			</div>
	 			<ul class="indcatelist" id="tradList"></ul>
	 		</div>
	 		<input name="trade_cn" id="trade_cn" type="hidden" value="" />
			<input name="trade_id" id="trade_id" type="hidden" value="" />
	 	</div>
        <div class="over"></div>
            <div class="fl gjc">地&nbsp;&nbsp;&nbsp;&nbsp;区</div>
	 	<div class="box" id="jobsCity">
	 		<div class="itemT">
	 			<span id="cityText">&nbsp;</span><i class="fa fa-plus-square"></i>
	 		</div>
	 		<div style="display:none;left:0px;" id="divCityCate" class="divJobCate">
	 			<table class="jobcatebox citycatebox">
	 				<div class="acquired">
		 				<div class="l">已选</div>
		 				<div class="c" id="cityAcq"></div>
		 				<div class="r">
		 					<div class="empty" id="cityEmpty"></div>
		 					<div class="sure" id="citySure">确定</div>
		 					<div class="container" id="citydropcontent">
								<div class="content">您的选择已达上限（5项）<br>请点击“确定”，或移除部分选项</div>
								<s><e></e></s>
							</div>
		 				</div>
		 			</div>
	 				<tbody></tbody>
	 			</table>
	 		</div>
            <input id="district_id" type="hidden" value="" name="district_id">
            <input id="district_cn" type="hidden" value="" name="district_cn"/>
	 	</div>
        <div class="hdns"></div>
        <div class="sousuo">

            <div class="btnsearch" id="btnsearch" ty="QS_jobslist">搜 索</div>
            <a class="more" id="showmoreoption" href="javascript:;"><span>更多条件</span><i></i></a>
        </div>
        
	 </div>
</div>
		<script src="http://www.1dagong.com/templates/1jobsnew/js/jquery.autocomplete.js" type="text/javascript"></script>
					<script language="javascript" type="text/javascript">
					 $(document).ready(function()
					{
						  var a = $('#searckey').autocomplete({ 
							serviceUrl:'plus/ajax_common.php?act=hotword',
							minChars:1, 
							maxHeight:400,
							width:371,
							zIndex: 1,
							deferRequestBy: 0 
						  });
					
					});
					  </script>
<div class="searoptions" id="searoptions" style="display:block;">
	<div class="list"><div class="tit">工作性质：</div><div class="option" id="jobsnature"></div></div>
	<div class="list"><div class="tit">职位月薪：</div><div class="option" id="jobswage"></div></div>
	<div class="list"><div class="tit">学历要求：</div><div class="option" id="jobseducation"></div></div>
	<div class="list"><div class="tit">工作经验：</div><div class="option" id="jobsexperience"></div></div>
	<div class="list">
		<div class="tit">更新时间：</div>
		<div class="option" id="jobsuptime">
			<a href="javascript:;" class="opt" id="settr-3">3天内</a>
			<a href="javascript:;" class="opt" id="settr-7">7天内</a>
			<a href="javascript:;" class="opt" id="settr-15">15天内</a>
			<a href="javascript:;" class="opt" id="settr-30">30天内</a>
		</div>
	</div>
</div>
<div class="jobselected" id="jobselected">
	<div class="tit">已选条件：</div>
	<div class="showselected" id="showselected"></div>
	<div class="clearjobs" id="clearallopt">清空所选项</div>
	<div class="clear"></div>
</div>
<!-- 职位列表 -->


<div class="kuang over">
	<div class="left_list">
        <div class="fine">	
            <span class="fl">共为您找到 <strong>611</strong> 职位 </span>
            <div class="hehe fr">
            	<!--<a href="http://hefei.1dagong.com/jobs/jobs-list.php?sort=rtime&page=1&category=&subclass=&district=&sdistrict=&mdistrict=&settr=&trade=&wage=&nature=&scale=&inforow=" >更新时间<i class="fa fa-long-arrow-down"></i></a>-->
                <a href="http://hefei.1dagong.com/jobs/jobs-list.php?sort=wage&page=1&category=&subclass=&district=&sdistrict=&mdistrict=&settr=&trade=&wage=&nature=&scale=&inforow=" >薪资待遇<i class="fa fa-long-arrow-down"></i></a>
                <a href="http://hefei.1dagong.com/jobs/jobs-list.php?sort=hot&page=1&category=&subclass=&district=&sdistrict=&mdistrict=&settr=&trade=&wage=&nature=&scale=&inforow=">热度<i class="fa fa-long-arrow-down"></i></a>
            </div> 
        </div> 
               
        <ul class="l_list">
		
			            <li>
                <a href="http://hefei.1dagong.com/zhaopin/zhiwei_7303.html" >
                    <h3>装配工</h3>
                    <dl>
                        <dt>合肥元丰汽车制动系统有...</dt>
                        <dd class="ls01">安徽省/合肥市</dd>
                        <dd class="ls02"><span style="color:#FF3300">1小时前</span></dd>
                        <dd class="ls03">月薪<font>3000~5000元/月</font></dd>
                    </dl>        
                </a>
                <div class="fr hidns" id="infolists">
                    <a class="shouc add_favorites" href="javascript:void(0);" id="7303"><i class="fa fa-heart"></i>&nbsp;收藏</a>
                    <a class="touti app_jobs" href="javascript:void(0);" id="7303">投递简历</a>
                </div>
            </li>
			            <li>
                <a href="http://hefei.1dagong.com/zhaopin/zhiwei_7298.html" >
                    <h3>电子商务专员</h3>
                    <dl>
                        <dt>安徽万承投资管理有限公...</dt>
                        <dd class="ls01">安徽省/合肥市</dd>
                        <dd class="ls02"><span style="color:#FF3300">6小时前</span></dd>
                        <dd class="ls03">月薪<font>3000~5000元/月</font></dd>
                    </dl>        
                </a>
                <div class="fr hidns" id="infolists">
                    <a class="shouc add_favorites" href="javascript:void(0);" id="7298"><i class="fa fa-heart"></i>&nbsp;收藏</a>
                    <a class="touti app_jobs" href="javascript:void(0);" id="7298">投递简历</a>
                </div>
            </li>
			            <li>
                <a href="http://hefei.1dagong.com/zhaopin/zhiwei_7297.html" >
                    <h3>管理培训生</h3>
                    <dl>
                        <dt>安徽万承投资管理有限公...</dt>
                        <dd class="ls01">安徽省/合肥市</dd>
                        <dd class="ls02"><span style="color:#FF3300">6小时前</span></dd>
                        <dd class="ls03">月薪<font>2000~3000元/月</font></dd>
                    </dl>        
                </a>
                <div class="fr hidns" id="infolists">
                    <a class="shouc add_favorites" href="javascript:void(0);" id="7297"><i class="fa fa-heart"></i>&nbsp;收藏</a>
                    <a class="touti app_jobs" href="javascript:void(0);" id="7297">投递简历</a>
                </div>
            </li>
			            <li>
                <a href="http://hefei.1dagong.com/zhaopin/zhiwei_7291.html" >
                    <h3>销售</h3>
                    <dl>
                        <dt>安徽茉达电子商务有限公...</dt>
                        <dd class="ls01">安徽省/合肥市</dd>
                        <dd class="ls02"><span style="color:#FF3300">2天前</span></dd>
                        <dd class="ls03">月薪<font>3000~5000元/月</font></dd>
                    </dl>        
                </a>
                <div class="fr hidns" id="infolists">
                    <a class="shouc add_favorites" href="javascript:void(0);" id="7291"><i class="fa fa-heart"></i>&nbsp;收藏</a>
                    <a class="touti app_jobs" href="javascript:void(0);" id="7291">投递简历</a>
                </div>
            </li>
			            <li>
                <a href="http://hefei.1dagong.com/zhaopin/zhiwei_7285.html" >
                    <h3>操作工</h3>
                    <dl>
                        <dt>合肥信和机械科技有限公...</dt>
                        <dd class="ls01">安徽省/合肥市</dd>
                        <dd class="ls02"><span style="color:#FF3300">3天前</span></dd>
                        <dd class="ls03">月薪<font>2000~3000元/月</font></dd>
                    </dl>        
                </a>
                <div class="fr hidns" id="infolists">
                    <a class="shouc add_favorites" href="javascript:void(0);" id="7285"><i class="fa fa-heart"></i>&nbsp;收藏</a>
                    <a class="touti app_jobs" href="javascript:void(0);" id="7285">投递简历</a>
                </div>
            </li>
			            <li>
                <a href="http://hefei.1dagong.com/zhaopin/zhiwei_7286.html" >
                    <h3>客服人员</h3>
                    <dl>
                        <dt>安徽梦科云电子商务股份...</dt>
                        <dd class="ls01">安徽省</dd>
                        <dd class="ls02"><span style="color:#FF3300">3天前</span></dd>
                        <dd class="ls03">月薪<font>3000~5000元/月</font></dd>
                    </dl>        
                </a>
                <div class="fr hidns" id="infolists">
                    <a class="shouc add_favorites" href="javascript:void(0);" id="7286"><i class="fa fa-heart"></i>&nbsp;收藏</a>
                    <a class="touti app_jobs" href="javascript:void(0);" id="7286">投递简历</a>
                </div>
            </li>
			            <li>
                <a href="http://hefei.1dagong.com/zhaopin/zhiwei_7280.html" >
                    <h3>投资顾问</h3>
                    <dl>
                        <dt>安徽金实资产管理有限公...</dt>
                        <dd class="ls01">安徽省</dd>
                        <dd class="ls02"><span style="color:#FF3300">3天前</span></dd>
                        <dd class="ls03">月薪<font>3000~5000元/月</font></dd>
                    </dl>        
                </a>
                <div class="fr hidns" id="infolists">
                    <a class="shouc add_favorites" href="javascript:void(0);" id="7280"><i class="fa fa-heart"></i>&nbsp;收藏</a>
                    <a class="touti app_jobs" href="javascript:void(0);" id="7280">投递简历</a>
                </div>
            </li>
			            <li>
                <a href="http://hefei.1dagong.com/zhaopin/zhiwei_7275.html" >
                    <h3>销售</h3>
                    <dl>
                        <dt>合肥易捌房地产代理销售...</dt>
                        <dd class="ls01">安徽省/合肥市</dd>
                        <dd class="ls02"><span style="color:#FF3300">3天前</span></dd>
                        <dd class="ls03">月薪<font>面议</font></dd>
                    </dl>        
                </a>
                <div class="fr hidns" id="infolists">
                    <a class="shouc add_favorites" href="javascript:void(0);" id="7275"><i class="fa fa-heart"></i>&nbsp;收藏</a>
                    <a class="touti app_jobs" href="javascript:void(0);" id="7275">投递简历</a>
                </div>
            </li>
			            <li>
                <a href="http://hefei.1dagong.com/zhaopin/zhiwei_7273.html" >
                    <h3>销售</h3>
                    <dl>
                        <dt>合肥易捌房地产代理销售...</dt>
                        <dd class="ls01">安徽省/合肥市</dd>
                        <dd class="ls02"><span style="color:#FF3300">3天前</span></dd>
                        <dd class="ls03">月薪<font>面议</font></dd>
                    </dl>        
                </a>
                <div class="fr hidns" id="infolists">
                    <a class="shouc add_favorites" href="javascript:void(0);" id="7273"><i class="fa fa-heart"></i>&nbsp;收藏</a>
                    <a class="touti app_jobs" href="javascript:void(0);" id="7273">投递简历</a>
                </div>
            </li>
			            <li>
                <a href="http://hefei.1dagong.com/zhaopin/zhiwei_7274.html" >
                    <h3>销售</h3>
                    <dl>
                        <dt>银谷财富（北京）投资管...</dt>
                        <dd class="ls01">安徽省/合肥市</dd>
                        <dd class="ls02"><span style="color:#FF3300">3天前</span></dd>
                        <dd class="ls03">月薪<font>2000~3000元/月</font></dd>
                    </dl>        
                </a>
                <div class="fr hidns" id="infolists">
                    <a class="shouc add_favorites" href="javascript:void(0);" id="7274"><i class="fa fa-heart"></i>&nbsp;收藏</a>
                    <a class="touti app_jobs" href="javascript:void(0);" id="7274">投递简历</a>
                </div>
            </li>
			        </ul>
        
<table border="0" align="center" cellpadding="0" cellspacing="0" class="link_bk">
          <tr>
                        <td><div class="page link_bk"><li><a class="">首页</a></li><li><a class="">上一页</a></li><li><a class="select">1</a></li>
<li><a  href="http://hefei.1dagong.com/jobs/jobs-list.php?district_cn=安徽&page=2">2</a></li>
<li><a  href="http://hefei.1dagong.com/jobs/jobs-list.php?district_cn=安徽&page=3">3</a></li>
<li><a  href="http://hefei.1dagong.com/jobs/jobs-list.php?district_cn=安徽&page=4">4</a></li>
<li><a  href="http://hefei.1dagong.com/jobs/jobs-list.php?district_cn=安徽&page=5">5</a></li>
<li><a  href="http://hefei.1dagong.com/jobs/jobs-list.php?district_cn=安徽&page=6">6</a></li>
<li><a  href="http://hefei.1dagong.com/jobs/jobs-list.php?district_cn=安徽&page=2">下一页</a></li><li><a  href="http://hefei.1dagong.com/jobs/jobs-list.php?district_cn=安徽&page=62">尾页</a></li><li class="page_all">1/62页</li><div class="clear"></div></div></td>
                    </tr>
      </table>    </div>
    
    <div class="right_list">
    	<div class="ewma">
        	<img src="/files/img/app.jpg" title="壹打工网客户端"  />
            扫描二维码，手机轻松找工作
        </div>
        
        <div class="rzhao">
        	<h2>最新招聘职位</h2>
            
            <ul class="rzlist">
						            	<li>
                	<h3><a href="http://hefei.1dagong.com/zhaopin/zhiwei_7303.html">装配工</a></h3>
                    <p>合肥元丰汽车制动系统有限公司</p>
                    <font>月薪范围：3000~5000元/月</font>
                </li>
			            	<li>
                	<h3><a href="http://hefei.1dagong.com/zhaopin/zhiwei_7298.html">电子商务专员</a></h3>
                    <p>安徽万承投资管理有限公司</p>
                    <font>月薪范围：3000~5000元/月</font>
                </li>
			            	<li>
                	<h3><a href="http://hefei.1dagong.com/zhaopin/zhiwei_7297.html">管理培训生</a></h3>
                    <p>安徽万承投资管理有限公司</p>
                    <font>月薪范围：2000~3000元/月</font>
                </li>
			            	<li>
                	<h3><a href="http://hefei.1dagong.com/zhaopin/zhiwei_7291.html">销售</a></h3>
                    <p>安徽茉达电子商务有限公司</p>
                    <font>月薪范围：3000~5000元/月</font>
                </li>
			            	<li>
                	<h3><a href="http://hefei.1dagong.com/zhaopin/zhiwei_7286.html">客服人员</a></h3>
                    <p>安徽梦科云电子商务股份有限公司</p>
                    <font>月薪范围：3000~5000元/月</font>
                </li>
			            	<li>
                	<h3><a href="http://hefei.1dagong.com/zhaopin/zhiwei_7285.html">操作工</a></h3>
                    <p>合肥信和机械科技有限公司</p>
                    <font>月薪范围：2000~3000元/月</font>
                </li>
			            </ul>
        </div>
    </div>
</div>



<script src="/files/js/jquery.jobs-list.js" type='text/javascript' ></script>

    
<!--底部开始-->
	
<div class="footer over">
    	<div class="footer-con kuang">
        	<div class="fl">
            	<a href="http://www.1dagong.com"><img src="/files/img/footer_logo.jpg" title="壹打工网" /></a>
            </div>
            <div class="fr appewm"><img src="/files/img/app.jpg" height="100" width="100" alt="" title="壹打工网客户端" /></div> 
            <div class="fr copy">
            	<div class="footer-nav">
                    <a href="#">友情链接</a>
                	<a href="#">用户帮助</a>
                    <a href="http://www.1dagong.com/zt/app/">手机客户端</a>
                    <a href="#">关于我们</a>
                </div>
                <div class="over"></div>
                <div class="icp">
                	 &copy;2013-2015 Www.1dagong.Com &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp; 国家工业和信息化部备案号：皖ICP备13015030号-4
                </div>
                <div class="over"></div>
                <div class="zuic">
                	专业的求职招聘网站，致力打造人才网第一品牌！
                </div>
            </div>
            
        </div>    
    </div>
<!-- 回到顶部组件 -->
<!--<div class="back_to_top" id="back_to_top">
	<div class="back" style="display:none;">
		<div>回到顶部</div>
	</div>
	<div class="steer">
		<div onclick="javascript:location.href='http://www.1dagong.com/suggest'">我要建议</div>
	</div>
	<div class="sub">
		<div onclick="javascript:location.href='http://www.1dagong.com/subscribe'">我要订阅</div>
	</div>
</div>-->
<script>
	$(function(){
		//回到顶部组件出现设置
		$(window).scroll(function(){
			if($(window).scrollTop()>200){
				$(".back").fadeIn(400);
			}else{
				$(".back").fadeOut(400);
			}
		})

		//回到顶部hover效果
		$(".back_to_top .back, .steer, .sub").hover(function(){
			$(this).find("div").css("display","block");
		},function(){
			$(this).find("div").css("display","none");
		})

		//设置滚回顶部方法
		$(".back").click(function(){
			$("body,html").animate({scrollTop:0}, 500);
			return false;
		})
	});
	$(function(){
		$(".foot_list ul:odd li").css("width", 62);
		$(".weixin_img:last").css("margin-right", 0);
	})
	
//尾部显示时间
/*$.get("/plus/ajax_user.php", {"act":"bottom_date_up"},
function (data,textStatus)
{
	//alert(data);			
$(".date_up").html(data);
}
);*/
</script>

<!--底部结束-->

</body>
</html>