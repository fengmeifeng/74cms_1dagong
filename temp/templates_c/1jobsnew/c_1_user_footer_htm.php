<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-13 16:38 �й���׼ʱ�� */ ?>
<div class="footer over" style="height:auto; padding:15px 0;">
    	<div class="footer-con kuang">
        	<div class="fl">
            	<a href="#"><img src="/files/img/logo3.gif" title="Ҽ����" /></a>
            </div>
            <div class="fr">
                <div class="over"></div>
                <div class="icp" style="color:#333;">
                	 &copy;2013-2015 Www.1dagong.Com &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp; ���ҹ�ҵ����Ϣ���������ţ���ICP��13015030��-3
                </div>
                <div class="over"></div>
                <div class="zuic" style="color:#333;">
                	��רҵ����ְ��Ƹ��վ�����������˲�����һƷ�ƣ�
                </div>
            </div>
            
        </div>    
    </div>
<!-- �ص�������� -->
<div class="back_to_top" id="back_to_top">
	<div class="back" style="display:none;">
		<div>�ص�����</div>
	</div>
	<div class="steer">
		<div onclick="javascript:location.href='<?php echo $this->_vars['QISHI']['main_domain']; ?>
suggest'">��Ҫ����</div>
	</div>
	<div class="sub">
		<div onclick="javascript:location.href='<?php echo $this->_vars['QISHI']['main_domain']; ?>
subscribe'">��Ҫ����</div>
	</div>
</div>
<script>
	$(function(){
		//�ص����������������
		$(window).scroll(function(){
			if($(window).scrollTop()>200){
				$(".back").fadeIn(400);
			}else{
				$(".back").fadeOut(400);
			}
		})

		//�ص�����hoverЧ��
		$(".back_to_top .back, .steer, .sub").hover(function(){
			$(this).find("div").css("display","block");
		},function(){
			$(this).find("div").css("display","none");
		})

		//���ù��ض�������
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

