<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-09 15:14 �й���׼ʱ�� */ ?>

<div class="footer over">
    	<div class="footer-con kuang">
        	<div class="fl">
            	<a href="#"><img src="/files/img/footer_logo.jpg" title="Ҽ����" /></a>
            </div>
            <div class="fr appewm"><img src="/files/img/app.jpg" height="100" width="100" alt="" title="Ҽ�����ͻ���" /></div> 
            <div class="fr copy">
            	<div class="footer-nav">
                    <a href="#">��������</a>
                	<a href="#">�û�����</a>
                    <a href="#">�ֻ��ͻ���</a>
                    <a href="#">��������</a>
                </div>
                <div class="over"></div>
                <div class="icp">
                	 &copy;2013-2015 Www.1dagong.Com &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp; ���ҹ�ҵ����Ϣ���������ţ���ICP��13015030��-4
                </div>
                <div class="over"></div>
                <div class="zuic">
                	��רҵ����ְ��Ƹ��վ�����������˲�����һƷ�ƣ�
                </div>
            </div>
            
        </div>    
    </div>
<!-- �ص�������� -->
<!--<div class="back_to_top" id="back_to_top">
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
</div>-->
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
	
//β����ʾʱ��
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
