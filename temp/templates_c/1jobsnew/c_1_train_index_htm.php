<?php require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_curriculum_list.php'); $this->register_function("qishi_curriculum_list", "tpl_function_qishi_curriculum_list",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_ad.php'); $this->register_function("qishi_ad", "tpl_function_qishi_ad",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_get_classify.php'); $this->register_function("qishi_get_classify", "tpl_function_qishi_get_classify",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_pageinfo.php'); $this->register_function("qishi_pageinfo", "tpl_function_qishi_pageinfo",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-09-28 14:59 中国标准时间 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php echo tpl_function_qishi_pageinfo(array('set' => "列表名:page,调用:QS_train"), $this);?>
<title><?php echo $this->_vars['page']['title']; ?>
</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta name="description" content="">
<meta name="keywords" content="">
<link href="/files/css/common.css" rel="stylesheet" type="text/css" />
<link href="/files/css/font-awesome.min.css" rel="stylesheet" >
<link href="/files/css/reg.css" rel="stylesheet" type="text/css" />
<link href="/files/css/peixun/peixun.css" type="text/css"  rel="stylesheet">

<!---->
<link href="/files/css/header.css" rel="stylesheet" type="text/css" />
<!---->
<script type="text/javascript" src="/files/js/jquery.min.js"></script>
<script type="text/javascript" src="/files/js/jquery.SuperSlide.2.1.1.js"></script>
</head>
<body>
<!--头部开始-->
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("header_train.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<!--头部结束-->

<!-- 培训首页开始 -->
<div class="peixun_index">
    <div id="menu"class="peixun_indexLeft">
    	<?php echo tpl_function_qishi_get_classify(array('set' => "列表名:category,类型:QS_train,显示数目:4"), $this);?>
		<?php if (count((array)$this->_vars['category'])): foreach ((array)$this->_vars['category'] as $this->_vars['list']): ?>
        <dl class="kecheng_name">
            <dt><?php echo $this->_vars['list']['categoryname']; ?>
</dt>
            <?php echo tpl_function_qishi_get_classify(array('set' => "列表名:sublist,类型:QS_train,id:" . $this->_vars['list']['id'] . ",显示数目:12"), $this);?>
			<?php if (count((array)$this->_vars['sublist'])): foreach ((array)$this->_vars['sublist'] as $this->_vars['listtrain']): ?>
            <dd><a href="/train/train-curriculum-list.php?category=<?php echo $this->_vars['listtrain']['id']; ?>
" target="_blank" title=""><?php echo $this->_vars['listtrain']['categoryname']; ?>
</a></dd>
            <?php endforeach; endif; ?>
        </dl>
        <?php endforeach; endif; ?>
		<!--<div class="fabu">
        	<a href="/user/train/train_course.php?act=addcourse" target="_blank" class="fabu-01">发布教程</a>
            <a href="/user/user_reg.php?member_type=4" target="_blank" class="fabu-01">学校注册</a>
        </div>-->
    </div>
    
    <!--页面固定-->
	<script>
            $(function(){
                $("#menu").data({offset:$("#menu").offset()});
                $(window).bind("scroll",function(){
                    var menu=$("#menu");
                    var dtop=$(document).scrollTop();
                    var offset=menu.data("offset");
                    if(dtop>offset.top){
                        if($.browser.msie&&parseInt($.browser.version)<7){//IE6
                            menu.css({position:"absolute",top:dtop});
                        }else{
                            menu.css({position:"fixed",top:0,});
                        }
                    }else{
                        menu.css({left:"",top:"",position:""});
                    }
                });
            });
        </script>
       <!--页面固定-->
    <div class="peixun_indexRight">
    	<div class="slideBox banner">
            <div class="bd">
                <ul>
                	<?php echo tpl_function_qishi_ad(array('set' => "显示数目:5,调用名称:QS_trainfocus,列表名:ad"), $this); if (count((array)$this->_vars['ad'])): foreach ((array)$this->_vars['ad'] as $this->_vars['list']): ?>
                    <li><a href="<?php echo $this->_vars['list']['img_url']; ?>
" target="_blank"><img src="<?php echo $this->_vars['list']['img_path']; ?>
" title="<?php echo $this->_vars['list']['img_explain']; ?>
" width="750" height="280" ></a></li>
                    <?php endforeach; endif; ?>
                    <!--<li><a href="" target="_blank"><img src="../files/img/banner01.jpg" width="750" height="280" ></a></li>-->
                </ul>
            </div>
            <a href="javascript:void(0)" title="" class="pre"></a>
            <a href="javascript:void(0)" title="" class="next"></a>
        </div>
        <!-- 轮播  -->
        <script type="text/javascript">
            jQuery(".slideBox").slide({mainCell:".bd ul",effect:"fold",autoPlay:true,easing:"easeOutCirc"});
        </script>
   	
        <div class="search">
            <div class="form_search">
                    <input type="text" id="keyinput" name="key" class="text01" ><input type="button" id="search_btn" class="btn-search" value="搜索">
            </div>
            <div class="search_title">
                <ul>
                    <li>热门搜索：</li>
                    <li><a href="/train/train-curriculum-list.php?category=11" target="_blank" title="IT培训">IT培训</a> </li>
                    <li><a href="/train/train-curriculum-list.php?category=14" target="_blank" title="餐饮培训" class="search-red">餐饮培训</a> </li>
                    <li><a href="/train/train-curriculum-list.php?category=3" target="_blank" title="美容">美容</a> </li>
                    <li><a href="/train/train-curriculum-list.php?category=10" target="_blank" title="技工" class="search-red">技工</a> </li>
                    <li><a href="/train/train-curriculum-list.php?category=23" target="_blank" title="会计资格证">会计资格证</a> </li>
                    <li><a href="/train/train-curriculum-list.php?category=7" target="_blank" title="医药健康" class="search-red">医药健康</a> </li>
                    <li><a href="/train/train-curriculum-list.php?category=21" target="_blank" title="土木工程">土木工程</a> </li>
                    <!--<li><a href="/train/train-curriculum-list.php?category=29" target="_blank" title="函授" class="search-red">函授</a> </li>-->
                </ul>
            </div>
        </div>        
        <div class="find-kec">
            <div class="peixun-course-title"><span>名校展示</span>【汇聚全国名校，培养专业技能】<!--<a href="" title="" target="_blank" class="more">查看更多</a>--></div>
            <div class="slideTxtBox">
               <!-- <div class="hd find-kec-title">
                    <ul>
                        <li>最新课程</li>
                        <li>人力资源</li>
                        <li>财务管理</li>
                        <li>电子商务</li>
                        <li>总裁课堂</li>
                        <li>职业素质</li>
                        <li>市场营销</li>
                        <li>客户服务</li>
                        <li>采购物流</li>
                    </ul>
                </div>-->
                <div class="bd find-kec-box">
                    <dl>
                    	<?php echo tpl_function_qishi_ad(array('set' => "显示数目:7,调用名称:QS_traincentreimg,列表名:ad,排序:show_order>desc"), $this); if (count((array)$this->_vars['ad'])): foreach ((array)$this->_vars['ad'] as $this->_vars['list']): ?>
                        <?php if ($this->_vars['list']['i'] == 1): ?>
                        <dt><a href="<?php echo $this->_vars['list']['img_url']; ?>
" target="_blank" title="<?php echo $this->_vars['list']['img_explain']; ?>
"><img src="<?php echo $this->_vars['list']['img_path']; ?>
" title="<?php echo $this->_vars['list']['img_explain']; ?>
" width="280" height="267" alt=""/><br><?php echo $this->_vars['list']['img_explain']; ?>
</a> </dt>
                        <?php else: ?>
                        <dd class="overflow"><a href="<?php echo $this->_vars['list']['img_url']; ?>
" target="_blank" title="<?php echo $this->_vars['list']['img_explain']; ?>
" class="overflow"><img src="<?php echo $this->_vars['list']['img_path']; ?>
" title="<?php echo $this->_vars['list']['img_explain']; ?>
" width="140" height="111" alt=""/><br><?php echo $this->_vars['list']['img_explain']; ?>
</a></dd>
                        <?php endif; ?>
                        <?php endforeach; endif; ?>
                    </dl>
                   <!-- <dl>
                        <dt><a href="" target="_blank" title=""><img src="../files/img/1bc62bdd582244bcb27b626c17083e57_224.jpg" width="280" height="267" alt=""/><br>用模式占领市场，构建价值型企业（4集）</a> </dt>
                        <dd><a href="" target="_blank" title=""><img src="../files/img/1289_353_279.jpg" width="140" height="111" alt=""/><br>集团管控与战略布...</a></dd>
                        <dd><a href="" target="_blank" title=""><img src="../files/img/1289_353_279.jpg" width="140" height="111" alt=""/><br>集团管控与战略布...</a></dd>
                        <dd><a href="" target="_blank" title=""><img src="../files/img/1289_353_279.jpg" width="140" height="111" alt=""/><br>集团管控与战略布...</a></dd>
                        <dd><a href="" target="_blank" title=""><img src="../files/img/1289_353_279.jpg" width="140" height="111" alt=""/><br>集团管控与战略布...</a></dd>
                        <dd><a href="" target="_blank" title=""><img src="../files/img/1289_353_279.jpg" width="140" height="111" alt=""/><br>集团管控与战略布...</a></dd>
                        <dd><a href="" target="_blank" title=""><img src="../files/img/1289_353_279.jpg" width="140" height="111" alt=""/><br>集团管控与战略布...</a></dd>
                    </dl>-->
                </div>
            </div>
            <!-- 切换效果 -->
            <script type="text/javascript">
                jQuery(".slideTxtBox").slide({});
            </script>
        </div>
       <!-- <div class="peixun-xt">
            <div class="peixun-course-title"><span>岗位系统班</span>【快速筛选你所需要的课程，全面提升你的职场能力】</div>
            <div class="peixun-xt-box">
                <div class="fl peixun-xt-list">
                   <a href="" target="_blank" title="">
                       <strong>文案</strong>系统班<br>
                       不再百思不得解-让你灵感如泉涌
                   </a>
                </div>
                <div class="fl peixun-xt-list peixun-xt-list-color02">
                    <a href="" target="_blank" title="">
                        <strong>EXCEL</strong>系统班<br>
                        一份表格的逆袭之旅
                    </a>
                </div>
                <div class="fl peixun-xt-list peixun-xt-list-color03">
                    <a href="" target="_blank" title="">
                        <strong>PPT</strong>系统班<br>
                        制作一份符合领导心水的PPT
                    </a>
                </div>
                <div class="fl peixun-xt-list peixun-xt-list-color03">
                    <a href="" target="_blank" title="">
                        <strong>领导力</strong>系统班<br>
                        领导不再无力-我说一不二
                    </a>
                </div>
                <div class="fl peixun-xt-list">
                    <a href="" target="_blank" title="">
                        <strong>微营销入门</strong>系统班<br>
                        微营销实现大收入
                    </a>
                </div>
                <div class="fl peixun-xt-list peixun-xt-list-color02">
                    <a href="" target="_blank" title="">
                        <strong>职业规划</strong>系统班<br>
                        谋定而后动-怎样规划你的职场人生
                    </a>
                </div>
                <div class="over"></div>
            </div>
        </div>-->
        <!--<div class="peixun-xt">
            <div class="peixun-course-title"><span>能力系统班</span>【快速筛选你所需要的课程，全面提升你的职场能力】</div>
            <div class="peixun-xt-box">
                <div class="fl peixun-xt-list">
                    <a href="" target="_blank" title="">
                        <strong>文案</strong>系统班<br>
                        不再百思不得解-让你灵感如泉涌
                    </a>
                </div>
                <div class="fl peixun-xt-list peixun-xt-list-color02">
                    <a href="" target="_blank" title="">
                        <strong>文案</strong>系统班<br>
                        不再百思不得解-让你灵感如泉涌
                    </a>
                </div>
                <div class="fl peixun-xt-list peixun-xt-list-color03">
                    <a href="" target="_blank" title="">
                        <strong>文案</strong>系统班<br>
                        不再百思不得解-让你灵感如泉涌
                    </a>
                </div>
                <div class="fl peixun-xt-list peixun-xt-list-color03">
                    <a href="" target="_blank" title="">
                        <strong>文案</strong>系统班<br>
                        不再百思不得解-让你灵感如泉涌
                    </a>
                </div>
                <div class="fl peixun-xt-list">
                    <a href="" target="_blank" title="">
                        <strong>文案</strong>系统班<br>
                        不再百思不得解-让你灵感如泉涌
                    </a>
                </div>
                <div class="fl peixun-xt-list peixun-xt-list-color02">
                    <a href="" target="_blank" title="">
                        <strong>文案</strong>系统班<br>
                        不再百思不得解-让你灵感如泉涌
                    </a>
                </div>
                <div class="over"></div>
            </div>
        </div>-->
        <div class="peixun-course">
            <div class="peixun-course-title"><span>培训课程</span>【海量课程，总有一个适合你】<a href="/train/train-curriculum-list.php?key=&page=1" title="" target="_blank" class="more">查看更多</a></div>
            <div class="peixun-course-box">
                <ul>
                <?php echo tpl_function_qishi_curriculum_list(array('set' => "列表名:course,填补字符:...,课程名长度:18,分页显示:0,显示数目:50,列表页:QS_train_agency_curriculum,机构名长度:7,排序:rtime>desc"), $this);?>
			  	<?php if (count((array)$this->_vars['course'])): foreach ((array)$this->_vars['course'] as $this->_vars['list']): ?>
                    <li>
                        <dl>
                            <dt class="overflow"><a href="<?php echo $this->_vars['list']['course_url']; ?>
" target="_blank" title="<?php echo $this->_vars['list']['course_name']; ?>
"><?php echo $this->_vars['list']['course_name']; ?>
</a>(<?php echo $this->_vars['list']['trainname']; ?>
) </dt>
                            <dd>
                                发布时间：<span><?php echo $this->_run_modifier($this->_vars['list']['addtime'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>
</span>
                            </dd>
                            <dd class="overflow">
                                课程学时：<span><?php echo $this->_vars['list']['classhour']; ?>
 课时</span>
                            </dd>
                            <dd class="overflow">
                                开课时间：<span class="course-color"><?php if ($this->_vars['list']['starttime'] == 0): ?>常年开课<?php else:  echo $this->_run_modifier($this->_vars['list']['starttime'], 'date_format', 'plugin', 1, "%Y-%m-%d");  endif; ?></span>
                            </dd>
                            <dd class="overflow">
                                截止日期：<span class="course-color"><?php echo $this->_run_modifier($this->_vars['list']['deadline'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>
</span>
                            </dd>
                            <dd class="overflow">
                                所在地区：<span><?php echo $this->_vars['list']['district_cn']; ?>
</span>
                            </dd>
                            <dd  class="overflow">
                                培训对象：<span><?php echo $this->_vars['list']['train_object']; ?>
</span>
                            </dd>
                        </dl>
                    </li>
                   	<?php endforeach; endif; ?> 
                   
                </ul>
            </div>
        </div>
    </div>
    <div class="over"></div>
</div>
<!-- 培训首页结束 -->

<!--footer开始-->

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>

<!--footer结束-->
<script type="text/javascript">
				showmenu('#typeid_cn','#trainshowdiv',"#typeid");
				$("#search_btn").click(function() {
					 var patrn1=/^(请输入关键字)/i;	 
					 var key1=$("#keyinput").val();
					if (patrn1.exec(key1))
					{
						 $(this).css('color','#000000').val('');
						 $("#keyinput").val('');
						 key1='';
					}
				$.get("/plus/ajax_search_location.php", {"act":"QS_train_curriculum","key":key1,"category":$("#typeid").val(),"page":1},
						function (data,textStatus)
						 {
							 window.location.href=data;
						 }
					);
				});
				//模拟select
				function showmenu(menuID,showID,inputname)
				{
					$(menuID).click(function(){
						$(menuID).blur();
						$(menuID).parent("div").css("position","relative");
						$(showID).slideToggle("fast");
						//生成背景
						$(menuID).parent("div").before("<div class=\"menu_bg_layer\"></div>");
						$(".menu_bg_layer").height($(document).height());
						$(".menu_bg_layer").css({ width: $(document).width(), position: "absolute", left: "0", top: "0" , "z-index": "0", "background-color": "#ffffff"});
						$(".menu_bg_layer").css("opacity","0");
						//生成背景结束
						$(showID+" li").live("click",function(){
							$(menuID).val($(this).attr("title"));
							$(inputname).val($(this).attr("id"));
							$(".menu_bg_layer").hide();
							$(showID).hide();
							$(menuID).parent("div").css("position","");	
							$(this).css("background-color","");
						});

								$(".menu_bg_layer").click(function(){
									$(".menu_bg_layer").hide();
									$(showID).hide();
									$(menuID).parent("div").css("position","");
								});
						$(showID+" li").unbind("hover").hover(
						function()
						{
						$(this).css("background-color","#F5F5F5");
						},
						function()
						{
						$(this).css("background-color","");

						}
						);
					});
				}
			</script>
</body>
</html>