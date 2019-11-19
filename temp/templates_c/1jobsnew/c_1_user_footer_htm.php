<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-13 16:38 中国标准时间 */ ?>
<div class="footer over" style="height:auto; padding:15px 0;">
    	<div class="footer-con kuang">
        	<div class="fl">
            	<a href="#"><img src="/files/img/logo3.gif" title="壹打工网" /></a>
            </div>
            <div class="fr">
                <div class="over"></div>
                <div class="icp" style="color:#333;">
                	 &copy;2013-2015 Www.1dagong.Com &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp; 国家工业和信息化部备案号：皖ICP备13015030号-3
                </div>
                <div class="over"></div>
                <div class="zuic" style="color:#333;">
                	最专业的求职招聘网站，致力打造人才网第一品牌！
                </div>
            </div>
            
        </div>    
    </div>
<!-- 回到顶部组件 -->
<div class="back_to_top" id="back_to_top">
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
</div>
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
</script>

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?aa1b6622cda40ea74c1ac85e4b432e3a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>


