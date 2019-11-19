<!DOCTYPE html>
<html lang="zh-cn">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Cache-Control" content="no-transform" />
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<title>服务员_壹打工网-工作让生活更精彩</title>
	<!-- head_css-->
	<link href="/files/style/css/bootstrap.css" type="text/css" rel="stylesheet" /> 

	<link href="/files/style/css/all.css" type="text/css" rel="stylesheet" />

	<script src="/files/style/js/jquery.min.js" language="JavaScript" type="text/javascript" ></script>
    <script src="/files/style/js/jquery.ca.js" language="JavaScript" type="text/javascript" ></script>
	<script src="/files/style/js/bootstrap.min.js" language="JavaScript" type="text/javascript" ></script>
    <script src="/files/style/js/a_modal.js" language="JavaScript" type="text/javascript" ></script>
	<script language="javascript" type="text/javascript" src="/include/login.js"></script>
	<script language="javascript" type="text/javascript">
		<!--
			
			function CheckLogin(){
			  var taget_obj = document.getElementById('headlogin');
			  myajax = new DedeAjax(taget_obj,false,false,'','','');
			  myajax.SendGet2("/home/headlogin.php");
			  DedeXHTTP = null;
			}
		-->
	</script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media
		queries -->
		<!--[if lt IE 9]>
			<script src="/files/js/html5shiv.min.js">
			</script>
			<script src="/files/js/respond.min.js">
			</script>
		<![endif]-->
	<!--head_css end -->	
</head>
<body>
<!-- head -->
<!--<nav class="navbar navbar-default top">
  <div class="container-fluid">
    <div class="navbar-header col-md-2 col-xs-6">
      <a href="/" class="logo"><img src="/files/style/image/logo.png" height="90" width="190" class="img-responsive" /></a>
    </div>

      <ul class="nav navbar-nav col-md-6">
      	<li class="active ml_30"><a href="/">首页</a></li>
        <li><a href="/plus/search.php?typeid=41">工作库</a></li>
        <li><a href="/gongzuo/">行业名企</a></li>
      </ul>
		
       <div  id="headlogin" class="col-md-4 col-xs-6 logint">
          <ul class="login pull-right">
            <li class="dropwnd pr_10"><a href="/home/"  data-target="#denglu">登录</a></li>
            <li class="pl_10">
              <a href="/home/p_register.php" class="dropdown-toggle">注册 </a>
            </li>
          </ul><script language="javascript" type="text/javascript">CheckLogin();</script>
       </div>
	   
  </div>
</nav>
-->


<script>

//记录导航条原来在页面上的位置 
var naviga_offsetTop = 0; 

//使导航条，悬停在顶部 
function naviga_stay_top(){ 
//获取滚动距离 
var scrollTop = $(document).scrollTop(); 
//如果向下滚动的距离大于原来导航栏离顶部的距离 
//直接将导航栏固定到可视区顶部 
if( scrollTop > naviga_offsetTop ){ 
$("#nav").css({"top": "0px"}); 
} else { 
//如果向下滚动的距离小原来导航栏离顶部的距离，则重新计算导航栏的位置 
$("#nav").css({"top": naviga_offsetTop - scrollTop + "px"}); 
} 
} 

function onload_function(){ 
//记录初始状态导航栏的高度 
naviga_offsetTop = $("#nav").attr("offsetTop"); 

//绑定滚动和鼠标事件 
$(window).bind("scroll", naviga_stay_top); 
$(window).bind("mousewheel",naviga_stay_top); 
$(document).bind("scroll", naviga_stay_top); 
$(document).bind("mousewheel",naviga_stay_top); 
} 

$(document).ready( onload_function ); 

</script>


<div class="container" >
<div class="top_sh row">

     <div class="col-xs-12 col-md-6 mp">
        <ul class="login jidns pull-left">
       	  <li class="pr_10 hotline dropwnd"><a data-trigger="modal" href="http://www.1dagong.com/ajax/number.html" data-title="Modal title">免费咨询</a></li>
          <li class="phone pr_10"><a data-trigger="modal" href="http://www.1dagong.com/ajax/qrcode.html" data-title="Modal title">手机壹打工</a></li>
        </ul>
     </div>
     
     <div class="col-xs-12 col-md-6 mp">
     	<div class="free pull-right">
        全国免费求职热线： 
        <a href="tel:400-118-5188">400-118-5188</a>
        </div>
     </div>
</div>    
</div>


<div id="nav" class=" navigation">

<nav class="navbar navbar-default top">

  <div class="container">
    
    <div class="navbar-header col-md-2 col-xs-4">
      <a href="/" class="logo"><img src="/files/style/image/logo.png" height="90" width="190" class="img-responsive hidden-xs" />
      <img src="/files/style/image/logo.jpg" class="img-responsive visible-xs" /></a>
    </div>
    
    <div class="col-md-4 row logint pull-right mp">
     
        <ul class="login pull-right bcsa">
          <li class="pr_10 hogin dropwnd"><a href="/home/"  data-target="#denglu">登录</a></li>
          <li><a href="/home/p_register.php" class="#denglu">注册 </a></li>
        </ul>
		<script language="javascript" type="text/javascript">CheckLogin();</script>
    </div>
    
    
    <div class="navbar-header pull-left" >
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse col-md-7" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav ">
      	<li class="active"><a href="/">首页</a></li>
        <li><a href="/plus/search.php?typeid=41">工作库</a></li>
        <li><a href="/gongzuo/">行业名企</a></li>
      </ul>
    
    </div><!-- /.navbar-collapse -->
    


  </div><!-- /.container-fluid -->
</nav>
</div>
<!--head end -->



<!--            列表                  -->

<div class="container">
    <ol class="breadcrumb "><!--mt_20-->
		<li class="active"><a href='http://www.1dagong.com'>网站首页</a> / <a href='/plus/list.php?tid=41'>工作库</a> / <a href='/plus/list.php?tid=46'>服务员</a> / </li>
		<li>服务员</li>
    </ol>
</div>
    

<div class="container">
	<div class="row">
    	<div class="col-md-9">
        	<div class="find mr_20">
                
                <div class="l_isj">
                	<h1>服务员</h1>
                </div>
                <div class="h1_box">发布时间： 2015年03月19日</div>
                <div class="over">
                    <ul class="a_box">
                        <li ><span>工资：</span><strong>面议</strong></font></li>
                        <li ><span>公司：</span>上海统一星巴克咖啡有限公司</li>
                        <li ><span>地区：</span>江苏省 - 苏州市</li><!--{field:nativeplace function="Getsysenum(@me)"/}-->
                        <li ><span>性别要求：</span>女</li>
                        <li ><span>学历要求：</span>大专</li>
                        <li ><span>招聘人数：</span>10</li>
                        <!--<li ><span>报名人数：</span></li>-->
                        <li ><span>截止时间：</span>2015-08-19</li>
                     </ul>
                </div>
                <div class="delivery text-center"><a class="btn btn-warning" href="/plus/toudi.php?aid=1115&job=21084&c=上海统一星巴克咖啡有限公司"> 投递简历 </a>
                <a class="btn btn-default ml_30" href="/home/pt_gongzuo.php?channelid=81"> 我也要发布职位 </a></div>
                <div class="d_led zhiwei-ms">
                	<h4>职位描述</h4>
                    
                    <dl>
                        
                    </dl>
                    
                    <div class="write">
                    	<div class="pull-left resume">在壹打工网<a href="#">完善简历</a>，即有机会被企业和猎头推荐应聘</div>
                    	<div class="delivery pull-right"> <a class="btn btn-primary" href="/plus/toudi.php?aid=1115&job=21084&c=上海统一星巴克咖啡有限公司" style="color:#fff;">投递简历</a></div>
                    </div>
                </div>
                
            </div> 
            
        </div>
        
        <div class="col-md-3 col-sm-12 rcon">
            
            <div class="mbott mb_30 mr_10">
                <a href="#">
                    <img class="img-responsive" title="1+2事业平台" src="/files/image/nei_12.jpg" data-bd-imgshare-binded="1">
                </a>
            </div>
            <ul class="list-group mr_10">
                <li class="list-group-item"><span class="badge"> </span>相关的招聘企业</li>
            </ul>
			<dl class="mr_10">
             <dt><a href='/plus/view.php?aid=1115'>服务员</a></dt>
					<dd>...</dd>
					<dd class="bb">已有<b></b>人报名<u><a href="/plus/view.php?aid=1115">我想去</a></u></dd>
<dt><a href='/plus/view.php?aid=1098'>厨师</a></dt>
					<dd>湘菜，工资视厨艺水平而面谈。底薪2500，包两顿饭  
、以上岗位工资水平：每...</dd>
					<dd class="bb">已有<b></b>人报名<u><a href="/plus/view.php?aid=1098">我想去</a></u></dd>

			</dl> 
            </div>            
            
        </div>
        
        
    </div>
</div>
    
<!--            列表                  -->    



<!-------baoming------->   
<div class="extra">
	<div class="container">
		<div class="row">
			<div class="col-xs-6 col-sm-3">
				<h5>
					用户帮助
				</h5>
				<ul class="icons-list">
					
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="#">
							帐户状态
						</a>
					</li>
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="#">
							密码找回与修改
						</a>
					</li>
				</ul>
			</div>
			<!-- /span3 -->
			<div class="col-xs-6 col-sm-3">
				<h5>
					关注我们
				</h5>
				<ul class="icons-list">
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="/home/weixin_x.php">
							微信
						</a>
					</li>
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="http://www.1dagong.com/m/index.html">
							手机客户端
						</a>
					</li>
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="http://www.1dagong.com/">
							手机网页版
						</a>
					</li>
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="#">
							新浪微博
						</a>
					</li>
				</ul>
			</div>
			<!-- /span3 -->
			<div class="col-xs-12 col-sm-3">
				<h5>
					壹打工网相关
				</h5>
				<ul class="icons-list">
					<li>
						<i class="icon-li fa fa-twitter">
						</i>
						<a href="#" target="_blank">
							友情链接
						</a>
					</li>
				</ul>
			</div>
			<!-- /span3 -->
			<div class="col-xs-12 col-sm-3">
				<h5>
					免费报名
				</h5>
				<p>
					仅需留下您的手机或电话，我们专业的求职顾问便会迅速为您量身定制合适的职位。
				</p>
				<div id="mc_embed_signup">
					<form class="form-signin" role="form" method="post" action="/home/p_register.php" id="regUser">
						<input type="hidden" value="regbase" name="dopost"/>
						<input type="hidden" value="1" name="step"/>
						<input type="hidden" value="个人" name="mtype"/>

						<div class="mc-field-group form-group">
							<input type="text" class="required email form-control" placeholder="手机号码" required name="shouye" id="userid" maxlength="13">
							<datalist id="userid">
								<option value="0551-12345678">
								<option value="13912345678">
								<option value="055112345678">
							</datalist>

						</div>
						
						<div class="clear">
							<button class="btn btn-primary btn-block" type="submit">免费报名</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!--------baoming------->


<!-- /footer -->
<div class="footer">
	<div class="container">
		<ul class="nav footer-nav pull-left">
			<li>
				© 2013-2014 Www.1dagong.Com 本站所有招聘信息及作品，未经书面授权不得转载！<br />
				<a href="/help/aboutus.html">关于我们</a>
			</li>
		</ul>
		<ul class="nav footer-nav pull-right">
			<li>
				最专业的求职招聘网站，致力打造人才网第一品牌！
				<i class="fa fa-heart text-primary">
				</i>
				&amp;
				<a href="http://www.1dagong.com" target="_blank">
					壹打工网.
				</a><br />
				国家工业和信息化部备案号：<a href="http://www.miibeian.gov.cn/">皖ICP备13015030号-3</a>
			</li>
		</ul>
	</div>
	<!-- /container -->
</div>
<div class="none">
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fb41da31689d0e576af45aaeafc3be8d8' type='text/javascript'%3E%3C/script%3E"));
</script>
</div>
<!-- /footer -->


</body>
</html>
