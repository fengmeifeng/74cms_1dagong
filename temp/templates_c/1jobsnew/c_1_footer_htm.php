<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-09 15:14 中国标准时间 */ ?>

<div class="footer over">
    	<div class="footer-con kuang">
        	<div class="fl">
            	<a href="#"><img src="/files/img/footer_logo.jpg" title="壹打工网" /></a>
            </div>
            <div class="fr appewm"><img src="/files/img/app.jpg" height="100" width="100" alt="" title="壹打工网客户端" /></div> 
            <div class="fr copy">
            	<div class="footer-nav">
                    <a href="#">友情链接</a>
                	<a href="#">用户帮助</a>
                    <a href="#">手机客户端</a>
                    <a href="#">关于我们</a>
                </div>
                <div class="over"></div>
                <div class="icp">
                	 &copy;2013-2015 Www.1dagong.Com &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp; 国家工业和信息化部备案号：皖ICP备13015030号-4
                </div>
                <div class="over"></div>
                <div class="zuic">
                	最专业的求职招聘网站，致力打造人才网第一品牌！
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
		<div onclick="javascript:location.href='<?php echo $this->_vars['QISHI']['main_domain']; ?>
suggest'">我要建议</div>
	</div>
	<div class="sub">
		<div onclick="javascript:location.href='<?php echo $this->_vars['QISHI']['main_domain']; ?>
subscribe'">我要订阅</div>
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

<div class="date_up">
<?php
	fw_date();
?>
</div>

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?aa1b6622cda40ea74c1ac85e4b432e3a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

