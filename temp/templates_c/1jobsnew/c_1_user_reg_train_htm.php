<?php require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.default.php'); $this->register_modifier("default", "tpl_modifier_default",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-13 16:38 中国标准时间 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>会员注册</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta name="author" content="骑士CMS" />
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
//验证
$(document).ready(function() {
	
	//-----地区显示
	allaround('<?php echo $this->_vars['QISHI']['site_dir']; ?>
');
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
					        if(that.find('.subcate').length > 0) {
			 					that.addClass('selected');
			 					var tharsub = that.find('.subcate');
			 					var thap = that.find('p');
			 					thap.css("border-bottom","0px");
			 					var swidth = tharsub.outerWidth(true); // 获取三级弹出框的宽度
			 					if((lastx - sx) < swidth) { // 判断li与弹出框最右边的距离是否大于三级弹出框的宽度
			 						tharsub.css("left",-265); // 如果小于就改变三级弹出框x方向的位置
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
	
	//-----地区显示结束
	
 $("#Form1").validate({
//debug: true,
// onsubmit:false,
//onfocusout :true,
submitHandler:function(form){
if($("#agreement").attr("checked")==false)
{
alert("您必须同意[注册协议]才能继续下一步");
return false;
}
		$("#reg").hide();
		$("#waiting").show();
		$("#sub").hide();
		var tsTimeStamp= new Date().getTime();
		$.post("/plus/ajax_user.php", { "username": $("#username").val(),"password": $("#password").val(),"member_type": $("#member_type").val(),"email":$("#email").val(),"postcaptcha": $("#postcaptcha").val(),"xs_user":$("#xs_user").val(),"district_cn":$("#district_cn").val(),"district":$("#district").val(),"sdistrict":$("#sdistrict").val(),"trainname":$("#trainname").val(),"time":tsTimeStamp,"act":"do_reg"},
	 	function (data,textStatus)
	 	 {
			if (data=="err")
			{
			$("#waiting").hide();
			$("#sub").show();
			$("#reg").show();
			//$("#username").attr("value","");
			//$("#email").attr("value","");
			alert("注册失败zwl");
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
   trainname:{
    required: true,
	remote:{     
		url:"/plus/ajax_user.php",     
		type:"post",    
		data:{"trainname":function (){return $("#trainname").val()},"act":"check_trainname","time":new Date().getTime()}     
		}
   }
	},
    messages: {
    username: {
    required: "请填写用户名",
	remote: jQuery.format("用户名已经存在或者不合法")	
   },
   trainname: {
    required: "请填写机构名称",
	remote: jQuery.format("机构名称已经存在!")	
   },
    email: {
    required: "请填写电子邮箱",
	email: jQuery.format("电子邮箱格式错误"),
	remote: jQuery.format("email已经存在")	
   },
    <?php if ($this->_vars['verify_userreg'] == "1"): ?>
    postcaptcha: {
    required: "请填写验证码",
	remote: jQuery.format("验证码错误")	
   },
    <?php endif; ?>
   password: {
    required: "请填写密码",
    minlength: jQuery.format("填写不能小于{0}个字符"),
	maxlength: jQuery.format("填写不能大于{0}个字符")
   },
   password2: {
   required: "请填写密码",
    equalTo: "两次输入的密码不同"
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
	 //中文字两个字节
	jQuery.validator.addMethod("byteRangeLength", function(value, element,	param) {
	var length = value.length;
	for (var i = 0; i < value.length; i++) {
			if (value.charCodeAt(i) > 127) {
			length++;
			}
		}
	return this.optional(element)	|| (length >= param[0] && length <= param[1]);
	}, "确保的值在3-18个字节之间");
	 //字符验证
	jQuery.validator.addMethod("userName", function(value, element) {
	return this.optional(element) || /^[\u0391-\uFFE5\w]+$/.test(value);
	}, "只能包含中英文、数字和下划线");
	jQuery.validator.addMethod("nomobile", function(value, element) { 
    var tel = /^(13|15|14|17|18)\d{9}$/;
	var $cstr= true;
	if (tel.test(value)) $cstr= false;
	return $cstr || this.optional(element); 
}, "用户名不能是手机号");
	jQuery.validator.addMethod("IScaptchastr", function(value, element) {
	var str="点击获取验证码";
	var flag=true;
	if (str==value)
	{
	flag=false;
	}
	return  flag || this.optional(element) ;
	}, "请填写验证码");
/////验证码部分
<?php if ($this->_vars['verify_userreg'] == "1"): ?>
function imgcaptcha(inputID,imgdiv)
{
	$(inputID).focus(function(){
		if ($(inputID).val()=="点击获取验证码")
		{
		$(inputID).val("");
		$(inputID).css("color","#333333");
		}
		$(inputID).parent("div").css("position","relative");
		//设置验证码DIV
		//$(imgdiv).css({ position: "absolute",right: "-148px", "top": "0px" , "z-index": "10", "background-color": "#FFFFFF", "border": "1px #A3C8DC solid","display": "none","margin-left": "15px"});
		$(imgdiv).show();
		if ($(imgdiv).html()=='')
		{
		$(imgdiv).append("<img src=\"/include/imagecaptcha.php?t=<?php echo $this->_vars['random']; ?>
\" id=\"getcode\" align=\"absmiddle\"  style=\"cursor:pointer; margin:3px;\" title=\"看不请验证码？点击更换一张\"  border=\"0\"/>");
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
//验证码结束
<?php endif; ?>
//
$(".but-reg").hover(function(){$(this).addClass("but-reg-hover")},function(){$(this).removeClass("but-reg-hover")});
$(".but-reg-login").hover(function(){$(this).addClass("but-reg-login-hover")},function(){$(this).removeClass("but-reg-login-hover")});
//-------企业注册提交结束

//-------个人注册提交

//
$(".but-reg").hover(function(){$(this).addClass("but-reg-hover")},function(){$(this).removeClass("but-reg-hover")});
$(".but-reg-login").hover(function(){$(this).addClass("but-reg-login-hover")},function(){$(this).removeClass("but-reg-login-hover")});
//

});

</script>

</head>
<body>
<!--头部开始-->
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("user/header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<!--头部结束-->
<div class="kua">
  <div class="panel-heading">欢迎加入壹打工网</div>
        <div class="left_list">
            <div class="tab"> 
                <ul> 
                    <li id="one1" class="on" onmouseover='setTab("one",1,5)'>培训会员注册</li> 
                </ul> 
            </div> 
            <div class="tabList ergao"> 
                <div id="cont_one_1" class="the01 one block"> 
                    <form id="Form1" name="Form1" method="post" action="?sd" class="form-horizontal home-form">
                 <input name="member_type" type="hidden" id="member_type" value="4" />
						<div class="form-group">
								<h2>培训会员注册<span class=""><font color="#ff0000">*</font>&nbsp;为必填项，谢谢合作。</span></h2>
						</div>

						<div class="form-group">
							<label class=" fl control-label"><font color="#ff0000">*</font><!--手机号-->用户名：</label>
							<div class="fl input_box">
								<input type="text" name="username" id="username" class="sign_up_input_name form-control error" placeholder="请输入用户名" maxlength="25" />
							</div>
                            <div class="item-tip"></div>
						</div>

						<div class="form-group">
							<label class="fl control-label"><font color="#ff0000">*</font>密码：</label>
							<div class="fl input_box">
								<input type="password" name="password" id="password" class="sign_up_input_pwd form-control" placeholder="请输入登录密码" maxlength="18" />
							</div>
                            <div class="item-tip"></div>
                            <div class="clear"></div>
						</div>

						<div class="form-group">
							<label class="fl control-label"><font color="#ff0000">*</font>确认密码：</label>
							<div class="fl input_box">
								<input type="password" name="password2" id="password2" class="sign_up_input_pwd form-control" placeholder="请确认登录密码" maxlength="18"/>
							</div>
                            <div class="item-tip"></div>
							<div class="clear"></div>
						</div>
						
                        <div class="form-group">
							<label class="fl control-label"><font color="#ff0000">*</font>机构名称：</label>
							<div class="fl input_box">
                            	<input type="text" name="trainname" id="trainname" class="form-control" placeholder="请输入机构名称" maxlength="60" />
							</div>
                            <div class="item-tip"></div>
							<div class="clear"></div>
						</div>
                        
						<div class="form-group">
							<label class="fl control-label"><font color="#ff0000">*</font>电子邮箱：</label>
							<div class="fl input_box">
                            	<input type="text" name="email" id="email" class="sign_up_input_mail form-control" placeholder="请输入您的常用邮箱" maxlength="60" />
							</div>
                            <div class="item-tip"></div>
							<div class="clear"></div>
						</div>
                        
                        <div class="form-group jobmain idng">
							<label class="fl control-label"><font color="#ff0000">*</font>所在地区：</label>
							<div id="jobsCity" style="position:relative;">
                           <div class="input_text_wc0_bg" id="cityText"><?php echo $this->_run_modifier($this->_vars['company_profile']['district_cn'], 'default', 'plugin', 1, "请选择"); ?>
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
						
						
						<!---<div class="form-group">
							<label class="fl control-label">客户经理：</label>
							<div class="fl">
								<input type="text" class="form-control" name="xs_user" id="xs_user">
							</div>
						</div>-->
						
                        <?php if ($this->_vars['verify_userreg'] == "1"): ?>
                        <div class="form-group">
                            <label class="fl control-label">验证码：</label>
                            
                            <div class="fl" >
                                <input  class="sign_up_input_varcode form-control" name="postcaptcha" id="postcaptcha" type="text" value="点击获取验证码" style="color:#999999;width:110px;"/>
                            </div><div id="imgdiv" class="fl item-tip"></div>
                        </div>
                        <?php endif; ?>
                        <div class="clear"></div>
						 <div class="form-group">
							<div class="col-sm-offset-3">
								<div class="checkbox">
									<label style="line-height:24px;">
										<input type="checkbox" class="heif" name="agreement" id="agreement" value="1" checked="checked"/> 我已阅读并同意遵
                               			<a href="/agreement/">《<?php echo $this->_vars['QISHI']['site_name']; ?>
用户服务协议》</a>
									</label>
								</div>
							</div>
						</div>
                        <!--注册之后提示-->
                       <!-- <div class="form-group">
                            <div class="item-input-box waiting" id="waiting" style="display:none">
                              正在注册中,请等待... 
                            </div>
                        </div>-->
                        <div class="form-group" id="waiting" style="display:none">
									<label class="fl"> &nbsp;</label>
							<div class="fl col-sm-offset-3">
								<button class="btn btn-lg btn-primary btn-block" name="signup" id="waiting" type="submit" style="color:#fff; background:#999;">正在注册中...</button>
							</div>
						</div>

						<div class="form-group" id="sub">
									<label class="fl"> &nbsp;</label>
							<div class="fl col-sm-offset-3">
								<button class="btn btn-lg btn-primary btn-block" name="signup" id="waiting" type="submit">提交注册</button>
							</div>
						</div>

						<!--  -->
                        
                    </form>
                </div> 
  
            </div> 
                        

        </div>





        <div class="right_list">
                
                <div class="h_anniu">
                <p>您已注册个人/企业，请点击登录：</p>
                <a href="/user/login.php" class="btn-warning">个人 / 企业登录入口</a>
                
                <p>您已注册培训,请点击登录：</p>
                <a href="/user/login.php?utype=4" class="btn-warning">培训登录入口</a>
                </div>

               

                <div class="h_tishi">
                    <p>全国免费服务热线：</p>
                    <a href="tel:400-118-5188">400-118-5188</a>
                </div>

        </div>

</div>

<!--底部开始-->
   <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("user/footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<!--底部结束-->
</body>
</html>