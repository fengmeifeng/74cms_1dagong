<?php require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.default.php'); $this->register_modifier("default", "tpl_modifier_default",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-09-28 15:00 �й���׼ʱ�� */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��Աע��</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta name="author" content="��ʿCMS" />
<meta name="copyright" content="74cms.com" />
<!--<link href="/files/css/user_common.css" rel="stylesheet" type="text/css" />
-->
<link href="/files/css/font-awesome.min.css" rel="stylesheet" >
<link href="/files/css/common.css" rel="stylesheet" type="text/css" />
<link href="/files/css/reg.css" rel="stylesheet" type="text/css" />
<!---->
<link href="/files/css/header.css" rel="stylesheet" type="text/css" />
<link href="/files/css/jobs.css" rel="stylesheet" type="text/css" />
<!---->
<script src="/files/js/jquery.js" type='text/javascript' language="javascript"></script>
<script src="/files/js/jquery.validate.min.js" type='text/javascript' language="javascript"></script>


<script src="/data/cache_classify.js" type="text/javascript" charset="utf-8"></script>
<script src="/files/js/jquery.reg.selectlayer.js" type='text/javascript' language="javascript"></script>
<script src="/files/js/jquery.hoverDelay.js" type='text/javascript'></script>




<script type="text/javascript">
//��֤
$(document).ready(function() {
	
	//-----������ʾ
	allaround('<?php echo $this->_vars['QISHI']['site_dir']; ?>
');
	$("#jobsCity").hoverDelay({
		    hoverEvent: function(){
		        $("#divCityCate").show();
		        var dx = $("#divCityCate").offset().left; // ��ȡ�������x����
		        var dwidth = $("#divCityCate").outerWidth(true); // ��ȡ������Ŀ���
		        var lastx = dx + dwidth; // ���ϵ�����Ŀ��Ȼ�ȡ���������ұߵ�x����
	 			$("#divCityCate li").each(function(index, el) {
	 				var that = $(this);
	 				var sx = that.offset().left; // ��ȡ��ǰli��x����
	 				that.hoverDelay({
					    hoverEvent: function(){
					        if(that.find('.subcate').length > 0) {
			 					that.addClass('selected');
			 					var tharsub = that.find('.subcate');
			 					var thap = that.find('p');
			 					thap.css("border-bottom","0px");
			 					var swidth = tharsub.outerWidth(true); // ��ȡ����������Ŀ���
			 					if((lastx - sx) < swidth) { // �ж�li�뵯�������ұߵľ����Ƿ��������������Ŀ���
			 						tharsub.css("left",-265); // ���С�ھ͸ı�����������x�����λ��
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
                $("#divCityCate").hide(); 
            }
		});
	
	//-----������ʾ����
	
 $("#Form1").validate({
//debug: true,
// onsubmit:false,
//onfocusout :true,
submitHandler:function(form){
if($("#agreement").attr("checked")==false)
{
alert("������ͬ��[ע��Э��]���ܼ�����һ��");
return false;
}
		$("#reg").hide();
		$("#waiting").show();
		$("#sub").hide();
		var tsTimeStamp= new Date().getTime();
		$.post("/plus/ajax_user.php", { "username": $("#username").val(),"password": $("#password").val(),"member_type": $("#member_type").val(),"subsite_id": $("#subsite_id").val(),"email":$("#email").val(),"postcaptcha": $("#postcaptcha").val(),"xs_user":$("#xs_user").val(),"district_cn":$("#district_cn").val(),"district":$("#district").val(),"sdistrict":$("#sdistrict").val(),"companyname":$("#companyname").val(),"time":tsTimeStamp,"act":"do_reg"},
	 	function (data,textStatus)
	 	 {
			if (data=="err")
			{
			$("#waiting").hide();
			$("#sub").show();
			$("#reg").show();
			//$("#username").attr("value","");
			//$("#email").attr("value","");
			alert("ע��ʧ��zwl");
			}
			else
			{
				$("body").append(data);
			}
	 	 })
//$(form).ajaxSubmit();
},
success: function(label) {
				label.text(" ").addClass("success");
			},
   rules:{
   username:{
    required: true,
	userName : true,
	nomobile : false,
	byteRangeLength : [3, 18],
	remote:{     
		url:"/plus/ajax_user.php",     
		type:"post",    
		data:{"usname":function (){return $("#username").val()},"act":"check_usname","time":function (){return new Date().getTime()}}     
		}
   },
   email:{
    required: true,
	email:true,
	remote:{     
		url:"/plus/ajax_user.php",     
		type:"post",    
		data:{"email":function (){return $("#email").val()},"act":"check_email","time": new Date().getTime()}     
		}
   },
   <?php if ($this->_vars['verify_userreg'] == "1"): ?>
    postcaptcha:{
	IScaptchastr:true,
    required: true,
	remote:{     
	url:"/include/imagecaptcha.php",     
	type:"post",    
	data:{"postcaptcha":function (){return $("#postcaptcha").val()},"act":"verify","time":function (){return new Date().getTime()}}     
	}
   },
   <?php endif; ?>
   password:{
    required: true,
	minlength:6,
    maxlength:18
   },
   password2:{
   required: true,
	 equalTo:"#password"
   },
   companyname:{
    required: true,
	remote:{     
		url:"/plus/ajax_user.php",     
		type:"post",    
		data:{"companyname":function (){return $("#companyname").val()},"act":"check_companyname","time":new Date().getTime()}     
		}
   }
	},
    messages: {
    username: {
    required: "����д�û���",
	remote: jQuery.format("�û����Ѿ����ڻ��߲��Ϸ�")	
   },
   companyname: {
    required: "����д��˾����",
	remote: jQuery.format("��˾�����Ѿ�����!")	
   },
    email: {
    required: "����д��������",
	email: jQuery.format("���������ʽ����"),
	remote: jQuery.format("email�Ѿ�����")	
   },
    <?php if ($this->_vars['verify_userreg'] == "1"): ?>
    postcaptcha: {
    required: "����д��֤��",
	remote: jQuery.format("��֤�����")	
   },
    <?php endif; ?>
   password: {
    required: "����д����",
    minlength: jQuery.format("��д����С��{0}���ַ�"),
	maxlength: jQuery.format("��д���ܴ���{0}���ַ�")
   },
   password2: {
   required: "����д����",
    equalTo: "������������벻ͬ"
   }
  },
  errorPlacement: function(error, element) {
    if ( element.is(":radio") )
        error.appendTo( element.parent().next().next() );
    else if ( element.is(":checkbox") )
        error.appendTo ( element.next());
    else
        error.appendTo(element.parent().next());
	}
    });
	 //�����������ֽ�
	jQuery.validator.addMethod("byteRangeLength", function(value, element,	param) {
	var length = value.length;
	for (var i = 0; i < value.length; i++) {
			if (value.charCodeAt(i) > 127) {
			length++;
			}
		}
	return this.optional(element)	|| (length >= param[0] && length <= param[1]);
	}, "ȷ����ֵ��3-18���ֽ�֮��");
	 //�ַ���֤
	jQuery.validator.addMethod("userName", function(value, element) {
	return this.optional(element) || /^[\u0391-\uFFE5\w]+$/.test(value);
	}, "ֻ�ܰ�����Ӣ�ġ����ֺ��»���");
	jQuery.validator.addMethod("nomobile", function(value, element) { 
    var tel = /^(13|15|14|17|18)\d{9}$/;
	var $cstr= true;
	if (tel.test(value)) $cstr= false;
	return $cstr || this.optional(element); 
}, "�û����������ֻ���");
	jQuery.validator.addMethod("IScaptchastr", function(value, element) {
	var str="�����ȡ��֤��";
	var flag=true;
	if (str==value)
	{
	flag=false;
	}
	return  flag || this.optional(element) ;
	}, "����д��֤��");
/////��֤�벿��
<?php if ($this->_vars['verify_userreg'] == "1"): ?>
function imgcaptcha(inputID,imgdiv)
{
	$(inputID).focus(function(){
		if ($(inputID).val()=="�����ȡ��֤��")
		{
		$(inputID).val("");
		$(inputID).css("color","#333333");
		}
		$(inputID).parent("div").css("position","relative");
		//������֤��DIV
		//$(imgdiv).css({ position: "absolute",right: "-148px", "top": "0px" , "z-index": "10", "background-color": "#FFFFFF", "border": "1px #A3C8DC solid","display": "none","margin-left": "15px"});
		$(imgdiv).show();
		if ($(imgdiv).html()=='')
		{
		$(imgdiv).append("<img src=\"/include/imagecaptcha.php?t=<?php echo $this->_vars['random']; ?>
\" id=\"getcode\" align=\"absmiddle\"  style=\"cursor:pointer; margin:3px;\" title=\"��������֤�룿�������һ��\"  border=\"0\"/>");
		}
		$(imgdiv+" img").click(function()
		{
			$(imgdiv+" img").attr("src",$(imgdiv+" img").attr("src")+"1");
			$(inputID).val("");
			$("#Form1").validate().element("#postcaptcha");	
		});

	});
}
imgcaptcha("#postcaptcha","#imgdiv");
//��֤�����
<?php endif; ?>
//
$(".but-reg").hover(function(){$(this).addClass("but-reg-hover")},function(){$(this).removeClass("but-reg-hover")});
$(".but-reg-login").hover(function(){$(this).addClass("but-reg-login-hover")},function(){$(this).removeClass("but-reg-login-hover")});
//-------��ҵע���ύ����

//-------����ע���ύ
// ��ʾ����
 		$("#jobsCity_1").hoverDelay({
		    hoverEvent: function(){
		        $("#divCityCate_1").show();
		        var dx = $("#divCityCate_1").offset().left; // ��ȡ�������x����
		        var dwidth = $("#divCityCate_1").outerWidth(true); // ��ȡ������Ŀ���
		        var lastx = dx + dwidth; // ���ϵ�����Ŀ��Ȼ�ȡ���������ұߵ�x����
	 			$("#divCityCate_1 li").each(function(index, el) {
	 				var that = $(this);
	 				var sx = that.offset().left; // ��ȡ��ǰli��x����
	 				that.hoverDelay({
					    hoverEvent: function(){
					        if(that.find('.subcate').length > 0) {
			 					that.addClass('selected');
			 					var tharsub = that.find('.subcate');
			 					var thap = that.find('p');
			 					thap.css("border-bottom","0px");
			 					var swidth = tharsub.outerWidth(true); // ��ȡ����������Ŀ���
			 					if((lastx - sx) < swidth) { // �ж�li�뵯�������ұߵľ����Ƿ��������������Ŀ���
			 						tharsub.css("left",-265); // ���С�ھ͸ı�����������x�����λ��
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
                $("#divCityCate_1").hide(); 
            }
		});
		
		//---��ʾ���
		showyearbox(".date_input","#birthday");
function showyearbox(divname,inputname)
{
	$(divname).click(function(){
		var inputdiv=$(this);
		$(inputdiv).parent("div").before("<div class=\"menu_bg_layer\"></div>");
		$(".menu_bg_layer").height($(document).height());
		$(".menu_bg_layer").css({ width: $(document).width(), position: "absolute", left: "0", top: "0" , "z-index": "0"});
		$(inputdiv).parent("div").css("position","relative");
		
		var myDate = new Date();
		var y=myDate.getFullYear();
			 y=y-16;
		var ymin=y-35;
		htm="<div class=\"showyearbox yearlist\">";		
		htm+="<ul>";
		for (i=y;i>=ymin;i--)
		{
		htm+="<li title=\""+i+"\">"+i+"��</li>";
		}
		htm+="<div class=\"clear\"></div>";
		htm+="</ul>";
		htm+="</div>";
		$(inputdiv).blur();
		if ($(inputdiv).parent("div").find(".showyearbox").html())
		{
			$(inputdiv).parent("div").children(".showyearbox.yearlist").slideToggle("fast");
		}
		else
		{
			$(inputdiv).parent("div").append(htm);
			$(inputdiv).parent("div").children(".showyearbox.yearlist").slideToggle("fast");
		}
		//
		$(inputdiv).parent("div").children(".yearlist").find("li").unbind("click").click(function()
		{
			$(inputname).val($(this).attr("title"));
			$(inputdiv).html($(this).attr("title"));
			$(inputdiv).parent("div").children(".yearlist").hide();
			$(".menu_bg_layer").remove();
		});	
		//
		$(".showyearbox>ul>li").hover(
		function()
		{
		$(this).css("background-color","#DAECF5");
		$(this).css("color","#ff0000");
		},
		function()
		{
		$(this).css("background-color","");
		$(this).css("color","");
		}
		);
		//
		$(".menu_bg_layer").click(function(){
					$(".menu_bg_layer").hide();
					$(inputdiv).parent("div").css("position","");
					$(inputdiv).parent("div").find(".showyearbox").hide();
					
		});
	});
}
		
//----��ʾ��ݽ���
//�Ա�ѡ
$("#sex_radio .input_radio").click(function(){
		$("#sex").val($(this).attr('id'));
		$("#sex_cn").val($(this).text());
		$("#sex_radio .input_radio").removeClass("select");
		$(this).addClass("select");
});

//----�Ա�ѡ����
$("#Form1_1").validate({
//debug: true,
// onsubmit:false,
//onfocusout :true,
submitHandler:function(form){
if($("#agreement_1").attr("checked")==false)
{
alert("������ͬ��[ע��Э��]���ܼ�����һ��");
return false;
}
		$("#reg_1").hide();
		$("#waiting_1").show();
		$("#sub_1").hide();
		var tsTimeStamp= new Date().getTime();
		$.post("/plus/ajax_user.php", { "username_1": $("#tel").val(),"mobile_verifycode": $("#mobile_verifycode").val(),"password": $("#password_1").val(),"member_type": $("#member_type_1").val(),"subsite_id": $("#subsite_id_1").val(),"sex":$("#sex").val(),"sex_cn":$("#sex_cn").val(),"realname":$("#realname").val(),"birthday":$("#birthday").val(),"residence":$("#residence").val(),"residence_cn":$("#residence_cn").val(),"postcaptcha": $("#postcaptcha_1").val(),"time":tsTimeStamp,"act":"do_reg"},
	 	function (data,textStatus)
	 	 {
			if (data=="err" || data=="�ֻ���֤�����")
			{
			$("#waiting_1").hide();
			$("#sub_1").show();
			$("#reg_1").show();
			$("#tel").attr("value","");
			$("#email_1").attr("value","");
			alert("ע��ʧ��");
			}
			else
			{
				$("body").append(data);
			}
	 	 })
//$(form).ajaxSubmit();
},
success: function(label) {
				label.text(" ").addClass("success");
			},
   rules:{
   username_1:{
    required: true,
	userName_1 : true,
	nomobile : false,
	byteRangeLength_1 : [11, 18],
	remote:{     
		url:"/plus/ajax_user.php",     
		type:"post",    
		data:{"usname":function (){return $("#username_1").val()},"act":"check_usname","time":function (){return new Date().getTime()}}     
		}
   },
   email:{
    required: true,
	email:true,
	remote:{     
		url:"/plus/ajax_user.php",     
		type:"post",    
		data:{"email":function (){return $("#email_1").val()},"act":"check_email","time": new Date().getTime()}     
		}
   },
   realname:{
    required: true
	/*remote:{     
		url:"/plus/ajax_user.php",     
		type:"post",    
		data:{"realname":function (){return $("#realname").val()},"act":"realname","time": new Date().getTime()}     
		}*/
   },
   birthday:{
    required: true
   },
    residence_cn:{
    required: true
   },
   <?php if ($this->_vars['verify_userreg'] == "1"): ?>
    postcaptcha:{
	IScaptchastr:true,
    required: true,
	remote:{     
	url:"/include/imagecaptcha.php",     
	type:"post",    
	data:{"postcaptcha":function (){return $("#postcaptcha_1").val()},"act":"verify","time":function (){return new Date().getTime()}}     
	}
   },
   <?php endif; ?>
   password:{
    required: true,
	minlength:6,
    maxlength:18
   },
   password2:{
   required: true,
	 equalTo:"#password_1"
   }
	},
    messages: {
    username_1: {
    required: "����д�û���",
	remote: jQuery.format("�û����Ѿ����ڻ��߲��Ϸ�")	
   },
    <?php if ($this->_vars['verify_userreg'] == "1"): ?>
    postcaptcha: {
    required: "����д��֤��",
	remote: jQuery.format("��֤�����")	
   },
    <?php endif; ?>
   realname: {
    required: "����д��������"
   },
   birthday: {
    required: "��ѡ��������"
   },
   residence_cn: {
    required: "��ѡ�����"
   },
   password2: {
   required: "����д����",
    equalTo: "������������벻ͬ"
   }
  },
  errorPlacement: function(error, element) {
    if ( element.is(":radio") )
        error.appendTo( element.parent().next().next() );
    else if ( element.is(":checkbox") )
        error.appendTo ( element.next());
    else
        error.appendTo(element.parent().next());
	}
    });
	 //�����������ֽ�
	jQuery.validator.addMethod("byteRangeLength_1", function(value, element,	param) {
	var length = value.length;
	for (var i = 0; i < value.length; i++) {
			if (value.charCodeAt(i) > 127) {
			length++;
			}
		}
	return this.optional(element)	|| (length >= param[0] && length <= param[1]);
	}, "ȷ����ֵ��11-18���ֽ�֮��");
	 //�ַ���֤
	 jQuery.validator.addMethod("userName_1", function(value, element) {
	return this.optional(element) || /^(13|15|14|17|18)\d{9}$/.test(value);
	}, "ֻ�����ֻ�����");
	/*jQuery.validator.addMethod("userName", function(value, element) {
	return this.optional(element) || /^[\u0391-\uFFE5\w]+$/.test(value);
	}, "ֻ�ܰ�����Ӣ�ġ����ֺ��»���");
	jQuery.validator.addMethod("nomobile", function(value, element) { 
    var tel = /^(13|15|14|17|18)\d{9}$/;
	var $cstr= true;
	if (tel.test(value)) $cstr= false;
	return $cstr || this.optional(element); 
}, "�û����������ֻ���");*/
	jQuery.validator.addMethod("IScaptchastr", function(value, element) {
	var str="�����ȡ��֤��";
	var flag=true;
	if (str==value)
	{
	flag=false;
	}
	return  flag || this.optional(element) ;
	}, "����д��֤��");
/////��֤�벿��
<?php if ($this->_vars['verify_userreg'] == "1"): ?>
function imgcaptcha_1(inputID,imgdiv_1)
{
	$(inputID).focus(function(){
		if ($(inputID).val()=="�����ȡ��֤��")
		{
		$(inputID).val("");
		$(inputID).css("color","#333333");
		}
		$(inputID).parent("div").css("position","relative");
		//������֤��DIV
		//$(imgdiv).css({ position: "absolute",right: "-148px", "top": "0px" , "z-index": "10", "background-color": "#FFFFFF", "border": "1px #A3C8DC solid","display": "none","margin-left": "15px"});
		$(imgdiv_1).show();
		if ($(imgdiv_1).html()=='')
		{
		$(imgdiv_1).append("<img src=\"/include/imagecaptcha.php?t=<?php echo $this->_vars['random']; ?>
\" id=\"getcode\" align=\"absmiddle\"  style=\"cursor:pointer; margin:3px;\" title=\"��������֤�룿�������һ��\"  border=\"0\"/>");
		}
		$(imgdiv_1+" img").click(function()
		{
			$(imgdiv_1+" img").attr("src",$(imgdiv_1+" img").attr("src")+"1");
			$(inputID).val("");
			$("#Form1_1").validate().element("#postcaptcha_1");	
		});

	});
}
imgcaptcha_1("#postcaptcha_1","#imgdiv_1");
//��֤�����
<?php endif; ?>
//
$(".but-reg").hover(function(){$(this).addClass("but-reg-hover")},function(){$(this).removeClass("but-reg-hover")});
$(".but-reg-login").hover(function(){$(this).addClass("but-reg-login-hover")},function(){$(this).removeClass("but-reg-login-hover")});
//

});

</script>

</head>
<body>
<!--ͷ����ʼ-->
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("user/header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<!--ͷ������-->
<div class="kua">
  <div class="panel-heading">��ӭ����Ҽ����</div>
        <div class="left_list">
        
            
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
            
            <div class="tab"> 
                <ul> 
                    <li><a id="one1" href="#cont_one_1" class="on" onclick='setTab("one",1,2)'>���˻�Ա��¼</a></li> 
                    <li><a id="one2" href="#cont_one_2" onclick='setTab("one",2,2)'>��ҵ��Ա��¼</a></li> 
                </ul> 
            </div> 
            <div class="tabList ergao"> 
                <div id="cont_one_1" class="the01 one block"> 
                    <form id="Form1_1" name="Form1" method="post" action="?sd" class="form-horizontal home-form time_position">
					<input name="member_type" type="hidden" id="member_type_1" value="2" />
                    <input name="subsite_id" type="hidden" id="subsite_id_1" value="<?php echo $this->_vars['subsite_id']; ?>
" />	
                                <div class="form-group">
										<h2>���˻�Աע��<span class=""><font color="#ff0000">*</font>&nbsp;Ϊ�����лл������</span></h2>
								</div>
						<!--<div class="form-group">
							<label class=" fl control-label"><font color="#ff0000">*</font>�ֻ��ţ�</label>
							<input type="text" name="username_1" id="username_1" class="sign_up_input_name form-control" placeholder="�������ֻ�����" maxlength="11" />
                            <div class="fl"></div>							
                            <div class="item-tip_1">
                            	
                            </div>                            
							<div class="clear"></div>
						</div>-->
                        <div class="form-group">
                            <ul>
                                <li>
                                <span id="timer" style="display:none;">�ѳɹ�������֤�룬<i id="time"></i>�������·��ͣ�</span>
                                <label for="tel" class="fl control-label"><font color="#ff0000">*</font>�ֻ���</label><input class="sign_up_input_name form-control input-tel" type="text" name="tel" id="tel" placeholder="�������ֻ�����" /><input class="input-btn mobilesend" id="submit" type="submit" value="�ֻ���֤" onclick="sendMessage()" /></li>
                                <li class="mobile_infor">
                                    <span class="fl code-tips"><i></i>����д���ֻ��յ�����֤�룡</span>
                                    <label for="code" class="fl"><font color="#ff0000">*</font>�ֻ���֤�룺</label><input class="input-test" type="text" id="mobile_verifycode" name="mobile_verifycode" />
                                </li>
                            </ul>
                        </div>
                        <!--�ֻ�������֤-->                        
                        <script>
                        var InterValObj; //timer����������ʱ��
                        var count = 120; //���������1��ִ��
                        var curCount;//��ǰʣ������
                        function sendMessage() {
                            var checkTel = /^(((14[0-9]{1})|(17[0-9]{1})|(13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
                            var tel = $(".input-tel").val();
                            if(!checkTel.test($(".input-tel").val())){
                                alert('��������Ч���ֻ����룡'); 
                                $(".input-tel").focus();
                                return false;
                            }
                            curCount = count;
                            $("#timer").show().find("i").html(count);
                            $(".code-tips").show();
                            $("input.input-btn").hide();
                            $("#submit,.input-tel").attr("disabled", "true");
                            InterValObj = window.setInterval(SetRemainTime, 1000); //������ʱ����1��ִ��һ��									
							$.post("/plus/ajax_verify_mobile.php", {"mobile": $("#tel").val(),"send_key": "<?php echo $this->_vars['send_mobile_key']; ?>
","time":new Date().getTime(),"act":"send_code"},							
						function (data,textStatus)
						 {
							if (data=="success")
							{	
								//alert(data);
							}
							else
							{
								alert(data);
							}
						 }
						 ,"text"
						 );
							//alert($("#tel").val());
                            /*
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: 'xxx.php', //Ŀ���ַ
                                data: "xxx:xxxx", //����
                                error: function (XMLHttpRequest, textStatus, errorThrown) { 
                                    //ʧ��
                                },
                                success: function (msg){
                                    //�ɹ�
                                }
                            });
                            */
                        }
                        function SetRemainTime(){
                            if (curCount == 0) {
                                 window.clearInterval(InterValObj);//ֹͣ��ʱ��
                                 $("#submit,.input-tel").removeAttr("disabled");//���ð�ť
                                 $("input.input-btn").show();
                                 $(".code-tips").hide();
                                 $("#timer").hide().find("i").html(count);
                            }else{
                                curCount--;
                                $("#timer i").html(curCount);
                            }
                        }
                        </script>                        

                        <!--<div class="form-group">
							<label class=" fl control-label">�ֻ���̬��֤�룺</label>
							<div class="fl">
								<input type="button" name="mobile_click" id="mobile_click" class="mobile_btn" value="�����֤" />
							</div>
                            <div class="fl">
								<input type="text" name="mobile_number" id="mobile_number" class="mobile_number" />
							</div>                           
							<div class="clear"></div>
						</div>-->                         
						<div class="form-group">
							<label class="fl control-label"><font color="#ff0000">*</font>�Ա�</label>
							<div class="fl">
								<div id="sex_radio">
                                    <input name="sex" id="sex" type="hidden" value="1" />
                                    <input name="sex_cn" id="sex_cn" type="hidden" value="��" />
                                      <div class="input_radio<?php if ($this->_vars['userprofile']['sex'] == 1 || $this->_vars['userprofile']['sex'] == ""): ?> select<?php endif; ?>" id="1">��</div>
                                      <div class="input_radio<?php if ($this->_vars['userprofile']['sex'] == 2): ?> select<?php endif; ?>" id="2">Ů</div>			  
                                      <div class="clear"></div>
			  					</div>
                                <div class="item-tip_1"></div>
								<div class="clear"></div>
							</div>
						</div>

						<div class="form-group">
							<label class="fl control-label"><font color="#ff0000">*</font>����������</label>
							<div class="fl">
                                <input name="realname" type="text" class="input_text_200 form-control" id="realname" maxlength="6"   value="" />
							</div>
                            <div class="item-tip_1"></div>
							<div class="clear"></div>
						</div>

						<div class="form-group">
							<label class="fl control-label"><font color="#ff0000">*</font>���ĳ�����ݣ�</label>
							<div class="fl">
								<div style="z-index:10; float:left">
                                 <div class="input_text_wc0_bg date_input"><?php if ($this->_vars['userprofile']['birthday']):  echo $this->_vars['userprofile']['birthday'];  else: ?>��ѡ��<?php endif; ?></div>
                                  <input name="birthday" id="birthday" type="hidden" value="" />
                                </div>
								<div class="item-tip_1"></div>
							<div class="clear"></div>
							</div>
						</div>

						<div class="form-group idng" id="jobsCity_1" style="position:relative;z-index:9">
							<label class="fl control-label"><font color="#ff0000">*</font>Ŀǰ��ס������</label>
							<div class="fl" style="width:220px;">
								
                                <div class="input_text_wc0_bg" id="cityText_1"><?php echo $this->_run_modifier($this->_vars['userprofile']['residence_cn'], 'default', 'plugin', 1, "��ѡ��"); ?>
</div>
                                 <div style="display:none;left:1px;top:46px; width:600px;" id="divCityCate_1" class="divJobCate">
                                     <table class="jobcatebox citycatebox"><tbody></tbody></table>
                                 </div>
                                 <input name="residence" id="residence" type="hidden" value="" />
                                 <input name="residence_cn" id="residence_cn" type="hidden" value="" />

							</div>
                            <div class="item-tip_1"></div>
							<div class="clear"></div>
						</div>
                        
                        <?php if ($this->_vars['verify_userreg'] == "1"): ?>
                        <div class="form-group">
                            <label class="fl control-label"><font color="#ff0000">*</font>��֤�룺</label>
                            
                            <div class="fl" >
                                <input  class="sign_up_input_varcode form-control" name="postcaptcha" id="postcaptcha_1" type="text" value="�����ȡ��֤��" style="color:#999999;width:110px;"/>
                            </div><div id="imgdiv_1" class="fl item-tip"></div>
                        </div>
						<?php endif; ?>
                        <div class="clear"></div>
                        
                        <div class="form-group">
							<div class="col-sm-offset-3">
								<div class="checkbox">
									<label style="line-height:24px;">
										<input type="checkbox" class="heif" name="agreement" id="agreement_1" value="1" checked="checked"/> �����Ķ���ͬ����
                               			<a href="/agreement/">��Ҽ�����û�����Э�顷</a>
									</label>
								</div>
							</div>
						</div>
                        
                        <!--ע��ɹ�����ʾ-->
                        <div class="form-group" id="waiting_1" style="display:none">
                            <label class="fl control-label">&nbsp;</label>
                            <div class="fl col-sm-offset-3">
                                <button class="btn btn-lg btn-primary btn-block" name="signup" type="submit" style="color:#fff; background:#999;">����ע����... </button>
                            </div> 
                        </div>
						<!--ע���ύ-->
                        <div class="form-group" id="sub_1">
							<label class="fl control-label">&nbsp;</label>
                            <div class="fl abc">
                                <button class="btn btn-lg btn-primary btn-block" name="signup" type="submit">�ύע��</button>
                            </div>
                        </div>
						
					</form>
                </div> 
                <div id="cont_one_2" class="the01 the02 one sign_form"> 
                <form id="Form1" name="Form1" method="post" action="?sd" class="form-horizontal home-form">
                 <input name="member_type" type="hidden" id="member_type" value="1" />
                  <input name="subsite_id" type="hidden" id="subsite_id" value="<?php echo $this->_vars['subsite_id']; ?>
" />
                 
						<div class="form-group">
								<h2>��ҵ��Աע��<span class=""><font color="#ff0000">*</font>&nbsp;Ϊ�����лл������</span></h2>
						</div>

						<div class="form-group">
							<label class=" fl control-label"><font color="#ff0000">*</font><!--�ֻ���-->�û�����</label>
							<div class="fl input_box">
								<input type="text" name="username" id="username" class="sign_up_input_name form-control error" placeholder="�������û���" maxlength="25" />
							</div>
                            <div class="item-tip"></div>
						</div>

						<div class="form-group">
							<label class="fl control-label"><font color="#ff0000">*</font>���룺</label>
							<div class="fl input_box">
								<input type="password" name="password" id="password" class="sign_up_input_pwd form-control" placeholder="�������¼����" maxlength="18" />
							</div>
                            <div class="item-tip"></div>
                            <div class="clear"></div>
						</div>

						<div class="form-group">
							<label class="fl control-label"><font color="#ff0000">*</font>ȷ�����룺</label>
							<div class="fl input_box">
								<input type="password" name="password2" id="password2" class="sign_up_input_pwd form-control" placeholder="��ȷ�ϵ�¼����" maxlength="18"/>
							</div>
                            <div class="item-tip"></div>
							<div class="clear"></div>
						</div>
						
                        <div class="form-group">
							<label class="fl control-label"><font color="#ff0000">*</font>��˾���ƣ�</label>
							<div class="fl input_box">
                            	<input type="text" name="companyname" id="companyname" class="form-control" placeholder="�����빫˾����" maxlength="60" />
							</div>
                            <div class="item-tip"></div>
							<div class="clear"></div>
						</div>
                        
						<div class="form-group">
							<label class="fl control-label"><font color="#ff0000">*</font>�������䣺</label>
							<div class="fl input_box">
                            	<input type="text" name="email" id="email" class="sign_up_input_mail form-control" placeholder="���������ĳ�������" maxlength="60" />
							</div>
                            <div class="item-tip"></div>
							<div class="clear"></div>
						</div>
                        
                        <div class="form-group jobmain idng">
							<label class="fl control-label"><font color="#ff0000">*</font>���ڵ�����</label>
							<div id="jobsCity" style="position:relative;">
                           <div class="input_text_wc0_bg" id="cityText"><?php echo $this->_run_modifier($this->_vars['company_profile']['district_cn'], 'default', 'plugin', 1, "��ѡ��"); ?>
</div>
							<div style="display:none;left:1px;top:46px;" id="divCityCate" class="divJobCate">
								<table class="jobcatebox citycatebox"><tbody></tbody></table>
							</div>
							<input id="district" type="hidden" value="" name="district">
							<input id="sdistrict" type="hidden" value="" name="sdistrict">
							<input id="districtID" type="hidden" value="">
							<input name="district_cn" id="district_cn" type="hidden" value="" />
                              </div>
						</div>

						<!--<div class="form-group">
							<label class="fl control-label">�����ֻ��ţ�</label>
							<div class="fl">
								<input type="text" class="form-control" placeholder=""  name="sphone2" maxlength="11" />

							</div>
						</div>-->
                        
						<div class="form-group">
							<label class="fl control-label">�ͻ�������</label>
							<div class="fl">
								<input type="text" class="form-control" name="xs_user" id="xs_user">
							</div>
						</div>						
                        <?php if ($this->_vars['verify_userreg'] == "1"): ?>
                        <div class="form-group">
                            <label class="fl control-label">��֤�룺</label>
                            
                            <div class="fl" >
                                <input  class="sign_up_input_varcode form-control" name="postcaptcha" id="postcaptcha" type="text" value="�����ȡ��֤��" style="color:#999999;width:110px;"/>
                            </div><div id="imgdiv" class="fl item-tip"></div>
                        </div>
                        <?php endif; ?>
                        <div class="clear"></div>
						 <div class="form-group">
							<div class="col-sm-offset-3">
								<div class="checkbox">
									<label style="line-height:24px;">
										<input type="checkbox" class="heif" name="agreement" id="agreement" value="1" checked="checked"/> �����Ķ���ͬ����
                               			<a href="/agreement/">��<?php echo $this->_vars['QISHI']['site_name']; ?>
�û�����Э�顷</a>
									</label>
								</div>
							</div>
						</div>
                        <!--ע��֮����ʾ-->
                       <!-- <div class="form-group">
                            <div class="item-input-box waiting" id="waiting" style="display:none">
                              ����ע����,��ȴ�... 
                            </div>
                        </div>-->
                        <div class="form-group" id="waiting" style="display:none">
									<label class="fl"> &nbsp;</label>
							<div class="fl col-sm-offset-3">
								<button class="btn btn-lg btn-primary btn-block" name="signup" id="waiting" type="submit" style="color:#fff; background:#999;">����ע����...</button>
							</div>
						</div>

						<div class="form-group" id="sub">
									<label class="fl"> &nbsp;</label>
							<div class="fl col-sm-offset-3">
								<button class="btn btn-lg btn-primary btn-block" name="signup" id="waiting" type="submit">�ύע��</button>
							</div>
						</div>

						<!--  -->
                        
                    </form>
                </div> 
            </div> 
                        

        </div>





        <div class="right_list">
                
                <div class="h_anniu">
                <p>����ע�ᣬ������¼��</p>
                <a href="/user/login.php" class="btn-warning">���� / ��ҵ��¼���</a>
                <p>����ע�ᣬ������¼��</p>
                <a href="/user/login.php" class="btn-warning">��ѵ��¼���</a>
                
                </div>

                <div class="h_tishi">
                    <p>ȫ����ѷ������ߣ�</p>
                    <a href="tel:4001185188">400-118-5188</a>
                </div>

        </div>
		<div style="clear:both;"></div>
</div>

<!--�ײ���ʼ-->
   <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("user/footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<!--�ײ�����-->
</body>
</html>